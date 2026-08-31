<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'EduSecure - Protected E-Learning Player')</title>
    
    <!-- Plyr.js Video Player CSS -->
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    
    <!-- Custom E-Learning Player CSS (GitHub Minimalist White Theme) -->
    <link rel="stylesheet" href="{{ asset('css/elearning-player.css') }}">

    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>
<body>

    <!-- Top Navigation Header (GitHub Repo Header Style) -->
    <header class="app-header">
        <div class="header-top">
            <div class="header-left">
                <a href="/" class="brand-logo" title="EduSecure LMS">
                    <i class="fa-solid fa-graduation-cap"></i>
                </a>
                <div class="repo-breadcrumb">
                    <a href="/" class="org-name">EduSecure</a>
                    <span class="divider">/</span>
                    <a href="#" class="repo-name">{{ $course['slug'] ?? 'course-stream' }}</a>
                    <span class="badge-visibility">Protected</span>
                </div>
            </div>

            <div class="header-center">
                <div class="header-search-bar">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Type / to search lessons, resources..." readonly />
                    <span class="search-shortcut">/</span>
                </div>
            </div>

            <div class="header-right">
                <button class="btn-gh">
                    <i class="fa-regular fa-eye"></i> Watch
                    <span class="btn-counter">4.7k</span>
                </button>
                <button class="btn-gh">
                    <i class="fa-regular fa-star"></i> Star
                    <span class="btn-counter">1.2k</span>
                </button>
                <div class="user-profile-btn" title="Logged in as {{ $currentUser['name'] ?? 'User' }}">
                    <div class="user-avatar-circle">{{ substr($currentUser['name'] ?? 'U', 0, 1) }}</div>
                    <div class="user-details">
                        <span class="user-handle">{{ strtolower(str_replace(' ', '-', $currentUser['name'] ?? 'user')) }}</span>
                        <span class="user-id-tag">ID: #{{ $currentUser['id'] ?? '84920' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Underline Navigation Tabs (GitHub Style) -->
        <div class="underline-nav-wrapper">
            <div class="underline-nav-container">
                <button class="underline-nav-item active" onclick="switchTab(event, 'tab-overview')">
                    <i class="fa-solid fa-code"></i> Code & Lesson
                </button>
                <button class="underline-nav-item" onclick="switchTab(event, 'tab-security')">
                    <i class="fa-solid fa-shield-halved"></i> Protection Specs
                </button>
                <button class="underline-nav-item" onclick="switchTab(event, 'tab-resources')">
                    <i class="fa-solid fa-paperclip"></i> Resources
                    <span class="counter-badge">2</span>
                </button>
                <button class="underline-nav-item" onclick="switchTab(event, 'tab-discussion')">
                    <i class="fa-regular fa-comments"></i> Discussions
                    <span class="counter-badge">3</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="app-main">
        @yield('content')
    </main>

    <!-- Footer Minimalis Ala GitHub -->
    <footer class="app-footer">
        <div class="footer-container">
            <div>
                &copy; {{ date('Y') }} EduSecure LMS &bull; Clean Minimalist Player Engine
            </div>
            <div class="footer-links">
                <a href="#">Terms</a>
                <a href="#">Privacy</a>
                <a href="#">Security</a>
                <a href="#">Docs</a>
                <a href="#">Contact</a>
            </div>
        </div>
    </footer>

    <!-- Plyr.js Script CDN -->
    <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
    <!-- Custom E-Learning Player Script -->
    <script src="{{ asset('js/elearning-player.js') }}"></script>
    @stack('scripts')
</body>
</html>
