<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;
use App\Models\WebsiteSetting;
use App\Models\EmailLog;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = [
            'total_applications' => Application::count(),
            'pending_applications' => Application::where('loan_status', 'pending')->count(),
            'manual_review' => Application::where('loan_status', 'pending')
                ->where('identity_status', 'under_review')
                ->count(),
            'approved_applications' => Application::where('loan_status', 'approved')->count(),
            'rejected_applications' => Application::where('loan_status', 'rejected')->count(),
            'bank_reviews' => Application::whereHas('bankDetails', function($query) {
                $query->where('status', 'pending');
            })->count(),
            'total_loans' => Application::where('loan_status', 'approved')->count(),
            'recent_applications' => Application::latest('submitted_at')->limit(10)->get(),
            'email_logs' => EmailLog::latest('created_at')->limit(10)->get(),
            'total_amount_approved' => Application::where('loan_status', 'approved')
                ->sum('loan_amount'),
        ];

        return view('admin.dashboard', $data);
    }
}
