{{-- Modern Blog Post Card Component --}}
<div class="post-card blog-card">
    <div class="post-image"
        style="height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px 16px 0 0; display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
        📝
    </div>
    <div class="card-body">
        <div class="post-meta"
            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; font-size: 0.9rem; color: #64748b;">
            <span class="post-category"
                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                {{ $category ?? 'Technology' }}
            </span>
            <span class="post-date">{{ $date ?? now()->format('M j, Y') }}</span>
        </div>

        <h3 class="card-title"
            style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem; color: #1e293b; line-height: 1.3;">
            {{ $title ?? 'Amazing Blog Post Title' }}
        </h3>

        <p class="card-text" style="color: #64748b; line-height: 1.6; margin-bottom: 1.5rem;">
            {{ $excerpt ?? 'This is an amazing blog post that showcases the power of the Delaine templating system. The design is completely different from the default Delaine styles, featuring modern gradients, animations, and interactive elements.' }}
        </p>

        <div class="post-footer" style="display: flex; justify-content: space-between; align-items: center;">
            <div class="post-author" style="display: flex; align-items: center; gap: 0.5rem;">
                <div class="author-avatar"
                    style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 0.9rem;">
                    {{ substr($author ?? 'John Doe', 0, 2) }}
                </div>
                <span style="font-size: 0.9rem; color: #64748b; font-weight: 500;">{{ $author ?? 'John Doe' }}</span>
            </div>

            <div class="post-actions" style="display: flex; align-items: center; gap: 1rem;">
                <button class="like-button" data-post-id="1"
                    style="background: none; border: none; cursor: pointer; padding: 0.5rem; border-radius: 50%; transition: all 0.2s ease; display: flex; align-items: center; gap: 0.5rem;">
                    <span style="font-size: 1.2rem;">❤️</span>
                    <span class="like-count" style="font-size: 0.9rem; color: #64748b;">{{ $likes ?? '42' }}</span>
                </button>

                <a href="#" class="btn-blog-primary" style="text-decoration: none; display: inline-block;">
                    Read More
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Blog Hero Section Component --}}
@if(isset($showHero) && $showHero)
    <div class="blog-hero">
        <div class="container">
            <h1 class="blog-title">Welcome to Our Amazing Blog</h1>
            <p class="blog-subtitle">Discover the latest insights, tutorials, and stories from our team</p>
            <div style="margin-top: 2rem;">
                <a href="#" class="btn-blog-primary" style="margin-right: 1rem;">Explore Posts</a>
                <a href="#" class="btn-blog-secondary">Subscribe</a>
            </div>
        </div>
    </div>
@endif

{{-- Blog Search Component --}}
@if(isset($showSearch) && $showSearch)
    <div class="blog-search"
        style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border-radius: 16px; padding: 2rem; margin: 2rem 0; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);">
        <h3 style="margin-bottom: 1rem; color: #1e293b; font-weight: 700;">Search Our Blog</h3>
        <div style="position: relative;">
            <input type="text" id="blog-search" placeholder="Search for posts..."
                style="width: 100%; padding: 1rem 1.5rem; border: 2px solid #e2e8f0; border-radius: 50px; font-size: 1rem; outline: none; transition: all 0.3s ease; background: white;">
            <div id="search-results"
                style="position: absolute; top: 100%; left: 0; right: 0; background: white; border-radius: 12px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); margin-top: 0.5rem; max-height: 300px; overflow-y: auto; z-index: 100;">
            </div>
        </div>
    </div>
@endif

{{-- Blog Comments Component --}}
@if(isset($showComments) && $showComments)
    <div class="blog-comments"
        style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border-radius: 16px; padding: 2rem; margin: 2rem 0; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);">
        <h3 style="margin-bottom: 1.5rem; color: #1e293b; font-weight: 700;">Comments ({{ $commentCount ?? '12' }})</h3>

        <div id="comments-list">
            {{-- Sample comments --}}
            <div class="comment-item"
                style="display: flex; gap: 1rem; padding: 1.5rem; border-bottom: 1px solid #e2e8f0; background: white; border-radius: 12px; margin-bottom: 1rem; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);">
                <div class="comment-avatar"
                    style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                    JD
                </div>
                <div class="comment-content">
                    <div class="comment-header"
                        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                        <strong>John Doe</strong>
                        <span class="comment-date" style="color: #64748b; font-size: 0.9rem;">2 hours ago</span>
                    </div>
                    <p style="margin: 0; color: #374151; line-height: 1.6;">This is an amazing blog post! The templating
                        system looks incredible. Great work on the design!</p>
                </div>
            </div>

            <div class="comment-item"
                style="display: flex; gap: 1rem; padding: 1.5rem; border-bottom: 1px solid #e2e8f0; background: white; border-radius: 12px; margin-bottom: 1rem; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);">
                <div class="comment-avatar"
                    style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                    SM
                </div>
                <div class="comment-content">
                    <div class="comment-header"
                        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                        <strong>Sarah Miller</strong>
                        <span class="comment-date" style="color: #64748b; font-size: 0.9rem;">5 hours ago</span>
                    </div>
                    <p style="margin: 0; color: #374151; line-height: 1.6;">Love the modern design! The gradients and
                        animations make it so much more engaging than the default styles.</p>
                </div>
            </div>
        </div>

        <form id="comment-form" style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #e2e8f0;">
            <h4 style="margin-bottom: 1rem; color: #1e293b; font-weight: 600;">Add a Comment</h4>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <input type="text" id="comment-name" placeholder="Your Name"
                    style="padding: 0.75rem; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 1rem; outline: none; transition: all 0.3s ease;">
                <input type="email" id="comment-email" placeholder="Your Email"
                    style="padding: 0.75rem; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 1rem; outline: none; transition: all 0.3s ease;">
            </div>
            <textarea id="comment-message" placeholder="Your Comment" rows="4"
                style="width: 100%; padding: 0.75rem; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 1rem; outline: none; transition: all 0.3s ease; resize: vertical; margin-bottom: 1rem;"></textarea>
            <button type="submit" class="btn-blog-primary">Post Comment</button>
        </form>
    </div>
@endif