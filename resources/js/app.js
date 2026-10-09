/*
|--------------------------------------------------------------------------
| PENSARIUM - JAVASCRIPT PRINCIPAL
|--------------------------------------------------------------------------
| Interacciones de la interfaz.
| JavaScript puro, sin librerías externas.
|--------------------------------------------------------------------------
*/

'use strict';

/*
|--------------------------------------------------------------------------
| 1. ADMINISTRACIÓN DEL TEMA
|--------------------------------------------------------------------------
*/

const THEME_KEY = 'pensarium-theme';

function getSavedTheme() {
    try {
        const saved = localStorage.getItem(THEME_KEY);

        if (saved === 'light' || saved === 'dark') {
            return saved;
        }
    } catch (error) {
        // El navegador puede bloquear localStorage.
    }

    return window.matchMedia(
        '(prefers-color-scheme: dark)'
    ).matches ? 'dark' : 'light';
}

function applyTheme(theme) {
    const selectedTheme = theme === 'dark'
        ? 'dark'
        : 'light';

    document.documentElement.setAttribute(
        'data-theme',
        selectedTheme
    );

    document.documentElement.style.colorScheme =
        selectedTheme;

    document.querySelectorAll(
        '[data-theme-toggle]'
    ).forEach(button => {

        const isDark = selectedTheme === 'dark';

        button.setAttribute(
            'aria-label',
            isDark
                ? 'Activar modo claro'
                : 'Activar modo oscuro'
        );

        button.setAttribute(
            'title',
            isDark
                ? 'Modo claro'
                : 'Modo oscuro'
        );

        button.setAttribute(
            'aria-pressed',
            String(isDark)
        );

        const sunIcon = button.querySelector(
            '[data-icon-sun]'
        );

        const moonIcon = button.querySelector(
            '[data-icon-moon]'
        );

        if (sunIcon) {
            sunIcon.hidden = !isDark;
        }

        if (moonIcon) {
            moonIcon.hidden = isDark;
        }
    });
}

function saveTheme(theme) {
    try {
        localStorage.setItem(THEME_KEY, theme);
    } catch (error) {
        // La interfaz seguirá funcionando.
    }
}

function initializeTheme() {
    applyTheme(getSavedTheme());

    document.querySelectorAll(
        '[data-theme-toggle]'
    ).forEach(button => {

        button.addEventListener('click', () => {

            const currentTheme =
                document.documentElement.getAttribute(
                    'data-theme'
                );

            const newTheme = currentTheme === 'dark'
                ? 'light'
                : 'dark';

            applyTheme(newTheme);
            saveTheme(newTheme);
        });
    });
}

/*
|--------------------------------------------------------------------------
| 2. SIDEBAR RESPONSIVO
|--------------------------------------------------------------------------
*/

function initializeSidebar() {
    const menuButtons = document.querySelectorAll(
        '[data-sidebar-toggle]'
    );

    const overlay = document.querySelector(
        '[data-sidebar-overlay]'
    );

    const sidebar = document.querySelector(
        '.app-sidebar'
    );

    if (!sidebar) {
        return;
    }

    function setSidebarState(isOpen) {
        document.body.classList.toggle(
            'sidebar-open',
            isOpen
        );

        menuButtons.forEach(button => {
            button.setAttribute(
                'aria-expanded',
                String(isOpen)
            );
        });
    }

    menuButtons.forEach(button => {
        button.addEventListener('click', () => {
            const isOpen = document.body.classList.contains(
                'sidebar-open'
            );

            setSidebarState(!isOpen);
        });
    });

    if (overlay) {
        overlay.addEventListener('click', () => {
            setSidebarState(false);
        });
    }

    document.addEventListener('keydown', event => {
        if (event.key === 'Escape') {
            setSidebarState(false);
        }
    });

    sidebar.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            setSidebarState(false);
        });
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 850) {
            setSidebarState(false);
        }
    });
}

/*
|--------------------------------------------------------------------------
| 3. MOSTRAR Y OCULTAR CONTRASEÑAS
|--------------------------------------------------------------------------
*/

function initializePasswordToggles() {
    document.querySelectorAll(
        '[data-password-toggle]'
    ).forEach(button => {

        button.addEventListener('click', () => {

            const inputId = button.getAttribute(
                'data-password-toggle'
            );

            const input = document.getElementById(inputId);

            if (!input) {
                return;
            }

            const isPassword = input.type === 'password';

            input.type = isPassword
                ? 'text'
                : 'password';

            button.setAttribute(
                'aria-label',
                isPassword
                    ? 'Ocultar contraseña'
                    : 'Mostrar contraseña'
            );

            button.setAttribute(
                'aria-pressed',
                String(isPassword)
            );

            const eyeIcon = button.querySelector(
                '[data-eye]'
            );

            const eyeOffIcon = button.querySelector(
                '[data-eye-off]'
            );

            if (eyeIcon) {
                eyeIcon.hidden = isPassword;
            }

            if (eyeOffIcon) {
                eyeOffIcon.hidden = !isPassword;
            }
        });
    });
}

/*
|--------------------------------------------------------------------------
| 4. CONTADOR DE CARACTERES
|--------------------------------------------------------------------------
*/

function initializeCharacterCounters() {
    document.querySelectorAll(
        '[data-character-count]'
    ).forEach(input => {

        const counterId = input.getAttribute(
            'data-character-count'
        );

        const counter = document.getElementById(counterId);

        if (!counter) {
            return;
        }

        const maxLength = Number(
            input.getAttribute('maxlength')
        );

        function updateCounter() {
            const currentLength = Array.from(
                input.value
            ).length;

            if (maxLength > 0) {
                counter.textContent =
                    `${currentLength} / ${maxLength}`;

                counter.classList.toggle(
                    'is-limit',
                    currentLength >= maxLength
                );
            } else {
                counter.textContent =
                    `${currentLength} caracteres`;
            }
        }

        input.addEventListener('input', updateCounter);

        updateCounter();
    });
}

/*
|--------------------------------------------------------------------------
| 5. CONFIRMACIÓN DE ELIMINACIÓN
|--------------------------------------------------------------------------
*/

function initializeDeleteConfirmations() {
    document.querySelectorAll(
        '[data-confirm-delete]'
    ).forEach(form => {

        form.addEventListener('submit', event => {

            const message = form.getAttribute(
                'data-confirm-delete'
            ) || '¿Seguro que deseas eliminar este elemento?';

            const confirmed = window.confirm(message);

            if (!confirmed) {
                event.preventDefault();
            }
        });
    });
}

/*
|--------------------------------------------------------------------------
| 6. CERRAR ALERTAS
|--------------------------------------------------------------------------
*/

function initializeAlerts() {
    document.querySelectorAll(
        '[data-alert-close]'
    ).forEach(button => {

        button.addEventListener('click', () => {

            const alert = button.closest('.alert');

            if (alert) {
                alert.remove();
            }
        });
    });
}

/*
|--------------------------------------------------------------------------
| 7. PREVENIR ENVÍOS DUPLICADOS
|--------------------------------------------------------------------------
*/

function initializeFormSubmissions() {
    document.querySelectorAll(
        'form[data-prevent-double-submit]'
    ).forEach(form => {

        let submitting = false;

        form.addEventListener('submit', event => {

            if (event.defaultPrevented) {
                return;
            }

            if (!form.checkValidity()) {
                return;
            }

            if (submitting) {
                event.preventDefault();
                return;
            }

            submitting = true;

            const submitButton = form.querySelector(
                'button[type="submit"]'
            );

            if (submitButton) {
                submitButton.setAttribute(
                    'aria-disabled',
                    'true'
                );

                submitButton.classList.add(
                    'is-submitting'
                );
            }
        });
    });
}

/*
|--------------------------------------------------------------------------
| 8. AUTOAJUSTAR TEXTAREAS
|--------------------------------------------------------------------------
*/

function initializeAutoResize() {
    document.querySelectorAll(
        'textarea[data-auto-resize]'
    ).forEach(textarea => {

        function resize() {
            textarea.style.height = 'auto';

            textarea.style.height =
                `${textarea.scrollHeight}px`;
        }

        textarea.addEventListener('input', resize);

        resize();
    });
}

/*
|--------------------------------------------------------------------------
| 9. INICIALIZAR LA APLICACIÓN
|--------------------------------------------------------------------------
*/

function initializePensarium() {
    initializeTheme();
    initializeSidebar();
    initializePasswordToggles();
    initializeCharacterCounters();
    initializeDeleteConfirmations();
    initializeAlerts();
    initializeFormSubmissions();
    initializeAutoResize();
}

if (document.readyState === 'loading') {
    document.addEventListener(
        'DOMContentLoaded',
        initializePensarium
    );
} else {
    initializePensarium();
}
