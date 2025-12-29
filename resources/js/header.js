// Header Navigation and Mobile Menu
document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.main-header');
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const navMenu = document.querySelector('.nav-menu');
    
    // Header scroll effect - only if header exists
    if (header) {
        let lastScroll = 0;
        window.addEventListener('scroll', function() {
            const currentScroll = window.pageYOffset;
            
            if (currentScroll > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
            
            lastScroll = currentScroll;
        });
    }
    
    // Mobile menu toggle - only if elements exist
    if (mobileMenuToggle && navMenu) {
        mobileMenuToggle.addEventListener('click', function() {
            this.classList.toggle('active');
            navMenu.classList.toggle('active');
            document.body.style.overflow = navMenu.classList.contains('active') ? 'hidden' : '';
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (navMenu && !navMenu.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                mobileMenuToggle.classList.remove('active');
                navMenu.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
        
        // Close menu when clicking a link
        const navLinks = navMenu.querySelectorAll('a');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileMenuToggle.classList.remove('active');
                navMenu.classList.remove('active');
                document.body.style.overflow = '';
            });
        });
    }
    
    // Profile Modal
    function initModals() {
        const profileModalBtn = document.getElementById('profileModalBtn');
        const profileModal = document.getElementById('profileModal');
        const profileModalClose = document.getElementById('profileModalClose');
        const profileEditModalBtn = document.getElementById('profileEditModalBtn');
        const profileEditModal = document.getElementById('profileEditModal');
        const profileEditModalClose = document.getElementById('profileEditModalClose');
        const passwordChangeModalBtn = document.getElementById('passwordChangeModalBtn');
        const passwordChangeModal = document.getElementById('passwordChangeModal');
        const passwordChangeModalClose = document.getElementById('passwordChangeModalClose');
        
        // Function to open modal
        function openModal(modal) {
            if (modal) {
                // Ensure modal is positioned correctly
                modal.style.position = 'fixed';
                modal.style.top = '0';
                modal.style.left = '0';
                modal.style.right = '0';
                modal.style.bottom = '0';
                modal.style.zIndex = '99999';
                modal.style.display = 'flex';
                setTimeout(() => {
                    modal.classList.add('active');
                }, 10);
                document.body.style.overflow = 'hidden';
            }
        }
        
        // Function to close modal
        function closeModal(modal) {
            if (modal) {
                modal.classList.remove('active');
                setTimeout(() => {
                    modal.style.display = 'none';
                }, 300);
                document.body.style.overflow = '';
            }
        }
        
        // Profile modal toggle
        if (profileModalBtn) {
            profileModalBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                if (profileModal) {
                    openModal(profileModal);
                }
            });
        }
        
        // Close button for profile modal
        if (profileModalClose) {
            profileModalClose.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeModal(profileModal);
            });
        }
        
        // Profile edit modal toggle
        if (profileEditModalBtn) {
            profileEditModalBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                // Close profile modal first
                if (profileModal) {
                    closeModal(profileModal);
                }
                // Open edit modal after a short delay
                setTimeout(() => {
                    if (profileEditModal) {
                        openModal(profileEditModal);
                    }
                }, 350);
            });
        }
        
        // Close button for profile edit modal
        if (profileEditModalClose) {
            profileEditModalClose.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeModal(profileEditModal);
            });
        }
        
        // Password change modal toggle
        if (passwordChangeModalBtn) {
            passwordChangeModalBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                // Close profile modal first
                if (profileModal) {
                    closeModal(profileModal);
                }
                // Open password modal after a short delay
                setTimeout(() => {
                    if (passwordChangeModal) {
                        openModal(passwordChangeModal);
                    }
                }, 350);
            });
        }
        
        // Close button for password change modal
        if (passwordChangeModalClose) {
            passwordChangeModalClose.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeModal(passwordChangeModal);
            });
        }
        
        // Close modals when clicking outside
        if (profileModal) {
            profileModal.addEventListener('click', function(e) {
                if (e.target === profileModal) {
                    closeModal(profileModal);
                }
            });
        }
        
        if (profileEditModal) {
            profileEditModal.addEventListener('click', function(e) {
                if (e.target === profileEditModal) {
                    closeModal(profileEditModal);
                }
            });
        }
        
        if (passwordChangeModal) {
            passwordChangeModal.addEventListener('click', function(e) {
                if (e.target === passwordChangeModal) {
                    closeModal(passwordChangeModal);
                }
            });
        }
        
        // Close modals on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (passwordChangeModal && passwordChangeModal.classList.contains('active')) {
                    closeModal(passwordChangeModal);
                } else if (profileEditModal && profileEditModal.classList.contains('active')) {
                    closeModal(profileEditModal);
                } else if (profileModal && profileModal.classList.contains('active')) {
                    closeModal(profileModal);
                }
            }
        });
        
        // Auto-open edit modal if there's a success message or validation errors
        // This handles the case when form is submitted and page reloads
        const hasProfileSuccess = document.querySelector('#profileEditModal .alert-success') !== null;
        const hasProfileErrors = document.querySelector('#profileEditModal .form-error') !== null;
        const hasPasswordSuccess = document.querySelector('#passwordChangeModal .alert-success') !== null;
        const hasPasswordErrors = document.querySelector('#passwordChangeModal .form-error') !== null;
        const urlParams = new URLSearchParams(window.location.search);
        const profileUpdated = urlParams.get('profile_updated') === '1';
        
        if ((hasProfileSuccess || hasProfileErrors || profileUpdated) && profileEditModal) {
            // Remove the query parameter from URL if present
            if (urlParams.has('profile_updated')) {
                window.history.replaceState({}, document.title, window.location.pathname);
            }
            // Open the edit modal
            setTimeout(() => {
                openModal(profileEditModal);
            }, 100);
        }
        
        // Auto-open password modal if there's a success message or validation errors
        if ((hasPasswordSuccess || hasPasswordErrors) && passwordChangeModal) {
            setTimeout(() => {
                openModal(passwordChangeModal);
            }, 100);
        }

        // Change Email Modal functionality
        const changeEmailBtn = document.getElementById('changeEmailBtn');
        const changeEmailModal = document.getElementById('changeEmailModal');
        const changeEmailModalClose = document.getElementById('changeEmailModalClose');
        const verifyPasswordForm = document.getElementById('verifyPasswordForm');
        const changeEmailForm = document.getElementById('changeEmailForm');
        const changeEmailStep1 = document.getElementById('changeEmailStep1');
        const changeEmailStep2 = document.getElementById('changeEmailStep2');
        const passwordError = document.getElementById('password-error');

        // Function to open change email modal
        function openChangeEmailModal() {
            if (changeEmailModal) {
                changeEmailModal.style.display = 'flex';
                setTimeout(() => {
                    changeEmailModal.classList.add('active');
                }, 10);
                document.body.style.overflow = 'hidden';
                // Reset to step 1
                resetChangeEmailModal();
            }
        }

        // Function to close change email modal
        function closeChangeEmailModal() {
            if (changeEmailModal) {
                changeEmailModal.classList.remove('active');
                setTimeout(() => {
                    changeEmailModal.style.display = 'none';
                }, 300);
                document.body.style.overflow = '';
                resetChangeEmailModal();
            }
        }

        // Function to reset modal to initial state
        function resetChangeEmailModal() {
            if (changeEmailStep1) changeEmailStep1.style.display = 'block';
            if (changeEmailStep2) changeEmailStep2.style.display = 'none';
            if (verifyPasswordForm) {
                verifyPasswordForm.reset();
                if (passwordError) passwordError.style.display = 'none';
            }
            if (changeEmailForm) changeEmailForm.reset();
        }

        // Make functions globally available
        window.closeChangeEmailModal = closeChangeEmailModal;
        window.resetChangeEmailModal = resetChangeEmailModal;

        // Open modal when Change Email button is clicked
        if (changeEmailBtn) {
            changeEmailBtn.addEventListener('click', function(e) {
                e.preventDefault();
                openChangeEmailModal();
            });
        }

        // Close modal button
        if (changeEmailModalClose) {
            changeEmailModalClose.addEventListener('click', function(e) {
                e.preventDefault();
                closeChangeEmailModal();
            });
        }

        // Close modal when clicking outside
        if (changeEmailModal) {
            changeEmailModal.addEventListener('click', function(e) {
                if (e.target === changeEmailModal) {
                    closeChangeEmailModal();
                }
            });
        }

        // Handle password verification form submission
        if (verifyPasswordForm) {
            verifyPasswordForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(verifyPasswordForm);
                const password = formData.get('password');
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || formData.get('_token');
                const verifyRoute = verifyPasswordForm.getAttribute('data-verify-route') || '/profile/verify-password';

                fetch(verifyRoute, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ password: password })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw new Error(data.message || 'Invalid password');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Hide step 1, show step 2
                        if (changeEmailStep1) changeEmailStep1.style.display = 'none';
                        if (changeEmailStep2) changeEmailStep2.style.display = 'block';
                        if (passwordError) passwordError.style.display = 'none';
                        // Focus on new email input
                        const newEmailInput = document.getElementById('new-email');
                        if (newEmailInput) {
                            setTimeout(() => newEmailInput.focus(), 100);
                        }
                    } else {
                        // Show error
                        if (passwordError) {
                            passwordError.textContent = data.message || 'Invalid password. Please try again.';
                            passwordError.style.display = 'block';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (passwordError) {
                        passwordError.textContent = error.message || 'Invalid password. Please try again.';
                        passwordError.style.display = 'block';
                    }
                });
            });
        }

        // Handle email change form submission - update email field value after success
        if (changeEmailForm) {
            changeEmailForm.addEventListener('submit', function(e) {
                // Let form submit normally, but update email field after if successful
                const form = this;
                const originalSubmit = form.onsubmit;
                
                // After form submission, if successful, update the readonly email field
                setTimeout(() => {
                    const newEmailInput = document.getElementById('new-email');
                    const editEmailInput = document.getElementById('edit-email');
                    if (newEmailInput && editEmailInput) {
                        // Check if we're on the same page (form submitted successfully)
                        // The email will be updated via page reload with new value from server
                    }
                }, 100);
            });
        }

        // Update email field value after page load if email was updated
        const emailUpdatedStatus = document.querySelector('.alert-success')?.textContent?.includes('Email updated');
        if (emailUpdatedStatus) {
            // Email field will be updated by server on next page load
            // Close change email modal if open
            if (changeEmailModal && changeEmailModal.classList.contains('active')) {
                closeChangeEmailModal();
            }
        }
    }
    
    // Initialize modals
    initModals();
});

