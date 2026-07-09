<?php

namespace App\Listeners;

use App\Events\ApplicationSubmitted;
use App\Services\EmailService;
use App\Services\OCRService;

class SendApplicationReceivedEmail
{
    protected $emailService;
    protected $ocrService;

    public function __construct(EmailService $emailService, OCRService $ocrService)
    {
        $this->emailService = $emailService;
        $this->ocrService = $ocrService;
    }

    public function handle(ApplicationSubmitted $event)
    {
        $application = $event->application;

        // Send initial received email
        $this->emailService->sendApplicationReceivedEmail($application);

        // If OCR is enabled, verify application
        if ($this->ocrService->isEnabled()) {
            $this->ocrService->verifyApplication($application);
        } else {
            // Mark for manual review
            $application->update([
                'identity_status' => 'under_review',
            ]);
        }
    }
}
