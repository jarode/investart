<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Invest;
use App\Models\ProfitReturn;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class InvestController extends Controller
{

    public function investList()
    {
        $pageTitle = "My Invest";
        $invests   = Invest::where('user_id', auth()->id())->with(['user', 'case', 'plan'])->withSum("profits", 'profit_amount')->latest('id')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.case.invest', compact('pageTitle', 'invests'));
    }

    public function profitReturn()
    {
        $pageTitle = "Profit";
        $profits   = ProfitReturn::where('from_user', auth()->user()->id)->with(['invest.case', 'invest.user'])->latest('id')->paginate(getPaginate());

        return view($this->activeTemplate . 'user.case.returns', compact('pageTitle', 'profits'));
    }

    public function profitReturnSubmit($id)
    {
        $user   = auth()->user();
        $return = ProfitReturn::where('from_user', $user->id)->where('status', Status::PENDING)->findOrFail($id);

        if ($user->balance < $return->profit_amount) {
            $notify[] = ['error', 'Insufficient balance'];
            return back()->withNotify($notify);
        }

        $user->balance -= $return->profit_amount;
        $user->save();

        $this->process($return);

        $invest = $return->invest;
        $invest->total_return += 1;

        if ($invest->total_return == $invest->total_return_time) {
            $invest->status = Status::INVEST_COMPLETED;
        }
        $invest->save();

        if ($invest->status == Status::INVEST_COMPLETED && $invest->is_capital_back == Status::YES) {

            $investTorUser = User::find($return->to_user);

            $transaction               = new Transaction();
            $transaction->user_id      = $investTorUser->id;
            $transaction->amount       = $invest->invest_amount;
            $transaction->post_balance = $investTorUser->balance;
            $transaction->charge       = 0;
            $transaction->trx_type     = '+';
            $transaction->details      = showAmount($invest->invest_amount) . " " . gs('cur_text') . " back as a investment capital amount";
            $transaction->trx          = $invest->trx;
            $transaction->remark       = 'capital_back';
            $transaction->save();
        }

        $notify[] = ['success', "Profit return sent successfully"];
        return back()->withNotify($notify);
    }

    public function profitReturnAllSubmit(Request $request)
    {
        $request->validate([
            'return_id'   => 'required|array|min:1',
            'return_id.*' => 'required',
        ]);

        $user    = auth()->user();
        $returns = ProfitReturn::whereIn('id', $request->return_id)->where('from_user', $user->id)->where('status', Status::PENDING)->get();

        foreach ($returns as $return) {

            if ($user->balance < $return->profit_amount) {
                $notify[] = ['error', 'Insufficient balance'];
                return back()->withNotify($notify);
            }

            $user->balance -= $return->profit_amount;
            $user->save();

            $this->process($return);

            $invest                = $return->invest;
            $invest->total_return += 1;

            if ($invest->total_return == $invest->total_return_time) {
                $invest->status = Status::INVEST_COMPLETED;
            }

            $invest->save();

            if ($invest->status == Status::INVEST_COMPLETED && $invest->is_capital_back == Status::YES) {

                $investTorUser = User::find($return->to_user);

                $transaction               = new Transaction();
                $transaction->user_id      = $investTorUser->id;
                $transaction->amount       = $invest->invest_amount;
                $transaction->post_balance = $investTorUser->balance;
                $transaction->charge       = 0;
                $transaction->trx_type     = '+';
                $transaction->details      = showAmount($invest->invest_amount) . " " . gs('cur_text') . " back as a investment capital amount";
                $transaction->trx          = $invest->trx;
                $transaction->remark       = 'capital_back';
                $transaction->save();
            }
        }

        $notify[] = ['success', "Profit return sent successfully"];
        return back()->withNotify($notify);
    }

    private function process($return)
    {
        $return->status = Status::APPROVED;
        $return->save();

        $sender   = User::find($return->from_user);
        $receiver = User::find($return->to_user);
        $invest   = $return->invest;

        $transaction               = new Transaction();
        $transaction->user_id      = $sender->id;
        $transaction->amount       = $return->profit_amount;
        $transaction->post_balance = $sender->balance;
        $transaction->charge       = 0;
        $transaction->trx_type     = '-';
        $transaction->details      = showAmount($return->profit_amount) . " " . gs('cur_text') . " sent as a investment profit amount";
        $transaction->trx          = $invest->trx;
        $transaction->remark       = 'return_investment_profit';
        $transaction->save();


        $receiver->balance += $return->profit_amount;
        $receiver->save();


        $transaction               = new Transaction();
        $transaction->user_id      = $receiver->id;
        $transaction->amount       = $return->profit_amount;
        $transaction->post_balance = $receiver->balance;
        $transaction->charge       = 0;
        $transaction->trx_type     = '+';
        $transaction->details      = showAmount($return->profit_amount) . " " . gs('cur_text') . " received as a investment profit amount";
        $transaction->trx          = $invest->trx;
        $transaction->remark       = 'investment_profit';
        $transaction->save();

        if (gs('profit_commission') > 0) {
            $commissionAmount = $return->profit_amount / 100 * gs('profit_commission');

            $receiver->balance -= $commissionAmount;
            $receiver->save();

            $transaction               = new Transaction();
            $transaction->user_id      = $receiver->id;
            $transaction->amount       = $commissionAmount;
            $transaction->post_balance = $receiver->balance;
            $transaction->charge       = 0;
            $transaction->trx_type     = '-';
            $transaction->details      = showAmount($commissionAmount) . " " . gs('cur_text') . " deducted from your account as profit commission";
            $transaction->trx          = $invest->trx;
            $transaction->remark       = 'profit_commission';
            $transaction->save();
        }

        notify($receiver, 'PROFIT_RETURN', [
            'invest'       => $return->invest->case->title,
            'amount'       => showAmount($return->profit_amount),
            'trx'          => $transaction->trx,
            'post_balance' => $receiver->balance
        ]);
    }
}
