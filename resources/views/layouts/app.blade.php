<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyKasir</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4A90E2;
            --primary-light: #6aadf9;
            --primary-dark: #3a75c4;
            --secondary-color: #50E3C2;
            --dark-color: #2C3E50;
            --light-color: #F5F7FA;
            --error-color: #E74C3C;
            --gradient-primary: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            --gradient-dark: linear-gradient(135deg, var(--dark-color) 0%, #1a2530 100%);
            --bg-color: #f8f9fa;
            --text-color: #333;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --card-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
            --transition-normal: all 0.3s ease;
            --transition-fast: all 0.2s ease;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar Styles */
        .navbar {
            background: var(--gradient-primary);
            padding: 0.5rem 1rem;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1.5rem;
            color: white !important;
            display: flex;
            align-items: center;
            transition: var(--transition-normal);
        }

        .navbar-brand:hover { transform: scale(1.05); }
        .navbar-brand i { margin-right: 10px; font-size: 1.4rem; }

        .nav-link {
            color: white !important;
            font-weight: 500;
            padding: 0.5rem 0.9rem;
            border-radius: 6px;
            transition: var(--transition-normal);
            margin: 0 2px;
            position: relative;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        .nav-item.active .nav-link {
            background-color: var(--primary-color);
            color: white !important;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        .nav-link i { margin-right: 6px; }
        
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 5px;
            left: 50%;
            background-color: white;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover::after { width: 60%; }

        /* Main Content */
        .container-fluid {
            margin-top: 70px;
            padding: 0 1.2rem;
            flex: 1;
        }

        /* Card Styles */
        .card {
            background: white;
            border: none;
            border-radius: 10px;
            box-shadow: var(--card-shadow);
            transition: var(--transition-normal);
            margin-bottom: 20px;
            overflow: hidden;
        }
        
        .card:hover {
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
            transform: translateY(-3px);
        }

        .card-header {
            background: var(--primary-color);
            color: white;
            font-weight: 600;
            padding: 1rem 1.2rem;
            border-bottom: none;
            border-radius: 10px 10px 0 0 !important;
            position: relative;
            overflow: hidden;
        }
        
        .card-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(45deg);
            transition: all 0.8s ease;
            opacity: 0;
            pointer-events: none;
        }
        
        .card:hover .card-header::before {
            opacity: 1;
            transform: rotate(45deg) translateX(10%);
        }

        .card-body { padding: 1.2rem; }

        /* Button Styles */
        .btn {
            border-radius: 6px;
            padding: 0.5rem 1.1rem;
            font-weight: 500;
            transition: var(--transition-normal);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: all 0.4s ease;
            z-index: -1;
        }
        
        .btn:hover::before { left: 0; }

        .btn-primary {
            background: var(--primary-color);
            border: none;
            box-shadow: 0 3px 8px rgba(74, 144, 226, 0.25);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 12px rgba(74, 144, 226, 0.35);
        }
        
        .btn-primary:active { transform: translateY(0); }

        .btn-success {
            background: var(--success-color);
            border: none;
            box-shadow: 0 3px 8px rgba(40, 167, 69, 0.25);
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 12px rgba(40, 167, 69, 0.35);
        }

        .btn-danger {
            background: var(--error-color);
            border: none;
            box-shadow: 0 3px 8px rgba(231, 76, 60, 0.25);
        }
        
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 12px rgba(231, 76, 60, 0.35);
        }

        /* Alert Styles */
        .alert {
            border-radius: 8px;
            padding: 0.9rem 1.2rem;
            border-left: 4px solid;
            animation: fadeInDown 0.5s;
        }
        
        .alert-success {
            border-left-color: var(--success-color);
            background-color: rgba(40, 167, 69, 0.1);
        }
        
        .alert-danger {
            border-left-color: var(--error-color);
            background-color: rgba(231, 76, 60, 0.1);
        }

        /* Table Styles */
        .table {
            color: var(--text-color);
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead th {
            background: var(--primary-color);
            color: white;
            font-weight: 600;
            padding: 0.8rem;
            border: none;
        }
        
        .table thead th:first-child { border-radius: 8px 0 0 0; }
        .table thead th:last-child { border-radius: 0 8px 0 0; }
        
        .table tbody tr { transition: var(--transition-fast); }
        .table tbody tr:hover { background-color: rgba(74, 144, 226, 0.05); }
        
        .table tbody td {
            padding: 0.8rem;
            border-top: none;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        /* Form Styles */
        .form-control, .form-select {
            border-radius: 6px;
            padding: 0.6rem 1rem;
            border: 1px solid rgba(0, 0, 0, 0.1);
            transition: var(--transition-normal);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.2);
            transform: translateY(-1px);
        }

        .form-label {
            font-weight: 500;
            color: var(--primary-dark);
            margin-bottom: 0.5rem;
        }

        /* Footer Styles */
        .footer {
            background: var(--gradient-primary);
            color: white;
            padding: 1rem 0;
            margin-top: 2rem;
            text-align: center;
            box-shadow: 0 -3px 10px rgba(0, 0, 0, 0.1);
        }
        
        /* Landing Animation */
        .landing-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--gradient-primary);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: all 0.5s ease;
        }
        
        .landing-animation.hide {
            opacity: 0;
            visibility: hidden;
            transform: scale(1.1);
        }
        
        .logo-container {
            margin-bottom: 25px;
            animation: fadeInUp 1s;
        }

        .logo {
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            animation: pulse 2s infinite, float 3s ease-in-out infinite;
            position: relative;
            overflow: hidden;
        }
        
        .logo::before {
            content: '';
            position: absolute;
            width: 150%;
            height: 150%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(45deg);
            animation: rotate 6s linear infinite;
        }
        
        .loading-text {
            font-size: 1.3rem;
            color: white;
            margin-top: 25px;
            letter-spacing: 1px;
            animation: fadeIn 1s;
        }
        
        .loading-text::after {
            content: '';
            animation: dots 1.5s infinite;
        }
        
        /* Page title */
        .page-title {
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
            padding-bottom: 5px;
        }
        
        .page-title::after {
            content: '';
            position: absolute;
            width: 60%;
            height: 3px;
            background: var(--gradient-primary);
            bottom: 0;
            left: 0;
            border-radius: 2px;
        }
        
        /* Animation classes */
        .fade-in-up { animation: fadeInUp 0.5s; }
        .fade-in { animation: fadeIn 0.5s; }
        
        /* Badge styles */
        .badge {
            font-weight: 500;
            padding: 0.4em 0.8em;
            border-radius: 30px;
        }
        
        .badge-primary { background-color: var(--primary-color); }
        .badge-success { background-color: var(--success-color); }
        .badge-warning { background-color: var(--warning-color); color: #212529; }
        .badge-danger { background-color: var(--error-color); }
        
        /* Stats boxes */
        .stats-box {
            border-radius: 10px;
            padding: 1.2rem;
            color: white;
            box-shadow: var(--card-shadow);
            transition: var(--transition-normal);
            position: relative;
            overflow: hidden;
            z-index: 1;
            height: 100%;
        }
        
        .stats-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        
        .stats-box::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.03);
            top: -50%;
            left: -50%;
            transform: rotate(35deg);
            transition: all 0.5s ease;
            z-index: -1;
        }
        
        .stats-box:hover::before { transform: rotate(35deg) translateX(10%); }
        
        .stats-box.primary { background: var(--primary-color); }
        .stats-box.success { background: var(--success-color); }
        .stats-box.warning { background: var(--warning-color); color: #212529; }
        .stats-box.danger { background: var(--error-color); }
        
        .stats-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            opacity: 0.8;
        }
        
        .stats-number {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .stats-title {
            font-size: 1rem;
            opacity: 0.9;
        }
        
        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .container-fluid {
                padding: 0 1rem;
                margin-top: 65px;
            }
            
            .navbar-collapse {
                background: var(--primary-color);
                margin-top: 10px;
                border-radius: 8px;
                padding: 10px; 
                animation: fadeIn 0.3s;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            }
            
            .nav-item { margin: 5px 0; }
            
            .table-responsive {
                border-radius: 8px;
                overflow: hidden;
            }
        }
        
        /* Keyframe Animations */
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes fadeInUp { 
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInDown { 
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes rotate {
            0% { transform: rotate(0deg) translateX(-50%); }
            100% { transform: rotate(360deg) translateX(-50%); }
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4); }
            70% { box-shadow: 0 0 0 15px rgba(255, 255, 255, 0); }
            100% { box-shadow: 0 0 0 0 rgba(255, 255, 255, 0); }
        }
        @keyframes dots {
            0%, 20% { content: '.'; }
            40%, 60% { content: '..'; }
            80%, 100% { content: '...'; }
        }
    </style>
</head>
<body>
    <!-- Landing Animation -->
    @auth
    <div class="landing-animation" id="landing-animation">
        <div class="logo-container">
            <div class="logo">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="50" height="50">
                    <path d="M4 6h16v2H4zm2-4h12v2H6zm14 8H4c-1.1 0-2 .9-2 2v8c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2v-8c0-1.1-.9-2-2-2zm0 10H4v-8h16v8zm-10-7h6v2h-6z"/>
                </svg>
            </div>
        </div>
        <div class="loading-text">Sabar yah</div>
    </div>
    @endauth

    <!-- Main Content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                
                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                
                @hasSection('title')
                <h4 class="page-title fade-in">@yield('title')</h4>
                @endif
                
                @yield('content')
            </div>
        </div>
    </div>

    @auth
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} EasyKasir. Hak Cipta Dilindungi.</p>
        </div>
    </footer>
    @endauth

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
            
            // Hide landing animation after 2 seconds
            setTimeout(function() {
                $('#landing-animation').addClass('hide');
                setTimeout(function() {
                    $('#landing-animation').remove();
                }, 500);
            }, 2000);
            
            // Add loading animation for form submissions
            $('form').submit(function() {
                let submitBtn = $(this).find('button[type="submit"]');
                let originalText = submitBtn.html();
                
                submitBtn.html(
                    '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Processing...'
                ).prop('disabled', true);
                
                submitBtn.data('original-text', originalText);
            });
            
            // Tambahkan animasi untuk card masuk ke halaman
            $('.card').each(function(index) {
                $(this).addClass('fade-in-up');
                $(this).css('animation-delay', (index * 0.1) + 's');
            });
            
            // Animasi tooltip
            $('[data-bs-toggle="tooltip"]').tooltip();
            
            // Smooth scroll untuk link internal
            $('a[href^="#"]').on('click', function(e) {
                e.preventDefault();
                
                $('html, body').animate({
                    scrollTop: $($(this).attr('href')).offset().top - 70
                }, 500, 'linear');
            });
        });
    </script>
    @yield('scripts')
</body>
</html>