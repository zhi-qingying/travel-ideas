<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Travel Ideas')); ?></title>
    

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="<?php echo e(asset('css/ideas.css')); ?>">


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
                <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
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
                        <?php if(auth()->guard()->check()): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(url('/ideas')); ?>">📋 All Ideas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(url('/ideas/create')); ?>">➕ Create Idea</a>
                            </li>
                        <?php endif; ?>
                    </ul>

                    <!-- Right Side Navigation -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Guest (Not Logged In) -->
                        <?php if(auth()->guard()->guest()): ?>
                            <?php if(Route::has('login')): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo e(route('login')); ?>">🔐 Login</a>
                                </li>
                            <?php endif; ?>
                            <?php if(Route::has('register')): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo e(route('register')); ?>">📝 Register</a>
                                </li>
                            <?php endif; ?>
                        <?php else: ?>
                            <!-- User (Logged In) -->
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php if(Auth::user()->profile_picture): ?>
                                        <img src="<?php echo e(asset('storage/' . Auth::user()->profile_picture)); ?>" class="avatar-small me-1">
                                    <?php endif; ?>
                                    <?php echo e(Auth::user()->name); ?>

                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <!-- Profile Link -->
                                    <a class="dropdown-item" href="<?php echo e(route('profile.show', Auth::id())); ?>">
                                        👤 My Profile
                                    </a>
                                    
                                    
                                    <div class="dropdown-divider"></div>
                                    
                                    <!-- Logout Link -->
                                    <a class="dropdown-item text-danger" href="<?php echo e(route('logout')); ?>"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        🚪 Logout
                                    </a>

                                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                        <?php echo csrf_field(); ?>
                                    </form>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="py-4">
            <div class="container">
                <!-- Success Message -->
                <?php if(session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>✓ Success!</strong> <?php echo e(session('success')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Error Message -->
                <?php if(session('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>✗ Error!</strong> <?php echo e(session('error')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Page Content -->
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </main>

        <!-- Footer -->
        <footer>
            <div class="container text-center">
                <p class="mb-0 text-muted">
                    &copy; <?php echo e(date('Y')); ?> Travel Ideas. Share your travel experiences with friends!
                </p>
            </div>
        </footer>
    </div>

    <!-- Bootstrap JavaScript Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery (required for AJAX comments later) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Custom JavaScript -->
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/travel-ideas/resources/views/layouts/app.blade.php ENDPATH**/ ?>