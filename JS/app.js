/**
 * Karuna Swasthya Clinic - JavaScript
 * Interactive functionality and animations
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all functions
    initThemeToggle();
    initMobileMenu();
    initBackToTop();
    initAnimations();
    initSmoothScroll();
    
    console.log('Karuna Clinic website initialized successfully!');
});

/**
 * Theme Toggle Functionality
 */
function initThemeToggle() {
    const themeToggle = document.getElementById('theme-toggle');
    const themeIcon = document.getElementById('theme-icon');
    const html = document.documentElement;
    
    // Get current theme
    let currentTheme = getCookie('theme') || 'light';
    
    // Set initial theme
    html.setAttribute('data-theme', currentTheme);
    updateThemeIcon(currentTheme);
    
    // Theme toggle click event
    themeToggle.addEventListener('click', function() {
        currentTheme = currentTheme === 'light' ? 'dark' : 'light';
        
        // Apply theme with smooth transition
        html.style.transition = 'all 0.3s ease';
        html.setAttribute('data-theme', currentTheme);
        
        // Update icon
        updateThemeIcon(currentTheme);
        
        // Save preference
        setCookie('theme', currentTheme, 365);
        
        // Remove transition after animation
        setTimeout(() => {
            html.style.transition = '';
        }, 300);
        
        // Add pulse animation to button
        themeToggle.classList.add('animate-pulse');
        setTimeout(() => {
            themeToggle.classList.remove('animate-pulse');
        }, 1000);
    });
}

/**
 * Update theme icon based on current theme
 */
function updateThemeIcon(theme) {
    const themeIcon = document.getElementById('theme-icon');
    if (theme === 'light') {
        themeIcon.className = 'fas fa-moon';
    } else {
        themeIcon.className = 'fas fa-sun';
    }
}

/**
 * Mobile Menu Toggle
 */
function initMobileMenu() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileIcon = mobileMenuButton.querySelector('i');
    
    let isMenuOpen = false;
    
    mobileMenuButton.addEventListener('click', function() {
        isMenuOpen = !isMenuOpen;
        
        if (isMenuOpen) {
            mobileMenu.classList.remove('hidden');
            mobileMenu.classList.add('animate-fadeInUp');
            mobileIcon.className = 'fas fa-times text-xl';
        } else {
            mobileMenu.classList.add('hidden');
            mobileMenu.classList.remove('animate-fadeInUp');
            mobileIcon.className = 'fas fa-bars text-xl';
        }
    });
    
    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        if (!mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
            if (isMenuOpen) {
                mobileMenu.classList.add('hidden');
                mobileMenu.classList.remove('animate-fadeInUp');
                mobileIcon.className = 'fas fa-bars text-xl';
                isMenuOpen = false;
            }
        }
    });
}

/**
 * Back to Top Button
 */
function initBackToTop() {
    const backToTopButton = document.getElementById('back-to-top');
    
    // Show/hide button based on scroll position
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTopButton.classList.add('visible');
        } else {
            backToTopButton.classList.remove('visible');
        }
    });
    
    // Smooth scroll to top
    backToTopButton.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

/**
 * Initialize scroll animations
 */
function initAnimations() {
    // Intersection Observer for scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = entry.target;
                
                // Add appropriate animation class
                if (target.classList.contains('animate-on-scroll')) {
                    target.classList.add('animate-fadeInUp');
                }
                
                // Stop observing this element
                observer.unobserve(target);
            }
        });
    }, observerOptions);
    
    // Observe all elements with animation class
    document.querySelectorAll('.animate-on-scroll').forEach(el => {
        observer.observe(el);
    });
}

/**
 * Smooth scrolling for navigation links
 */
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
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
}

/**
 * Form handling with validation
 */
function handleFormSubmit(form, successCallback, errorCallback) {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        const submitButton = form.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;
        
        // Show loading state
        submitButton.innerHTML = '<span class="loading-spinner"></span> Sending...';
        submitButton.disabled = true;
        
        // Simulate API call (replace with actual endpoint)
        fetch(form.action || 'process-form.php', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (successCallback) successCallback(data);
                showNotification('Message sent successfully!', 'success');
                form.reset();
            } else {
                if (errorCallback) errorCallback(data);
                showNotification(data.message || 'An error occurred', 'error');
            }
        })
        .catch(error => {
            console.error('Form submission error:', error);
            showNotification('An error occurred. Please try again.', 'error');
            if (errorCallback) errorCallback(error);
        })
        .finally(() => {
            // Reset button state
            submitButton.innerHTML = originalText;
            submitButton.disabled = false;
        });
    });
}

/**
 * Show notification to user
 */
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-20 right-4 p-4 rounded-lg shadow-lg z-50 max-w-sm ${getNotificationClasses(type)}`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${getNotificationIcon(type)} mr-3"></i>
            <span>${message}</span>
            <button class="ml-auto text-lg" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Add entrance animation
    notification.classList.add('animate-fadeInRight');
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}

/**
 * Get notification CSS classes based on type
 */
function getNotificationClasses(type) {
    const classes = {
        success: 'bg-green-500 text-white',
        error: 'bg-red-500 text-white',
        warning: 'bg-yellow-500 text-white',
        info: 'bg-blue-500 text-white'
    };
    return classes[type] || classes.info;
}

/**
 * Get notification icon based on type
 */
function getNotificationIcon(type) {
    const icons = {
        success: 'fa-check-circle',
        error: 'fa-exclamation-circle',
        warning: 'fa-exclamation-triangle',
        info: 'fa-info-circle'
    };
    return icons[type] || icons.info;
}

/**
 * Utility function to set cookies
 */
function setCookie(name, value, days) {
    const expires = new Date();
    expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
    document.cookie = `${name}=${value};expires=${expires.toUTCString()};path=/`;
}

/**
 * Utility function to get cookies
 */
function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

/**
 * Debounce function for performance optimization
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

/**
 * Initialize tooltips (if using any)
 */
function initTooltips() {
    const tooltipElements = document.querySelectorAll('[data-tooltip]');
    
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            showTooltip(this, this.getAttribute('data-tooltip'));
        });
        
        element.addEventListener('mouseleave', function() {
            hideTooltip();
        });
    });
}

/**
 * Show tooltip
 */
function showTooltip(element, text) {
    const tooltip = document.createElement('div');
    tooltip.id = 'tooltip';
    tooltip.className = 'absolute bg-gray-800 text-white px-2 py-1 rounded text-sm z-50 pointer-events-none';
    tooltip.textContent = text;
    
    document.body.appendChild(tooltip);
    
    // Position tooltip
    const rect = element.getBoundingClientRect();
    tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
    tooltip.style.top = rect.top - tooltip.offsetHeight - 5 + 'px';
}

/**
 * Hide tooltip
 */
function hideTooltip() {
    const tooltip = document.getElementById('tooltip');
    if (tooltip) {
        tooltip.remove();
    }
}