<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Modern Blog</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Blog Template Styles -->
    <link rel="stylesheet" href="{{ asset('css/blog-template.css') }}">

    <!-- Additional Meta Tags -->
    <meta name="description" content="A modern blog showcasing the power of Delaine's templating system">
    <meta name="keywords" content="blog, technology, web development, delaine, templates">
    <meta name="author" content="Delaine Team">

    <!-- Open Graph -->
    <meta property="og:title" content="Modern Blog - Delaine Template">
    <meta property="og:description" content="Experience the difference with our modern blog template">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml"
        href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📝</text></svg>">
</head>

<body class="font-sans antialiased">
    <!-- Modern Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <strong>📝 ModernBlog</strong>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #1e293b; font-weight: 500;">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #1e293b; font-weight: 500;">Technology</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #1e293b; font-weight: 500;">Design</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #1e293b; font-weight: 500;">Tutorials</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <div class="search-icon"
                        style="cursor: pointer; padding: 0.5rem; border-radius: 50%; transition: all 0.2s ease;">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>

                    @auth
                        <div class="dropdown">
                            <button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                style="color: #1e293b; text-decoration: none; border: none;">
                                <div class="user-avatar"
                                    style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 0.9rem;">
                                    {{ substr(auth()->user()->name, 0, 2) }}
                                </div>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn-blog-secondary" style="text-decoration: none;">Login</a>
                        <a href="{{ route('register') }}" class="btn-blog-primary" style="text-decoration: none;">Sign
                            Up</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="blog-hero" style="margin-top: 76px;">
        <div class="container">
            <h1>Welcome to Our Amazing Blog</h1>
            <p>Discover the latest insights, tutorials, and stories from our team. Experience the power of modern web
                design with our custom Delaine template.</p>
            <div style="margin-top: 2rem;">
                <a href="#posts" class="btn-blog-primary" style="margin-right: 1rem; text-decoration: none;">Explore
                    Posts</a>
                <a href="#subscribe" class="btn-blog-secondary" style="text-decoration: none;">Subscribe</a>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container" style="padding: 4rem 0;">
        <div class="row">
            <!-- Blog Posts -->
            <div class="col-lg-8">
                <div id="posts">
                    <h2 class="blog-title">Latest Posts</h2>
                    <p class="blog-subtitle">Stay updated with our latest content</p>

                    <div class="blog-grid">
                        <!-- Featured Post -->
                        <div class="post-card blog-card" style="grid-column: 1 / -1;">
                            <div class="post-image"
                                style="height: 300px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px 20px 0 0; display: flex; align-items: center; justify-content: center; color: white; font-size: 4rem; position: relative; overflow: hidden;">
                                <div
                                    style="position: absolute; top: 1rem; right: 1rem; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                                    FEATURED
                                </div>
                                🚀
                            </div>
                            <div class="card-body">
                                <div class="post-meta"
                                    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; font-size: 0.9rem; color: #64748b;">
                                    <span class="post-category"
                                        style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                                        Featured
                                    </span>
                                    <span class="post-date">{{ now()->format('M j, Y') }}</span>
                                </div>

                                <h3 class="card-title"
                                    style="font-size: 2rem; font-weight: 800; margin-bottom: 1rem; color: #1e293b; line-height: 1.2;">
                                    The Power of Delaine's Template System
                                </h3>

                                <p class="card-text"
                                    style="color: #64748b; line-height: 1.6; margin-bottom: 1.5rem; font-size: 1.1rem;">
                                    Discover how Delaine's revolutionary templating system transforms the way we build
                                    web applications. This blog post showcases the dramatic difference between default
                                    styles and custom templates, featuring modern gradients, animations, and interactive
                                    elements that make your applications stand out.
                                </p>

                                <div class="post-footer"
                                    style="display: flex; justify-content: space-between; align-items: center;">
                                    <div class="post-author" style="display: flex; align-items: center; gap: 0.5rem;">
                                        <div class="author-avatar"
                                            style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 1rem;">
                                            DT
                                        </div>
                                        <div>
                                            <div style="font-weight: 600; color: #1e293b;">Delaine Team</div>
                                            <div style="font-size: 0.8rem; color: #64748b;">Framework Developer</div>
                                        </div>
                                    </div>

                                    <div class="post-actions" style="display: flex; align-items: center; gap: 1rem;">
                                        <button class="like-button" data-post-id="featured"
                                            style="background: none; border: none; cursor: pointer; padding: 0.5rem; border-radius: 50%; transition: all 0.2s ease; display: flex; align-items: center; gap: 0.5rem;">
                                            <span style="font-size: 1.2rem;">❤️</span>
                                            <span class="like-count"
                                                style="font-size: 0.9rem; color: #64748b;">127</span>
                                        </button>

                                        <a href="#" class="btn-blog-primary"
                                            style="text-decoration: none; display: inline-block;">
                                            Read Full Article
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Regular Posts -->
                        <div class="post-card blog-card">
                            <div class="post-image"
                                style="height: 200px; background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 100%); border-radius: 16px 16px 0 0; display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                                💻
                            </div>
                            <div class="card-body">
                                <div class="post-meta"
                                    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; font-size: 0.9rem; color: #64748b;">
                                    <span class="post-category"
                                        style="background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 100%); color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                                        Technology
                                    </span>
                                    <span class="post-date">{{ now()->subDays(1)->format('M j, Y') }}</span>
                                </div>

                                <h3 class="card-title"
                                    style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem; color: #1e293b; line-height: 1.3;">
                                    Modern Web Development Trends
                                </h3>

                                <p class="card-text" style="color: #64748b; line-height: 1.6; margin-bottom: 1.5rem;">
                                    Explore the latest trends in web development, from serverless architectures to
                                    modern CSS techniques that are shaping the future of the web.
                                </p>

                                <div class="post-footer"
                                    style="display: flex; justify-content: space-between; align-items: center;">
                                    <div class="post-author" style="display: flex; align-items: center; gap: 0.5rem;">
                                        <div class="author-avatar"
                                            style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 0.9rem;">
                                            JD
                                        </div>
                                        <span style="font-size: 0.9rem; color: #64748b; font-weight: 500;">John
                                            Doe</span>
                                    </div>

                                    <div class="post-actions" style="display: flex; align-items: center; gap: 1rem;">
                                        <button class="like-button" data-post-id="2"
                                            style="background: none; border: none; cursor: pointer; padding: 0.5rem; border-radius: 50%; transition: all 0.2s ease; display: flex; align-items: center; gap: 0.5rem;">
                                            <span style="font-size: 1.2rem;">❤️</span>
                                            <span class="like-count"
                                                style="font-size: 0.9rem; color: #64748b;">89</span>
                                        </button>

                                        <a href="#" class="btn-blog-primary"
                                            style="text-decoration: none; display: inline-block;">
                                            Read More
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="post-card blog-card">
                            <div class="post-image"
                                style="height: 200px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 16px 16px 0 0; display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                                🎨
                            </div>
                            <div class="card-body">
                                <div class="post-meta"
                                    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; font-size: 0.9rem; color: #64748b;">
                                    <span class="post-category"
                                        style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                                        Design
                                    </span>
                                    <span class="post-date">{{ now()->subDays(2)->format('M j, Y') }}</span>
                                </div>

                                <h3 class="card-title"
                                    style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem; color: #1e293b; line-height: 1.3;">
                                    UI/UX Design Principles
                                </h3>

                                <p class="card-text" style="color: #64748b; line-height: 1.6; margin-bottom: 1.5rem;">
                                    Learn the fundamental principles of UI/UX design that create engaging and
                                    user-friendly interfaces for modern web applications.
                                </p>

                                <div class="post-footer"
                                    style="display: flex; justify-content: space-between; align-items: center;">
                                    <div class="post-author" style="display: flex; align-items: center; gap: 0.5rem;">
                                        <div class="author-avatar"
                                            style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #8b5cf6 0%, #06b6d4 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 0.9rem;">
                                            SM
                                        </div>
                                        <span style="font-size: 0.9rem; color: #64748b; font-weight: 500;">Sarah
                                            Miller</span>
                                    </div>

                                    <div class="post-actions" style="display: flex; align-items: center; gap: 1rem;">
                                        <button class="like-button" data-post-id="3"
                                            style="background: none; border: none; cursor: pointer; padding: 0.5rem; border-radius: 50%; transition: all 0.2s ease; display: flex; align-items: center; gap: 0.5rem;">
                                            <span style="font-size: 1.2rem;">❤️</span>
                                            <span class="like-count"
                                                style="font-size: 0.9rem; color: #64748b;">156</span>
                                        </button>

                                        <a href="#" class="btn-blog-primary"
                                            style="text-decoration: none; display: inline-block;">
                                            Read More
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="blog-sidebar">
                    <h3>Search</h3>
                    <div style="position: relative; margin-bottom: 2rem;">
                        <input type="text" id="blog-search" placeholder="Search for posts..."
                            style="width: 100%; padding: 1rem 1.5rem; border: 2px solid #e2e8f0; border-radius: 50px; font-size: 1rem; outline: none; transition: all 0.3s ease; background: white;">
                        <div id="search-results"
                            style="position: absolute; top: 100%; left: 0; right: 0; background: white; border-radius: 12px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); margin-top: 0.5rem; max-height: 300px; overflow-y: auto; z-index: 100;">
                        </div>
                    </div>

                    <h3>Categories</h3>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 2rem;">
                        <a href="#"
                            style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: rgba(102, 126, 234, 0.1); border-radius: 8px; text-decoration: none; color: #1e293b; transition: all 0.2s ease;">
                            <span>Technology</span>
                            <span
                                style="background: #6366f1; color: white; padding: 0.25rem 0.5rem; border-radius: 12px; font-size: 0.8rem;">12</span>
                        </a>
                        <a href="#"
                            style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: rgba(139, 92, 246, 0.1); border-radius: 8px; text-decoration: none; color: #1e293b; transition: all 0.2s ease;">
                            <span>Design</span>
                            <span
                                style="background: #8b5cf6; color: white; padding: 0.25rem 0.5rem; border-radius: 12px; font-size: 0.8rem;">8</span>
                        </a>
                        <a href="#"
                            style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: rgba(6, 182, 212, 0.1); border-radius: 8px; text-decoration: none; color: #1e293b; transition: all 0.2s ease;">
                            <span>Tutorials</span>
                            <span
                                style="background: #06b6d4; color: white; padding: 0.25rem 0.5rem; border-radius: 12px; font-size: 0.8rem;">15</span>
                        </a>
                    </div>

                    <h3>Subscribe</h3>
                    <p style="color: #64748b; margin-bottom: 1rem;">Get the latest posts delivered to your inbox.</p>
                    <form id="subscribe-form" style="display: flex; gap: 0.5rem;">
                        <input type="email" placeholder="Your email"
                            style="flex: 1; padding: 0.75rem; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 1rem; outline: none;">
                        <button type="submit" class="btn-blog-primary" style="white-space: nowrap;">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer
        style="background: rgba(30, 41, 59, 0.95); backdrop-filter: blur(20px); color: white; padding: 3rem 0; margin-top: 4rem;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 style="font-weight: 700; margin-bottom: 1rem;">ModernBlog</h4>
                    <p style="color: #94a3b8; line-height: 1.6;">A modern blog showcasing the power of Delaine's
                        templating system. Experience the difference with our custom designs and interactive features.
                    </p>
                </div>
                <div class="col-md-3">
                    <h5 style="font-weight: 600; margin-bottom: 1rem;">Quick Links</h5>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 0.5rem;"><a href="#"
                                style="color: #94a3b8; text-decoration: none;">Home</a></li>
                        <li style="margin-bottom: 0.5rem;"><a href="#"
                                style="color: #94a3b8; text-decoration: none;">About</a></li>
                        <li style="margin-bottom: 0.5rem;"><a href="#"
                                style="color: #94a3b8; text-decoration: none;">Contact</a></li>
                        <li style="margin-bottom: 0.5rem;"><a href="#"
                                style="color: #94a3b8; text-decoration: none;">Privacy</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5 style="font-weight: 600; margin-bottom: 1rem;">Follow Us</h5>
                    <div style="display: flex; gap: 1rem;">
                        <a href="#" style="color: #94a3b8; font-size: 1.5rem;">📘</a>
                        <a href="#" style="color: #94a3b8; font-size: 1.5rem;">🐦</a>
                        <a href="#" style="color: #94a3b8; font-size: 1.5rem;">📷</a>
                        <a href="#" style="color: #94a3b8; font-size: 1.5rem;">💼</a>
                    </div>
                </div>
            </div>
            <hr style="border-color: #334155; margin: 2rem 0;">
            <div class="text-center" style="color: #94a3b8;">
                <p>&copy; {{ date('Y') }} ModernBlog. Built with Delaine Framework.</p>
            </div>
        </div>
    </footer>

    <!-- Blog Template JavaScript -->
    <script src="{{ asset('js/blog-template.js') }}"></script>
</body>

</html>