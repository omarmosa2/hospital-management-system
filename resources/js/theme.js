/**
 * Dark Mode Theme Manager
 * Handles theme switching and persistence
 */

class ThemeManager {
    constructor() {
        this.STORAGE_KEY = 'hospital-theme-mode';
        this.DARK_CLASS = 'dark';
        this.init();
        this.setupEventListeners();
    }

    /**
     * Initialize theme on page load
     */
    init() {
        // Check localStorage for saved preference
        const savedTheme = localStorage.getItem(this.STORAGE_KEY);

        // Check system preference if no saved preference
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

        // Determine theme: saved > system preference > light (default)
        const isDark = savedTheme ? savedTheme === 'dark' : prefersDark;

        this.setTheme(isDark);

        // Listen for system theme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (!localStorage.getItem(this.STORAGE_KEY)) {
                this.setTheme(e.matches);
            }
        });
    }

    /**
     * Setup event listeners for theme toggle button
     */
    setupEventListeners() {
        // Wait for DOM to be ready
        const setupButton = () => {
            const themeToggleBtn = document.getElementById('theme-toggle-btn');
            if (themeToggleBtn) {
                themeToggleBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    this.toggle();
                });
                console.log('✓ Theme toggle button initialized');
            } else {
                console.warn('⚠ Theme toggle button not found');
            }
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', setupButton);
        } else {
            setupButton();
        }
    }

    /**
     * Set theme and update DOM
     * @param {boolean} isDark - Whether to enable dark mode
     */
    setTheme(isDark) {
        const html = document.documentElement;

        if (isDark) {
            html.classList.add(this.DARK_CLASS);
            localStorage.setItem(this.STORAGE_KEY, 'dark');
            console.log('🌙 Dark mode enabled');
            console.log('HTML classes:', html.className);
            console.log('Has dark class:', html.classList.contains('dark'));
        } else {
            html.classList.remove(this.DARK_CLASS);
            localStorage.setItem(this.STORAGE_KEY, 'light');
            console.log('☀️ Light mode enabled');
            console.log('HTML classes:', html.className);
            console.log('Has dark class:', html.classList.contains('dark'));
        }

        // Dispatch custom event for other scripts to listen
        window.dispatchEvent(new CustomEvent('themechange', {
            detail: { isDark }
        }));
    }

    /**
     * Toggle between dark and light mode
     */
    toggle() {
        const isDark = document.documentElement.classList.contains(this.DARK_CLASS);
        console.log('Toggling theme from:', isDark ? 'dark' : 'light');
        this.setTheme(!isDark);
    }

    /**
     * Get current theme
     * @returns {string} 'dark' or 'light'
     */
    getCurrentTheme() {
        return document.documentElement.classList.contains(this.DARK_CLASS) ? 'dark' : 'light';
    }

    /**
     * Check if dark mode is enabled
     * @returns {boolean}
     */
    isDarkMode() {
        return document.documentElement.classList.contains(this.DARK_CLASS);
    }
}

// Initialize theme manager immediately
window.themeManager = new ThemeManager();

// Make it available globally
window.ThemeManager = ThemeManager;

// Log initialization
console.log('✓ Theme Manager initialized successfully');
console.log('Available commands: window.themeManager.toggle(), window.themeManager.setTheme(true/false)');

export default ThemeManager;

