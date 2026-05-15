document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const mobileMenu = document.querySelector('.mobile-menu');
    
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('open');
            const icon = mobileMenuBtn.querySelector('.material-symbols-outlined');
            icon.textContent = mobileMenu.classList.contains('open') ? 'close' : 'menu';
        });
    }
    
    // Rating filter buttons
    const ratingBtns = document.querySelectorAll('.rating-btn');
    ratingBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            ratingBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });
    
    // City filter
    const cityInput = document.querySelector('.filter-input-wrapper input');
    if (cityInput) {
        cityInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                filterCards();
            }
        });
    }
    
    // Specialization checkboxes
    const checkboxes = document.querySelectorAll('.specialization-option input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            filterCards();
        });
    });
    
    // Filter function
    function filterCards() {
        const cards = document.querySelectorAll('.profile-card');
        const searchTerm = cityInput ? cityInput.value.toLowerCase() : '';
        
        cards.forEach(card => {
            let visible = true;
            
            if (searchTerm) {
                const cardText = card.textContent.toLowerCase();
                visible = cardText.includes(searchTerm);
            }
            
            card.style.display = visible ? 'block' : 'none';
        });
    }
    
    // View Profile button
const viewButtons = document.querySelectorAll('.btn-view-profile');
viewButtons.forEach(btn => {
    btn.addEventListener('click', function() {
        window.location.href = '/expert-detail';
    });
});
    
    // Navigation scroll effect
    const nav = document.querySelector('.glass-nav');
    window.addEventListener('scroll', function() {
        nav.style.boxShadow = window.pageYOffset > 100 
            ? '0 4px 6px rgba(0, 0, 0, 0.07)' 
            : '0 1px 2px rgba(0, 0, 0, 0.05)';
    });
});