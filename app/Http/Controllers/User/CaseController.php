<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Invest;
use App\Models\InvestmentCase;
use App\Models\InvestmentPlan;
use App\Models\Schedule;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use HTMLPurifier;

class CaseController extends Controller
{
    public function investCaseHistory()
    {
        $pageTitle = "Case History";
        $cases     = InvestmentCase::where('user_id', auth()->id())->paginate(getPaginate());
        return view($this->activeTemplate . 'user.case.index', compact('pageTitle', 'cases'));
    }

    public function caseLog($id)
    {
        $case      = InvestmentCase::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $pageTitle = "Case Investment Log";
        $invests   = Invest::where('case_id', $id)->with('user', 'case', 'plan')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.case.log', compact('pageTitle', 'invests'));
    }

    public function caseFormOne($id = 0)
    {
        if ($id) {
            $case      = InvestmentCase::where('user_id', auth()->id())->where('id', $id)->firstOrFail();
            $pageTitle = "Update Case";
        } else {
            $case      = null;
            $pageTitle = "Create Case";
        }
        $schedules = Schedule::active()->get();
        return view($this->activeTemplate . 'user.case.step_one', compact('pageTitle', 'schedules', 'case'));
    }

    public function caseFormTwo($id)
    {
        $case      = InvestmentCase::with('plans')->where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $pageTitle = "Case Investment Plan";
        $schedules = Schedule::active()->get();
        return view($this->activeTemplate . 'user.case.step_two', compact('pageTitle', 'schedules', 'case'));
    }
    public function caseFormThree($id)
    {
        $case = InvestmentCase::with('plans')->where('id', $id)->where('user_id', auth()->id())->first();
        if ($case->completed_step < 2) {
            $notify[] = ['error', 'Please complete the investment plan stage to access this stage.'];
            return back()->withNotify($notify);
        }
        if ($case->completed_step == 3) {
            $pageTitle = 'Edit Investment Case';
        } else {
            $pageTitle = 'Create Investment Case';
        }
        return view($this->activeTemplate . 'user.case.step_three', compact('pageTitle', 'case'));
    }
    public function caseFormFour($id)
    {
        $case = InvestmentCase::with('plans')->where('id', $id)->where('user_id', auth()->id())->first();

        if ($case->completed_step != 3) {
            $notify[] = ['error', 'Please complete the investment plan stage to access this stage.'];
            return back()->withNotify($notify);
        }
        
        if ($case->completed_step == 3) {
            $pageTitle = 'Edit Investment Case';
        } else {
            $pageTitle = 'Create Investment Case';
        }

        $schedules = Schedule::active()->get();

        return view($this->activeTemplate . 'user.case.step_four', compact('pageTitle', 'schedules', 'case'));
    }

    public function investCaseSubmitOne(Request $request, $id = 0)
    {

        $isRequired = $id ? 'nullable' : 'required';
        
        $request->validate([
            'title'           => 'required',
            'goal_amount'     => 'required|numeric|gt:0',
            'overview'        => 'required',
            'expired_date'    => 'required|after_or_equal:today',
            'agreement_paper' => "$isRequired|mimes:pdf",
            'image'           => "$isRequired|mimes:jpg,jpeg,png",
        ]);

        if ($id) {
            $case = InvestmentCase::where('user_id', auth()->id())->where('id', $id)->firstOrFail();
        } else {
            $case            = new InvestmentCase();
            $case->case_code = getTrx();
            $case->user_id   = auth()->id();
        }

        $case->title        = $request->title;
        $case->goal_amount  = $request->goal_amount;
        $case->overview     = (new HTMLPurifier())->purify($request->overview);
        $case->video_url    = $request->video_url;
        $case->expired_date = $request->expired_date;

        if ($request->hasFile('image')) {
            $case->image = fileUploader($request->image, getFilePath('investmentImage'), getFileSize('investmentImage'), @$case->image, getThumbSize("investmentImage"));
        }

        if ($request->hasFile('agreement_paper')) {
            $case->agreement_paper = fileUploader($request->agreement_paper, getFilePath('investmentFile'), old: @$case->agreement_paper);
        }

        $case->save();

        $notify[] = ['success', 'Overview save successfully'];

        if ($id) {
            return back()->withNotify($notify);
        } else {
            return redirect()->route('user.case.step.two', $case->id)->withNotify($notify);
        }
    }

    public function investCaseSubmitTwo(Request $request, $id)
    {
        $request->validate([
            "plan"                  => "required|array|min:1",
            'plan.*.minimum_invest' => 'required|numeric|gt:0',
            'plan.*.maximum_invest' => 'required|numeric|gt:0',
            'plan.*.schedule_id' => 'required|integer',
            'plan.*.title'          => 'required',
            'plan.*.profit_type'    => 'required|in:0,1',
            'plan.*.profit_value'   => 'required',
            'plan.*.capital_back'   => 'required|in:0,1,2'
        ]);

        $case = InvestmentCase::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        if ($case->completed_step == 1) {
            $case->completed_step = 2;
            $case->save();
        }

        $user = auth()->user();

        foreach ($request->plan as $requestPlan) {

            if (array_key_exists('id', $requestPlan)) {
                $plan = InvestmentPlan::where('id', $requestPlan['id'])->where('case_id', $case->id)->first();
                if (!$plan) continue;
            } else {
                $plan          = new InvestmentPlan();
                $plan->case_id = $case->id;
                $plan->user_id = $user->id;
            }

            $plan->title          = $requestPlan['title'];
            $plan->schedule_id    = $requestPlan['schedule_id'];
            $plan->minimum_invest = $requestPlan['minimum_invest'];
            $plan->maximum_invest = $requestPlan['maximum_invest'];
            $plan->capital_back   = $requestPlan['capital_back'];
            $plan->profit_type    = $requestPlan['profit_type'];
            $plan->profit_value   = $requestPlan['profit_value'];
            $plan->return_times   = $requestPlan['return_time'];
            $plan->status         = $requestPlan['status'];
            $plan->save();
        }

        $notify[] = ['success', 'Investment plan save successfully'];

        if ($case->completed_step == 3) {
            return back()->withNotify($notify);
        } else {
            return redirect()->route('user.case.step.three', $case->id)->withNotify($notify);
        }
    }

    public function investCaseSubmitThree(Request $request, $id)
    {
        $request->validate([
            'question.*' => 'required',
            'answer.*'   => 'required',
        ]);

        $faq = [];

        foreach ($request->question as $k => $question) {
            $item = [
                'question' => $question,
                'answer'   => $request->answer[$k]
            ];
            array_push($faq, $item);
        }

        $isNew      = true;
        $user       = auth()->user();
        $investment = InvestmentCase::where('user_id', $user->id)->where('id', $id)->firstOrFail();
        
        if ($investment->completed_step == 2) {
            $investment->completed_step = 3;
            $investment->save();
        }


        if ($investment->faq !=  null) {
            $isNew = false;
        }

        $investment->faq    = $faq;
        $investment->status = Status::ENABLE;

        if (gs('case_approve') == Status::ENABLE) {
            $investment->is_approved = Status::CASE_APPROVE;
            $investment->status      = Status::CASE_APPROVE;
        } else {
            $investment->status = Status::CASE_PENDING;
        }

        $investment->save();

        if ($isNew) {
            $msg = 'New case submitted from ' . $user->username;
        } else {
            $msg = 'Case edited from ' . $user->username;
        }

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $user->id;
        $adminNotification->title     = $msg;
        $adminNotification->click_url = urlPath('admin.cases.details', $investment->id);
        $adminNotification->save();

        $notify[] = ['success', 'Case save successfully'];
        return redirect()->route('user.case.step.four', $investment->id)->withNotify($notify);
    }

    public function form()
    {
        abort_if(!request()->ajax(), 404);

        $schedules = Schedule::active()->get();
        $count     = request()->count;
        return view($this->activeTemplate . 'user.case.case_form', compact('schedules', 'count'));
    }

    public function planView($code, $segment)
    {
        $investment = InvestmentCase::where('case_code', $code)->active()->firstOrFail();

        if ($investment->user_id == auth()->id()) {
            $notify[] = ['error', "You can't invest your case"];
            return back()->withNotify($notify);
        }

        $plan      = InvestmentPlan::where('case_id', $investment->id)->where('id', $segment)->firstOrFail();
        $pageTitle = "Investment Plan";
        return view($this->activeTemplate . 'user.case.segment', compact('pageTitle', 'investment', 'plan'));
    }

    public function investSubmit(Request $request, $code, $id)
    {

        $request->validate([
            'amount' => "required|numeric|min:0"
        ]);

        $investment = InvestmentCase::where('case_code', $code)->active()->firstOrFail();
        $segment    = InvestmentPlan::where('case_id', $investment->id)->where('id', $id)->firstOrFail();

        if ($segment->minimum_invest > $request->amount || $segment->maximum_invest < $request->amount) {
            $notify[] = ['error', 'The investment amount must be a range of minimum and maximum amounts'];
            return back()->withNotify($notify);
        }

        $user = auth()->user();

        if ($user->balance < $request->amount) {
            $notify[] = ['error', 'Insufficient balance'];
            return back()->withNotify($notify);
        }

        if ($user->id == $investment->user_id) {
            $notify[] = ['error', "You can't invest your case"];
            return back()->withNotify($notify);
        }

        $goalReached = $investment->reach_amount + $request->amount;

        if ($investment->goal_amount < $goalReached) {
            $notify[] = ['error', 'Your investment is higher than goal amount'];
            return back()->withNotify($notify);
        }

        if ($segment->profit_type == Status::FIXED_TYPE) {
            $profit = $segment->profit_value;
        } else {
            $profit = $segment->profit_value * $request->amount / 100;
        }

        $nextDrawDate = Carbon::now()->addHours($segment->schedule->hour)->toDateString();

        $user->balance -= $request->amount;
        $user->save();

        $invest                    = new Invest();
        $invest->trx               = getTrx();
        $invest->case_id           = $investment->id;
        $invest->case_type_id      = $segment->id;
        $invest->from_user         = $investment->user_id;
        $invest->user_id           = $user->id;
        $invest->invest_amount     = $request->amount;
        $invest->profit_amount     = $profit;
        $invest->next_return_date  = $nextDrawDate;
        $invest->total_return_time = $segment->return_times;
        $invest->is_capital_back   = $segment->capital_back;
        $invest->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $user->id;
        $transaction->amount       = $invest->invest_amount;
        $transaction->post_balance = $user->balance;
        $transaction->charge       = 0;
        $transaction->trx_type     = '-';
        $transaction->details      = "invest in " . $investment->title;
        $transaction->trx          = $invest->trx;
        $transaction->remark       = 'invest';
        $transaction->save();

        $investment->reach_amount += $invest->invest_amount;
        $investment->save();

        $receiver           = $investment->user;
        $receiver->balance += $invest->invest_amount;
        $receiver->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $receiver->id;
        $transaction->amount       = $invest->invest_amount;
        $transaction->post_balance = $receiver->balance;
        $transaction->charge       = 0;
        $transaction->trx_type     = '+';
        $transaction->details      = "invest amount received";
        $transaction->trx          = $invest->trx;
        $transaction->remark       = 'invest_received';
        $transaction->save();

        notify($user, 'INVEST', [
            'trx'          => $invest->trx,
            'title'        => $investment->title,
            'amount'       => showAmount($invest->goal_amount),
            'post_balance' => $user->balance
        ]);

        notify($receiver, 'INVEST_RECEIVED', [
            'trx'          => $invest->trx,
            'user'         => $user->fullname,
            'amount'       => showAmount($invest->goal_amount),
            'post_balance' => $receiver->balance
        ]);

        if ($investment->goal_amount == $investment->reach_amount) {
            $investment->status = Status::CASE_REACHED;
            $investment->save();
        }

        $notify[] = ['success', 'Invest successfully completed'];
        return redirect()->route('user.invest.list')->withNotify($notify);
    }

    public function status($id)
    {
        return InvestmentCase::changeStatus($id);
    }
}
