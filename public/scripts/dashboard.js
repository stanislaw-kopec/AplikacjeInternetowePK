document.addEventListener('DOMContentLoaded', function() {
    const cityInput = document.querySelector('.filter-input-wrapper input');
    const categoryCheckboxes = document.querySelectorAll('.specialization-option input[type="checkbox"]');
    const ratingBtns = document.querySelectorAll('.rating-btn');
    const profileCards = document.querySelectorAll('.profile-card');

    // ----- Odczyt parametrów z URL (home → dashboard) -----
    const urlParams = new URLSearchParams(window.location.search);
    const paramCity = urlParams.get('city');
    const paramCategory = urlParams.get('category');

    if (paramCity && cityInput) {
        cityInput.value = paramCity;
    }
    if (paramCategory) {
        const catLower = paramCategory.toLowerCase();
        categoryCheckboxes.forEach(cb => {
            if (cb.dataset.category === catLower) {
                cb.checked = true;
            }
        });
    }

    // Natychmiastowe filtrowanie po parametrach
    if (paramCity || paramCategory) {
        filterCards();
    }

    // Rating
    ratingBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            ratingBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            filterCards();
        });
    });

    // Miasto (Enter)
    if (cityInput) {
        cityInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') filterCards();
        });
    }

    // Kategorie
    categoryCheckboxes.forEach(cb => cb.addEventListener('change', filterCards));

    // Główna funkcja filtrująca
    function filterCards() {
        const searchCity = cityInput ? cityInput.value.trim().toLowerCase() : '';
        const selectedCategories = [];
        categoryCheckboxes.forEach(cb => {
            if (cb.checked) selectedCategories.push(cb.dataset.category.toLowerCase());
        });

        const activeRatingBtn = document.querySelector('.rating-btn.active');
        const minRating = activeRatingBtn ? activeRatingBtn.dataset.rating : 'all';

        profileCards.forEach(card => {
            let visible = true;

            // Miasto
            if (searchCity) {
                const cardText = card.textContent.toLowerCase();
                if (!cardText.includes(searchCity)) visible = false;
            }

            // Kategorie
            if (visible && selectedCategories.length > 0) {
                const raw = card.dataset.categories || '';
                const cardCats = raw.toLowerCase().split(',').map(s => s.trim()).filter(s => s !== '');
                if (cardCats.length === 0) {
                    visible = false;
                } else {
                    const hasCategory = selectedCategories.some(cat => cardCats.includes(cat));
                    if (!hasCategory) visible = false;
                }
            }

            // Ocena
            if (visible && minRating !== 'all') {
                const ratingEl = card.querySelector('.rating-value');
                if (ratingEl) {
                    const ratingText = ratingEl.textContent.trim();
                    const rating = ratingText === 'New' ? 0 : parseFloat(ratingText);
                    if (rating < parseFloat(minRating)) visible = false;
                }
            }

            card.style.display = visible ? '' : 'none';
        });

        // Aktualizacja licznika
        const visibleCards = document.querySelectorAll('.profile-card[style*="display: block"], .profile-card:not([style*="display"])');
        const header = document.querySelector('.results-header h1');
        if (header) {
            header.innerHTML = `${visibleCards.length} Results for <span>Experts</span>`;
        }
    }

    // Sign In
    document.querySelectorAll('.btn-sign-in').forEach(btn => {
        btn.addEventListener('click', () => window.location.href = '/login');
    });

    // Nav shadow
    const nav = document.querySelector('.glass-nav');
    if (nav) {
        window.addEventListener('scroll', () => {
            nav.style.boxShadow = window.pageYOffset > 100
                ? '0 4px 6px rgba(0,0,0,0.07)'
                : '0 1px 2px rgba(0,0,0,0.05)';
        });
    }
});