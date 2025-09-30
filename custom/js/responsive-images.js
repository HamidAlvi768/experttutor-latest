// Responsive Image Handler
class ResponsiveImageHandler {
    constructor(options = {}) {
        this.options = {
            lazyLoadClass: 'img-lazy',
            loadedClass: 'loaded',
            threshold: 0.1,
            rootMargin: '50px 0px',
            ...options
        };

        this.init();
    }

    init() {
        // Check for IntersectionObserver support
        if ('IntersectionObserver' in window) {
            this.setupIntersectionObserver();
        } else {
            this.loadAllImages();
        }

        // Handle dynamic content
        this.observeDOMChanges();
        
        // Handle orientation changes
        this.handleOrientationChange();
    }

    setupIntersectionObserver() {
        const options = {
            root: null,
            rootMargin: this.options.rootMargin,
            threshold: this.options.threshold
        };

        this.observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.loadImage(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, options);

        this.observeImages();
    }

    observeImages() {
        const images = document.querySelectorAll(`img.${this.options.lazyLoadClass}:not(.${this.options.loadedClass})`);
        images.forEach(img => this.observer.observe(img));
    }

    loadImage(img) {
        const src = img.dataset.src;
        const srcset = img.dataset.srcset;
        const sizes = img.dataset.sizes;

        if (src) {
            img.src = src;
        }

        if (srcset) {
            img.srcset = srcset;
        }

        if (sizes) {
            img.sizes = sizes;
        }

        img.classList.add(this.options.loadedClass);

        // Remove data attributes to free up memory
        img.removeAttribute('data-src');
        img.removeAttribute('data-srcset');
        img.removeAttribute('data-sizes');

        // Dispatch custom event
        img.dispatchEvent(new CustomEvent('imageLoaded'));
    }

    loadAllImages() {
        const images = document.querySelectorAll(`img.${this.options.lazyLoadClass}:not(.${this.options.loadedClass})`);
        images.forEach(img => this.loadImage(img));
    }

    observeDOMChanges() {
        // Watch for dynamically added images
        const observer = new MutationObserver((mutations) => {
            mutations.forEach(mutation => {
                mutation.addedNodes.forEach(node => {
                    if (node.nodeType === 1) { // ELEMENT_NODE
                        const images = node.querySelectorAll(`img.${this.options.lazyLoadClass}:not(.${this.options.loadedClass})`);
                        if (images.length > 0) {
                            if (this.observer) {
                                images.forEach(img => this.observer.observe(img));
                            } else {
                                images.forEach(img => this.loadImage(img));
                            }
                        }
                    }
                });
            });
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }

    handleOrientationChange() {
        window.addEventListener('orientationchange', () => {
            // Reset image dimensions and recalculate after orientation change
            const images = document.querySelectorAll('img[data-optimize="true"]');
            images.forEach(img => {
                this.optimizeImageForScreen(img);
            });
        });
    }

    optimizeImageForScreen(img) {
        const devicePixelRatio = window.devicePixelRatio || 1;
        const viewportWidth = window.innerWidth;
        const viewportHeight = window.innerHeight;

        // Get image's natural dimensions
        const naturalWidth = img.naturalWidth;
        const naturalHeight = img.naturalHeight;

        if (naturalWidth && naturalHeight) {
            // Calculate optimal dimensions
            let optimalWidth = Math.min(viewportWidth, naturalWidth);
            let optimalHeight = (optimalWidth / naturalWidth) * naturalHeight;

            // Adjust for device pixel ratio
            optimalWidth *= devicePixelRatio;
            optimalHeight *= devicePixelRatio;

            // Set size attributes
            img.setAttribute('width', Math.round(optimalWidth));
            img.setAttribute('height', Math.round(optimalHeight));
        }
    }

    // Public method to manually trigger image optimization
    optimizeImages() {
        const images = document.querySelectorAll('img[data-optimize="true"]');
        images.forEach(img => this.optimizeImageForScreen(img));
    }
}

// Initialize the handler when the DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.responsiveImageHandler = new ResponsiveImageHandler({
        lazyLoadClass: 'img-lazy',
        loadedClass: 'loaded',
        threshold: 0.1,
        rootMargin: '50px 0px'
    });
});

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ResponsiveImageHandler;
} 