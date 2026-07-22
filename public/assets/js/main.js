$(document).ready(function() {
    // Sidebar Toggle
    $('#sidebarToggle').on('click', function() {
        if ($(window).width() <= 768) {
            $('#sidebar').toggleClass('show');
        } else {
            $('#sidebar').toggleClass('collapsed');
            const isCollapsed = $('#sidebar').hasClass('collapsed');
            localStorage.setItem('sidebarCollapsed', isCollapsed);
        }
    });

    // Close sidebar when clicking outside on mobile
    $(document).on('click', function(e) {
        if ($(window).width() <= 768) {
            if (!$(e.target).closest('#sidebar').length && !$(e.target).closest('#sidebarToggle').length) {
                $('#sidebar').removeClass('show');
            }
        }
    });

    // Check Sidebar State
    if (localStorage.getItem('sidebarCollapsed') === 'true') {
        $('#sidebar').addClass('collapsed');
    }

    // Theme Toggle
    const currentTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', currentTheme);
    updateThemeIcon(currentTheme);

    $('#themeToggle').on('click', function() {
        let theme = document.documentElement.getAttribute('data-theme');
        let newTheme = theme === 'light' ? 'dark' : 'light';
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        updateThemeIcon(newTheme);
    });

    function updateThemeIcon(theme) {
        const icon = $('#themeToggle i');
        if (theme === 'dark') {
            icon.removeClass('bi-moon').addClass('bi-sun');
        } else {
            icon.removeClass('bi-sun').addClass('bi-moon');
        }
    }

    // Fullscreen Toggle
    $('#fullscreenToggle').on('click', function() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            }
        }
    });

    // Active Link Highlight
    const currentPath = window.location.pathname;
    const currentUrl = window.location.href;
    
    $('#sidebar .nav-link').each(function() {
        const href = $(this).attr('href');
        if (href && href !== '#' && (currentUrl === href || currentPath === href || currentUrl.includes(href))) {
            $(this).addClass('active');
            // If it's in a submenu, expand the parent
            const parentCollapse = $(this).closest('.collapse');
            if (parentCollapse.length) {
                parentCollapse.addClass('show');
                $(`a[href="#${parentCollapse.attr('id')}"]`).removeClass('collapsed').attr('aria-expanded', 'true');
            }
        }
    });
});
