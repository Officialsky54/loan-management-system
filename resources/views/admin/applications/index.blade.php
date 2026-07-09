<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applications - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root { --primary: #667eea; --secondary: #764ba2; }
        .sidebar { background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); min-height: 100vh; position: fixed; left: 0; top: 0; width: 250px; padding: 20px; color: white; overflow-y: auto; }
        .sidebar-menu a { color: rgba(255,255,255,0.8); text-decoration: none; display: block; padding: 12px 0; border-left: 3px solid transparent; padding-left: 15px; transition: all 0.3s; }
        .sidebar-menu a:hover, .sidebar-menu a.active { color: white; border-left-color: white; }
        .main-content { margin-left: 250px; padding: 20px; }
        .table-responsive { border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .table { margin-bottom: 0; }
        .badge { padding: 6px 12px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h4><i class="bi bi-speedometer2"></i> Admin</h4>
        <div class="sidebar-menu mt-4">
            <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="{{ route('admin.applications.index') }}" class="active"><i class="bi bi-file-earmark"></i> Applications</a>
            <a href="{{ route('admin.manual-review') }}"><i class="bi bi-check-circle"></i> Manual Review</a>
            <a href="{{ route('admin.bank-details.index') }}"><i class="bi bi-bank"></i> Bank Details</a>
            <a href="{{ route('admin.email-templates.index') }}"><i class="bi bi-envelope"></i> Email Templates</a>
            <a href="{{ route('admin.settings') }}"><i class="bi bi-gear"></i> Settings</a>
            <hr style="border-color: rgba(255,255,255,0.2);">
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout').submit();"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Loan Applications</h2>
                <div>
                    <a href="{{ route('admin.applications.export', 'excel') }}" class="btn btn-success btn-sm"><i class="bi bi-download"></i> Export Excel</a>
                    <a href="{{ route('admin.applications.export', 'pdf') }}" class="btn btn-danger btn-sm"><i class="bi bi-file-pdf"></i> Export PDF</a>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="card-title">Search Applications</h6>
                    <form method="GET" action="{{ route('admin.applications.search') }}" class="row g-3">
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="reference_id" placeholder="Reference ID" value="{{ request('reference_id') }}">
                        </div>
                        <div class="col-md-3">
                            <input type="email" class="form-control" name="email" placeholder="Email" value="{{ request('email') }}">
                        </div>
                        <div class="col-md-2">
                            <select class="form-control" name="loan_status">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('loan_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ request('loan_status') === 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ request('loan_status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Search</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead style="background: #f8f9fa;">
                        <tr>
                            <th>Reference ID</th>
                            <th>Applicant</th>
                            <th>Email</th>
                            <th>Loan Amount</th>
                            <th>Status</th>
                            <th>Identity</th>
                            <th>Submitted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications as $app)
                            <tr>
                                <td><strong>{{ $app->reference_id }}</strong></td>
                                <td>{{ $app->full_name }}</td>
                                <td>{{ $app->email }}</td>
                                <td>{{ formatCurrency($app->loan_amount) }}</td>
                                <td>
                                    <span class="badge bg-{{ $app->loan_status === 'approved' ? 'success' : ($app->loan_status === 'rejected' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($app->loan_status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $app->identity_status === 'verified' ? 'success' : 'secondary' }}">
                                        {{ ucfirst(str_replace('_', ' ', $app->identity_status)) }}
                                    </span>
                                </td>
                                <td>{{ $app->submitted_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.applications.show', $app) }}" class="btn btn-sm btn-primary"><i class="bi bi-eye"></i></a>
                                    @if($app->loan_status === 'pending')
                                        <form action="{{ route('admin.applications.approve', $app) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Approve this application?')"><i class="bi bi-check"></i></button>
                                        </form>
                                        <button class="btn btn-sm btn-danger" onclick="showRejectForm({{ $app->id }})"><i class="bi bi-x"></i></button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">No applications found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $applications->links() }}
            </div>
        </div>
    </div>

    <form id="logout" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
