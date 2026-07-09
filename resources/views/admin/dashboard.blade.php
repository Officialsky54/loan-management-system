<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - {{ setting('website_title') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root { --primary: #667eea; --secondary: #764ba2; }
        body { background: #f8f9fa; }
        .sidebar { background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); min-height: 100vh; position: fixed; left: 0; top: 0; width: 250px; padding: 20px; color: white; }
        .sidebar-menu { margin-top: 30px; }
        .sidebar-menu a { color: rgba(255,255,255,0.8); text-decoration: none; display: block; padding: 12px 0; border-left: 3px solid transparent; padding-left: 15px; transition: all 0.3s; }
        .sidebar-menu a:hover, .sidebar-menu a.active { color: white; border-left-color: white; }
        .main-content { margin-left: 250px; padding: 20px; }
        .stat-card { background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center; }
        .stat-icon { font-size: 30px; margin-bottom: 10px; }
        .stat-number { font-size: 24px; font-weight: bold; color: var(--primary); }
        .stat-label { color: #6c757d; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h4>🏦 Admin Panel</h4>
        <div class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="active"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="{{ route('admin.applications.index') }}"><i class="bi bi-file-earmark"></i> Applications</a>
            <a href="{{ route('admin.manual-review') }}"><i class="bi bi-check-circle"></i> Manual Review</a>
            <a href="{{ route('admin.bank-details.index') }}"><i class="bi bi-bank"></i> Bank Details</a>
            <a href="{{ route('admin.email-templates.index') }}"><i class="bi bi-envelope"></i> Email Templates</a>
            <a href="{{ route('admin.settings') }}"><i class="bi bi-gear"></i> Settings</a>
            <hr style="border-color: rgba(255,255,255,0.2);">
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <h2 class="mb-4">Dashboard</h2>

            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon">📋</div>
                        <div class="stat-number">{{ $total_applications }}</div>
                        <div class="stat-label">Total Applications</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon">⏳</div>
                        <div class="stat-number">{{ $pending_applications }}</div>
                        <div class="stat-label">Pending</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon">✅</div>
                        <div class="stat-number">{{ $approved_applications }}</div>
                        <div class="stat-label">Approved</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon">❌</div>
                        <div class="stat-number">{{ $rejected_applications }}</div>
                        <div class="stat-label">Rejected</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <h5>Recent Applications</h5>
                        <div class="table-responsive mt-3">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Reference ID</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recent_applications as $app)
                                        <tr>
                                            <td><strong>{{ $app->reference_id }}</strong></td>
                                            <td>{{ substr($app->full_name, 0, 15) }}</td>
                                            <td><span class="badge bg-{{ $app->loan_status === 'approved' ? 'success' : ($app->loan_status === 'rejected' ? 'danger' : 'warning') }}">{{ ucfirst($app->loan_status) }}</span></td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="text-center text-muted">No applications yet</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <h5>Key Metrics</h5>
                        <div class="mt-3">
                            <p><strong>Total Loans Approved:</strong> {{ $total_loans }}</p>
                            <p><strong>Total Amount Approved:</strong> {{ formatCurrency($total_amount_approved) }}</p>
                            <p><strong>Manual Review Pending:</strong> {{ $manual_review }}</p>
                            <p><strong>Bank Details Pending:</strong> {{ $bank_reviews }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
