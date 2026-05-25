document.addEventListener('DOMContentLoaded', function() {
    // Tagi – przekierowanie po kliknięciu
    const tags = document.querySelectorAll('.popular-tags .tag');
    tags.forEach(tag => {
        tag.addEventListener('click', function () {
            const category = this.dataset.category.trim().toLowerCase();
            if (category) {
                window.location.href = `/dashboard?category=${encodeURIComponent(category)}`;
            }
        });
        
        // Efekt hover
        tag.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.transition = 'transform 0.2s ease';
        });
        tag.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Przycisk Search Now
    const searchBtn = document.getElementById('searchButton');
    if (searchBtn) {
        searchBtn.addEventListener('click', function () {
            const expertise = document.getElementById('expertiseInput').value.trim();
            const city = document.getElementById('cityInput').value.trim();
            const params = new URLSearchParams();
            if (expertise) params.set('category', expertise.toLowerCase());
            if (city) params.set('city', city);
            const query = params.toString();
            window.location.href = '/dashboard' + (query ? '?' + query : '');
        });
    }

    // Enter w polach też wywołuje wyszukiwanie
    const inputs = document.querySelectorAll('#expertiseInput, #cityInput');
    inputs.forEach(input => {
        input.addEventListener('keyup', function (e) {
            if (e.key === 'Enter') {
                searchBtn.click();
            }
        });
    });

    // Smooth scroll dla linków
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // Efekt cienia nawigacji
    const nav = document.querySelector('.glass-nav');
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 100) {
            nav.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.07)';
        } else {
            nav.style.boxShadow = '0 1px 2px rgba(0, 0, 0, 0.05)';
        }
    });

    // Intersection Observer dla animacji
    const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.step-card').forEach(card => observer.observe(card));
    document.querySelectorAll('.feature-card').forEach(card => observer.observe(card));

    // Sign In
    document.querySelectorAll('.btn-sign-in').forEach(button => {
        button.addEventListener('click', () => window.location.href = '/login');
    });
});