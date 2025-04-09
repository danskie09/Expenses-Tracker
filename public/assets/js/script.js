// Add mobile menu toggle functionality
document.getElementById('mobileMenuToggle').addEventListener('click', function () {
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.toggle('d-none');

    if (window.getComputedStyle(sidebar).display === 'none') {
        sidebar.classList.remove('d-none');
    } else {
        // Do nothing, keep it visible
    }
});

// Handle responsive behavior
function handleResponsive() {
    const sidebar = document.querySelector('.sidebar');
    if (window.innerWidth < 992) {
        // On small screens, collapse sidebar by default
        if (document.querySelector('.sidebar').classList.contains('d-none')) {
            sidebar.classList.remove('d-none');
        }
    }
}

// Call on page load
handleResponsive();

// Call on window resize
window.addEventListener('resize', handleResponsive);