<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - {{ setting('website_title') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --primary: #667eea; --secondary: #764ba2; }
        .hero { background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); color: white; padding: 80px 0; }
        .feature-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; margin: 40px 0; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/"><strong>{{ setting('company_name') }}</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('about') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('services') }}">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('apply-loan') }}">Apply Now</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="hero">
        <div class="container">
            <h1 class="display-4 fw-bold">About {{ setting('company_name') }}</h1>
            <p class="lead">Empowering dreams through accessible lending</p>
        </div>
    </div>

    <div class="container my-5">
        <div class="row mb-5">
            <div class="col-md-6">
                <h2>Our Mission</h2>
                <p>We are committed to providing fast, transparent, and accessible loan services to individuals and businesses. Our mission is to make financial support available to those who need it most, with minimal hassle and maximum transparency.</p>
                <p>With our innovative platform and dedicated team, we strive to simplify the loan application process and help our customers achieve their financial goals.</p>
            </div>
            <div class="col-md-6">
                <h2>Our Vision</h2>
                <p>To be the leading digital lending platform, known for our customer-centric approach, innovative solutions, and commitment to financial inclusion.</p>
                <p>We envision a future where financial support is just a few clicks away, where credit is accessible to everyone regardless of their background, and where lending is transparent and fair.</p>
            </div>
        </div>

        <hr class="my-5">

        <h2 class="mb-4">Why Choose Us?</h2>
        <div class="feature-grid">
            <div class="p-4 border rounded">
                <h5>⚡ Fast Approval</h5>
                <p>Get your loan approved within 24 hours with our streamlined process.</p>
            </div>
            <div class="p-4 border rounded">
                <h5>🔒 Secure & Safe</h5>
                <p>Your data is protected with industry-leading security measures.</p>
            </div>
            <div class="p-4 border rounded">
                <h5>💰 Competitive Rates</h5>
                <p>Enjoy some of the lowest interest rates in the market.</p>
            </div>
            <div class="p-4 border rounded">
                <h5>📱 Easy Application</h5>
                <p>Simple, user-friendly interface for seamless experience.</p>
            </div>
            <div class="p-4 border rounded">
                <h5>📞 24/7 Support</h5>
                <p>Our customer support team is always ready to help.</p>
            </div>
            <div class="p-4 border rounded">
                <h5>✅ Transparent Terms</h5>
                <p>No hidden charges, everything is clear and upfront.</p>
            </div>
        </div>
    </div>

    <div class="bg-light py-5 my-5">
        <div class="container">
            <h2 class="mb-4 text-center">Our Team</h2>
            <p class="text-center mb-4">We are a dedicated team of finance professionals committed to providing the best lending experience.</p>
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <div class="p-4">
                        <h5>👔 Management</h5>
                        <p>Experienced leaders with decades of financial expertise</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="p-4">
                        <h5>💻 Technology</h5>
                        <p>Innovative developers building cutting-edge solutions</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="p-4">
                        <h5>🎯 Customer Support</h5>
                        <p>Friendly professionals dedicated to your success</p>
                    </div>
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
