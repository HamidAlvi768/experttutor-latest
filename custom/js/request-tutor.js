document.addEventListener('DOMContentLoaded', function() {
    // File Upload Handling
    const fileUpload = document.getElementById('fileUpload');
    const fileName = document.querySelector('.file-name');

    if (fileUpload && fileName) {
        fileUpload.addEventListener('change', function(e) {
            if (this.files.length > 0) {
                fileName.value = this.files[0].name;
            }
        });
    }

    // Form Preview
    const previewBtn = document.querySelector('.preview-btn');
    if (previewBtn) {
        previewBtn.addEventListener('click', function() {
            // Collect form data
            const formData = new FormData(document.querySelector('.request-tutor-form'));
            
            // Here you would typically show a preview modal or page
            // For now, we'll just log the data
            console.log('Preview Data:', Object.fromEntries(formData));
        });
    }

    // Form Submission
    const requestForm = document.querySelector('.request-tutor-form');
    if (requestForm) {
        requestForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Here you would typically handle the form submission
            // For now, we'll just show an alert
            alert('Form submitted successfully!');
        });
    }

    // Add smooth hover effects to form controls
    const formControls = document.querySelectorAll('.form-control, .form-select');
    formControls.forEach(control => {
        control.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        control.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });
}); 