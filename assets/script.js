/* ────────────────────────────────────────────────
   Student Portal global JavaScript
   Put this file at: student-portal/assets/script.js
────────────────────────────────────────────────‑*/

document.addEventListener('DOMContentLoaded', () => {

    /* ========== Theme Switcher ========== */
    const toggleBtn = document.getElementById('toggleTheme');

    const getPref = () =>
        document.cookie.match(/(?:^|; )theme=(dark|light)/)?.[1];

    const setPref = theme =>
        document.cookie = `theme=${theme};path=/;max-age=31536000`;

    const applyTheme = theme => {
        document.documentElement.dataset.theme = theme;
        if (toggleBtn) {
            toggleBtn.innerHTML =
                theme === 'dark'
                    ? '<i class="bi bi-sun"></i>'
                    : '<i class="bi bi-moon-fill"></i>';
        }
    };

    applyTheme(getPref() || 'light');

    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            const newTheme =
                document.documentElement.dataset.theme === 'dark'
                    ? 'light'
                    : 'dark';
            setPref(newTheme);
            applyTheme(newTheme);
        });
    }

    /* ========== Bootstrap 5 client‑side form validation ========== */
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener(
            'submit',
            event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            },
            false
        );
    });
});