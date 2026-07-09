<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\BankDetail;
use App\Models\EmailLog;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Mail;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $applications = Application::with('bankDetails')
            ->orderBy('submitted_at', 'desc')
            ->paginate(15);

        return view('admin.applications.index', ['applications' => $applications]);
    }

    public function show(Application $application)
    {
        return view('admin.applications.show', ['application' => $application]);
    }

    public function manualReview()
    {
        $applications = Application::where('identity_status', 'under_review')
            ->orderBy('submitted_at', 'desc')
            ->paginate(15);

        return view('admin.applications.manual-review', ['applications' => $applications]);
    }

    public function approve(Request $request, Application $application)
    {
        $application->update([
            'identity_status' => 'verified',
            'loan_status' => 'processing',
            'current_step' => 'identity_verified',
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);

        // Send verification email
        $template = EmailTemplate::where('slug', 'application_verified')->first();
        if ($template) {
            $this->sendEmail($application, $template);
        }

        return redirect()->back()->with('success', 'Application approved!');
    }

    public function reject(Request $request, Application $application)
    {
        $request->validate(['reason' => 'required|string']);

        $application->update([
            'loan_status' => 'rejected',
            'current_step' => 'loan_rejected',
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);

        // Send rejection email
        $template = EmailTemplate::where('slug', 'loan_rejected')->first();
        if ($template) {
            $this->sendEmail($application, $template);
        }

        return redirect()->back()->with('success', 'Application rejected!');
    }

    public function search(Request $request)
    {
        $query = Application::query();

        if ($request->filled('reference_id')) {
            $query->where('reference_id', 'like', '%' . $request->reference_id . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('loan_status')) {
            $query->where('loan_status', $request->loan_status);
        }

        if ($request->filled('identity_status')) {
            $query->where('identity_status', $request->identity_status);
        }

        $applications = $query->orderBy('submitted_at', 'desc')->paginate(15);

        return view('admin.applications.index', ['applications' => $applications]);
    }

    public function export(Request $request)
    {
        $format = $request->format ?? 'excel';
        $applications = Application::all();

        if ($format === 'excel') {
            return $this->exportToExcel($applications);
        } elseif ($format === 'pdf') {
            return $this->exportToPdf($applications);
        }
    }

    private function exportToExcel($applications)
    {
        // Implementation using maatwebsite/excel
        // Will be completed in actual implementation
    }

    private function exportToPdf($applications)
    {
        // Implementation using dompdf
        // Will be completed in actual implementation
    }

    private function sendEmail(Application $application, EmailTemplate $template)
    {
        $placeholders = [
            '{customer_name}' => $application->full_name,
            '{reference_id}' => $application->reference_id,
            '{loan_amount}' => $application->loan_amount,
            '{loan_duration}' => $application->loan_duration,
            '{interest_rate}' => setting('interest_rate'),
            '{monthly_payment}' => $this->calculateMonthlyPayment($application),
            '{total_interest}' => $this->calculateTotalInterest($application),
            '{total_repayment}' => $this->calculateTotalRepayment($application),
            '{currency}' => setting('currency_symbol'),
            '{company_name}' => setting('company_name'),
            '{tracking_link}' => route('track'),
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

    private function calculateMonthlyPayment($application)
    {
        $principal = $application->loan_amount;
        $rate = setting('interest_rate') / 100 / 12;
        $months = $application->loan_duration;
        return round(($principal * $rate * pow(1 + $rate, $months)) / (pow(1 + $rate, $months) - 1), 2);
    }

    private function calculateTotalInterest($application)
    {
        $monthlyPayment = $this->calculateMonthlyPayment($application);
        return round(($monthlyPayment * $application->loan_duration) - $application->loan_amount, 2);
    }

    private function calculateTotalRepayment($application)
    {
        $monthlyPayment = $this->calculateMonthlyPayment($application);
        return round($monthlyPayment * $application->loan_duration, 2);
    }
}
