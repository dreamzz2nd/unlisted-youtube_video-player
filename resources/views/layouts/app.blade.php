<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'E-Learning Protected Video Player')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    
    <!-- Plyr.js Video Player CSS -->
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    
    <!-- Custom E-Learning Player CSS -->
    <link rel="stylesheet" href="{{ asset('css/elearning-player.css') }}">

    <!-- Feather Icons / FontAwesome Icons (SVG lightweight) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased selection:bg-indigo-500 selection:text-white">

    <!-- Top Navigation Bar -->
    <header class="app-header">
        <div class="header-container">
            <div class="logo-group">
                <a href="/" class="brand-logo">
                    <div class="brand-badge">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div class="brand-text">
                        <span class="brand-title">EduSecure</span>
                        <span class="brand-tag">LMS Player</span>
                    </div>
                </a>
            </div>

            <div class="header-center">
                <div class="course-badge">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <span>{{ $course['title'] ?? 'Full-Stack Development' }}</span>
                </div>
            </div>

            <div class="header-actions">
                <div class="user-profile-badge">
                    <div class="user-avatar">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <div class="user-meta">
                        <span class="user-name">{{ $currentUser['name'] ?? 'Siswa Aktif' }}</span>
                        <span class="user-status">ID: #{{ $currentUser['id'] ?? '84920' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="app-main">
        @yield('content')
    </main>

    <!-- Plyr.js Script CDN -->
    <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
    <!-- Custom E-Learning Player Script -->
    <script src="{{ asset('js/elearning-player.js') }}"></script>
    @stack('scripts')
</body>
</html>
