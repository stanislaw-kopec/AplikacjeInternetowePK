document.addEventListener('DOMContentLoaded', function() {
    // Tab switching functionality
    const tabs = document.querySelectorAll('.tab');
    const tabPanels = document.querySelectorAll('.tab-panel');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            
            // Remove active class from all tabs and panels
            tabs.forEach(t => t.classList.remove('active'));
            tabPanels.forEach(p => p.classList.remove('active'));
            
            // Add active class to current tab and panel
            this.classList.add('active');
            const targetPanel = document.getElementById(targetTab);
            if (targetPanel) {
                targetPanel.classList.add('active');
            }
        });
    });
    
    // Profile photo upload simulation
    const photoOverlay = document.querySelector('.photo-overlay');
    if (photoOverlay) {
        photoOverlay.addEventListener('click', function() {
            alert('Photo upload functionality would open here');
        });
    }
    
    // Add photo button
    const addPhotoBtn = document.querySelector('.btn-add-photo');
    if (addPhotoBtn) {
        addPhotoBtn.addEventListener('click', function() {
            alert('Add photo functionality would open here');
        });
    }
    
    // Navigation scroll effect
    const nav = document.querySelector('.glass-nav');
    window.addEventListener('scroll', function() {
        const currentScroll = window.pageYOffset;
        if (currentScroll > 100) {
            nav.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.07)';
        } else {
            nav.style.boxShadow = '0 1px 2px rgba(0, 0, 0, 0.05)';
        }
    });
    
    // Active sidebar link handling
    const sidebarLinks = document.querySelectorAll('.sidebar-link');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (this.classList.contains('logout')) {
                if (confirm('Are you sure you want to log out?')) {
                    return;
                }

                e.preventDefault();
                return;
            }
            
            sidebarLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });
});
