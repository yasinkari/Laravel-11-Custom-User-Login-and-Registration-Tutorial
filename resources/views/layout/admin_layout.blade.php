<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="NILLforMan Admin Dashboard">
    <meta name="robots" content="noindex, nofollow">
    <meta name="author" content="NILLforMan">
    <meta name="theme-color" content="#343a40">
    <title>@yield('title')</title>
    
    <!-- CSS Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s;
        }

        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
            overflow-y: auto;
            width: 250px;
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar.collapsed {
            margin-left: -250px;
        }

        .sidebar .nav-link {
            font-size: 16px;
            padding: 10px 20px;
            white-space: nowrap;
        }

        .sidebar .nav-link:hover {
            background-color: #495057;
            color: white;
        }

        .sidebar .logout-button {
            position: absolute;
            bottom: 20px;
            width: 100%;
            padding: 10px 20px;
        }

        main {
            margin-left: 250px;
            padding: 20px;
            flex-grow: 1;
            transition: all 0.3s;
        }

        main.expanded {
            margin-left: 0;
        }

        .navbar {
            display: none;
            background-color: #343a40;
            padding: 1rem;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
        }

        .close-sidebar {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            display: none;
        }

        /* Color Swatch Styles */
        .color-swatch-container {
            margin: 0;
            padding: 0;
        }

        .color-swatch {
            display: block;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            border: 2px solid #dee2e6;
            cursor: pointer;
            transition: transform 0.2s, border-color 0.2s;
        }

        .form-check-input:checked + .color-swatch {
            border-color: #0d6efd;
            transform: scale(1.1);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .color-swatch:hover {
            transform: scale(1.1);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Color Radio Grid Styles */
        .color-radio-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 10px;
            margin-top: 10px;
        }

        .color-radio-item {
            text-align: center;
        }

        .color-radio-label {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .btn-check:checked + .color-radio-label {
            background-color: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }

        /* Common Grid Styles */
        .color-radio-grid,
        .tone-grid,
        .size-radio-grid { /* Added size-radio-grid */
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 15px;
            margin-top: 10px;
        }

        .color-radio-item,
        .tone-item,
        .size-radio-item { /* Added size-radio-item */
            text-align: center;
        }

        /* Common Button Styles */
        .color-btn,
        .tone-btn,
        .size-btn { /* Added size-btn */
            width: 100%;
            height: 40px;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            margin-bottom: 5px;
            position: relative;
        }

        .color-btn:hover,
        .tone-btn:hover,
        .size-btn:hover { /* Added size-btn */
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Color Radio Specific */
        .btn-check:checked + .color-btn {
            border: 3px solid #0d6efd;
            box-shadow: 0 2px 4px rgba(13, 110, 253, 0.2);
        }

        /* Tone Checkbox Specific */
        .form-check-input:checked + .tone-btn {
            border: 3px solid #0d6efd;
            box-shadow: 0 2px 4px rgba(13, 110, 253, 0.2);
        }

        /* Size Radio Specific */
        .btn-check:checked + .size-btn {
            border: 3px solid #0d6efd;
            background-color: #0d6efd;
            color: white;
            box-shadow: 0 2px 4px rgba(13, 110, 253, 0.2);
        }

        /* Label Styles */
        .color-label,
        .tone-label,
        .size-label { /* Added size-label */
            display: block;
            font-size: 0.875rem;
            margin-top: 4px;
            color: #495057;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
            }
            
            .close-sidebar {
                display: block;
            }
            
            .sidebar.active {
                margin-left: 0;
            }

            main {
                margin-left: 0;
                padding: 0;
                padding-top: 20px;
                width: 100%;
            }

            .navbar {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .menu-toggle {
                display: block;
            }

            .color-radio-grid,
            .tone-grid,
            .size-radio-grid { /* Added size-radio-grid */
                grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            }

            .size-item {
                flex-direction: column;
            }

            .size-item .col-md-5,
            .size-item .col-md-2 {
                width: 100%;
                margin-bottom: 10px;
            }
        }

        @media (max-width: 576px) {
            .color-radio-grid,
            .tone-grid,
            .size-radio-grid { /* Added size-radio-grid */
                grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
                gap: 8px;
            }

            .color-label,
            .tone-label,
            .size-label { /* Added size-label */
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <button class="menu-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <span class="text-white">NILLforMan Admin</span>
    </nav>

    <div class="sidebar">
        <button class="close-sidebar d-md-none">
            <i class="fas fa-times"></i>
        </button>
        <ul class="nav flex-column">
            <li class="nav-item mb-2">
                <a class="nav-link text-white active" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-white" href="{{ route('products.index') }}">
                    <i class="fas fa-box"></i> Manage Products
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-white" href="{{ route('promotions.index') }}">
                    <i class="fas fa-tag"></i> Manage Promotions
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-white" href="#">
                    <i class="fas fa-shopping-cart"></i> Manage Order
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-white" href="#">
                    <i class="fas fa-chart-bar"></i> Reports
                </a>
            </li>
        </ul>
        <form method="POST" action="{{ route('admin.logout') }}" class="logout-button">
            @csrf
            <button type="submit" class="btn btn-link nav-link text-danger text-start w-100">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>

    <main>
        @yield('content')
    </main>

    <!-- JavaScript Dependencies -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#sidebarToggle').on('click', function() {
                $('.sidebar').toggleClass('active');
                $('main').toggleClass('expanded');
            });

            // Close sidebar when clicking outside on mobile
            $(document).on('click', function(e) {
                if ($(window).width() <= 768) {
                    if (!$(e.target).closest('.sidebar').length && !$(e.target).closest('#sidebarToggle').length) {
                        $('.sidebar').removeClass('active');
                        $('main').addClass('expanded');
                    }
                }
            });

            // Handle window resize
            $(window).resize(function() {
                if ($(window).width() > 768) {
                    $('.sidebar').removeClass('active');
                    $('main').removeClass('expanded');
                }
            });
            $('.close-sidebar').on('click', function() {
                $('.sidebar').removeClass('active');
                $('main').addClass('expanded');
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
