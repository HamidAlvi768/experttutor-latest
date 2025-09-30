document.addEventListener('DOMContentLoaded', function() {
    const mobileToggle = document.querySelector('.tutor-mobile-toggle');
    const mobileOverlay = document.querySelector('.tutor-mobile-overlay');
    const navLinksContainer = document.querySelector('.tutor-nav-links-container');
    const navClose = document.querySelector('.tutor-nav-close');
    const body = document.body;
    const dropdownNavs = document.querySelectorAll('.dropdown-nav');

    // Toggle mobile menu
    function toggleMobileMenu() {
        body.classList.toggle('mobile-menu-active');
        mobileToggle.setAttribute('aria-expanded', 
            mobileToggle.getAttribute('aria-expanded') === 'false' ? 'true' : 'false'
        );
    }

    // Close mobile menu
    function closeMobileMenu() {
        body.classList.remove('mobile-menu-active');
        mobileToggle.setAttribute('aria-expanded', 'false');
        // Close any open dropdowns
        dropdownNavs.forEach(nav => nav.classList.remove('active'));
    }

    // Event listeners
    if (mobileToggle) {
        mobileToggle.addEventListener('click', toggleMobileMenu);
    }
    
    if (mobileOverlay) {
        mobileOverlay.addEventListener('click', closeMobileMenu);
    }
    
    if (navClose) {
        navClose.addEventListener('click', closeMobileMenu);
    }

    // Handle dropdowns in mobile view
    dropdownNavs.forEach(nav => {
        const link = nav.querySelector('a');
        if (link) {
            link.addEventListener('click', function(e) {
                if (window.innerWidth < 992) {
                    e.preventDefault();
                    nav.classList.toggle('active');
                }
            });
        }
    });

    // Close menu when clicking a non-dropdown link
    document.querySelectorAll('.tutor-nav-links a:not(.dropdown-nav a)').forEach(link => {
        link.addEventListener('click', closeMobileMenu);
    });

    // Close menu on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && body.classList.contains('mobile-menu-active')) {
            closeMobileMenu();
        }
    });

    // Handle window resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (window.innerWidth >= 992 && body.classList.contains('mobile-menu-active')) {
                closeMobileMenu();
            }
        }, 250);
    });
}); 