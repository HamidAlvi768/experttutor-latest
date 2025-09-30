<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Store the current step in session
$_SESSION['current_wizard_step'] = 'subject-teach';
?>

<h2 class="wizard-section-title">Subject you Teach</h2>

<!-- Subject Fields -->
<div class="subject-form-container">
    <div class="subject-form-group">
        <label for="subject" class="subject-label">Subject</label>
        <select class="wizard-form-control wizard-select-control subject-select" id="subject" name="subject">
            <option value="" selected disabled>Set Language</option>
            <option value="english" <?php echo (isset($_SESSION['wizard_data']['subject-teach']['subject']) && $_SESSION['wizard_data']['subject-teach']['subject'] == 'english') ? 'selected' : ''; ?>>English</option>
            <option value="mathematics" <?php echo (isset($_SESSION['wizard_data']['subject-teach']['subject']) && $_SESSION['wizard_data']['subject-teach']['subject'] == 'mathematics') ? 'selected' : ''; ?>>Mathematics</option>
            <option value="science" <?php echo (isset($_SESSION['wizard_data']['subject-teach']['subject']) && $_SESSION['wizard_data']['subject-teach']['subject'] == 'science') ? 'selected' : ''; ?>>Science</option>
            <option value="history" <?php echo (isset($_SESSION['wizard_data']['subject-teach']['subject']) && $_SESSION['wizard_data']['subject-teach']['subject'] == 'history') ? 'selected' : ''; ?>>History</option>
            <option value="geography" <?php echo (isset($_SESSION['wizard_data']['subject-teach']['subject']) && $_SESSION['wizard_data']['subject-teach']['subject'] == 'geography') ? 'selected' : ''; ?>>Geography</option>
            <option value="physics" <?php echo (isset($_SESSION['wizard_data']['subject-teach']['subject']) && $_SESSION['wizard_data']['subject-teach']['subject'] == 'physics') ? 'selected' : ''; ?>>Physics</option>
            <option value="chemistry" <?php echo (isset($_SESSION['wizard_data']['subject-teach']['subject']) && $_SESSION['wizard_data']['subject-teach']['subject'] == 'chemistry') ? 'selected' : ''; ?>>Chemistry</option>
            <option value="biology" <?php echo (isset($_SESSION['wizard_data']['subject-teach']['subject']) && $_SESSION['wizard_data']['subject-teach']['subject'] == 'biology') ? 'selected' : ''; ?>>Biology</option>
            <option value="computer_science" <?php echo (isset($_SESSION['wizard_data']['subject-teach']['subject']) && $_SESSION['wizard_data']['subject-teach']['subject'] == 'computer_science') ? 'selected' : ''; ?>>Computer Science</option>
            <option value="economics" <?php echo (isset($_SESSION['wizard_data']['subject-teach']['subject']) && $_SESSION['wizard_data']['subject-teach']['subject'] == 'economics') ? 'selected' : ''; ?>>Economics</option>
            <option value="business_studies" <?php echo (isset($_SESSION['wizard_data']['subject-teach']['subject']) && $_SESSION['wizard_data']['subject-teach']['subject'] == 'business_studies') ? 'selected' : ''; ?>>Business Studies</option>
            <option value="art" <?php echo (isset($_SESSION['wizard_data']['subject-teach']['subject']) && $_SESSION['wizard_data']['subject-teach']['subject'] == 'art') ? 'selected' : ''; ?>>Art</option>
            <option value="music" <?php echo (isset($_SESSION['wizard_data']['subject-teach']['subject']) && $_SESSION['wizard_data']['subject-teach']['subject'] == 'music') ? 'selected' : ''; ?>>Music</option>
            <option value="physical_education" <?php echo (isset($_SESSION['wizard_data']['subject-teach']['subject']) && $_SESSION['wizard_data']['subject-teach']['subject'] == 'physical_education') ? 'selected' : ''; ?>>Physical Education</option>
        </select>
    </div>
    
    <div class="level-form-container">
        <div class="level-form-group">
            <label for="from-level" class="subject-label">From level</label>
            <select class="wizard-form-control wizard-select-control level-select" id="from-level" name="from_level">
                <option value="" selected disabled>-Select lowest level-</option>
                <option value="beginner" <?php echo (isset($_SESSION['wizard_data']['subject-teach']['from_level']) && $_SESSION['wizard_data']['subject-teach']['from_level'] == 'beginner') ? 'selected' : ''; ?>>Beginner</option>
                <option value="elementary" <?php echo (isset($_SESSION['wizard_data']['subject-teach']['from_level']) && $_SESSION['wizard_data']['subject-teach']['from_level'] == 'elementary') ? 'selected' : ''; ?>>Elementary</option>
                <option value="intermediate" <?php echo (isset($_SESSION['wizard_data']['subject-teach']['from_level']) && $_SESSION['wizard_data']['subject-teach']['from_level'] == 'intermediate') ? 'selected' : ''; ?>>Intermediate</option>
                <option value="upper_intermediate" <?php echo (isset($_SESSION['wizard_data']['subject-teach']['from_level']) && $_SESSION['wizard_data']['subject-teach']['from_level'] == 'upper_intermediate') ? 'selected' : ''; ?>>Upper Intermediate</option>
                <option value="advanced" <?php echo (isset($_SESSION['wizard_data']['subject-teach']['from_level']) && $_SESSION['wizard_data']['subject-teach']['from_level'] == 'advanced') ? 'selected' : ''; ?>>Advanced</option>
                <option value="proficient" <?php echo (isset($_SESSION['wizard_data']['subject-teach']['from_level']) && $_SESSION['wizard_data']['subject-teach']['from_level'] == 'proficient') ? 'selected' : ''; ?>>Proficient</option>
            </select>
        </div>
        
        <div class="level-form-group">
            <label for="to-level" class="subject-label">To level</label>
            <select class="wizard-form-control wizard-select-control level-select" id="to-level" name="to_level">
                <option value="" selected disabled>-Select High level-</option>
                <option value="beginner" <?php echo (isset($_SESSION['wizard_data']['subject-teach']['to_level']) && $_SESSION['wizard_data']['subject-teach']['to_level'] == 'beginner') ? 'selected' : ''; ?>>Beginner</option>
                <option value="elementary" <?php echo (isset($_SESSION['wizard_data']['subject-teach']['to_level']) && $_SESSION['wizard_data']['subject-teach']['to_level'] == 'elementary') ? 'selected' : ''; ?>>Elementary</option>
                <option value="intermediate" <?php echo (isset($_SESSION['wizard_data']['subject-teach']['to_level']) && $_SESSION['wizard_data']['subject-teach']['to_level'] == 'intermediate') ? 'selected' : ''; ?>>Intermediate</option>
                <option value="upper_intermediate" <?php echo (isset($_SESSION['wizard_data']['subject-teach']['to_level']) && $_SESSION['wizard_data']['subject-teach']['to_level'] == 'upper_intermediate') ? 'selected' : ''; ?>>Upper Intermediate</option>
                <option value="advanced" <?php echo (isset($_SESSION['wizard_data']['subject-teach']['to_level']) && $_SESSION['wizard_data']['subject-teach']['to_level'] == 'advanced') ? 'selected' : ''; ?>>Advanced</option>
                <option value="proficient" <?php echo (isset($_SESSION['wizard_data']['subject-teach']['to_level']) && $_SESSION['wizard_data']['subject-teach']['to_level'] == 'proficient') ? 'selected' : ''; ?>>Proficient</option>
            </select>
        </div>
    </div>
    
    <button type="button" class="btn-add-subject">
        <span>Add Further Subject</span>
        <i class="fas fa-plus"></i>
    </button>
    
    <!-- Container for additional subjects -->
    <div id="additional-subjects-container">
        <?php
        if (isset($_SESSION['wizard_data']['subject-teach']['additional_subjects']) && is_array($_SESSION['wizard_data']['subject-teach']['additional_subjects'])) {
            foreach ($_SESSION['wizard_data']['subject-teach']['additional_subjects'] as $index => $subject) {
                $subjectId = "subject-" . ($index + 1);
                $fromLevelId = "from-level-" . ($index + 1);
                $toLevelId = "to-level-" . ($index + 1);
                ?>
                <div class="subject-section" data-index="<?php echo $index + 1; ?>">
                    <div class="subject-form-group">
                        <label for="<?php echo $subjectId; ?>" class="subject-label">Subject</label>
                        <select class="wizard-form-control wizard-select-control subject-select" id="<?php echo $subjectId; ?>" name="subject_<?php echo $index + 1; ?>">
                            <option value="" disabled>Set Language</option>
                            <option value="english" <?php echo ($subject['subject'] == 'english') ? 'selected' : ''; ?>>English</option>
                            <option value="mathematics" <?php echo ($subject['subject'] == 'mathematics') ? 'selected' : ''; ?>>Mathematics</option>
                            <option value="science" <?php echo ($subject['subject'] == 'science') ? 'selected' : ''; ?>>Science</option>
                            <option value="history" <?php echo ($subject['subject'] == 'history') ? 'selected' : ''; ?>>History</option>
                            <option value="geography" <?php echo ($subject['subject'] == 'geography') ? 'selected' : ''; ?>>Geography</option>
                            <option value="physics" <?php echo ($subject['subject'] == 'physics') ? 'selected' : ''; ?>>Physics</option>
                            <option value="chemistry" <?php echo ($subject['subject'] == 'chemistry') ? 'selected' : ''; ?>>Chemistry</option>
                            <option value="biology" <?php echo ($subject['subject'] == 'biology') ? 'selected' : ''; ?>>Biology</option>
                            <option value="computer_science" <?php echo ($subject['subject'] == 'computer_science') ? 'selected' : ''; ?>>Computer Science</option>
                            <option value="economics" <?php echo ($subject['subject'] == 'economics') ? 'selected' : ''; ?>>Economics</option>
                            <option value="business_studies" <?php echo ($subject['subject'] == 'business_studies') ? 'selected' : ''; ?>>Business Studies</option>
                            <option value="art" <?php echo ($subject['subject'] == 'art') ? 'selected' : ''; ?>>Art</option>
                            <option value="music" <?php echo ($subject['subject'] == 'music') ? 'selected' : ''; ?>>Music</option>
                            <option value="physical_education" <?php echo ($subject['subject'] == 'physical_education') ? 'selected' : ''; ?>>Physical Education</option>
                        </select>
                    </div>
                    
                    <div class="level-form-container">
                        <div class="level-form-group">
                            <label for="<?php echo $fromLevelId; ?>" class="subject-label">From level</label>
                            <select class="wizard-form-control wizard-select-control level-select" id="<?php echo $fromLevelId; ?>" name="from_level_<?php echo $index + 1; ?>">
                                <option value="" disabled>-Select lowest level-</option>
                                <option value="beginner" <?php echo ($subject['from_level'] == 'beginner') ? 'selected' : ''; ?>>Beginner</option>
                                <option value="elementary" <?php echo ($subject['from_level'] == 'elementary') ? 'selected' : ''; ?>>Elementary</option>
                                <option value="intermediate" <?php echo ($subject['from_level'] == 'intermediate') ? 'selected' : ''; ?>>Intermediate</option>
                                <option value="upper_intermediate" <?php echo ($subject['from_level'] == 'upper_intermediate') ? 'selected' : ''; ?>>Upper Intermediate</option>
                                <option value="advanced" <?php echo ($subject['from_level'] == 'advanced') ? 'selected' : ''; ?>>Advanced</option>
                                <option value="proficient" <?php echo ($subject['from_level'] == 'proficient') ? 'selected' : ''; ?>>Proficient</option>
                            </select>
                        </div>
                        
                        <div class="level-form-group">
                            <label for="<?php echo $toLevelId; ?>" class="subject-label">To level</label>
                            <select class="wizard-form-control wizard-select-control level-select" id="<?php echo $toLevelId; ?>" name="to_level_<?php echo $index + 1; ?>">
                                <option value="" disabled>-Select High level-</option>
                                <option value="beginner" <?php echo ($subject['to_level'] == 'beginner') ? 'selected' : ''; ?>>Beginner</option>
                                <option value="elementary" <?php echo ($subject['to_level'] == 'elementary') ? 'selected' : ''; ?>>Elementary</option>
                                <option value="intermediate" <?php echo ($subject['to_level'] == 'intermediate') ? 'selected' : ''; ?>>Intermediate</option>
                                <option value="upper_intermediate" <?php echo ($subject['to_level'] == 'upper_intermediate') ? 'selected' : ''; ?>>Upper Intermediate</option>
                                <option value="advanced" <?php echo ($subject['to_level'] == 'advanced') ? 'selected' : ''; ?>>Advanced</option>
                                <option value="proficient" <?php echo ($subject['to_level'] == 'proficient') ? 'selected' : ''; ?>>Proficient</option>
                            </select>
                        </div>
                    </div>
                    
                    <button type="button" class="btn-remove-subject">
                        <i class="fas fa-times"></i> Remove
                    </button>
                </div>
                <?php
            }
        }
        ?>
    </div>
</div>

<!-- Form Actions -->
<div class="wizard-form-actions">
    <button type="button" class="btn-save" id="save-subjects">Save</button>
    <button type="button" class="btn-next" id="next-step" data-next-step="education-experience">Next</button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add Subject Functionality
    const addSubjectBtn = document.querySelector('.btn-add-subject');
    const subjectFormContainer = document.querySelector('.subject-form-container');
    const additionalSubjectsContainer = document.getElementById('additional-subjects-container');
    
    if (addSubjectBtn && additionalSubjectsContainer) {
        // Get the highest existing index
        let subjectCount = 0;
        const existingSections = document.querySelectorAll('.subject-section');
        existingSections.forEach(section => {
            const index = parseInt(section.getAttribute('data-index'), 10);
            if (index > subjectCount) {
                subjectCount = index;
            }
        });
        
        addSubjectBtn.addEventListener('click', function() {
            // Increment subject count for the new section
            subjectCount++;
            
            // Create a new subject section
            const newSubjectId = `subject-${subjectCount}`;
            const newFromLevelId = `from-level-${subjectCount}`;
            const newToLevelId = `to-level-${subjectCount}`;
            
            const newSubjectSection = document.createElement('div');
            newSubjectSection.className = 'subject-section';
            newSubjectSection.setAttribute('data-index', subjectCount);
            newSubjectSection.innerHTML = `
                <div class="subject-form-group">
                    <label for="${newSubjectId}" class="subject-label">Subject</label>
                    <select class="wizard-form-control wizard-select-control subject-select" id="${newSubjectId}" name="subject_${subjectCount}">
                        <option value="" selected disabled>Set Language</option>
                        <option value="english">English</option>
                        <option value="mathematics">Mathematics</option>
                        <option value="science">Science</option>
                        <option value="history">History</option>
                        <option value="geography">Geography</option>
                        <option value="physics">Physics</option>
                        <option value="chemistry">Chemistry</option>
                        <option value="biology">Biology</option>
                        <option value="computer_science">Computer Science</option>
                        <option value="economics">Economics</option>
                        <option value="business_studies">Business Studies</option>
                        <option value="art">Art</option>
                        <option value="music">Music</option>
                        <option value="physical_education">Physical Education</option>
                    </select>
                </div>
                
                <div class="level-form-container">
                    <div class="level-form-group">
                        <label for="${newFromLevelId}" class="subject-label">From level</label>
                        <select class="wizard-form-control wizard-select-control level-select" id="${newFromLevelId}" name="from_level_${subjectCount}">
                            <option value="" selected disabled>-Select lowest level-</option>
                            <option value="beginner">Beginner</option>
                            <option value="elementary">Elementary</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="upper_intermediate">Upper Intermediate</option>
                            <option value="advanced">Advanced</option>
                            <option value="proficient">Proficient</option>
                        </select>
                    </div>
                    
                    <div class="level-form-group">
                        <label for="${newToLevelId}" class="subject-label">To level</label>
                        <select class="wizard-form-control wizard-select-control level-select" id="${newToLevelId}" name="to_level_${subjectCount}">
                            <option value="" selected disabled>-Select High level-</option>
                            <option value="beginner">Beginner</option>
                            <option value="elementary">Elementary</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="upper_intermediate">Upper Intermediate</option>
                            <option value="advanced">Advanced</option>
                            <option value="proficient">Proficient</option>
                        </select>
                    </div>
                </div>
                
                <button type="button" class="btn-remove-subject">
                    <i class="fas fa-times"></i> Remove
                </button>
            `;
            
            // Add to container
            additionalSubjectsContainer.appendChild(newSubjectSection);
            
            // Add remove functionality
            const removeBtn = newSubjectSection.querySelector('.btn-remove-subject');
            if (removeBtn) {
                removeBtn.addEventListener('click', function() {
                    newSubjectSection.remove();
                });
            }
        });
        
        // Add remove functionality to existing buttons
        document.querySelectorAll('.btn-remove-subject').forEach(btn => {
            btn.addEventListener('click', function() {
                this.closest('.subject-section').remove();
            });
        });
    }
    
    // Save button functionality
    const saveButton = document.getElementById('save-subjects');
    if (saveButton) {
        saveButton.addEventListener('click', function() {
            saveFormData();
            // Show a success message
            alert('Your subject data has been saved!');
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
        
        // Add additional subjects
        const additionalSubjects = [];
        document.querySelectorAll('.subject-section').forEach(section => {
            const index = section.getAttribute('data-index');
            const subjectSelect = section.querySelector(`select[name="subject_${index}"]`);
            const fromLevelSelect = section.querySelector(`select[name="from_level_${index}"]`);
            const toLevelSelect = section.querySelector(`select[name="to_level_${index}"]`);
            
            if (subjectSelect && fromLevelSelect && toLevelSelect) {
                additionalSubjects.push({
                    index: index,
                    subject: subjectSelect.value,
                    from_level: fromLevelSelect.value,
                    to_level: toLevelSelect.value
                });
            }
        });
        
        // Add the additional subjects to the form data
        formData.append('additional_subjects', JSON.stringify(additionalSubjects));
        
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