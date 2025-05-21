// Theme management
document.addEventListener('DOMContentLoaded', function() {
    // Get the toggle button from the header
    const themeToggle = document.getElementById('toggleTheme');
    
    // Check for saved theme preference
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    updateThemeIcon(savedTheme);

    // Toggle theme
    themeToggle.addEventListener('click', () => {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        updateThemeIcon(newTheme);
    });
});

// Update theme icon
function updateThemeIcon(theme) {
    const themeToggle = document.getElementById('toggleTheme');
    if (themeToggle) {
        themeToggle.innerHTML = theme === 'light' 
            ? '<i class="bi bi-moon-fill"></i>'
            : '<i class="bi bi-sun-fill"></i>';
    }
} 