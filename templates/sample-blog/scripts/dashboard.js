// Modern Blog Template JavaScript - Interactive Features

document.addEventListener("DOMContentLoaded", function () {
    // Initialize blog features
    initBlogAnimations();
    initBlogInteractions();
    initBlogSearch();
    initBlogComments();
    initBlogLikes();
});

// Smooth animations and scroll effects
function initBlogAnimations() {
    // Intersection Observer for fade-in animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px",
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add("animate-fade-in");
            }
        });
    }, observerOptions);

    // Observe all blog cards
    document.querySelectorAll(".blog-card, .post-card").forEach((card) => {
        observer.observe(card);
    });

    // Parallax effect for hero section
    window.addEventListener("scroll", () => {
        const scrolled = window.pageYOffset;
        const hero = document.querySelector(".blog-hero");
        if (hero) {
            hero.style.transform = `translateY(${scrolled * 0.5}px)`;
        }
    });
}

// Interactive blog features
function initBlogInteractions() {
    // Add hover effects to cards
    document.querySelectorAll(".post-card").forEach((card) => {
        card.addEventListener("mouseenter", function () {
            this.style.transform = "translateY(-10px) scale(1.02)";
        });

        card.addEventListener("mouseleave", function () {
            this.style.transform = "translateY(0) scale(1)";
        });
    });

    // Add click ripple effect to buttons
    document
        .querySelectorAll(".btn-blog-primary, .btn-blog-secondary")
        .forEach((button) => {
            button.addEventListener("click", function (e) {
                const ripple = document.createElement("span");
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.style.width = ripple.style.height = size + "px";
                ripple.style.left = x + "px";
                ripple.style.top = y + "px";
                ripple.classList.add("ripple");

                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
}

// Blog search functionality
function initBlogSearch() {
    const searchInput = document.querySelector("#blog-search");
    const searchResults = document.querySelector("#search-results");

    if (searchInput && searchResults) {
        let searchTimeout;

        searchInput.addEventListener("input", function () {
            clearTimeout(searchTimeout);
            const query = this.value.trim();

            if (query.length < 2) {
                searchResults.innerHTML = "";
                return;
            }

            searchTimeout = setTimeout(() => {
                performBlogSearch(query);
            }, 300);
        });
    }
}

function performBlogSearch(query) {
    // Simulate search results (in real app, this would be an API call)
    const mockResults = [
        {
            title: "Getting Started with Modern Web Development",
            excerpt: "Learn the fundamentals of modern web development...",
            url: "#",
        },
        {
            title: "CSS Grid vs Flexbox: When to Use What",
            excerpt:
                "A comprehensive guide to choosing the right layout method...",
            url: "#",
        },
        {
            title: "JavaScript ES2024 Features You Should Know",
            excerpt:
                "Explore the latest JavaScript features and how to use them...",
            url: "#",
        },
    ];

    const filteredResults = mockResults.filter(
        (post) =>
            post.title.toLowerCase().includes(query.toLowerCase()) ||
            post.excerpt.toLowerCase().includes(query.toLowerCase())
    );

    displaySearchResults(filteredResults);
}

function displaySearchResults(results) {
    const searchResults = document.querySelector("#search-results");
    if (!searchResults) return;

    if (results.length === 0) {
        searchResults.innerHTML =
            '<div class="search-no-results">No results found</div>';
        return;
    }

    const resultsHTML = results
        .map(
            (result) => `
        <div class="search-result-item">
            <h4><a href="${result.url}">${result.title}</a></h4>
            <p>${result.excerpt}</p>
        </div>
    `
        )
        .join("");

    searchResults.innerHTML = resultsHTML;
}

// Blog comments system
function initBlogComments() {
    const commentForm = document.querySelector("#comment-form");
    const commentsList = document.querySelector("#comments-list");

    if (commentForm) {
        commentForm.addEventListener("submit", function (e) {
            e.preventDefault();
            addComment();
        });
    }
}

function addComment() {
    const nameInput = document.querySelector("#comment-name");
    const emailInput = document.querySelector("#comment-email");
    const messageInput = document.querySelector("#comment-message");

    if (!nameInput || !emailInput || !messageInput) return;

    const comment = {
        name: nameInput.value.trim(),
        email: emailInput.value.trim(),
        message: messageInput.value.trim(),
        date: new Date().toLocaleDateString(),
        avatar: generateAvatar(nameInput.value.trim()),
    };

    if (comment.name && comment.message) {
        displayComment(comment);
        clearCommentForm();
        showNotification("Comment added successfully!", "success");
    }
}

function displayComment(comment) {
    const commentsList = document.querySelector("#comments-list");
    if (!commentsList) return;

    const commentHTML = `
        <div class="comment-item animate-fade-in">
            <div class="comment-avatar">
                <img src="${comment.avatar}" alt="${comment.name}" />
            </div>
            <div class="comment-content">
                <div class="comment-header">
                    <strong>${comment.name}</strong>
                    <span class="comment-date">${comment.date}</span>
                </div>
                <p>${comment.message}</p>
            </div>
        </div>
    `;

    commentsList.insertAdjacentHTML("beforeend", commentHTML);
}

function clearCommentForm() {
    document.querySelector("#comment-name").value = "";
    document.querySelector("#comment-email").value = "";
    document.querySelector("#comment-message").value = "";
}

function generateAvatar(name) {
    const colors = ["#6366f1", "#8b5cf6", "#06b6d4", "#f093fb", "#f5576c"];
    const color = colors[name.length % colors.length];
    const initials = name
        .split(" ")
        .map((n) => n[0])
        .join("")
        .toUpperCase();

    return `data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"><circle cx="20" cy="20" r="20" fill="${color}"/><text x="20" y="26" text-anchor="middle" fill="white" font-family="Arial" font-size="14" font-weight="bold">${initials}</text></svg>`;
}

// Blog likes system
function initBlogLikes() {
    document.querySelectorAll(".like-button").forEach((button) => {
        button.addEventListener("click", function () {
            const postId = this.dataset.postId;
            const likeCount = this.querySelector(".like-count");
            const isLiked = this.classList.contains("liked");

            if (isLiked) {
                this.classList.remove("liked");
                likeCount.textContent = parseInt(likeCount.textContent) - 1;
                showNotification("Post unliked", "info");
            } else {
                this.classList.add("liked");
                likeCount.textContent = parseInt(likeCount.textContent) + 1;
                showNotification("Post liked!", "success");
            }

            // Add heart animation
            this.style.transform = "scale(1.2)";
            setTimeout(() => {
                this.style.transform = "scale(1)";
            }, 200);
        });
    });
}

// Utility functions
function showNotification(message, type = "info") {
    const notification = document.createElement("div");
    notification.className = `notification notification-${type}`;
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.classList.add("show");
    }, 100);

    setTimeout(() => {
        notification.classList.remove("show");
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Add CSS for animations and effects
const additionalStyles = `
<style>
.animate-fade-in {
    animation: fadeInUp 0.6s ease-out forwards;
}

.ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.6);
    transform: scale(0);
    animation: ripple-animation 0.6s linear;
    pointer-events: none;
}

@keyframes ripple-animation {
    to {
        transform: scale(4);
        opacity: 0;
    }
}

.search-result-item {
    padding: 1rem;
    border-bottom: 1px solid #e2e8f0;
    transition: background-color 0.2s ease;
}

.search-result-item:hover {
    background-color: #f8fafc;
}

.search-result-item h4 {
    margin: 0 0 0.5rem 0;
    font-size: 1.1rem;
}

.search-result-item h4 a {
    color: var(--blog-primary);
    text-decoration: none;
}

.search-result-item h4 a:hover {
    text-decoration: underline;
}

.comment-item {
    display: flex;
    gap: 1rem;
    padding: 1.5rem;
    border-bottom: 1px solid #e2e8f0;
    background: white;
    border-radius: 12px;
    margin-bottom: 1rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.comment-avatar img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
}

.comment-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.comment-date {
    color: #64748b;
    font-size: 0.9rem;
}

.like-button {
    background: none;
    border: none;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 50%;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.like-button:hover {
    background: rgba(102, 126, 234, 0.1);
}

.like-button.liked {
    color: #ef4444;
}

.notification {
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
}

.notification.show {
    transform: translateX(0);
}

.notification-success {
    background: #10b981;
}

.notification-info {
    background: #3b82f6;
}

.notification-error {
    background: #ef4444;
}
</style>
`;

document.head.insertAdjacentHTML("beforeend", additionalStyles);
