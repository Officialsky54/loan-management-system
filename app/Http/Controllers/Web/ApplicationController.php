<?php

namespace App\Http\Controllers\Web;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\ApplicationDocument;
use App\Models\WebsiteSetting;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ApplicationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'employment_status' => 'required|string',
            'monthly_income' => 'required|numeric|min:0',
            'employer_name' => 'nullable|string',
            'loan_amount' => 'required|numeric|min:' . WebsiteSetting::getValue('minimum_loan_amount', 1000),
            'loan_duration' => 'required|integer',
            'loan_purpose' => 'required|string',
            'id_card' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'passport_photo' => 'required|file|mimes:jpg,jpeg,png|max:10240',
        ]);

        try {
            // Generate reference ID
            $referenceId = $this->generateReferenceId();

            // Create application
            $application = Application::create([
                'reference_id' => $referenceId,
                'full_name' => $request->full_name,
                'date_of_birth' => $request->date_of_birth,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'country' => $request->country,
                'employment_status' => $request->employment_status,
                'monthly_income' => $request->monthly_income,
                'employer_name' => $request->employer_name,
                'loan_amount' => $request->loan_amount,
                'loan_duration' => $request->loan_duration,
                'loan_purpose' => $request->loan_purpose,
                'identity_status' => 'unverified',
                'loan_status' => 'pending',
                'current_step' => 'application_received',
                'submitted_at' => now(),
            ]);

            // Store documents
            if ($request->hasFile('id_card')) {
                $this->storeDocument($application, $request->file('id_card'), ApplicationDocument::TYPE_ID_CARD);
            }

            if ($request->hasFile('passport_photo')) {
                $this->storeDocument($application, $request->file('passport_photo'), ApplicationDocument::TYPE_PASSPORT);
            }

            // Send email notification
            event(new \App\Events\ApplicationSubmitted($application));

            return response()->json([
                'success' => true,
                'message' => 'Application submitted successfully!',
                'reference_id' => $referenceId
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    private function generateReferenceId()
    {
        $date = date('Ymd');
        $count = Application::whereDate('created_at', today())->count() + 1;
        return 'LN-' . $date . '-' . str_pad($count, 6, '0', STR_PAD_LEFT);
    }

    private function storeDocument(Application $application, $file, $documentType)
    {
        $path = Storage::disk('public')->putFile(
            'documents/applications/' . $application->id,
            $file,
            'public'
        );

        ApplicationDocument::create([
            'application_id' => $application->id,
            'document_type' => $documentType,
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
        ]);
    }

    public function trackApplication(Request $request)
    {
        $request->validate([
            'reference_id' => 'required|string',
            'email' => 'required|email',
        ]);

        $application = Application::where('reference_id', $request->reference_id)
            ->where('email', $request->email)
            ->first();

        if (!$application) {
            return response()->json(['success' => false, 'message' => 'Application not found.'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'reference_id' => $application->reference_id,
                'full_name' => $application->full_name,
                'loan_amount' => $application->loan_amount,
                'loan_duration' => $application->loan_duration,
                'submitted_at' => $application->submitted_at->format('Y-m-d H:i'),
                'identity_status' => $application->identity_status,
                'loan_status' => $application->loan_status,
                'current_step' => $application->current_step,
                'document' => $application->documents()->where('document_type', ApplicationDocument::TYPE_PASSPORT)->first(),
            ]
        ]);
    }
}
