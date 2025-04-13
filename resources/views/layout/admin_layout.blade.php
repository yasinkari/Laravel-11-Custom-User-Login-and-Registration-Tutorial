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
    
    <!-- Bootstrap CSS - removed duplicate link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome - removed outdated link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .sidebar {
            height: 100vh; /* Make the sidebar stretch to the full height */
            position: fixed; /* Fix the sidebar position */
            top: 0;
            left: 0;
            background-color: #343a40; /* Dark background */
            color: white;
            padding-top: 20px;
            overflow-y: auto; /* Scrollable sidebar for content overflow */
            width: 200px; /* Added explicit width */
        }

        .sidebar .nav-link {
            font-size: 16px;
            padding: 10px 20px;
        }

        .sidebar .nav-link:hover {
            background-color: #495057; /* Slight hover effect */
            color: white;
        }

        .sidebar .logout-button {
            position: absolute;
            bottom: 20px;
            width: 100%;
            padding: 10px 20px;
        }

        main {
            margin-left: 200px; /* Leave space for the sidebar */
            padding: 20px;
            flex-grow: 1; /* Allow the main content to grow */
        }
        
        /* Pagination styles */
        .pagination {
            --bs-pagination-color: #333;
            --bs-pagination-active-bg: #4e73df;
            --bs-pagination-active-border-color: #4e73df;
        }
        .pagination .page-link {
            padding: 0.5rem 0.75rem;
            margin: 0 2px;
            border-radius: 0.25rem;
        }
        .pagination .active .page-link {
            color: white;
        }
        
        /* Alert styles for Bootstrap 5 */
        .alert .btn-close {
            padding: 0.5rem 0.5rem;
            margin: -0.5rem -0.5rem -0.5rem auto;
        }
    </style>
</head>
<body>
    <div class="sidebar">
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
                <a class="nav-link text-white" href="#">
                    <i class="fas fa-shopping-cart"></i> Shopping Cart
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
        <!-- Flash messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @yield('content')
    </main>

    <!-- JavaScript dependencies - removed duplicates -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
