<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ setting('website_title') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --primary: #667eea; --secondary: #764ba2; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar { background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .hero { background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); color: white; padding: 100px 0; }
        .feature { text-align: center; padding: 30px; }
        .feature-icon { font-size: 40px; margin-bottom: 20px; }
        .footer { background: #f8f9fa; padding: 30px 0; margin-top: 50px; border-top: 1px solid #dee2e6; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="/">{{ setting('company_name') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('services') }}">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('faq') }}">FAQ</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('apply-loan') }}" style="color: var(--primary); font-weight: 600;">Apply Now</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="hero">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">{{ setting('homepage_title') }}</h1>
            <p class="lead mb-4">{{ setting('homepage_subtitle') }}</p>
            <a href="{{ route('apply-loan') }}" class="btn btn-light btn-lg">Start Your Application</a>
        </div>
    </div>

    <div class="container my-5">
        <h2 class="text-center mb-5">Why Choose Us?</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="feature">
                    <div class="feature-icon">⚡</div>
                    <h4>Fast Processing</h4>
                    <p>Get your loan application processed within 24 hours</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature">
                    <div class="feature-icon">🔒</div>
                    <h4>Secure & Safe</h4>
                    <p>Your data is encrypted and protected with latest security</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature">
                    <div class="feature-icon">💰</div>
                    <h4>Competitive Rates</h4>
                    <p>Get the best interest rates in the market</p>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h6>{{ setting('company_name') }}</h6>
                    <p class="small">{{ setting('company_address') }}</p>
                </div>
                <div class="col-md-3">
                    <h6>Quick Links</h6>
                    <ul class="list-unstyled small">
                        <li><a href="{{ route('about') }}">About Us</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                        <li><a href="{{ route('faq') }}">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>Legal</h6>
                    <ul class="list-unstyled small">
                        <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('terms') }}">Terms & Conditions</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>Contact Info</h6>
                    <p class="small">📞 {{ setting('company_phone') }}<br>📧 {{ setting('company_email') }}</p>
                </div>
            </div>
            <hr>
            <p class="text-center small text-muted mb-0">&copy; {{ date('Y') }} {{ setting('company_name') }}. All rights reserved.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
