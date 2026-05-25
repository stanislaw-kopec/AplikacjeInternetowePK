document.addEventListener('DOMContentLoaded', function() {
    const isLoggedIn = document.body.dataset.isLoggedIn === 'true';
    const specialistId = document.body.dataset.specialistId || '1';

    // Portfolio filter buttons
    const filterBtns = document.querySelectorAll('.filter-btn');
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Filter logic would go here
            const filter = this.textContent.trim();
            const items = document.querySelectorAll('.portfolio-item');
            
            if (filter === 'All') {
                items.forEach(item => item.style.display = 'block');
            } else {
                items.forEach(item => {
                    const label = item.querySelector('.portfolio-overlay span').textContent;
                    item.style.display = label.includes(filter) ? 'block' : 'none';
                });
            }
        });
    });
    
    // Call button
    const callBtn = document.querySelector('.btn-call');
    if (callBtn) {
        callBtn.addEventListener('click', function() {
            if (!isLoggedIn) {
                window.location.href = '/login?redirect=' + encodeURIComponent(window.location.pathname);
                return;
            }

            alert('Phone number: ' + (this.dataset.phone || 'not available'));
        });
    }
    
    // Contact form
    const contactForm = document.querySelector('.contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            if (!isLoggedIn) {
                window.location.href = '/login?redirect=' + encodeURIComponent(window.location.pathname);
                return;
            }

            const btn = this.querySelector('.btn-send');
            btn.textContent = 'Sending...';
            btn.disabled = true;
            
            setTimeout(() => {
                btn.textContent = 'Sent!';
                btn.style.background = '#16a34a';
                
                setTimeout(() => {
                    btn.textContent = 'Send Inquiry';
                    btn.disabled = false;
                    btn.style.background = '';
                    this.reset();
                }, 2000);
            }, 1000);
        });
    }
    
    // Pagination
    const paginationBtns = document.querySelectorAll('.pagination-btn');
    paginationBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const current = document.querySelector('.pagination-current');
            const parts = current.textContent.split('/');
            let page = parseInt(parts[0]);
            
            if (this.querySelector('.material-symbols-outlined').textContent === 'chevron_left') {
                page = Math.max(1, page - 1);
            } else {
                page = Math.min(5, page + 1);
            }
            
            current.textContent = `${page} / 5`;
        });
    });
    
    // Navigation scroll
    const nav = document.querySelector('.glass-nav');
    window.addEventListener('scroll', function() {
        nav.style.boxShadow = window.pageYOffset > 100 
            ? '0 4px 6px rgba(0, 0, 0, 0.07)' 
            : '0 1px 2px rgba(0, 0, 0, 0.05)';
    });

    document.querySelectorAll('.btn-sign-in').forEach(button => {
        button.addEventListener('click', function() {
            window.location.href = '/login?redirect=' + encodeURIComponent(window.location.pathname);
        });
    });

    const writeReviewButton = document.querySelector('.btn-write-review');
    if (writeReviewButton) {
        writeReviewButton.addEventListener('click', function() {
            if (!isLoggedIn) {
                window.location.href = '/login?redirect=' + encodeURIComponent(window.location.pathname);
                return;
            }

            window.location.href = '/review/' + encodeURIComponent(specialistId);
        });
    }
});
