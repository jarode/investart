<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invest;
use App\Models\ProfitReturn;

class InvestmentController extends Controller
{
    public function invest()
    {
        $pageTitle = "Invest Logs";
        $invests   = Invest::with('user.invest', 'case', 'plan')->searchable(['user:username',"case:case_code"])->latest('id')->paginate(getPaginate());
        return view('admin.invest.invest', compact('pageTitle', 'invests'));
    }

    public function investCase($id)
    {
        $pageTitle = "Invest Logs";
        $invests   = Invest::where('case_id', $id)->with('user.invest', 'case', 'plan')->searchable(['user:username'])->paginate(getPaginate());
        return view('admin.invest.invest', compact('pageTitle', 'invests'));
    }

    public function profit()
    {
        $pageTitle = "Profit Logs";
        $profits   = ProfitReturn::with('invest.user', 'invest.case')->searchable(['user:username'])->latest('id')->paginate(getPaginate());
        return view('admin.invest.profit', compact('pageTitle', 'profits'));
    }
}
