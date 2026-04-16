<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Travel Ideas') }}</title>
    

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/ideas.css') }}">


    <!-- Custom Styles -->
    <style>
        .navbar-brand {
            font-weight: bold;
        }
        .avatar-small {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
        }
        footer {
            margin-top: auto;
            background-color: #f8f9fa;
            padding: 20px 0;
            border-top: 1px solid #dee2e6;
        }
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        .container {
            flex: 1;
        }
    </style>
</head>
<body>
    <div id="app">
        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                <!-- Brand / Logo -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    ✈️ Travel Ideas
                </a>
                
                <!-- Mobile Toggle Button -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navigation Links -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Navigation -->
                    <ul class="navbar-nav me-auto">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/ideas') }}">📋 All Ideas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/ideas/create') }}">➕ Create Idea</a>
                            </li>
                        @endauth
                    </ul>

                    <!-- Right Side Navigation -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Guest (Not Logged In) -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">🔐 Login</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">📝 Register</a>
                                </li>
                            @endif
                        @else
                            <!-- User (Logged In) -->
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @if(Auth::user()->profile_picture)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" class="avatar-small me-1">
                                    @endif
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <!-- Profile Link -->
                                    <a class="dropdown-item" href="{{ route('profile.show', Auth::id()) }}">
                                        👤 My Profile
                                    </a>
                                    
                                    
                                    <div class="dropdown-divider"></div>
                                    
                                    <!-- Logout Link -->
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        🚪 Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="py-4">
            <div class="container">
                <!-- Success Message -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>✓ Success!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Error Message -->
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>✗ Error!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer>
            <div class="container text-center">
                <p class="mb-0 text-muted">
                    &copy; {{ date('Y') }} Travel Ideas. Share your travel experiences with friends!
                </p>
            </div>
        </footer>
    </div>

    <!-- Bootstrap JavaScript Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery (required for AJAX comments later) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Custom JavaScript -->
    @stack('scripts')
</body>
</html>