<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Store the current step in session
$_SESSION['current_wizard_step'] = 'professional-experience';
?>

<h2 class="wizard-section-title">Professional Experience</h2>

<div class="professional-form-container">
    <!-- Professional Experience entries container -->
    <div id="experience-entries">
        <!-- First experience entry (default) -->
        <div class="experience-entry">
            <!-- Organization With City -->
            <div class="wizard-form-group full-width">
                <label class="subject-label">Organization With City</label>
                <div class="custom-select-wrapper">
                    <input type="text" class="wizard-form-control" id="organization-name" name="organization_name" placeholder="Enter Name" value="<?php echo isset($_SESSION['wizard_data']['professional-experience']['organization_name']) ? $_SESSION['wizard_data']['professional-experience']['organization_name'] : ''; ?>">
                    <div class="dropdown-icon"><i class="fas fa-chevron-down"></i></div>
                </div>
            </div>
            
            <!-- Designation -->
            <div class="wizard-form-group full-width">
                <label class="subject-label">Designation</label>
                <div class="custom-select-wrapper">
                    <input type="text" class="wizard-form-control" id="designation" name="designation" placeholder="Enter Name" value="<?php echo isset($_SESSION['wizard_data']['professional-experience']['designation']) ? $_SESSION['wizard_data']['professional-experience']['designation'] : ''; ?>">
                    <div class="dropdown-icon"><i class="fas fa-chevron-down"></i></div>
                </div>
            </div>
            
            <!-- Start Date and End Date (side by side) -->
            <div class="form-row">
                <div class="wizard-form-group half-width">
                    <label class="subject-label">Start Date</label>
                    <div class="custom-select-wrapper">
                        <input type="text" class="wizard-form-control date-picker" id="start-date" name="start_date" placeholder="MM/YY/DD" value="<?php echo isset($_SESSION['wizard_data']['professional-experience']['start_date']) ? $_SESSION['wizard_data']['professional-experience']['start_date'] : ''; ?>">
                        <div class="dropdown-icon"><i class="fas fa-chevron-down"></i></div>
                    </div>
                </div>
                
                <div class="wizard-form-group half-width">
                    <label class="subject-label">End Date</label>
                    <div class="custom-select-wrapper">
                        <input type="text" class="wizard-form-control date-picker" id="end-date" name="end_date" placeholder="MM/YY/DD" value="<?php echo isset($_SESSION['wizard_data']['professional-experience']['end_date']) ? $_SESSION['wizard_data']['professional-experience']['end_date'] : ''; ?>">
                        <div class="dropdown-icon"><i class="fas fa-chevron-down"></i></div>
                    </div>
                </div>
            </div>
            
            <!-- Association -->
            <div class="wizard-form-group full-width">
                <label class="subject-label">Association</label>
                <select class="wizard-form-control wizard-select-control" id="association" name="association">
                    <option value="" selected disabled>Select</option>
                    <option value="full_time" <?php echo (isset($_SESSION['wizard_data']['professional-experience']['association']) && $_SESSION['wizard_data']['professional-experience']['association'] == 'full_time') ? 'selected' : ''; ?>>Full Time</option>
                    <option value="part_time" <?php echo (isset($_SESSION['wizard_data']['professional-experience']['association']) && $_SESSION['wizard_data']['professional-experience']['association'] == 'part_time') ? 'selected' : ''; ?>>Part Time</option>
                    <option value="contract" <?php echo (isset($_SESSION['wizard_data']['professional-experience']['association']) && $_SESSION['wizard_data']['professional-experience']['association'] == 'contract') ? 'selected' : ''; ?>>Contract</option>
                    <option value="freelance" <?php echo (isset($_SESSION['wizard_data']['professional-experience']['association']) && $_SESSION['wizard_data']['professional-experience']['association'] == 'freelance') ? 'selected' : ''; ?>>Freelance</option>
                </select>
            </div>
            
            <!-- Role and Responsibility -->
            <div class="wizard-form-group full-width">
                <label class="subject-label">Your Role and responsibility at this job</label>
                <textarea class="wizard-form-control" id="role-responsibility" name="role_responsibility" placeholder="Describe" rows="4"><?php echo isset($_SESSION['wizard_data']['professional-experience']['role_responsibility']) ? $_SESSION['wizard_data']['professional-experience']['role_responsibility'] : ''; ?></textarea>
            </div>
        </div>
    </div>
    
    <!-- Container for additional experience entries -->
    <div id="additional-experience-entries">
        <?php
        if (isset($_SESSION['wizard_data']['professional-experience']['additional_experience']) && is_array($_SESSION['wizard_data']['professional-experience']['additional_experience'])) {
            foreach ($_SESSION['wizard_data']['professional-experience']['additional_experience'] as $index => $experience) {
                ?>
                <div class="experience-entry additional-entry" data-index="<?php echo $index + 1; ?>">
                    <!-- Additional experience fields here -->
                    <!-- Similar structure as above but with unique IDs and names -->
                    <button type="button" class="btn-remove-experience">
                        <i class="fas fa-times"></i> Remove
                    </button>
                </div>
                <?php
            }
        }
        ?>
    </div>
    
    <!-- Add Further Experience Button -->
    <button type="button" class="btn-add-experience" id="add-experience">
        <span>Add Further Experience</span>
        <i class="fas fa-plus"></i>
    </button>
</div>

<!-- Form Actions -->
<div class="wizard-form-actions">
    <button type="button" class="btn-save" id="save-experience">Save</button>
    <button type="button" class="btn-next" id="next-step" data-next-step="teaching-details">Next</button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize date pickers
    initializeDatePickers();
    
    // Add Experience Entry Functionality
    const addExperienceBtn = document.getElementById('add-experience');
    const additionalExperienceContainer = document.getElementById('additional-experience-entries');
    
    if (addExperienceBtn && additionalExperienceContainer) {
        let experienceCount = document.querySelectorAll('.additional-entry').length;
        
        addExperienceBtn.addEventListener('click', function() {
            experienceCount++;
            
            const newExperienceEntry = document.createElement('div');
            newExperienceEntry.className = 'experience-entry additional-entry';
            newExperienceEntry.setAttribute('data-index', experienceCount);
            
            // Create the new experience entry HTML
            newExperienceEntry.innerHTML = `
                <!-- Organization With City -->
                <div class="wizard-form-group full-width">
                    <label class="subject-label">Organization With City</label>
                    <div class="custom-select-wrapper">
                        <input type="text" class="wizard-form-control" name="additional_organization_${experienceCount}" placeholder="Enter Name">
                        <div class="dropdown-icon"><i class="fas fa-chevron-down"></i></div>
                    </div>
                </div>
                
                <!-- Designation -->
                <div class="wizard-form-group full-width">
                    <label class="subject-label">Designation</label>
                    <div class="custom-select-wrapper">
                        <input type="text" class="wizard-form-control" name="additional_designation_${experienceCount}" placeholder="Enter Name">
                        <div class="dropdown-icon"><i class="fas fa-chevron-down"></i></div>
                    </div>
                </div>
                
                <!-- Start Date and End Date -->
                <div class="form-row">
                    <div class="wizard-form-group half-width">
                        <label class="subject-label">Start Date</label>
                        <div class="custom-select-wrapper">
                            <input type="text" class="wizard-form-control date-picker" name="additional_start_date_${experienceCount}" placeholder="MM/YY/DD">
                            <div class="dropdown-icon"><i class="fas fa-chevron-down"></i></div>
                        </div>
                    </div>
                    
                    <div class="wizard-form-group half-width">
                        <label class="subject-label">End Date</label>
                        <div class="custom-select-wrapper">
                            <input type="text" class="wizard-form-control date-picker" name="additional_end_date_${experienceCount}" placeholder="MM/YY/DD">
                            <div class="dropdown-icon"><i class="fas fa-chevron-down"></i></div>
                        </div>
                    </div>
                </div>
                
                <!-- Association -->
                <div class="wizard-form-group full-width">
                    <label class="subject-label">Association</label>
                    <select class="wizard-form-control wizard-select-control" name="additional_association_${experienceCount}">
                        <option value="" selected disabled>Select</option>
                        <option value="full_time">Full Time</option>
                        <option value="part_time">Part Time</option>
                        <option value="contract">Contract</option>
                        <option value="freelance">Freelance</option>
                    </select>
                </div>
                
                <!-- Role and Responsibility -->
                <div class="wizard-form-group full-width">
                    <label class="subject-label">Your Role and responsibility at this job</label>
                    <textarea class="wizard-form-control" name="additional_role_responsibility_${experienceCount}" placeholder="Describe" rows="4"></textarea>
                </div>
                
                <button type="button" class="btn-remove-experience">
                    <i class="fas fa-times"></i> Remove
                </button>
            `;
            
            // Add to container
            additionalExperienceContainer.appendChild(newExperienceEntry);
            
            // Initialize date pickers for new fields
            initializeDatePickers();
            
            // Add remove functionality
            const removeBtn = newExperienceEntry.querySelector('.btn-remove-experience');
            if (removeBtn) {
                removeBtn.addEventListener('click', function() {
                    newExperienceEntry.remove();
                });
            }
        });
        
        // Add remove functionality to existing buttons
        document.querySelectorAll('.btn-remove-experience').forEach(btn => {
            btn.addEventListener('click', function() {
                this.closest('.experience-entry').remove();
            });
        });
    }
    
    // Date picker initialization function
    function initializeDatePickers() {
        document.querySelectorAll('.date-picker').forEach(datePicker => {
            datePicker.addEventListener('focus', function() {
                this.type = 'date';
            });
            
            datePicker.addEventListener('blur', function() {
                if (this.value === '') {
                    this.type = 'text';
                }
            });
        });
    }
    
    // Save button functionality
    const saveButton = document.getElementById('save-experience');
    if (saveButton) {
        saveButton.addEventListener('click', function() {
            saveFormData();
            alert('Professional experience data saved!');
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
        
        // Add additional experience entries
        const additionalExperience = [];
        document.querySelectorAll('.additional-entry').forEach(entry => {
            const index = entry.getAttribute('data-index');
            
            const experienceData = {
                organization_name: entry.querySelector(`[name="additional_organization_${index}"]`).value,
                designation: entry.querySelector(`[name="additional_designation_${index}"]`).value,
                start_date: entry.querySelector(`[name="additional_start_date_${index}"]`).value,
                end_date: entry.querySelector(`[name="additional_end_date_${index}"]`).value,
                association: entry.querySelector(`[name="additional_association_${index}"]`).value,
                role_responsibility: entry.querySelector(`[name="additional_role_responsibility_${index}"]`).value
            };
            
            additionalExperience.push(experienceData);
        });
        
        // Add the additional experience entries to the form data
        formData.append('additional_experience', JSON.stringify(additionalExperience));
        
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