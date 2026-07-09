<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\BankDetail;
use App\Models\Application;
use App\Models\EmailTemplate;
use App\Models\EmailLog;

class BankDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $bankDetails = BankDetail::where('status', 'pending')
            ->with('application')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.bank-details.index', ['bankDetails' => $bankDetails]);
    }

    public function show(BankDetail $bankDetail)
    {
        return view('admin.bank-details.show', ['bankDetail' => $bankDetail]);
    }

    public function approve(BankDetail $bankDetail)
    {
        $bankDetail->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        $application = $bankDetail->application;
        $application->update([
            'loan_status' => 'approved',
            'current_step' => 'loan_approved',
        ]);

        // Send approval email
        $template = EmailTemplate::where('slug', 'loan_approved')->first();
        if ($template) {
            $this->sendEmail($application, $template);
        }

        return redirect()->back()->with('success', 'Bank details approved!');
    }

    public function reject(Request $request, BankDetail $bankDetail)
    {
        $request->validate(['rejection_reason' => 'required|string']);

        $bankDetail->update([
            'status' => 'rejected',
            'rejected_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        $application = $bankDetail->application;
        $application->update([
            'loan_status' => 'rejected',
            'current_step' => 'loan_rejected',
        ]);

        // Send rejection email
        $template = EmailTemplate::where('slug', 'loan_rejected')->first();
        if ($template) {
            $this->sendEmail($application, $template);
        }

        return redirect()->back()->with('success', 'Bank details rejected!');
    }

    private function sendEmail(Application $application, EmailTemplate $template)
    {
        $placeholders = [
            '{customer_name}' => $application->full_name,
            '{reference_id}' => $application->reference_id,
            '{company_name}' => setting('company_name'),
        ];

        $body = str_replace(array_keys($placeholders), array_values($placeholders), $template->body);

        EmailLog::create([
            'application_id' => $application->id,
            'template_id' => $template->id,
            'recipient' => $application->email,
            'subject' => $template->subject,
            'body' => $body,
            'status' => 'sent',
            'sent_at' => now(),
        ]);
    }
}
