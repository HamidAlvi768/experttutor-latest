// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // Add shadow to header on scroll
    window.addEventListener('scroll', function() {
        const header = document.querySelector('.main-header');
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // Initialize number animations when they come into view
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateNumber(entry.target);
                observer.unobserve(entry.target); // Only animate once
            }
        });
    }, {
        threshold: 0.5 // Trigger when 50% of the element is visible
    });

    // Observe all stat numbers
    document.querySelectorAll('.stat-number').forEach(stat => {
        // Only observe elements that have the required data attributes
        if (stat.dataset.value && stat.dataset.suffix) {
            observer.observe(stat);
        } else {
            console.warn('Stat number element missing required data attributes, skipping animation:', stat);
            // Add a fallback class to indicate this element won't animate
            stat.classList.add('no-animation');
        }
    });
    
    // Add loading state for statistics
    const statNumbers = document.querySelectorAll('.stat-number');
    if (statNumbers.length > 0) {
        statNumbers.forEach(stat => {
            if (stat.dataset.value && stat.dataset.suffix) {
                stat.style.opacity = '0.8'; // Slightly dimmed until animation starts
            }
        });
    }

    // Form validation
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
});

function animateNumber(element) {
    // Check if the element has the required data attributes
    if (!element.dataset.value || !element.dataset.suffix) {
        console.warn('Stat number element missing required data attributes:', element);
        return; // Exit early if attributes are missing
    }
    
    const value = parseFloat(element.dataset.value);
    const suffix = element.dataset.suffix;
    
    // Validate that the value is a valid number
    if (isNaN(value) || value <= 0) {
        console.warn('Invalid value for stat number:', element.dataset.value);
        return; // Exit early if value is invalid
    }
    
    const duration = 2000; // Animation duration in milliseconds
    const steps = 60; // Number of steps in the animation
    const stepDuration = duration / steps;
    
    let currentStep = 0;
    let currentValue = 0;
    const increment = value / steps;
    
    // Store the original text content as fallback
    const originalText = element.textContent;
    
    // Clear any existing content
    element.textContent = '0' + suffix;
    
    const animation = setInterval(() => {
        currentStep++;
        currentValue = currentStep * increment;
        
        // Format the number based on whether it's a decimal or integer
        let formattedValue = Number.isInteger(value) ? 
            Math.round(currentValue).toString() : 
            currentValue.toFixed(1);
            
        // Add the suffix
        element.textContent = formattedValue + suffix;
        
        // Stop the animation when we reach the target value
        if (currentStep >= steps) {
            element.textContent = value + suffix;
            clearInterval(animation);
        }
    }, stepDuration);
    
    // Add error handling for the animation
    setTimeout(() => {
        if (animation) {
            clearInterval(animation);
            // Fallback to original text if animation fails
            element.textContent = originalText;
        }
    }, duration + 1000); // Give extra time for animation to complete
} 