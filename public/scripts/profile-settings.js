// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const mobileMenu = document.querySelector('.mobile-menu');
    
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('open');
            
            const icon = mobileMenuBtn.querySelector('.material-symbols-outlined');
            if (mobileMenu.classList.contains('open')) {
                icon.textContent = 'close';
            } else {
                icon.textContent = 'menu';
            }
        });
    }
    
    // Close mobile menu when clicking on a link
    const mobileLinks = document.querySelectorAll('.mobile-menu a');
    mobileLinks.forEach(link => {
        link.addEventListener('click', function() {
            mobileMenu.classList.remove('open');
            const icon = mobileMenuBtn.querySelector('.material-symbols-outlined');
            if (icon) icon.textContent = 'menu';
        });
    });

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
    
    // Save button simulation
    const saveButton = document.querySelector('.btn-save');
    if (saveButton) {
        saveButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Show saving state
            const originalText = saveButton.textContent;
            saveButton.textContent = 'Saving...';
            saveButton.disabled = true;
            saveButton.style.opacity = '0.7';
            
            // Simulate save
            setTimeout(() => {
                saveButton.textContent = 'Saved!';
                saveButton.style.background = '#16a34a';
                
                setTimeout(() => {
                    saveButton.textContent = originalText;
                    saveButton.disabled = false;
                    saveButton.style.opacity = '1';
                    saveButton.style.background = '';
                }, 2000);
            }, 1000);
        });
    }
    
    // Cancel button
    const cancelButton = document.querySelector('.btn-cancel');
    if (cancelButton) {
        cancelButton.addEventListener('click', function() {
            if (confirm('Are you sure you want to discard changes?')) {
                window.location.reload();
            }
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
                e.preventDefault();
                if (confirm('Are you sure you want to log out?')) {
                    // Handle logout
                }
                return;
            }
            
            sidebarLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });
});