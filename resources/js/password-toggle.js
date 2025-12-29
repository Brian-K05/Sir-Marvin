// Password Visibility Toggle Functionality
(function() {
    'use strict';
    
    function handlePasswordToggle(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const button = e.currentTarget;
        const wrapper = button.closest('.password-input-wrapper, .admin-password-input-wrapper');
        if (!wrapper) return;
        
        const passwordInput = wrapper.querySelector('input[type="password"], input[type="text"]');
        if (!passwordInput) return;
        
        // Toggle input type
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        
        // Toggle icon visibility - show icon that represents the NEW state
        const eyeOpenIcon = button.querySelector('.eye-open');
        const eyeClosedIcon = button.querySelector('.eye-closed');
        
        if (eyeOpenIcon && eyeClosedIcon) {
            // After toggle: if now visible (text), show open eye (with slash)
            // If now hidden (password), show closed eye (normal)
            if (passwordInput.type === 'text') {
                // Password is now visible - show open eye (with slash)
                eyeOpenIcon.style.display = 'block';
                eyeClosedIcon.style.display = 'none';
            } else {
                // Password is now hidden - show closed eye (normal)
                eyeOpenIcon.style.display = 'none';
                eyeClosedIcon.style.display = 'block';
            }
        }
    }
    
    function initPasswordToggle() {
        const passwordToggleButtons = document.querySelectorAll('.password-toggle-btn, .admin-password-toggle-btn');
        passwordToggleButtons.forEach(button => {
            button.removeEventListener('click', handlePasswordToggle);
            button.addEventListener('click', handlePasswordToggle);
        });
    }
    
    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initPasswordToggle);
    } else {
        initPasswordToggle();
    }
    
    // Re-initialize on dynamic content changes
    const observer = new MutationObserver(initPasswordToggle);
    observer.observe(document.body, { childList: true, subtree: true });
})();
