<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Store the current step in session
$_SESSION['current_wizard_step'] = 'education-experience';
?>

<h2 class="wizard-section-title">Education / Experience</h2>

<div class="education-form-container">
    <!-- Education entries container -->
    <div id="education-entries">
        <!-- First education entry (default) -->
        <div class="education-entry">
            <!-- Institute Name with City -->
            <div class="wizard-form-group full-width">
                <label class="subject-label">Institute Name with City</label>
                <div class="custom-select-wrapper">
                    <input type="text" class="wizard-form-control" id="institute-name" name="institute_name" placeholder="Enter Name" value="<?php echo isset($_SESSION['wizard_data']['education-experience']['institute_name']) ? $_SESSION['wizard_data']['education-experience']['institute_name'] : ''; ?>">
                    <div class="dropdown-icon"><i class="fas fa-chevron-down"></i></div>
                </div>
            </div>
            
            <!-- Degree Type and Name (side by side) -->
            <div class="form-row">
                <div class="wizard-form-group half-width">
                    <label class="subject-label">Degree Type</label>
                    <select class="wizard-form-control wizard-select-control" id="degree-type" name="degree_type">
                        <option value="" selected disabled>-Degree Type-</option>
                        <option value="bachelors" <?php echo (isset($_SESSION['wizard_data']['education-experience']['degree_type']) && $_SESSION['wizard_data']['education-experience']['degree_type'] == 'bachelors') ? 'selected' : ''; ?>>Bachelor's</option>
                        <option value="masters" <?php echo (isset($_SESSION['wizard_data']['education-experience']['degree_type']) && $_SESSION['wizard_data']['education-experience']['degree_type'] == 'masters') ? 'selected' : ''; ?>>Master's</option>
                        <option value="phd" <?php echo (isset($_SESSION['wizard_data']['education-experience']['degree_type']) && $_SESSION['wizard_data']['education-experience']['degree_type'] == 'phd') ? 'selected' : ''; ?>>PhD</option>
                        <option value="diploma" <?php echo (isset($_SESSION['wizard_data']['education-experience']['degree_type']) && $_SESSION['wizard_data']['education-experience']['degree_type'] == 'diploma') ? 'selected' : ''; ?>>Diploma</option>
                        <option value="certificate" <?php echo (isset($_SESSION['wizard_data']['education-experience']['degree_type']) && $_SESSION['wizard_data']['education-experience']['degree_type'] == 'certificate') ? 'selected' : ''; ?>>Certificate</option>
                    </select>
                </div>
                
                <div class="wizard-form-group half-width">
                    <label class="subject-label">Degree Name</label>
                    <select class="wizard-form-control wizard-select-control" id="degree-name" name="degree_name">
                        <option value="" selected disabled>-Name-</option>
                        <option value="computer_science" <?php echo (isset($_SESSION['wizard_data']['education-experience']['degree_name']) && $_SESSION['wizard_data']['education-experience']['degree_name'] == 'computer_science') ? 'selected' : ''; ?>>Computer Science</option>
                        <option value="business" <?php echo (isset($_SESSION['wizard_data']['education-experience']['degree_name']) && $_SESSION['wizard_data']['education-experience']['degree_name'] == 'business') ? 'selected' : ''; ?>>Business Administration</option>
                        <option value="engineering" <?php echo (isset($_SESSION['wizard_data']['education-experience']['degree_name']) && $_SESSION['wizard_data']['education-experience']['degree_name'] == 'engineering') ? 'selected' : ''; ?>>Engineering</option>
                        <option value="education" <?php echo (isset($_SESSION['wizard_data']['education-experience']['degree_name']) && $_SESSION['wizard_data']['education-experience']['degree_name'] == 'education') ? 'selected' : ''; ?>>Education</option>
                        <option value="arts" <?php echo (isset($_SESSION['wizard_data']['education-experience']['degree_name']) && $_SESSION['wizard_data']['education-experience']['degree_name'] == 'arts') ? 'selected' : ''; ?>>Arts</option>
                    </select>
                </div>
            </div>
            
            <!-- Start Date and End Date (side by side) -->
            <div class="form-row">
                <div class="wizard-form-group half-width">
                    <label class="subject-label">Start Date</label>
                    <div class="custom-select-wrapper">
                        <input type="text" class="wizard-form-control date-picker" id="start-date" name="start_date" placeholder="MM/YY/DD" value="<?php echo isset($_SESSION['wizard_data']['education-experience']['start_date']) ? $_SESSION['wizard_data']['education-experience']['start_date'] : ''; ?>">
                        <div class="dropdown-icon"><i class="fas fa-chevron-down"></i></div>
                    </div>
                </div>
                
                <div class="wizard-form-group half-width">
                    <label class="subject-label">End Date</label>
                    <div class="custom-select-wrapper">
                        <input type="text" class="wizard-form-control date-picker" id="end-date" name="end_date" placeholder="MM/YY/DD" value="<?php echo isset($_SESSION['wizard_data']['education-experience']['end_date']) ? $_SESSION['wizard_data']['education-experience']['end_date'] : ''; ?>">
                        <div class="dropdown-icon"><i class="fas fa-chevron-down"></i></div>
                    </div>
                </div>
            </div>
            
            <!-- Association -->
            <div class="wizard-form-group full-width">
                <label class="subject-label">Association</label>
                <select class="wizard-form-control wizard-select-control" id="association" name="association">
                    <option value="" selected disabled>Select</option>
                    <option value="student" <?php echo (isset($_SESSION['wizard_data']['education-experience']['association']) && $_SESSION['wizard_data']['education-experience']['association'] == 'student') ? 'selected' : ''; ?>>Student</option>
                    <option value="alumni" <?php echo (isset($_SESSION['wizard_data']['education-experience']['association']) && $_SESSION['wizard_data']['education-experience']['association'] == 'alumni') ? 'selected' : ''; ?>>Alumni</option>
                    <option value="faculty" <?php echo (isset($_SESSION['wizard_data']['education-experience']['association']) && $_SESSION['wizard_data']['education-experience']['association'] == 'faculty') ? 'selected' : ''; ?>>Faculty</option>
                    <option value="staff" <?php echo (isset($_SESSION['wizard_data']['education-experience']['association']) && $_SESSION['wizard_data']['education-experience']['association'] == 'staff') ? 'selected' : ''; ?>>Staff</option>
                </select>
            </div>
            
            <!-- Specialization (optional) -->
            <div class="wizard-form-group full-width">
                <label class="subject-label">Specialization<span class="optional-label">(optional)</span></label>
                <select class="wizard-form-control wizard-select-control" id="specialization" name="specialization">
                    <option value="" selected disabled>Select</option>
                    <option value="ai" <?php echo (isset($_SESSION['wizard_data']['education-experience']['specialization']) && $_SESSION['wizard_data']['education-experience']['specialization'] == 'ai') ? 'selected' : ''; ?>>Artificial Intelligence</option>
                    <option value="data_science" <?php echo (isset($_SESSION['wizard_data']['education-experience']['specialization']) && $_SESSION['wizard_data']['education-experience']['specialization'] == 'data_science') ? 'selected' : ''; ?>>Data Science</option>
                    <option value="software_dev" <?php echo (isset($_SESSION['wizard_data']['education-experience']['specialization']) && $_SESSION['wizard_data']['education-experience']['specialization'] == 'software_dev') ? 'selected' : ''; ?>>Software Development</option>
                    <option value="finance" <?php echo (isset($_SESSION['wizard_data']['education-experience']['specialization']) && $_SESSION['wizard_data']['education-experience']['specialization'] == 'finance') ? 'selected' : ''; ?>>Finance</option>
                    <option value="marketing" <?php echo (isset($_SESSION['wizard_data']['education-experience']['specialization']) && $_SESSION['wizard_data']['education-experience']['specialization'] == 'marketing') ? 'selected' : ''; ?>>Marketing</option>
                </select>
            </div>
        </div>
    </div>
    
    <!-- Container for additional education entries -->
    <div id="additional-education-entries">
        <?php
        if (isset($_SESSION['wizard_data']['education-experience']['additional_education']) && is_array($_SESSION['wizard_data']['education-experience']['additional_education'])) {
            foreach ($_SESSION['wizard_data']['education-experience']['additional_education'] as $index => $education) {
                ?>
                <div class="education-entry additional-entry" data-index="<?php echo $index + 1; ?>">
                    <!-- Institute Name with City -->
                    <div class="wizard-form-group full-width">
                        <label class="subject-label">Institute Name with City</label>
                        <div class="custom-select-wrapper">
                            <input type="text" class="wizard-form-control" name="additional_institute_name_<?php echo $index + 1; ?>" placeholder="Enter Name" value="<?php echo $education['institute_name']; ?>">
                            <div class="dropdown-icon"><i class="fas fa-chevron-down"></i></div>
                        </div>
                    </div>
                    
                    <!-- Degree Type and Name (side by side) -->
                    <div class="form-row">
                        <div class="wizard-form-group half-width">
                            <label class="subject-label">Degree Type</label>
                            <select class="wizard-form-control wizard-select-control" name="additional_degree_type_<?php echo $index + 1; ?>">
                                <option value="" disabled>-Degree Type-</option>
                                <option value="bachelors" <?php echo ($education['degree_type'] == 'bachelors') ? 'selected' : ''; ?>>Bachelor's</option>
                                <option value="masters" <?php echo ($education['degree_type'] == 'masters') ? 'selected' : ''; ?>>Master's</option>
                                <option value="phd" <?php echo ($education['degree_type'] == 'phd') ? 'selected' : ''; ?>>PhD</option>
                                <option value="diploma" <?php echo ($education['degree_type'] == 'diploma') ? 'selected' : ''; ?>>Diploma</option>
                                <option value="certificate" <?php echo ($education['degree_type'] == 'certificate') ? 'selected' : ''; ?>>Certificate</option>
                            </select>
                        </div>
                        
                        <div class="wizard-form-group half-width">
                            <label class="subject-label">Degree Name</label>
                            <select class="wizard-form-control wizard-select-control" name="additional_degree_name_<?php echo $index + 1; ?>">
                                <option value="" disabled>-Name-</option>
                                <option value="computer_science" <?php echo ($education['degree_name'] == 'computer_science') ? 'selected' : ''; ?>>Computer Science</option>
                                <option value="business" <?php echo ($education['degree_name'] == 'business') ? 'selected' : ''; ?>>Business Administration</option>
                                <option value="engineering" <?php echo ($education['degree_name'] == 'engineering') ? 'selected' : ''; ?>>Engineering</option>
                                <option value="education" <?php echo ($education['degree_name'] == 'education') ? 'selected' : ''; ?>>Education</option>
                                <option value="arts" <?php echo ($education['degree_name'] == 'arts') ? 'selected' : ''; ?>>Arts</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Start Date and End Date (side by side) -->
                    <div class="form-row">
                        <div class="wizard-form-group half-width">
                            <label class="subject-label">Start Date</label>
                            <div class="custom-select-wrapper">
                                <input type="text" class="wizard-form-control date-picker" name="additional_start_date_<?php echo $index + 1; ?>" placeholder="MM/YY/DD" value="<?php echo $education['start_date']; ?>">
                                <div class="dropdown-icon"><i class="fas fa-chevron-down"></i></div>
                            </div>
                        </div>
                        
                        <div class="wizard-form-group half-width">
                            <label class="subject-label">End Date</label>
                            <div class="custom-select-wrapper">
                                <input type="text" class="wizard-form-control date-picker" name="additional_end_date_<?php echo $index + 1; ?>" placeholder="MM/YY/DD" value="<?php echo $education['end_date']; ?>">
                                <div class="dropdown-icon"><i class="fas fa-chevron-down"></i></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Association -->
                    <div class="wizard-form-group full-width">
                        <label class="subject-label">Association</label>
                        <select class="wizard-form-control wizard-select-control" name="additional_association_<?php echo $index + 1; ?>">
                            <option value="" disabled>Select</option>
                            <option value="student" <?php echo ($education['association'] == 'student') ? 'selected' : ''; ?>>Student</option>
                            <option value="alumni" <?php echo ($education['association'] == 'alumni') ? 'selected' : ''; ?>>Alumni</option>
                            <option value="faculty" <?php echo ($education['association'] == 'faculty') ? 'selected' : ''; ?>>Faculty</option>
                            <option value="staff" <?php echo ($education['association'] == 'staff') ? 'selected' : ''; ?>>Staff</option>
                        </select>
                    </div>
                    
                    <!-- Specialization (optional) -->
                    <div class="wizard-form-group full-width">
                        <label class="subject-label">Specialization<span class="optional-label">(optional)</span></label>
                        <select class="wizard-form-control wizard-select-control" name="additional_specialization_<?php echo $index + 1; ?>">
                            <option value="" disabled>Select</option>
                            <option value="ai" <?php echo ($education['specialization'] == 'ai') ? 'selected' : ''; ?>>Artificial Intelligence</option>
                            <option value="data_science" <?php echo ($education['specialization'] == 'data_science') ? 'selected' : ''; ?>>Data Science</option>
                            <option value="software_dev" <?php echo ($education['specialization'] == 'software_dev') ? 'selected' : ''; ?>>Software Development</option>
                            <option value="finance" <?php echo ($education['specialization'] == 'finance') ? 'selected' : ''; ?>>Finance</option>
                            <option value="marketing" <?php echo ($education['specialization'] == 'marketing') ? 'selected' : ''; ?>>Marketing</option>
                        </select>
                    </div>
                    
                    <button type="button" class="btn-remove-education">
                        <i class="fas fa-times"></i> Remove
                    </button>
                </div>
                <?php
            }
        }
        ?>
    </div>
    
    <!-- Add Further Subject Button -->
    <button type="button" class="btn-add-subject" id="add-education">
        <span>Add Further Subject</span>
        <i class="fas fa-plus"></i>
    </button>
</div>

<!-- Form Actions -->
<div class="wizard-form-actions">
    <button type="button" class="btn-save" id="save-education">Save</button>
    <button type="button" class="btn-next" id="next-step" data-next-step="professional-experience">Next</button>
</div>

<style>
.education-form-container {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.education-entry {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.additional-entry {
    border-top: 1px solid #e9ecef;
    padding-top: 25px;
    margin-top: 10px;
    position: relative;
}

.form-row {
    display: flex;
    gap: 20px;
}

.full-width {
    width: 100%;
}

.half-width {
    flex: 1;
}

.custom-select-wrapper {
    position: relative;
}

.dropdown-icon {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    pointer-events: none;
}

.optional-label {
    color: #6c757d;
    font-weight: normal;
    font-size: 14px;
    margin-left: 5px;
}

.btn-remove-education {
    background-color: #f8f9fa;
    color: #dc3545;
    border: 1px solid #dc3545;
    border-radius: 8px;
    padding: 8px 15px;
    font-weight: 500;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    align-self: flex-start;
    margin-top: 10px;
}

.btn-remove-education:hover {
    background-color: #feecef;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize date pickers
    initializeDatePickers();
    
    // Add Education Entry Functionality
    const addEducationBtn = document.getElementById('add-education');
    const additionalEducationContainer = document.getElementById('additional-education-entries');
    
    if (addEducationBtn && additionalEducationContainer) {
        // Get the highest existing index
        let educationCount = 0;
        const existingEntries = document.querySelectorAll('.additional-entry');
        existingEntries.forEach(entry => {
            const index = parseInt(entry.getAttribute('data-index'), 10);
            if (index > educationCount) {
                educationCount = index;
            }
        });
        
        addEducationBtn.addEventListener('click', function() {
            // Increment education count for the new entry
            educationCount++;
            
            // Create a new education entry
            const newEducationEntry = document.createElement('div');
            newEducationEntry.className = 'education-entry additional-entry';
            newEducationEntry.setAttribute('data-index', educationCount);
            newEducationEntry.innerHTML = `
                <!-- Institute Name with City -->
                <div class="wizard-form-group full-width">
                    <label class="subject-label">Institute Name with City</label>
                    <div class="custom-select-wrapper">
                        <input type="text" class="wizard-form-control" name="additional_institute_name_${educationCount}" placeholder="Enter Name">
                        <div class="dropdown-icon"><i class="fas fa-chevron-down"></i></div>
                    </div>
                </div>
                
                <!-- Degree Type and Name (side by side) -->
                <div class="form-row">
                    <div class="wizard-form-group half-width">
                        <label class="subject-label">Degree Type</label>
                        <select class="wizard-form-control wizard-select-control" name="additional_degree_type_${educationCount}">
                            <option value="" selected disabled>-Degree Type-</option>
                            <option value="bachelors">Bachelor's</option>
                            <option value="masters">Master's</option>
                            <option value="phd">PhD</option>
                            <option value="diploma">Diploma</option>
                            <option value="certificate">Certificate</option>
                        </select>
                    </div>
                    
                    <div class="wizard-form-group half-width">
                        <label class="subject-label">Degree Name</label>
                        <select class="wizard-form-control wizard-select-control" name="additional_degree_name_${educationCount}">
                            <option value="" selected disabled>-Name-</option>
                            <option value="computer_science">Computer Science</option>
                            <option value="business">Business Administration</option>
                            <option value="engineering">Engineering</option>
                            <option value="education">Education</option>
                            <option value="arts">Arts</option>
                        </select>
                    </div>
                </div>
                
                <!-- Start Date and End Date (side by side) -->
                <div class="form-row">
                    <div class="wizard-form-group half-width">
                        <label class="subject-label">Start Date</label>
                        <div class="custom-select-wrapper">
                            <input type="text" class="wizard-form-control date-picker" name="additional_start_date_${educationCount}" placeholder="MM/YY/DD">
                            <div class="dropdown-icon"><i class="fas fa-chevron-down"></i></div>
                        </div>
                    </div>
                    
                    <div class="wizard-form-group half-width">
                        <label class="subject-label">End Date</label>
                        <div class="custom-select-wrapper">
                            <input type="text" class="wizard-form-control date-picker" name="additional_end_date_${educationCount}" placeholder="MM/YY/DD">
                            <div class="dropdown-icon"><i class="fas fa-chevron-down"></i></div>
                        </div>
                    </div>
                </div>
                
                <!-- Association -->
                <div class="wizard-form-group full-width">
                    <label class="subject-label">Association</label>
                    <select class="wizard-form-control wizard-select-control" name="additional_association_${educationCount}">
                        <option value="" selected disabled>Select</option>
                        <option value="student">Student</option>
                        <option value="alumni">Alumni</option>
                        <option value="faculty">Faculty</option>
                        <option value="staff">Staff</option>
                    </select>
                </div>
                
                <!-- Specialization (optional) -->
                <div class="wizard-form-group full-width">
                    <label class="subject-label">Specialization<span class="optional-label">(optional)</span></label>
                    <select class="wizard-form-control wizard-select-control" name="additional_specialization_${educationCount}">
                        <option value="" selected disabled>Select</option>
                        <option value="ai">Artificial Intelligence</option>
                        <option value="data_science">Data Science</option>
                        <option value="software_dev">Software Development</option>
                        <option value="finance">Finance</option>
                        <option value="marketing">Marketing</option>
                    </select>
                </div>
                
                <button type="button" class="btn-remove-education">
                    <i class="fas fa-times"></i> Remove
                </button>
            `;
            
            // Add to container
            additionalEducationContainer.appendChild(newEducationEntry);
            
            // Initialize date pickers for new fields
            initializeDatePickers();
            
            // Add remove functionality
            const removeBtn = newEducationEntry.querySelector('.btn-remove-education');
            if (removeBtn) {
                removeBtn.addEventListener('click', function() {
                    newEducationEntry.remove();
                });
            }
        });
        
        // Add remove functionality to existing buttons
        document.querySelectorAll('.btn-remove-education').forEach(btn => {
            btn.addEventListener('click', function() {
                this.closest('.education-entry').remove();
            });
        });
    }
    
    // Date picker initialization function
    function initializeDatePickers() {
        document.querySelectorAll('.date-picker').forEach(datePicker => {
            datePicker.addEventListener('focus', function() {
                // Here you would typically initialize a date picker component
                // For simplicity, we're just using the default date input
                this.type = 'date';
            });
            
            datePicker.addEventListener('blur', function() {
                if (this.value === '') {
                    this.type = 'text';
                }
            });
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
    
    // Save button functionality
    const saveButton = document.getElementById('save-education');
    if (saveButton) {
        saveButton.addEventListener('click', function() {
            saveFormData();
            // Show a success message
            alert('Your education data has been saved!');
        });
    }
    
    // Function to save form data
    function saveFormData() {
        const form = document.querySelector('form');
        const formData = new FormData(form);
        
        // Add additional education entries
        const additionalEducation = [];
        document.querySelectorAll('.additional-entry').forEach(entry => {
            const index = entry.getAttribute('data-index');
            
            const educationData = {
                institute_name: entry.querySelector(`[name="additional_institute_name_${index}"]`).value,
                degree_type: entry.querySelector(`[name="additional_degree_type_${index}"]`).value,
                degree_name: entry.querySelector(`[name="additional_degree_name_${index}"]`).value,
                start_date: entry.querySelector(`[name="additional_start_date_${index}"]`).value,
                end_date: entry.querySelector(`[name="additional_end_date_${index}"]`).value,
                association: entry.querySelector(`[name="additional_association_${index}"]`).value,
                specialization: entry.querySelector(`[name="additional_specialization_${index}"]`).value
            };
            
            additionalEducation.push(educationData);
        });
        
        // Add the additional education entries to the form data
        formData.append('additional_education', JSON.stringify(additionalEducation));
        
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