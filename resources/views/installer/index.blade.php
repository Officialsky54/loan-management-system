<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ setting('website_title') }} - Installer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; }
        .installer-container { background: white; border-radius: 10px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); padding: 40px; max-width: 600px; }
        .installer-header { text-align: center; margin-bottom: 30px; }
        .installer-header h1 { color: #667eea; margin-bottom: 10px; }
        .form-group { margin-bottom: 20px; }
        .form-label { font-weight: 600; color: #333; }
        .btn-install { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 12px 30px; font-weight: 600; }
        .progress { display: none; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="installer-container">
        <div class="installer-header">
            <h1>🚀 Installation Wizard</h1>
            <p>Setup your Loan Management System</p>
        </div>

        <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
        </div>

        <form id="installerForm">
            <h5 class="mb-3">Database Configuration</h5>
            <div class="form-group">
                <label class="form-label">Database Host</label>
                <input type="text" class="form-control" name="db_host" value="localhost" required>
            </div>
            <div class="form-group">
                <label class="form-label">Database Name</label>
                <input type="text" class="form-control" name="db_name" required>
            </div>
            <div class="form-group">
                <label class="form-label">Database User</label>
                <input type="text" class="form-control" name="db_user" value="root" required>
            </div>
            <div class="form-group">
                <label class="form-label">Database Password</label>
                <input type="password" class="form-control" name="db_password">
            </div>

            <hr>
            <h5 class="mb-3">Website Configuration</h5>
            <div class="form-group">
                <label class="form-label">Website URL</label>
                <input type="url" class="form-control" name="website_url" value="http://localhost" required>
            </div>

            <hr>
            <h5 class="mb-3">Admin Account</h5>
            <div class="form-group">
                <label class="form-label">Admin Email</label>
                <input type="email" class="form-control" name="admin_email" required>
            </div>
            <div class="form-group">
                <label class="form-label">Admin Username</label>
                <input type="text" class="form-control" name="admin_username" required>
            </div>
            <div class="form-group">
                <label class="form-label">Admin Password</label>
                <input type="password" class="form-control" name="admin_password" required>
            </div>
            <div class="form-group">
                <label class="form-label">Confirm Password</label>
                <input type="password" class="form-control" name="admin_password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-primary btn-install w-100 mt-4">Complete Installation</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('installerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            document.querySelector('.progress').style.display = 'block';
            
            fetch('{{ route("installer.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(Object.fromEntries(new FormData(this)))
            })
            .then(r => r.json())
            .then(data => {
                if(data.success) {
                    alert('Installation completed successfully! Redirecting...');
                    window.location.href = '/admin/dashboard';
                } else {
                    alert('Error: ' + data.message);
                    document.querySelector('.progress').style.display = 'none';
                }
            })
            .catch(e => {
                alert('Installation failed: ' + e.message);
                document.querySelector('.progress').style.display = 'none';
            });
        });
    </script>
</body>
</html>
