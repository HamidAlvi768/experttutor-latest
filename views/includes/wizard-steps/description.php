<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Store the current step in session
$_SESSION['current_wizard_step'] = 'description';
?>

<h2 class="wizard-section-title">Description</h2>

<div class="description-form-container">
    <!-- Description textarea with custom styling -->
    <div class="wizard-form-group full-width">
        <label class="subject-label">Your Role and responsibility at this job</label>
        <textarea class="wizard-form-control" id="teacher-description" name="teacher_description" rows="8" placeholder="Describe"><?php echo isset($_SESSION['wizard_data']['description']['teacher_description']) ? $_SESSION['wizard_data']['description']['teacher_description'] : ''; ?></textarea>
    </div>
    
    <!-- Privacy checkbox -->
    <div class="wizard-form-group full-width" >
        <div class="checkbox-option">
            <input type="checkbox" id="privacy-agreement" name="privacy_agreement" <?php echo (isset($_SESSION['wizard_data']['description']['privacy_agreement']) && $_SESSION['wizard_data']['description']['privacy_agreement']) ? 'checked' : ''; ?>>
            <label for="privacy-agreement">I have not share of any details like(Phone, Skype,whatsapp etc.)</label>
        </div>
    </div>
</div>

<!-- Form Actions -->
<div class="wizard-form-actions">
    <button type="button" class="btn-save" id="save-description">Save</button>
    <button type="button" class="btn-next" id="finish-wizard">Next</button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Finish button functionality
    const finishButton = document.getElementById('finish-wizard');
    if (finishButton) {
        finishButton.addEventListener('click', function() {
            saveData();
            // Redirect to tutor profile page
            window.location.href = 'tutor-profile.php';
        });
    }
    
    // Save button functionality
    const saveButton = document.getElementById('save-description');
    if (saveButton) {
        saveButton.addEventListener('click', function() {
            saveData(true);
        });
    }
    
    // Function to save form data
    function saveData(showAlert = false) {
        const formData = {
            teacher_description: document.getElementById('teacher-description').value,
            privacy_agreement: document.getElementById('privacy-agreement').checked
        };
        
        // Send data to save-wizard-data.php
        fetch('includes/wizard-steps/save-wizard-data.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                step: 'description',
                data: formData
            })
        })
        .then(response => response.json())
        .then(data => {
            if (showAlert) {
                alert('Description saved successfully!');
            }
        })
        .catch(error => {
            console.error('Error saving data:', error);
            if (showAlert) {
                alert('Error saving data. Please try again.');
            }
        });
    }
});
</script> 