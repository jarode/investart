<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Lib\CurlRequest;
use App\Models\CronJob;
use App\Models\CronJobLog;
use App\Models\Invest;
use App\Models\ProfitReturn;
use App\Models\User;
use Carbon\Carbon;

class CronController extends Controller
{
    public function cron()
    {
        $general            = gs();
        $general->last_cron = now();
        $general->save();

        $crons = CronJob::with('schedule');

        if (request()->alias) {
            $crons->where('alias', request()->alias);
        } else {
            $crons->where('next_run', '<', now())->where('is_running', 1);
        }
        $crons = $crons->get();
        foreach ($crons as $cron) {
            $cronLog              = new CronJobLog();
            $cronLog->cron_job_id = $cron->id;
            $cronLog->start_at    = now();
            if ($cron->is_default) {
                $controller = new $cron->action[0];
                try {
                    $method = $cron->action[1];
                    $controller->$method();
                } catch (\Exception $e) {
                    $cronLog->error = $e->getMessage();
                }
            } else {
                try {
                    CurlRequest::curlContent($cron->url);
                } catch (\Exception $e) {
                    $cronLog->error = $e->getMessage();
                }
            }
            $cron->last_run = now();
            $cron->next_run = now()->addSeconds($cron->schedule->interval);
            $cron->save();

            $cronLog->end_at = $cron->last_run;

            $startTime         = Carbon::parse($cronLog->start_at);
            $endTime           = Carbon::parse($cronLog->end_at);
            $diffInSeconds     = $startTime->diffInSeconds($endTime);
            $cronLog->duration = $diffInSeconds;
            $cronLog->save();
        }
        if (request()->alias) {

            $notify[] = ['success', keyToTitle(request()->alias) . ' executed successfully'];
            return back()->withNotify($notify);
        }
    }


    public function profitReturn()
    {
        $invests = Invest::whereDate('next_return_date', '<=', date('Y-m-d'))
            ->where('status', Status::INVEST_RUNNING)
            ->whereColumn('total_return', '<=', 'total_return_time')
            ->get();

        foreach ($invests as $invest) {
            
            $invest->next_return_date = Carbon::now()->addHours($invest->plan->schedule->hour)->toDateString();
            $invest->save();

            $return                = new ProfitReturn();
            $return->from_user     = $invest->case->user_id;
            $return->to_user       = $invest->user_id;
            $return->invest_id     = $invest->id;
            $return->profit_amount = $invest->profit_amount;
            $return->save();
        }
    }



    public function verifiedBadge()
    {
        $users = User::where('verified_badge_active', Status::BADGE_ACTIVE)
            ->where('badge_expired', '<', now())
            ->get();

        foreach ($users as $user) {
            $user->verified_badge_active = Status::BADGE_INACTIVE;
            $user->save();

            notify($user, 'EXPIRED_BADGE', []);
        }
    }
}
