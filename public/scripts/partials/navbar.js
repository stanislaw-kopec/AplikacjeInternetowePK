document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const mobileMenu = document.querySelector('.mobile-menu');

    if (!mobileMenuBtn || !mobileMenu) {
        return;
    }

    mobileMenuBtn.addEventListener('click', function() {
        mobileMenu.classList.toggle('open');
        const icon = mobileMenuBtn.querySelector('.material-symbols-outlined');

        if (icon) {
            icon.textContent = mobileMenu.classList.contains('open') ? 'close' : 'menu';
        }
    });

    mobileMenu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', function() {
            mobileMenu.classList.remove('open');
            const icon = mobileMenuBtn.querySelector('.material-symbols-outlined');

            if (icon) {
                icon.textContent = 'menu';
            }
        });
    });
});
