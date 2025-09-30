<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Store the current step in session
$_SESSION['current_wizard_step'] = 'teaching-details';
?>

<h2 class="wizard-section-title">Teaching Details</h2>

<div class="teaching-form-container">
    <!-- Fee Structure Section -->
    <div class="form-row">
        <div class="wizard-form-group" style="flex: 1;">
            <label class="subject-label">I Charge</label>
            <select class="wizard-form-control wizard-select-control" name="charge_type" id="charge-type">
                <option value="hourly" selected>Hourly</option>
                <option value="daily">Daily</option>
                <option value="weekly">Weekly</option>
                <option value="monthly">Monthly</option>
            </select>
        </div>
        
        <div class="wizard-form-group" style="flex: 1;">
            <label class="subject-label">Min Fee</label>
            <select class="wizard-form-control wizard-select-control" name="min_fee" id="min-fee">
                <option value="" selected disabled>Fee</option>
                <?php for($i = 10; $i <= 200; $i += 5): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
        </div>
        
        <div class="wizard-form-group" style="flex: 1;">
            <label class="subject-label">Max Fee</label>
            <select class="wizard-form-control wizard-select-control" name="max_fee" id="max-fee">
                <option value="" selected disabled>Fee</option>
                <?php for($i = 20; $i <= 300; $i += 5): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
        </div>
    </div>
    
    <!-- Fee Details -->
    <div class="wizard-form-group full-width">
        <label class="subject-label">Fee Details</label>
        <div class="custom-select-wrapper">
            <input type="text" class="wizard-form-control" name="fee_details" id="fee-details" placeholder="Detail">
            <div class="dropdown-icon"><i class="fas fa-chevron-down"></i></div>
        </div>
    </div>
    
    <!-- Experience Fields -->
    <div class="wizard-form-group full-width">
        <label class="subject-label">Total Experience</label>
        <select class="wizard-form-control wizard-select-control" name="total_experience" id="total-experience">
            <option value="" selected disabled>Year</option>
            <?php for($i = 1; $i <= 30; $i++): ?>
                <option value="<?php echo $i; ?>"><?php echo $i . ' ' . ($i == 1 ? 'Year' : 'Years'); ?></option>
            <?php endfor; ?>
        </select>
    </div>
    
    <div class="wizard-form-group full-width">
        <label class="subject-label">Teaching Experience</label>
        <select class="wizard-form-control wizard-select-control" name="teaching_experience" id="teaching-experience">
            <option value="" selected disabled>Year</option>
            <?php for($i = 1; $i <= 30; $i++): ?>
                <option value="<?php echo $i; ?>"><?php echo $i . ' ' . ($i == 1 ? 'Year' : 'Years'); ?></option>
            <?php endfor; ?>
        </select>
    </div>
    
    <div class="wizard-form-group full-width">
        <label class="subject-label">Online Teaching Experience</label>
        <select class="wizard-form-control wizard-select-control" name="online_teaching_experience" id="online-teaching-experience">
            <option value="" selected disabled>Year</option>
            <?php for($i = 1; $i <= 30; $i++): ?>
                <option value="<?php echo $i; ?>"><?php echo $i . ' ' . ($i == 1 ? 'Year' : 'Years'); ?></option>
            <?php endfor; ?>
        </select>
    </div>
    
    <!-- Yes/No Questions -->
    <div class="wizard-form-group full-width">
        <label class="subject-label">Are You Willing to travel to Student?</label>
        <div class="radio-options">
            <div class="radio-option">
                <input type="radio" id="travel-yes" name="willing_to_travel" value="yes">
                <label for="travel-yes">Yes</label>
            </div>
            <div class="radio-option">
                <input type="radio" id="travel-no" name="willing_to_travel" value="no">
                <label for="travel-no">No</label>
            </div>
        </div>
    </div>
    
    <div class="wizard-form-group full-width">
        <label class="subject-label">Available for online?</label>
        <div class="radio-options">
            <div class="radio-option">
                <input type="radio" id="online-yes" name="available_online" value="yes">
                <label for="online-yes">Yes</label>
            </div>
            <div class="radio-option">
                <input type="radio" id="online-no" name="available_online" value="no">
                <label for="online-no">No</label>
            </div>
        </div>
    </div>
    
    <div class="wizard-form-group full-width">
        <label class="subject-label">Do you have digital pen?</label>
        <div class="radio-options">
            <div class="radio-option">
                <input type="radio" id="digital-pen-yes" name="have_digital_pen" value="yes">
                <label for="digital-pen-yes">Yes</label>
            </div>
            <div class="radio-option">
                <input type="radio" id="digital-pen-no" name="have_digital_pen" value="no">
                <label for="digital-pen-no">No</label>
            </div>
        </div>
    </div>
    
    <div class="wizard-form-group full-width">
        <label class="subject-label">Do you help with homework or assignment?</label>
        <div class="radio-options">
            <div class="radio-option">
                <input type="radio" id="homework-yes" name="help_with_homework" value="yes">
                <label for="homework-yes">Yes</label>
            </div>
            <div class="radio-option">
                <input type="radio" id="homework-no" name="help_with_homework" value="no">
                <label for="homework-no">No</label>
            </div>
        </div>
    </div>
    
    <div class="wizard-form-group full-width">
        <label class="subject-label">Are you current working at any school at full time?</label>
        <div class="radio-options">
            <div class="radio-option">
                <input type="radio" id="school-yes" name="working_at_school" value="yes">
                <label for="school-yes">Yes</label>
            </div>
            <div class="radio-option">
                <input type="radio" id="school-no" name="working_at_school" value="no">
                <label for="school-no">No</label>
            </div>
        </div>
    </div>
    
    <!-- Additional Dropdowns -->
    <div class="wizard-form-group full-width">
        <label class="subject-label">Opportunity are you interested</label>
        <select class="wizard-form-control wizard-select-control" name="interested_opportunity" id="interested-opportunity">
            <option value="" selected disabled>Select</option>
            <option value="full_time">Full Time</option>
            <option value="part_time">Part Time</option>
            <option value="freelance">Freelance</option>
            <option value="contract">Contract</option>
            <option value="all">All Opportunities</option>
        </select>
    </div>
    
    <div class="wizard-form-group full-width">
        <label class="subject-label">Communication language</label>
        <select class="wizard-form-control wizard-select-control" name="communication_language" id="communication-language">
            <option value="" selected disabled>Select</option>
            <option value="english">English</option>
            <option value="spanish">Spanish</option>
            <option value="french">French</option>
            <option value="german">German</option>
            <option value="chinese">Chinese</option>
            <option value="arabic">Arabic</option>
            <option value="hindi">Hindi</option>
            <option value="other">Other</option>
        </select>
    </div>
</div>

<!-- Form Actions -->
<div class="wizard-form-actions">
    <button type="button" class="btn-save" id="save-teaching">Save</button>
    <button type="button" class="btn-next" id="next-step" data-next-step="description">Next</button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load saved data from session if available
    <?php if(isset($_SESSION['wizard_data']['teaching-details'])): ?>
    const savedData = <?php echo json_encode($_SESSION['wizard_data']['teaching-details']); ?>;
    
    // Populate form fields with saved data
    if (savedData.charge_type) {
        document.getElementById('charge-type').value = savedData.charge_type;
    }
    
    if (savedData.min_fee) {
        document.getElementById('min-fee').value = savedData.min_fee;
    }
    
    if (savedData.max_fee) {
        document.getElementById('max-fee').value = savedData.max_fee;
    }
    
    if (savedData.fee_details) {
        document.getElementById('fee-details').value = savedData.fee_details;
    }
    
    if (savedData.total_experience) {
        document.getElementById('total-experience').value = savedData.total_experience;
    }
    
    if (savedData.teaching_experience) {
        document.getElementById('teaching-experience').value = savedData.teaching_experience;
    }
    
    if (savedData.online_teaching_experience) {
        document.getElementById('online-teaching-experience').value = savedData.online_teaching_experience;
    }
    
    // Set radio buttons
    if (savedData.willing_to_travel) {
        document.querySelector(`input[name="willing_to_travel"][value="${savedData.willing_to_travel}"]`).checked = true;
    }
    
    if (savedData.available_online) {
        document.querySelector(`input[name="available_online"][value="${savedData.available_online}"]`).checked = true;
    }
    
    if (savedData.have_digital_pen) {
        document.querySelector(`input[name="have_digital_pen"][value="${savedData.have_digital_pen}"]`).checked = true;
    }
    
    if (savedData.help_with_homework) {
        document.querySelector(`input[name="help_with_homework"][value="${savedData.help_with_homework}"]`).checked = true;
    }
    
    if (savedData.working_at_school) {
        document.querySelector(`input[name="working_at_school"][value="${savedData.working_at_school}"]`).checked = true;
    }
    
    if (savedData.interested_opportunity) {
        document.getElementById('interested-opportunity').value = savedData.interested_opportunity;
    }
    
    if (savedData.communication_language) {
        document.getElementById('communication-language').value = savedData.communication_language;
    }
    <?php endif; ?>
    
    // Next button functionality
    const nextButton = document.getElementById('next-step');
    if (nextButton) {
        nextButton.addEventListener('click', function() {
            saveData();
            const nextStep = this.getAttribute('data-next-step');
            if (nextStep) {
                window.location.href = 'teacher-profile-wizard.php?step=' + nextStep;
            }
        });
    }
    
    // Save button functionality
    const saveButton = document.getElementById('save-teaching');
    if (saveButton) {
        saveButton.addEventListener('click', function() {
            saveData(true);
        });
    }
    
    // Function to save form data
    function saveData(showAlert = false) {
        const formData = {
            charge_type: document.getElementById('charge-type').value,
            min_fee: document.getElementById('min-fee').value,
            max_fee: document.getElementById('max-fee').value,
            fee_details: document.getElementById('fee-details').value,
            total_experience: document.getElementById('total-experience').value,
            teaching_experience: document.getElementById('teaching-experience').value,
            online_teaching_experience: document.getElementById('online-teaching-experience').value,
            willing_to_travel: document.querySelector('input[name="willing_to_travel"]:checked')?.value || '',
            available_online: document.querySelector('input[name="available_online"]:checked')?.value || '',
            have_digital_pen: document.querySelector('input[name="have_digital_pen"]:checked')?.value || '',
            help_with_homework: document.querySelector('input[name="help_with_homework"]:checked')?.value || '',
            working_at_school: document.querySelector('input[name="working_at_school"]:checked')?.value || '',
            interested_opportunity: document.getElementById('interested-opportunity').value,
            communication_language: document.getElementById('communication-language').value
        };
        
        // Send data to save-wizard-data.php
        fetch('includes/wizard-steps/save-wizard-data.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                step: 'teaching-details',
                data: formData
            })
        })
        .then(response => response.json())
        .then(data => {
            if (showAlert) {
                alert('Teaching details saved successfully!');
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