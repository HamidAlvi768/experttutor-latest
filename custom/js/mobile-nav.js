document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const mobileNav = document.querySelector('.mobile-nav');
    const mobileNavClose = document.querySelector('.mobile-nav-close');
    const dropdownToggles = document.querySelectorAll('.mobile-nav-link[data-dropdown]');
    const body = document.body;

    // Toggle mobile menu
    if (mobileMenuToggle && mobileNav) {
        mobileMenuToggle.addEventListener('click', function() {
            mobileMenuToggle.classList.toggle('active');
            mobileNav.classList.toggle('active');
            body.style.overflow = mobileNav.classList.contains('active') ? 'hidden' : '';
        });
    }

    // Close mobile menu
    if (mobileNavClose) {
        mobileNavClose.addEventListener('click', function() {
            mobileMenuToggle.classList.remove('active');
            mobileNav.classList.remove('active');
            body.style.overflow = '';
        });
    }

    // Handle dropdowns
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const dropdownId = this.dataset.dropdown;
            const dropdown = document.querySelector(`#${dropdownId}`);
            
            if (dropdown) {
                // Close other dropdowns
                dropdownToggles.forEach(otherToggle => {
                    if (otherToggle !== toggle) {
                        const otherId = otherToggle.dataset.dropdown;
                        const otherDropdown = document.querySelector(`#${otherId}`);
                        if (otherDropdown) {
                            otherDropdown.classList.remove('active');
                        }
                    }
                });

                // Toggle current dropdown
                dropdown.classList.toggle('active');
            }
        });
    });

    // Close mobile menu on window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            mobileMenuToggle?.classList.remove('active');
            mobileNav?.classList.remove('active');
            body.style.overflow = '';
        }
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(e) {
        if (mobileNav?.classList.contains('active') &&
            !mobileNav.contains(e.target) &&
            !mobileMenuToggle.contains(e.target)) {
            mobileMenuToggle.classList.remove('active');
            mobileNav.classList.remove('active');
            body.style.overflow = '';
        }
    });

    // Handle mobile search
    const mobileSearchInput = document.querySelector('.mobile-search-input');
    const mobileSearchIcon = document.querySelector('.mobile-search-icon');

    if (mobileSearchInput && mobileSearchIcon) {
        mobileSearchIcon.addEventListener('click', function() {
            // Trigger search functionality
            const searchQuery = mobileSearchInput.value.trim();
            if (searchQuery) {
                // Implement your search functionality here
                console.log('Searching for:', searchQuery);
            }
        });

        // Search on enter key
        mobileSearchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const searchQuery = this.value.trim();
                if (searchQuery) {
                    // Implement your search functionality here
                    console.log('Searching for:', searchQuery);
                }
            }
        });
    }

    // Add touch event handling for better mobile experience
    let touchStartY = 0;
    let touchEndY = 0;

    mobileNav?.addEventListener('touchstart', function(e) {
        touchStartY = e.touches[0].clientY;
    }, { passive: true });

    mobileNav?.addEventListener('touchmove', function(e) {
        touchEndY = e.touches[0].clientY;
        const mobileNavContent = this.querySelector('.mobile-nav-content');
        
        // Allow scrolling only when content is scrollable
        if (mobileNavContent) {
            const isAtTop = mobileNavContent.scrollTop === 0;
            const isAtBottom = mobileNavContent.scrollHeight - mobileNavContent.scrollTop === mobileNavContent.clientHeight;
            
            // Prevent pull-to-refresh when at the top
            if (isAtTop && touchEndY > touchStartY) {
                e.preventDefault();
            }
            
            // Prevent overscroll at the bottom
            if (isAtBottom && touchEndY < touchStartY) {
                e.preventDefault();
            }
        }
    }, { passive: false });
}); 