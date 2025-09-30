<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Store the current step in session
$_SESSION['current_wizard_step'] = 'teacher-profile';
?>

<h2 class="wizard-section-title">Teacher Profile</h2>

<!-- Profile Photo Upload -->
<div class="profile-photo-upload">
    <div class="profile-photo-placeholder">
        <img src="assets/images/profiles/teacher-avatar.jpg" alt="Profile Photo" id="profile-preview">
        <input type="file" id="profile-upload" hidden>
    </div>
    <div class="upload-your-photo">Upload Your Photo</div>
</div>

<!-- Form Fields -->
<div class="wizard-form-grid">
    <!-- Full Name -->
    <div class="wizard-form-group">
        <label class="subject-label" for="full-name">Full Name</label>
        <input type="text" class="wizard-form-control" id="full-name" name="full_name" placeholder="Full Name" value="<?php echo isset($_SESSION['wizard_data']['teacher-profile']['full_name']) ? $_SESSION['wizard_data']['teacher-profile']['full_name'] : 'Ali'; ?>">
    </div>
    
    <!-- Nick Name -->
    <div class="wizard-form-group">
        <label class="subject-label" for="nick-name">Nick Name</label>
        <input type="text" class="wizard-form-control" id="nick-name" name="nick_name" placeholder="Nick Name" value="<?php echo isset($_SESSION['wizard_data']['teacher-profile']['nick_name']) ? $_SESSION['wizard_data']['teacher-profile']['nick_name'] : 'Khan'; ?>">
    </div>
    
    <!-- Gender -->
    <div class="wizard-form-group">
        <label class="subject-label" for="gender">Gender</label>
        <select class="wizard-form-control wizard-select-control" id="gender" name="gender">
            <option value="male" <?php echo (!isset($_SESSION['wizard_data']['teacher-profile']['gender']) || $_SESSION['wizard_data']['teacher-profile']['gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
            <option value="female" <?php echo (isset($_SESSION['wizard_data']['teacher-profile']['gender']) && $_SESSION['wizard_data']['teacher-profile']['gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
            <option value="other" <?php echo (isset($_SESSION['wizard_data']['teacher-profile']['gender']) && $_SESSION['wizard_data']['teacher-profile']['gender'] == 'other') ? 'selected' : ''; ?>>Other</option>
        </select>
    </div>
    
    <!-- Country -->
    <div class="wizard-form-group">
        <label class="subject-label" for="country">Country</label>
        <select class="wizard-form-control wizard-select-control" id="country" name="country">
            <option value="pakistan" <?php echo (!isset($_SESSION['wizard_data']['teacher-profile']['country']) || $_SESSION['wizard_data']['teacher-profile']['country'] == 'pakistan') ? 'selected' : ''; ?>>Pakistan</option>
            <option value="united_states" <?php echo (isset($_SESSION['wizard_data']['teacher-profile']['country']) && $_SESSION['wizard_data']['teacher-profile']['country'] == 'united_states') ? 'selected' : ''; ?>>United States</option>
            <option value="united_kingdom" <?php echo (isset($_SESSION['wizard_data']['teacher-profile']['country']) && $_SESSION['wizard_data']['teacher-profile']['country'] == 'united_kingdom') ? 'selected' : ''; ?>>United Kingdom</option>
            <option value="canada" <?php echo (isset($_SESSION['wizard_data']['teacher-profile']['country']) && $_SESSION['wizard_data']['teacher-profile']['country'] == 'canada') ? 'selected' : ''; ?>>Canada</option>
            <option value="australia" <?php echo (isset($_SESSION['wizard_data']['teacher-profile']['country']) && $_SESSION['wizard_data']['teacher-profile']['country'] == 'australia') ? 'selected' : ''; ?>>Australia</option>
            <!-- Add more countries as needed -->
        </select>
    </div>
    
    <!-- Language -->
    <div class="wizard-form-group">
        <label class="subject-label" for="language">Language</label>
        <select class="wizard-form-control wizard-select-control" id="language" name="language">
            <option value="english" <?php echo (!isset($_SESSION['wizard_data']['teacher-profile']['language']) || $_SESSION['wizard_data']['teacher-profile']['language'] == 'english') ? 'selected' : ''; ?>>English</option>
            <option value="urdu" <?php echo (isset($_SESSION['wizard_data']['teacher-profile']['language']) && $_SESSION['wizard_data']['teacher-profile']['language'] == 'urdu') ? 'selected' : ''; ?>>Urdu</option>
            <option value="spanish" <?php echo (isset($_SESSION['wizard_data']['teacher-profile']['language']) && $_SESSION['wizard_data']['teacher-profile']['language'] == 'spanish') ? 'selected' : ''; ?>>Spanish</option>
            <option value="french" <?php echo (isset($_SESSION['wizard_data']['teacher-profile']['language']) && $_SESSION['wizard_data']['teacher-profile']['language'] == 'french') ? 'selected' : ''; ?>>French</option>
            <option value="german" <?php echo (isset($_SESSION['wizard_data']['teacher-profile']['language']) && $_SESSION['wizard_data']['teacher-profile']['language'] == 'german') ? 'selected' : ''; ?>>German</option>
            <!-- Add more languages as needed -->
        </select>
    </div>
    
    <!-- Address -->
    <div class="wizard-form-group">
        <label class="subject-label" for="address">Address</label>
        <input type="text" class="wizard-form-control" id="address" name="address" placeholder="Address" value="<?php echo isset($_SESSION['wizard_data']['teacher-profile']['address']) ? $_SESSION['wizard_data']['teacher-profile']['address'] : 'Executive Center I8 islamabad'; ?>">
    </div>
</div>

<!-- Form Actions -->
<div class="wizard-form-actions">
    <button type="button" class="btn-save" id="save-profile">Save</button>
    <button type="button" class="btn-next" id="next-step" data-next-step="subject-teach">Next</button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Profile Image Preview
    const profilePlaceholder = document.querySelector('.profile-photo-placeholder');
    if (profilePlaceholder) {
        const profileInput = document.getElementById('profile-upload');
        const profilePreview = document.getElementById('profile-preview');
        
        profilePlaceholder.addEventListener('click', function() {
            profileInput.click();
        });
        
        profileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    profilePreview.src = e.target.result;
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
    
    // Save button functionality
    const saveButton = document.getElementById('save-profile');
    if (saveButton) {
        saveButton.addEventListener('click', function() {
            saveFormData();
            // Show a success message
            alert('Your profile data has been saved!');
        });
    }
    
    // Next button functionality
    const nextButton = document.getElementById('next-step');
    if (nextButton) {
        nextButton.addEventListener('click', function() {
            saveFormData();
            const nextStep = this.getAttribute('data-next-step');
            if (nextStep) {
                window.location.href = 'teacher-profile-wizard.php?step=' + nextStep;
            }
        });
    }
    
    // Function to save form data
    function saveFormData() {
        const form = document.querySelector('form');
        const formData = new FormData(form);
        
        // Use fetch to send the data to a server-side script
        fetch('includes/wizard-steps/save-wizard-data.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log('Success:', data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
});
</script> 