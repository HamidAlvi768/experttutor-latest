document.addEventListener('DOMContentLoaded', function() {
    // Handle form submission
    const profileForm = document.querySelector('.profile-form-container');
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // For now, just redirect to tutors page
            window.location.href = 'tutors.php';
        });
    }

    // Handle file input change
    const photoInput = document.getElementById('photo-upload');
    const photoPreview = document.getElementById('profile-preview');
    
    if (photoInput && photoPreview) {
        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    photoPreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Add smooth hover effects to form controls
    const formControls = document.querySelectorAll('.profile-form-control');
    formControls.forEach(control => {
        control.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        control.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });
}); 