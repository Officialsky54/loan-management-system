<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Details - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root { --primary: #667eea; --secondary: #764ba2; }
        .sidebar { background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); min-height: 100vh; position: fixed; left: 0; top: 0; width: 250px; padding: 20px; color: white; }
        .sidebar-menu a { color: rgba(255,255,255,0.8); text-decoration: none; display: block; padding: 12px 0; border-left: 3px solid transparent; padding-left: 15px; }
        .sidebar-menu a:hover { color: white; border-left-color: white; }
        .main-content { margin-left: 250px; padding: 20px; }
        .detail-section { background: white; border-radius: 10px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .detail-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f0f0f0; }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { font-weight: 600; color: #666; }
        .detail-value { color: #333; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h4><i class="bi bi-speedometer2"></i> Admin</h4>
        <div class="sidebar-menu mt-4">
            <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="{{ route('admin.applications.index') }}"><i class="bi bi-file-earmark"></i> Applications</a>
            <a href="{{ route('admin.manual-review') }}"><i class="bi bi-check-circle"></i> Manual Review</a>
            <a href="{{ route('admin.bank-details.index') }}"><i class="bi bi-bank"></i> Bank Details</a>
        </div>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Application Details</h2>
                <a href="{{ route('admin.applications.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
            </div>

            <!-- Application Info -->
            <div class="detail-section">
                <h5 class="mb-3">Application Information</h5>
                <div class="detail-row">
                    <span class="detail-label">Reference ID:</span>
                    <span class="detail-value fw-bold">{{ $application->reference_id }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value"><span class="badge bg-{{ $application->loan_status === 'approved' ? 'success' : 'warning' }}">{{ ucfirst($application->loan_status) }}</span></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Current Step:</span>
                    <span class="detail-value">{{ getApplicationStep($application->current_step) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Submitted:</span>
                    <span class="detail-value">{{ $application->submitted_at->format('M d, Y H:i') }}</span>
                </div>
            </div>

            <!-- Applicant Info -->
            <div class="detail-section">
                <h5 class="mb-3">Applicant Information</h5>
                <div class="detail-row">
                    <span class="detail-label">Full Name:</span>
                    <span class="detail-value">{{ $application->full_name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value">{{ $application->email }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Phone:</span>
                    <span class="detail-value">{{ $application->phone }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Date of Birth:</span>
                    <span class="detail-value">{{ $application->date_of_birth->format('M d, Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Address:</span>
                    <span class="detail-value">{{ $application->address }}, {{ $application->city }}, {{ $application->country }}</span>
                </div>
            </div>

            <!-- Employment Info -->
            <div class="detail-section">
                <h5 class="mb-3">Employment Information</h5>
                <div class="detail-row">
                    <span class="detail-label">Employment Status:</span>
                    <span class="detail-value">{{ ucfirst(str_replace('_', ' ', $application->employment_status)) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Monthly Income:</span>
                    <span class="detail-value">{{ formatCurrency($application->monthly_income) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Employer:</span>
                    <span class="detail-value">{{ $application->employer_name ?? 'N/A' }}</span>
                </div>
            </div>

            <!-- Loan Info -->
            <div class="detail-section">
                <h5 class="mb-3">Loan Information</h5>
                <div class="detail-row">
                    <span class="detail-label">Loan Amount:</span>
                    <span class="detail-value fw-bold">{{ formatCurrency($application->loan_amount) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Duration:</span>
                    <span class="detail-value">{{ $application->loan_duration }} months</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Purpose:</span>
                    <span class="detail-value">{{ $application->loan_purpose }}</span>
                </div>
            </div>

            <!-- Documents -->
            @if($application->documents->count() > 0)
            <div class="detail-section">
                <h5 class="mb-3">Documents</h5>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Document Type</th>
                            <th>File Name</th>
                            <th>Size</th>
                            <th>Uploaded</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($application->documents as $doc)
                        <tr>
                            <td>{{ ucfirst(str_replace('_', ' ', $doc->document_type)) }}</td>
                            <td>{{ $doc->file_name }}</td>
                            <td>{{ number_format($doc->file_size / 1024, 2) }} KB</td>
                            <td>{{ $doc->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="btn btn-sm btn-info"><i class="bi bi-download"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            <!-- Bank Details -->
            @if($application->bankDetails)
            <div class="detail-section">
                <h5 class="mb-3">Bank Details</h5>
                <div class="detail-row">
                    <span class="detail-label">Bank Name:</span>
                    <span class="detail-value">{{ $application->bankDetails->bank_name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Account Holder:</span>
                    <span class="detail-value">{{ $application->bankDetails->account_holder }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Account Number:</span>
                    <span class="detail-value">****{{ substr($application->bankDetails->account_number, -4) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value"><span class="badge bg-{{ $application->bankDetails->status === 'approved' ? 'success' : 'warning' }}">{{ ucfirst($application->bankDetails->status) }}</span></span>
                </div>
            </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
