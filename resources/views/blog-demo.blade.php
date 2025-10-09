<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Blog Template Demo - Delaine Framework</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Blog Template Styles -->
    <style>
        /* Modern Blog Template - Dramatically Different from Default Delaine */

        :root {
            --blog-primary: #6366f1;
            --blog-secondary: #8b5cf6;
            --blog-accent: #06b6d4;
            --blog-dark: #1e293b;
            --blog-light: #f8fafc;
            --blog-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --blog-gradient-alt: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        /* Override default Delaine styles */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
            background: var(--blog-gradient) !important;
            color: var(--blog-dark) !important;
            line-height: 1.6 !important;
        }

        /* Modern Navigation */
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(20px) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2) !important;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1) !important;
        }

        .navbar-brand {
            font-weight: 800 !important;
            font-size: 1.5rem !important;
            background: var(--blog-gradient) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            background-clip: text !important;
        }

        /* Hero Section */
        .blog-hero {
            background: var(--blog-gradient);
            padding: 100px 0;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .blog-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .blog-hero h1 {
            font-size: 3.5rem;
            font-weight: 900;
            margin-bottom: 1rem;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            animation: fadeInUp 1s ease-out;
        }

        .blog-hero p {
            font-size: 1.25rem;
            opacity: 0.9;
            animation: fadeInUp 1s ease-out 0.2s both;
        }

        /* Modern Cards */
        .blog-card {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(20px) !important;
            border-radius: 20px !important;
            padding: 2rem !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            position: relative;
            overflow: hidden;
        }

        .blog-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--blog-gradient);
        }

        .blog-card:hover {
            transform: translateY(-8px) !important;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15) !important;
        }

        /* Blog Post Cards */
        .post-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: none;
        }

        .post-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .post-card .card-img-top {
            height: 200px;
            object-fit: cover;
            background: var(--blog-gradient);
        }

        .post-card .card-body {
            padding: 1.5rem;
        }

        .post-card .card-title {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--blog-dark);
            margin-bottom: 0.75rem;
        }

        .post-card .card-text {
            color: #64748b;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Modern Buttons */
        .btn-blog-primary {
            background: var(--blog-gradient) !important;
            border: none !important;
            border-radius: 50px !important;
            padding: 12px 30px !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4) !important;
            text-decoration: none !important;
            display: inline-block !important;
            color: white !important;
        }

        .btn-blog-primary:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6) !important;
            color: white !important;
        }

        .btn-blog-secondary {
            background: transparent !important;
            border: 2px solid var(--blog-primary) !important;
            color: var(--blog-primary) !important;
            border-radius: 50px !important;
            padding: 10px 28px !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
            text-decoration: none !important;
            display: inline-block !important;
        }

        .btn-blog-secondary:hover {
            background: var(--blog-primary) !important;
            color: white !important;
            transform: translateY(-2px) !important;
        }

        /* Typography */
        .blog-title {
            font-size: 2.5rem;
            font-weight: 800;
            background: var(--blog-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
        }

        .blog-subtitle {
            font-size: 1.1rem;
            color: #64748b;
            font-weight: 500;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .animate-pulse {
            animation: pulse 2s infinite;
        }

        /* Grid Layout */
        .blog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin: 2rem 0;
        }

        /* Sidebar */
        .blog-sidebar {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .blog-sidebar h3 {
            color: var(--blog-dark);
            font-weight: 700;
            margin-bottom: 1.5rem;
            font-size: 1.25rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .blog-hero h1 {
                font-size: 2.5rem;
            }

            .blog-card {
                padding: 1.5rem !important;
            }

            .blog-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
        }

        /* Override any remaining default styles */
        .container {
            max-width: 1200px !important;
        }

        .row {
            margin: 0 !important;
        }

        .col-md-8,
        .col-md-4 {
            padding: 0 15px !important;
        }

        /* Demo specific styles */
        .demo-comparison {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 3rem;
            margin: 2rem 0;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .demo-button {
            margin: 1rem;
            padding: 1rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .demo-button:hover {
            transform: translateY(-3px);
        }
    </style>
</head>

<body class="font-sans antialiased">
    <!-- Modern Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <strong>📝 Blog Template Demo</strong>
            </a>

            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('dashboard') }}" class="btn-blog-secondary">Default Dashboard</a>
                <a href="{{ route('blog-demo') }}" class="btn-blog-primary">Blog Template</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="blog-hero" style="margin-top: 76px;">
        <div class="container">
            <h1>🎨 Dramatic Template Difference</h1>
            <p>See how Delaine's templating system transforms your application with completely different designs, modern
                gradients, animations, and interactive features.</p>
            <div style="margin-top: 2rem;">
                <a href="#comparison" class="btn-blog-primary" style="margin-right: 1rem;">See the Difference</a>
                <a href="{{ route('dashboard') }}" class="btn-blog-secondary">Compare with Default</a>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container" style="padding: 4rem 0;">
        <div class="row">
            <!-- Blog Posts -->
            <div class="col-lg-8">
                <div id="posts">
                    <h2 class="blog-title">🚀 Featured Blog Posts</h2>
                    <p class="blog-subtitle">Experience the power of modern web design</p>

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
                                    This blog template demonstrates the dramatic difference between default Delaine
                                    styles and custom templates. Notice the modern gradients, glassmorphism effects,
                                    smooth animations, and interactive elements that make your application stand out
                                    from the crowd.
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

                                        <a href="#" class="btn-blog-primary">
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

                                        <a href="#" class="btn-blog-primary">
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

                                        <a href="#" class="btn-blog-primary">
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
                    <h3>🔍 Search</h3>
                    <div style="position: relative; margin-bottom: 2rem;">
                        <input type="text" id="blog-search" placeholder="Search for posts..."
                            style="width: 100%; padding: 1rem 1.5rem; border: 2px solid #e2e8f0; border-radius: 50px; font-size: 1rem; outline: none; transition: all 0.3s ease; background: white;">
                    </div>

                    <h3>📂 Categories</h3>
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

                    <h3>📧 Subscribe</h3>
                    <p style="color: #64748b; margin-bottom: 1rem;">Get the latest posts delivered to your inbox.</p>
                    <form id="subscribe-form" style="display: flex; gap: 0.5rem;">
                        <input type="email" placeholder="Your email"
                            style="flex: 1; padding: 0.75rem; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 1rem; outline: none;">
                        <button type="submit" class="btn-blog-primary" style="white-space: nowrap;">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Comparison Section -->
        <div id="comparison" class="demo-comparison">
            <h2 class="blog-title text-center">🔄 Template Comparison</h2>
            <p class="blog-subtitle text-center" style="margin-bottom: 3rem;">See the dramatic difference between
                default and custom templates</p>

            <div class="row">
                <div class="col-md-6">
                    <div class="blog-card text-center">
                        <h3 style="color: #1e293b; margin-bottom: 1rem;">Default Delaine Dashboard</h3>
                        <p style="color: #64748b; margin-bottom: 2rem;">Clean, professional, but standard appearance</p>
                        <a href="{{ route('dashboard') }}" class="demo-button"
                            style="background: #6b7280; color: white;">View Default</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="blog-card text-center">
                        <h3 style="color: #1e293b; margin-bottom: 1rem;">Custom Blog Template</h3>
                        <p style="color: #64748b; margin-bottom: 2rem;">Modern gradients, animations, and interactive
                            features</p>
                        <a href="{{ route('blog-demo') }}" class="demo-button"
                            style="background: var(--blog-gradient); color: white;">View Custom</a>
                    </div>
                </div>
            </div>

            <div class="text-center" style="margin-top: 3rem;">
                <h4 style="color: #1e293b; margin-bottom: 1rem;">🎯 Key Differences</h4>
                <div class="row">
                    <div class="col-md-3">
                        <div style="padding: 1rem;">
                            <div style="font-size: 2rem; margin-bottom: 0.5rem;">🎨</div>
                            <strong>Modern Design</strong>
                            <p style="font-size: 0.9rem; color: #64748b;">Gradients, glassmorphism, rounded corners</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div style="padding: 1rem;">
                            <div style="font-size: 2rem; margin-bottom: 0.5rem;">✨</div>
                            <strong>Animations</strong>
                            <p style="font-size: 0.9rem; color: #64748b;">Smooth transitions, hover effects, scroll
                                animations</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div style="padding: 1rem;">
                            <div style="font-size: 2rem; margin-bottom: 0.5rem;">🎯</div>
                            <strong>Interactive</strong>
                            <p style="font-size: 0.9rem; color: #64748b;">Like buttons, search, comments, notifications
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div style="padding: 1rem;">
                            <div style="font-size: 2rem; margin-bottom: 0.5rem;">📱</div>
                            <strong>Responsive</strong>
                            <p style="font-size: 0.9rem; color: #64748b;">Mobile-first design, adaptive layouts</p>
                        </div>
                    </div>
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
                    <h4 style="font-weight: 700; margin-bottom: 1rem;">📝 Blog Template Demo</h4>
                    <p style="color: #94a3b8; line-height: 1.6;">A modern blog showcasing the power of Delaine's
                        templating system. Experience the difference with our custom designs and interactive features.
                    </p>
                </div>
                <div class="col-md-3">
                    <h5 style="font-weight: 600; margin-bottom: 1rem;">Quick Links</h5>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 0.5rem;"><a href="{{ route('dashboard') }}"
                                style="color: #94a3b8; text-decoration: none;">Default Dashboard</a></li>
                        <li style="margin-bottom: 0.5rem;"><a href="{{ route('blog-demo') }}"
                                style="color: #94a3b8; text-decoration: none;">Blog Template</a></li>
                        <li style="margin-bottom: 0.5rem;"><a href="#"
                                style="color: #94a3b8; text-decoration: none;">Documentation</a></li>
                        <li style="margin-bottom: 0.5rem;"><a href="#"
                                style="color: #94a3b8; text-decoration: none;">GitHub</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5 style="font-weight: 600; margin-bottom: 1rem;">Template Features</h5>
                    <ul style="list-style: none; padding: 0; color: #94a3b8;">
                        <li style="margin-bottom: 0.5rem;">✨ Modern Gradients</li>
                        <li style="margin-bottom: 0.5rem;">🎨 Glassmorphism</li>
                        <li style="margin-bottom: 0.5rem;">🚀 Smooth Animations</li>
                        <li style="margin-bottom: 0.5rem;">📱 Responsive Design</li>
                    </ul>
                </div>
            </div>
            <hr style="border-color: #334155; margin: 2rem 0;">
            <div class="text-center" style="color: #94a3b8;">
                <p>&copy; {{ date('Y') }} Blog Template Demo. Built with Delaine Framework.</p>
            </div>
        </div>
    </footer>

    <!-- Interactive JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Like button functionality
            document.querySelectorAll('.like-button').forEach(button => {
                button.addEventListener('click', function () {
                    const likeCount = this.querySelector('.like-count');
                    const isLiked = this.classList.contains('liked');

                    if (isLiked) {
                        this.classList.remove('liked');
                        likeCount.textContent = parseInt(likeCount.textContent) - 1;
                        showNotification('Post unliked', 'info');
                    } else {
                        this.classList.add('liked');
                        likeCount.textContent = parseInt(likeCount.textContent) + 1;
                        showNotification('Post liked!', 'success');
                    }

                    // Add heart animation
                    this.style.transform = 'scale(1.2)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 200);
                });
            });

            // Search functionality
            const searchInput = document.querySelector('#blog-search');
            if (searchInput) {
                searchInput.addEventListener('input', function () {
                    const query = this.value.trim();
                    if (query.length > 0) {
                        showNotification(`Searching for: ${query}`, 'info');
                    }
                });
            }

            // Subscribe form
            const subscribeForm = document.querySelector('#subscribe-form');
            if (subscribeForm) {
                subscribeForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const email = this.querySelector('input[type="email"]').value;
                    if (email) {
                        showNotification(`Subscribed with: ${email}`, 'success');
                        this.querySelector('input[type="email"]').value = '';
                    }
                });
            }

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });

        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 1rem 1.5rem;
                border-radius: 8px;
                color: white;
                font-weight: 500;
                transform: translateX(100%);
                transition: transform 0.3s ease;
                z-index: 1000;
                background: ${type === 'success' ? '#10b981' : type === 'info' ? '#3b82f6' : '#ef4444'};
            `;
            notification.textContent = message;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 100);

            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }
    </script>
</body>

</html>