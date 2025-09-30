<?php
function renderEmailVerificationScreen() {
    ?>
    <div class="email-verification-screen" style="display: none;">
        <div class="verification-overlay"></div>
        <div class="verification-card">
            <div class="verification-icon">
                <i class="fas fa-envelope"></i>
            </div>
            <h2>Check your email</h2>
            <p class="verification-text">We have sent a verification link to</p>
            <div class="verified-email">example@domain.com</div>
            <p class="verification-subtext">Please check your email and click on the verification link to continue.</p>
            <button class="btn btn-primary verification-btn">Continue</button>
            <a href="#" class="change-email-link">Change email</a>
        </div>
    </div>
    <?php
}

function renderAuthModal($type = 'login') {
    $isLogin = $type === 'login';
    $modalId = $isLogin ? 'loginModal' : 'signupModal';
    $title = $isLogin ? 'Login your account!' : 'Create your account!';
    $submitText = $isLogin ? 'Continue' : 'Sign Up';
    $alternateText = $isLogin ? 'Don\'t have an account?' : 'Already have an account?';
    $alternateLink = $isLogin ? 'Sign up' : 'Login';
    $alternateLinkTarget = $isLogin ? '#signupModal' : '#loginModal';
    ?>
    <div class="modal fade" id="<?php echo $modalId; ?>" tabindex="-1" aria-labelledby="<?php echo $modalId; ?>Label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="row g-0">
                    <!-- Left Image Panel -->
                    <div class="col-md-6 d-none d-md-block">
                        <div class="login-image-panel">
                            <img src="assets/images/student-login.jpg" 
                                 alt="Login illustration" 
                                 class="img-fluid h-100 w-100 object-fit-cover"
                                 id="auth-image">
                        </div>
                    </div>
                    <!-- Right Form Panel -->
                    <div class="col-md-6">
                        <div class="login-form-panel p-4 p-md-5">
                            <!-- User Type Toggle -->
                            <div class="user-type-toggle mb-4">
                                <button class="btn active" data-type="student">Student</button>
                                <button class="btn" data-type="teacher">Teacher</button>
                            </div>
                            
                            <h2 class="login-title mb-4"><?php echo $title; ?></h2>
                            
                            <!-- Auth Method Tabs -->
                            <div class="login-method-tabs mb-4">
                                <button class="btn active" data-method="email">E-mail</button>
                                <button class="btn" data-method="mobile">Mobile Number</button>
                            </div>
                            
                            <!-- Auth Form -->
                            <form class="auth-form <?php echo $type; ?>-form" action="verify/verify-email.php" onsubmit="handleAuthSubmit(event)">
                                <?php if (!$isLogin): ?>
                                <div class="form-group mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <input type="text" class="form-control" placeholder="Full Name" required>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <!-- Email Input Group -->
                                <div class="form-group mb-3" id="email-input-group">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        <input type="email" 
                                               class="form-control" 
                                               placeholder="Email" 
                                               pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" 
                                               required>
                                    </div>
                                </div>

                                <!-- Mobile Input Group (Initially Hidden) -->
                                <div class="form-group mb-3" id="mobile-input-group" style="display: none;">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-phone"></i>
                                        </span>
                                        <input type="tel" 
                                               class="form-control" 
                                               placeholder="Mobile Number" 
                                               pattern="[0-9]{10,}" 
                                               required>
                                    </div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password" class="form-control" placeholder="Password" required>
                                    </div>
                                </div>
                                
                                <?php if ($isLogin): ?>
                                <div class="text-end mb-3">
                                    <a href="#" class="forgot-password">Forgot password?</a>
                                </div>
                                <?php endif; ?>
                                
                                <!-- <button type="submit" class="btn btn-primary w-100 mb-4"><?php echo $submitText; ?></button> -->
                                <a href="verify/verify-email.php" class="btn btn-primary w-100 mb-4"><?php echo $submitText; ?></a>
                                
                                <!-- Social Login -->
                                <div class="social-login text-center">
                                    <p class="text-muted mb-3">Sign in With</p>
                                    <div class="social-icons mb-4">
                                        <button class="btn btn-social facebook" type="button">
                                            <i class="fab fa-facebook-f"></i>
                                        </button>
                                        <button class="btn btn-social google" type="button">
                                            <img src="assets/images/icons/google.svg" alt="Google" width="20" height="20">
                                        </button>
                                        <button class="btn btn-social apple" type="button">
                                            <i class="fab fa-apple"></i>
                                        </button>
                                    </div>
                                    <p class="signup-text">
                                        <?php echo $alternateText; ?> 
                                        <a href="#" class="<?php echo $isLogin ? 'signup-link' : 'login-link'; ?>" 
                                           data-bs-toggle="modal" 
                                           data-bs-target="<?php echo $alternateLinkTarget; ?>">
                                            <?php echo $alternateLink; ?>
                                        </a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function handleAuthSubmit(event) {
            event.preventDefault();
            
            // Check if the teacher option is selected
            const modalElement = event.target.closest('.modal');
            const isTeacherSelected = modalElement.querySelector('.user-type-toggle .btn[data-type="teacher"]').classList.contains('active');
            
            if (isTeacherSelected) {
                // Redirect to teacher profile wizard
                window.location.href = 'teacher-profile-wizard.php';
            } else {
                // Student login - redirect to email verification
                window.location.href = 'verify/verify-email.php';
            }
        }

        // Add event listeners for user type toggle and auth method tabs
        document.addEventListener('DOMContentLoaded', function() {
            // Function to initialize modal functionality
            function initializeModalFunctionality(modalId) {
                const modal = document.getElementById(modalId);
                if (!modal) return;

                // User type toggle functionality
                const userTypeButtons = modal.querySelectorAll('.user-type-toggle .btn');
                const authImage = modal.querySelector('#auth-image');

                userTypeButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        // Remove active class from all buttons in this modal
                        userTypeButtons.forEach(btn => btn.classList.remove('active'));
                        // Add active class to clicked button
                        this.classList.add('active');
                        
                        // Update image based on user type
                        const userType = this.getAttribute('data-type');
                        if (authImage) {
                            authImage.src = `assets/images/${userType}-login.jpg`;
                        }
                    });
                });

                // Auth method tabs functionality
                const authMethodButtons = modal.querySelectorAll('.login-method-tabs .btn');
                const emailInput = modal.querySelector('#email-input-group');
                const mobileInput = modal.querySelector('#mobile-input-group');

                authMethodButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        // Remove active class from all buttons in this modal
                        authMethodButtons.forEach(btn => btn.classList.remove('active'));
                        // Add active class to clicked button
                        this.classList.add('active');
                        
                        // Show/hide input fields based on selected method
                        const method = this.getAttribute('data-method');
                        if (method === 'email') {
                            emailInput.style.display = 'block';
                            mobileInput.style.display = 'none';
                            emailInput.querySelector('input').required = true;
                            mobileInput.querySelector('input').required = false;
                        } else {
                            emailInput.style.display = 'none';
                            mobileInput.style.display = 'block';
                            emailInput.querySelector('input').required = false;
                            mobileInput.querySelector('input').required = true;
                        }
                    });
                });
            }

            // Initialize functionality for both modals
            initializeModalFunctionality('loginModal');
            initializeModalFunctionality('signupModal');
        });
    </script>

    <style>
        .social-icons {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .btn-social {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-social:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .btn-social.facebook {
            background-color: #1877F2;
            color: white;
        }

        .btn-social.google {
            background-color: white;
            color: #DB4437;
            border: 1px solid #eee;
        }

        .btn-social.apple {
            background-color: white;
            color: black;
        }

        .btn-social i {
            font-size: 1.2rem;
        }

        /* Hover States */
        .btn-social.facebook:hover {
            background-color: #166fe5;
        }

        .btn-social.google:hover {
            background-color: #fafafa;
        }

        .btn-social.apple:hover {
            background-color: #1a1a1a;
            color: white;
        }
    </style>
    <?php
}
?> 