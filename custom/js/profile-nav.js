document.addEventListener('DOMContentLoaded', function() {
    const mobileToggle = document.querySelector('.profile-mobile-toggle');
    const mobileOverlay = document.querySelector('.profile-mobile-overlay');
    const navLinksContainer = document.querySelector('.profile-nav-links-container');
    const navClose = document.querySelector('.profile-nav-close');
    const body = document.body;

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
    }

    // Event listeners
    mobileToggle.addEventListener('click', toggleMobileMenu);
    mobileOverlay.addEventListener('click', closeMobileMenu);
    navClose.addEventListener('click', closeMobileMenu);

    // Close menu when clicking a link
    document.querySelectorAll('.profile-nav-links a').forEach(link => {
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