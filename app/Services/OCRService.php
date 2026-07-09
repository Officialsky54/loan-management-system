<?php

namespace App\Services;

use App\Models\Application;
use App\Models\ApplicationDocument;
use App\Models\EmailTemplate;
use App\Models\EmailLog;

class OCRService
{
    public function isEnabled()
    {
        return setting('ocr_enabled') === 'true';
    }

    public function getProvider()
    {
        return setting('ocr_provider', 'tesseract');
    }

    public function extractFromDocument(ApplicationDocument $document)
    {
        if (!$this->isEnabled()) {
            return null;
        }

        $provider = $this->getProvider();

        if ($provider === 'tesseract') {
            return $this->extractWithTesseract($document);
        } elseif ($provider === 'api') {
            return $this->extractWithApi($document);
        }

        return null;
    }

    private function extractWithTesseract(ApplicationDocument $document)
    {
        // Tesseract extraction logic
        // Requires tesseract-ocr to be installed on server
        try {
            $filePath = storage_path('app/' . $document->file_path);
            
            if (!file_exists($filePath)) {
                return null;
            }

            // This is a placeholder - actual implementation would use Tesseract
            return [
                'full_name' => null,
                'date_of_birth' => null,
                'confidence' => 0,
            ];
        } catch (\Exception $e) {
            return null;
        }
    }

    private function extractWithApi(ApplicationDocument $document)
    {
        // API-based OCR extraction logic
        $apiKey = setting('ocr_api_key');
        
        if (!$apiKey) {
            return null;
        }

        // Placeholder for API implementation
        return [
            'full_name' => null,
            'date_of_birth' => null,
            'confidence' => 0,
        ];
    }

    public function verifyApplication(Application $application)
    {
        if (!$this->isEnabled()) {
            // Auto-mark for manual review if OCR is disabled
            $application->update([
                'identity_status' => 'under_review',
                'loan_status' => 'pending',
            ]);
            return false;
        }

        // Get ID card document
        $idCard = $application->documents()
            ->where('document_type', ApplicationDocument::TYPE_ID_CARD)
            ->first();

        if (!$idCard) {
            $application->update(['identity_status' => 'under_review']);
            return false;
        }

        $ocrResults = $this->extractFromDocument($idCard);
        
        if (!$ocrResults) {
            $application->update(['identity_status' => 'under_review']);
            return false;
        }

        // Compare OCR results with application data
        $nameMatch = $this->compareNames($ocrResults['full_name'], $application->full_name);
        $dobMatch = $this->compareDates($ocrResults['date_of_birth'], $application->date_of_birth);

        if ($nameMatch && $dobMatch) {
            $application->update([
                'identity_status' => 'verified',
                'loan_status' => 'processing',
                'current_step' => 'identity_verified',
                'ocr_results' => json_encode($ocrResults),
            ]);
            return true;
        } else {
            $application->update([
                'identity_status' => 'under_review',
                'ocr_results' => json_encode($ocrResults),
            ]);
            return false;
        }
    }

    private function compareNames($ocr_name, $app_name)
    {
        // Simple string matching - can be enhanced with levenshtein distance
        return strtolower(trim($ocr_name)) === strtolower(trim($app_name));
    }

    private function compareDates($ocr_date, $app_date)
    {
        // Compare dates
        return $ocr_date === $app_date->format('Y-m-d');
    }
}
