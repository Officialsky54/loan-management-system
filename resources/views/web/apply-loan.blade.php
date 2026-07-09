<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Loan - {{ setting('website_title') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --primary: #667eea; --secondary: #764ba2; }
        body { background: #f8f9fa; }
        .form-container { background: white; border-radius: 10px; box-shadow: 0 2px 15px rgba(0,0,0,0.1); padding: 30px; }
        .form-step { display: none; }
        .form-step.active { display: block; }
        .progress-indicator { display: flex; justify-content: space-between; margin-bottom: 30px; }
        .step { text-align: center; flex: 1; }
        .step-number { width: 40px; height: 40px; border-radius: 50%; background: #e9ecef; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: 600; }
        .step.active .step-number { background: var(--primary); color: white; }
        .btn-next, .btn-submit { background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); border: none; }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="form-container" style="max-width: 600px; margin: 0 auto;">
            <h2 class="mb-4">Apply for a Loan</h2>
            
            <form id="loanApplicationForm" enctype="multipart/form-data">
                @csrf
                
                <!-- Personal Information -->
                <div class="form-step active">
                    <h5 class="mb-3">Personal Information</h5>
                    <div class="mb-3">
                        <label class="form-label">Full Name *</label>
                        <input type="text" class="form-control" name="full_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date of Birth *</label>
                        <input type="date" class="form-control" name="date_of_birth" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone *</label>
                        <input type="tel" class="form-control" name="phone" required>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="form-step">
                    <h5 class="mb-3">Address Information</h5>
                    <div class="mb-3">
                        <label class="form-label">Address *</label>
                        <input type="text" class="form-control" name="address" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">City *</label>
                        <input type="text" class="form-control" name="city" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Country *</label>
                        <input type="text" class="form-control" name="country" required>
                    </div>
                </div>

                <!-- Employment Information -->
                <div class="form-step">
                    <h5 class="mb-3">Employment Information</h5>
                    <div class="mb-3">
                        <label class="form-label">Employment Status *</label>
                        <select class="form-control" name="employment_status" required>
                            <option value="">Select...</option>
                            <option value="employed">Employed</option>
                            <option value="self_employed">Self Employed</option>
                            <option value="retired">Retired</option>
                            <option value="student">Student</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Monthly Income *</label>
                        <input type="number" class="form-control" name="monthly_income" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Employer Name</label>
                        <input type="text" class="form-control" name="employer_name">
                    </div>
                </div>

                <!-- Loan Details -->
                <div class="form-step">
                    <h5 class="mb-3">Loan Details</h5>
                    <div class="mb-3">
                        <label class="form-label">Loan Amount ({{ setting('currency_symbol') }}) *</label>
                        <input type="number" class="form-control" name="loan_amount" step="0.01" min="{{ $minAmount }}" max="{{ $maxAmount }}" required>
                        <small class="text-muted">Min: {{ formatCurrency($minAmount) }}, Max: {{ formatCurrency($maxAmount) }}</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Loan Duration (months) *</label>
                        <select class="form-control" name="loan_duration" required>
                            <option value="">Select...</option>
                            @foreach($durations as $duration)
                                <option value="{{ $duration }}">{{ $duration }} months</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Loan Purpose *</label>
                        <textarea class="form-control" name="loan_purpose" rows="3" required></textarea>
                    </div>
                </div>

                <!-- Documents -->
                <div class="form-step">
                    <h5 class="mb-3">Documents</h5>
                    <div class="mb-3">
                        <label class="form-label">ID Card/Passport (PDF, JPG, PNG) *</label>
                        <input type="file" class="form-control" name="id_card" accept=".pdf,.jpg,.jpeg,.png" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Passport Photo (JPG, PNG) *</label>
                        <input type="file" class="form-control" name="passport_photo" accept=".jpg,.jpeg,.png" required>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="mt-4 d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" id="prevBtn" style="display:none;" onclick="changeStep(-1)">Previous</button>
                    <button type="button" class="btn btn-next" id="nextBtn" onclick="changeStep(1)">Next</button>
                    <button type="submit" class="btn btn-submit" id="submitBtn" style="display:none;">Submit Application</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentStep = 0;
        const steps = document.querySelectorAll('.form-step');
        const totalSteps = steps.length;

        function changeStep(n) {
            if(n > 0) {
                if(!validateStep(currentStep)) return;
                currentStep = Math.min(currentStep + 1, totalSteps - 1);
            } else {
                currentStep = Math.max(currentStep - 1, 0);
            }
            showStep(currentStep);
        }

        function showStep(n) {
            steps.forEach((step, i) => {
                step.classList.toggle('active', i === n);
            });
            
            document.getElementById('prevBtn').style.display = n > 0 ? 'block' : 'none';
            document.getElementById('nextBtn').style.display = n < totalSteps - 1 ? 'block' : 'none';
            document.getElementById('submitBtn').style.display = n === totalSteps - 1 ? 'block' : 'none';
        }

        function validateStep(n) {
            const step = steps[n];
            const inputs = step.querySelectorAll('input[required], select[required], textarea[required]');
            
            for(let input of inputs) {
                if(!input.value) {
                    alert('Please fill all required fields');
                    return false;
                }
            }
            return true;
        }

        document.getElementById('loanApplicationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('{{ route("apply-loan.store") }}', {
                method: 'POST',
                body: formData
            })
            .then(r => r.json())
            .then(data => {
                if(data.success) {
                    alert('Application submitted successfully!\nYour reference ID: ' + data.reference_id);
                    window.location.href = '/track';
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(e => alert('Error: ' + e.message));
        });

        showStep(0);
    </script>
</body>
</html>
