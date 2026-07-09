<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Calculator - {{ setting('website_title') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --primary: #667eea; --secondary: #764ba2; }
        body { background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); min-height: 100vh; display: flex; align-items: center; }
        .calculator { background: white; border-radius: 15px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); padding: 40px; max-width: 600px; margin: 0 auto; }
        .result-box { background: #f8f9fa; border-radius: 10px; padding: 20px; margin-top: 20px; }
        .result-item { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #dee2e6; }
        .result-item:last-child { border-bottom: none; }
        .result-label { color: #666; }
        .result-value { font-weight: 600; color: var(--primary); }
    </style>
</head>
<body>
    <div class="calculator">
        <h2 class="mb-4 text-center">📊 Loan Calculator</h2>
        
        <form id="calculatorForm">
            <div class="mb-3">
                <label class="form-label">Loan Amount ({{ setting('currency_symbol') }})</label>
                <input type="range" class="form-range" id="loanAmount" min="{{ $minAmount }}" max="{{ $maxAmount }}" value="{{ ($minAmount + $maxAmount) / 2 }}" step="1000">
                <div class="input-group mt-2">
                    <span class="input-group-text">{{ setting('currency_symbol') }}</span>
                    <input type="number" class="form-control" id="loanAmountInput" value="{{ ($minAmount + $maxAmount) / 2 }}" step="1000">
                </div>
                <small class="text-muted">Range: {{ formatCurrency($minAmount) }} - {{ formatCurrency($maxAmount) }}</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Loan Duration (Months)</label>
                <input type="range" class="form-range" id="duration" min="6" max="60" value="24" step="1">
                <div class="input-group mt-2">
                    <input type="number" class="form-control" id="durationInput" value="24" min="6" max="60" step="1">
                    <span class="input-group-text">months</span>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Annual Interest Rate (%)</label>
                <input type="number" class="form-control" id="rate" value="{{ setting('interest_rate', 5.5) }}" step="0.1" readonly>
            </div>
        </form>

        <div id="results" class="result-box">
            <div class="result-item">
                <span class="result-label">Monthly Payment:</span>
                <span class="result-value" id="monthlyPayment">-</span>
            </div>
            <div class="result-item">
                <span class="result-label">Total Interest:</span>
                <span class="result-value" id="totalInterest">-</span>
            </div>
            <div class="result-item">
                <span class="result-label">Total Repayment:</span>
                <span class="result-value" id="totalRepayment">-</span>
            </div>
        </div>

        <a href="{{ route('apply-loan') }}" class="btn btn-primary w-100 mt-4">Apply for This Loan</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const loanAmount = document.getElementById('loanAmount');
        const loanAmountInput = document.getElementById('loanAmountInput');
        const duration = document.getElementById('duration');
        const durationInput = document.getElementById('durationInput');
        const rate = parseFloat(document.getElementById('rate').value);

        function calculateLoan() {
            const amount = parseFloat(loanAmountInput.value);
            const months = parseInt(durationInput.value);
            const monthlyRate = (rate / 100) / 12;

            let monthly = amount / months;
            if (monthlyRate > 0) {
                monthly = (amount * monthlyRate * Math.pow(1 + monthlyRate, months)) / 
                         (Math.pow(1 + monthlyRate, months) - 1);
            }

            const totalPaid = monthly * months;
            const totalInterest = totalPaid - amount;

            const currencySymbol = '{{ setting("currency_symbol") }}';
            document.getElementById('monthlyPayment').textContent = currencySymbol + monthly.toFixed(2);
            document.getElementById('totalInterest').textContent = currencySymbol + totalInterest.toFixed(2);
            document.getElementById('totalRepayment').textContent = currencySymbol + totalPaid.toFixed(2);
        }

        loanAmount.addEventListener('input', function() {
            loanAmountInput.value = this.value;
            calculateLoan();
        });

        loanAmountInput.addEventListener('input', function() {
            loanAmount.value = this.value;
            calculateLoan();
        });

        duration.addEventListener('input', function() {
            durationInput.value = this.value;
            calculateLoan();
        });

        durationInput.addEventListener('input', function() {
            duration.value = this.value;
            calculateLoan();
        });

        calculateLoan();
    </script>
</body>
</html>
