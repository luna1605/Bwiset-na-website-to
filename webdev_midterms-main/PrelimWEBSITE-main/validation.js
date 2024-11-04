document.addEventListener('DOMContentLoaded', () => {
    const nameInput = document.getElementById('register_name');
    const nameError = document.getElementById('name-error');
    const passwordInput = document.getElementById('register_password');
    const rePasswordInput = document.getElementById('register_re_password');
    const passwordError = document.getElementById('password-error');
    const rePasswordError = document.getElementById('re-password-error');

    nameInput.addEventListener('input', () => {
        const regex = /^[a-zA-Z\s]+$/;
        nameError.textContent = regex.test(nameInput.value) ? '' : 'No special characters or numbers allowed';
    });

    rePasswordInput.addEventListener('input', () => {
        rePasswordError.textContent = rePasswordInput.value === passwordInput.value ? '' : 'Passwords do not match';
    });
});
