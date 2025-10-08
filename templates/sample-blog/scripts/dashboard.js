// Modern Dashboard JavaScript
class Dashboard {
    constructor() {
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.initializeComponents();
    }

    setupEventListeners() {
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById("mobile-menu-button");
        const mobileMenu = document.getElementById("mobile-menu");

        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener("click", () => {
                mobileMenu.classList.toggle("hidden");
            });
        }

        // Sidebar toggle
        const sidebarToggle = document.getElementById("sidebar-toggle");
        const sidebar = document.getElementById("sidebar");

        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener("click", () => {
                sidebar.classList.toggle("-translate-x-full");
            });
        }

        // Form validation
        this.setupFormValidation();
    }

    initializeComponents() {
        // Initialize tooltips
        this.initTooltips();

        // Initialize charts (if Chart.js is available)
        this.initCharts();
    }

    setupFormValidation() {
        const forms = document.querySelectorAll("form[data-validate]");
        forms.forEach((form) => {
            form.addEventListener("submit", (e) => {
                if (!this.validateForm(form)) {
                    e.preventDefault();
                }
            });
        });
    }

    validateForm(form) {
        const inputs = form.querySelectorAll(
            "input[required], select[required], textarea[required]"
        );
        let isValid = true;

        inputs.forEach((input) => {
            if (!input.value.trim()) {
                this.showError(input, "This field is required");
                isValid = false;
            } else {
                this.clearError(input);
            }
        });

        return isValid;
    }

    showError(input, message) {
        const errorElement = input.parentNode.querySelector(".error-message");
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.classList.remove("hidden");
        }
        input.classList.add("border-red-500");
    }

    clearError(input) {
        const errorElement = input.parentNode.querySelector(".error-message");
        if (errorElement) {
            errorElement.classList.add("hidden");
        }
        input.classList.remove("border-red-500");
    }

    initTooltips() {
        // Simple tooltip implementation
        const tooltipElements = document.querySelectorAll("[data-tooltip]");
        tooltipElements.forEach((element) => {
            element.addEventListener("mouseenter", this.showTooltip);
            element.addEventListener("mouseleave", this.hideTooltip);
        });
    }

    showTooltip(e) {
        const tooltip = document.createElement("div");
        tooltip.className =
            "absolute z-50 px-2 py-1 text-sm text-white bg-gray-900 rounded shadow-lg";
        tooltip.textContent = e.target.dataset.tooltip;
        tooltip.id = "tooltip";

        document.body.appendChild(tooltip);

        const rect = e.target.getBoundingClientRect();
        tooltip.style.left =
            rect.left + rect.width / 2 - tooltip.offsetWidth / 2 + "px";
        tooltip.style.top = rect.top - tooltip.offsetHeight - 5 + "px";
    }

    hideTooltip() {
        const tooltip = document.getElementById("tooltip");
        if (tooltip) {
            tooltip.remove();
        }
    }

    initCharts() {
        // Initialize charts if Chart.js is available
        if (typeof Chart !== "undefined") {
            const chartElements = document.querySelectorAll("[data-chart]");
            chartElements.forEach((element) => {
                const config = JSON.parse(element.dataset.chart);
                new Chart(element, config);
            });
        }
    }
}

// Initialize dashboard when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
    new Dashboard();
});
