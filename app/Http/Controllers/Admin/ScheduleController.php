<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index()
    {
        $pageTitle = 'Schedules';
        $schedules = Schedule::orderBy('hour')->get();
        return view('admin.schedule.index', compact('pageTitle', 'schedules'));
    }

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'title' => 'required',
            'hour'  => 'required|integer|min:1'
        ]);

        if (!$id) {
            $notification = 'Schedule added successfully';
            $schedule     = new Schedule();
        } else {
            $notification = 'Schedule updated successfully';
            $schedule     = Schedule::findOrFail($id);
        }

        $schedule->title = $request->title;
        $schedule->hour = $request->hour;
        $schedule->save();

        $notify[] = ['success', $notification];

        return back()->withNotify($notify);
    }

    public function status($id)
    {
        return Schedule::changeStatus($id);
    }
}
