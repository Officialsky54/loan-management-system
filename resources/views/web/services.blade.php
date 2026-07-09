<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - {{ setting('website_title') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --primary: #667eea; --secondary: #764ba2; }
        .hero { background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); color: white; padding: 80px 0; }
        .service-card { background: white; border-radius: 10px; padding: 30px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); text-align: center; transition: transform 0.3s; }
        .service-card:hover { transform: translateY(-10px); }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/"><strong>{{ setting('company_name') }}</strong></a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('services') }}">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('apply-loan') }}">Apply Now</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="hero">
        <div class="container">
            <h1 class="display-4 fw-bold">Our Services</h1>
            <p class="lead">Comprehensive financial solutions for everyone</p>
        </div>
    </div>

    <div class="container my-5">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="service-card">
                    <h3 class="mb-3">💰 Personal Loans</h3>
                    <p>Quick and easy personal loans for any purpose. Get approved in 24 hours with minimal documentation.</p>
                    <a href="{{ route('apply-loan') }}" class="btn btn-primary mt-3">Apply Now</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-card">
                    <h3 class="mb-3">🏠 Home Loans</h3>
                    <p>Affordable home loans with flexible repayment options. Make your dream home a reality.</p>
                    <a href="{{ route('apply-loan') }}" class="btn btn-primary mt-3">Apply Now</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-card">
                    <h3 class="mb-3">🚗 Auto Loans</h3>
                    <p>Competitive rates on auto loans. Get your vehicle today with our hassle-free process.</p>
                    <a href="{{ route('apply-loan') }}" class="btn btn-primary mt-3">Apply Now</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-card">
                    <h3 class="mb-3">📚 Education Loans</h3>
                    <p>Support your education with our education loans. Invest in your future today.</p>
                    <a href="{{ route('apply-loan') }}" class="btn btn-primary mt-3">Apply Now</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-card">
                    <h3 class="mb-3">💼 Business Loans</h3>
                    <p>Start or grow your business with our flexible business loan options.</p>
                    <a href="{{ route('apply-loan') }}" class="btn btn-primary mt-3">Apply Now</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-card">
                    <h3 class="mb-3">💳 Credit Cards</h3>
                    <p>Get a credit card with attractive rewards and cashback offers.</p>
                    <a href="{{ route('apply-loan') }}" class="btn btn-primary mt-3">Apply Now</a>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p>&copy; {{ date('Y') }} {{ setting('company_name') }}. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
