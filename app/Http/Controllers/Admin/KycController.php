<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Lib\FormProcessor;
use Illuminate\Http\Request;

class KycController extends Controller
{
    public function setting()
    {
        $pageTitle = 'KYC Setting';
        $form = Form::where('act', 'kyc')->first();
        return view('admin.kyc.setting', compact('pageTitle', 'form'));
    }

    public function settingUpdate(Request $request)
    {
        $formProcessor = new FormProcessor();
        $generatorValidation = $formProcessor->generatorValidation();
        $request->validate($generatorValidation['rules'], $generatorValidation['messages']);
        $exist = Form::where('act', 'kyc')->first();
        if ($exist) {
            $isUpdate = true;
        } else {
            $isUpdate = false;
        }
        $formProcessor->generate('kyc', $isUpdate, 'act');

        $notify[] = ['success', 'KYC data updated successfully'];
        return back()->withNotify($notify);
    }
    
    public function caseCreatorKycSetting()
    {
        $pageTitle = 'Case Creator KYC Setting';
        $form      = Form::where('act', 'ckyc')->first();
        return view('admin.kyc.case_creator', compact('pageTitle', 'form'));
    }

    public function caseCreatorKycSettingUpdate(Request $request)
    {
        $formProcessor       = new FormProcessor();
        $generatorValidation = $formProcessor->generatorValidation();
        $request->validate($generatorValidation['rules'], $generatorValidation['messages']);
        $exist = Form::where('act', 'ckyc')->first();

        if ($exist) {
            $isUpdate = true;
        } else {
            $isUpdate = false;
        }
        $formProcessor->generate('ckyc', $isUpdate, 'act');

        $notify[] = ['success', 'Case creator KYC data updated successfully'];
        return back()->withNotify($notify);
    }
}
