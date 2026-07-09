<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Application - {{ setting('website_title') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --primary: #667eea; --secondary: #764ba2; }
        body { background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); min-height: 100vh; display: flex; align-items: center; }
        .tracker-container { background: white; border-radius: 10px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); padding: 40px; max-width: 600px; margin: 0 auto; }
        .tracker-header { text-align: center; margin-bottom: 30px; }
        .tracker-header h1 { color: var(--primary); margin-bottom: 10px; }
        .timeline { position: relative; padding: 20px 0; }
        .timeline-item { position: relative; margin-bottom: 30px; padding-left: 40px; }
        .timeline-item:before { content: ''; position: absolute; left: 0; top: 0; width: 20px; height: 20px; background: var(--primary); border-radius: 50%; }
        .timeline-item.completed:before { background: #28a745; }
        .timeline-item.pending:before { background: #ffc107; }
        .timeline-label { font-weight: 600; color: #333; }
        .timeline-date { color: #6c757d; font-size: 0.9em; }
    </style>
</head>
<body>
    <div class="tracker-container">
        <div class="tracker-header">
            <h1>📍 Track Your Application</h1>
            <p>Check the status of your loan application</p>
        </div>

        <form id="trackForm" class="mb-4">
            <div class="mb-3">
                <label class="form-label">Reference ID</label>
                <input type="text" class="form-control" id="reference_id" placeholder="e.g., LN-20240709-000001" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" required>
            </div>
            <button type="submit" class="btn btn-primary w-100" style="background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); border: none;">Track Application</button>
        </form>

        <div id="resultContainer" style="display: none;">
            <h5 class="mb-3">Application Status</h5>
            <div class="alert alert-info mb-3">
                <strong>Reference ID:</strong> <span id="displayRefId"></span><br>
                <strong>Applicant:</strong> <span id="displayName"></span>
            </div>

            <div class="timeline">
                <div class="timeline-item" id="step1">
                    <div class="timeline-label">✓ Application Received</div>
                    <div class="timeline-date"><span id="date1"></span></div>
                </div>
                <div class="timeline-item" id="step2">
                    <div class="timeline-label">Identity Verification</div>
                    <div class="timeline-date"><span id="date2"></span></div>
                </div>
                <div class="timeline-item" id="step3">
                    <div class="timeline-label">Bank Details Review</div>
                    <div class="timeline-date"><span id="date3"></span></div>
                </div>
                <div class="timeline-item" id="step4">
                    <div class="timeline-label">Final Decision</div>
                    <div class="timeline-date"><span id="date4"></span></div>
                </div>
            </div>

            <div class="alert mt-4" id="statusAlert">
                <strong>Current Status:</strong> <span id="statusText"></span>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('trackForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const referenceId = document.getElementById('reference_id').value;
            const email = document.getElementById('email').value;
            
            fetch('{{ route("track.search") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ reference_id: referenceId, email: email })
            })
            .then(r => r.json())
            .then(data => {
                if(data.success) {
                    const app = data.data;
                    document.getElementById('displayRefId').textContent = app.reference_id;
                    document.getElementById('displayName').textContent = app.full_name;
                    document.getElementById('date1').textContent = app.submitted_at;
                    
                    const statusMap = {
                        'pending': 'pending',
                        'verified': 'completed',
                        'processing': 'completed',
                        'approved': 'completed',
                        'rejected': 'pending'
                    };
                    
                    const status = statusMap[app.loan_status] || 'pending';
                    document.getElementById('step' + (app.loan_status === 'approved' ? '4' : '2')).classList.add(status);
                    
                    document.getElementById('statusText').textContent = app.loan_status.toUpperCase();
                    document.getElementById('statusAlert').className = 'alert mt-4 alert-' + (app.loan_status === 'approved' ? 'success' : (app.loan_status === 'rejected' ? 'danger' : 'warning'));
                    
                    document.getElementById('resultContainer').style.display = 'block';
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(e => alert('Error: ' + e.message));
        });
    </script>
</body>
</html>
