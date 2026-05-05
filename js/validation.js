document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action="index.php?page=inscription"]');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirm');
    
    if (form && passwordInput && confirmPasswordInput) {
        // Create an error message element
        const errorMsg = document.createElement('div');
        errorMsg.style.color = '#ff4d4f'; // red color for error
        errorMsg.style.marginTop = '5px';
        errorMsg.style.fontSize = '0.9em';
        errorMsg.style.display = 'none';
        errorMsg.textContent = 'Les mots de passe ne correspondent pas.';
        confirmPasswordInput.parentNode.appendChild(errorMsg);

        function validatePassword() {
            if (confirmPasswordInput.value !== '' && passwordInput.value !== confirmPasswordInput.value) {
                errorMsg.style.display = 'block';
                confirmPasswordInput.style.borderColor = '#ff4d4f';
                return false;
            } else {
                errorMsg.style.display = 'none';
                confirmPasswordInput.style.borderColor = ''; // reset to default
                return true;
            }
        }

        passwordInput.addEventListener('input', validatePassword);
        confirmPasswordInput.addEventListener('input', validatePassword);

        form.addEventListener('submit', function(e) {
            if (!validatePassword()) {
                e.preventDefault(); // Prevent form submission if passwords don't match
            }
        });
    }
});
