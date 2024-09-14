<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\InvestmentCase;
use Illuminate\Http\Request;

class ManageCasesController extends Controller
{
    public function cases()
    {
        $pageTitle = 'All Cases';
        $cases     = $this->caseData(null);
        return view('admin.cases.log', compact('pageTitle', 'cases'));
    }

    public function pending()
    {
        $pageTitle = 'Pending Cases';
        $cases     = $this->caseData('pending');
        return view('admin.cases.log', compact('pageTitle', 'cases'));
    }
    public function approved()
    {
        $pageTitle = 'Approved Cases';
        $cases     = $this->caseData('approved');
        return view('admin.cases.log', compact('pageTitle', 'cases'));
    }
    public function reached()
    {
        $pageTitle = 'Reached Cases';
        $cases     = $this->caseData('reached');
        return view('admin.cases.log', compact('pageTitle', 'cases'));
    }
    public function rejected()
    {
        $pageTitle = 'Rejected Cases';
        $cases     = $this->caseData('rejected');
        return view('admin.cases.log', compact('pageTitle', 'cases'));
    }

    public function details($id)
    {
        $pageTitle = 'Case Details';
        $case      = InvestmentCase::with(['plans'])->findOrFail($id);
        return view('admin.cases.details', compact('pageTitle', 'case'));
    }

    protected function caseData($scope)
    {
        if ($scope) {
            $cases = InvestmentCase::$scope()->with(['user']);
        } else {
            $cases = InvestmentCase::with(['user']);
        }
        $cases = $cases->whereNot('status', Status::CASE_DRAFT)->searchable(['case_code', 'user:username'])->dateFilter();
        return $cases->orderBy('id', 'desc')->paginate(getPaginate());
    }

    public function approve($id)
    {
        $case              = InvestmentCase::findOrFail($id);
        $case->is_approved = Status::CASE_APPROVE;
        $case->status      = Status::CASE_APPROVE;
        $case->save();

        notify($case->user, 'CASE_ACCEPT', [
            'code'              => $case->case_code,
            'case_title'        => $case->title,
            'case_expired_date' => showDateTime($case->expired_date, 'd M Y H:i:s')
        ]);

        $notify[] = ['success', 'Case approved successfully'];
        return back()->withNotify($notify);
    }

    public function reject(Request $request)
    {
        $request->validate([
            'id'   => 'required',
            'note' => 'required|max:55'
        ]);

        $case              = InvestmentCase::findOrFail($request->id);
        $case->status      = Status::CASE_REJECTED;
        $case->reject_note = $request->note;
        $case->save();

        notify($case->user, 'CASE_REJECTED', [
            'code' => $case->case_code,
            'case_title' => $case->case_title,
            'note' => $request->note
        ]);


        $notify[] = ['success', 'Case rejected successfully'];
        return back()->withNotify($notify);
    }

    public function download($id)
    {

        $attachment = InvestmentCase::findOrFail($id);
        $file       = $attachment->agreement_paper;
        $path       = getFilePath('agreement_paper');
        $fullPath  = $path . '/' . $file;

        // Check if the file exists
        if (file_exists($fullPath)) {
            $title      = slug($attachment->title);
            $ext        = pathinfo($file, PATHINFO_EXTENSION);
            $mimetype   = mime_content_type($fullPath);

            // Send headers
            header('Content-Disposition: attachment; filename="' . $title . '.' . $ext . '";');
            header("Content-Type: " . $mimetype);

            // Output the file
            readfile($fullPath);
        } else {
            $notify[] = ['error', 'File not found'];
            return back()->withNotify($notify);
        }
    }
}
