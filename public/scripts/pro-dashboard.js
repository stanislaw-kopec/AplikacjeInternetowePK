document.addEventListener('DOMContentLoaded', function() {
    // Refresh button
    const refreshBtn = document.querySelector('.btn-outline');
    if (refreshBtn) {
        refreshBtn.addEventListener('click', function() {
            const btn = this;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span class="material-symbols-outlined">refresh</span> Refreshing...';
            btn.disabled = true;
            
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }, 2000);
        });
    }
    
    // Edit Profile button
    const editBtn = document.querySelectorAll('.btn-outline')[1];
    if (editBtn) {
        editBtn.addEventListener('click', function() {
            window.location.href = '/profile-settings';
        });
    }
    
    // View Public Page button
    const viewBtn = document.querySelector('.btn-primary');
    if (viewBtn) {
        viewBtn.addEventListener('click', function() {
            window.location.href = '/expert-detail';
        });
    }
    
    // Chart select
    const chartSelect = document.querySelector('.chart-select');
    if (chartSelect) {
        chartSelect.addEventListener('change', function() {
            console.log('Chart period changed:', this.value);
            // Update chart data based on selection
        });
    }
    
    // Navigation scroll
    const nav = document.querySelector('.glass-nav');
    window.addEventListener('scroll', function() {
        nav.style.boxShadow = window.pageYOffset > 100 
            ? '0 4px 6px rgba(0, 0, 0, 0.07)' 
            : '0 1px 2px rgba(0, 0, 0, 0.05)';
    });
    
    // Premium upgrade button
    const upgradeBtn = document.querySelector('.btn-upgrade');
    if (upgradeBtn) {
        upgradeBtn.addEventListener('click', function() {
            alert('Redirecting to upgrade page...');
        });
    }
});