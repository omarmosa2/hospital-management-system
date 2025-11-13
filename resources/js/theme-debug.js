/**
 * Dark Mode Debug Helper
 * Use this to debug theme issues in the console
 */

window.themeDebug = {
    /**
     * Check if theme manager is loaded
     */
    checkManager() {
        console.log('=== Theme Manager Status ===');
        console.log('window.themeManager exists:', !!window.themeManager);
        if (window.themeManager) {
            console.log('Current theme:', window.themeManager.getCurrentTheme());
            console.log('Is dark mode:', window.themeManager.isDarkMode());
        }
        return !!window.themeManager;
    },

    /**
     * Check if toggle button exists
     */
    checkButton() {
        console.log('=== Theme Toggle Button Status ===');
        const btn = document.getElementById('theme-toggle-btn');
        console.log('Button exists:', !!btn);
        if (btn) {
            console.log('Button ID:', btn.id);
            console.log('Button classes:', btn.className);
            console.log('Button listeners:', getEventListeners(btn).click ? 'Yes' : 'No');
        }
        return !!btn;
    },

    /**
     * Check localStorage
     */
    checkStorage() {
        console.log('=== LocalStorage Status ===');
        const theme = localStorage.getItem('hospital-theme-mode');
        console.log('Stored theme:', theme);
        console.log('All localStorage:', localStorage);
        return theme;
    },

    /**
     * Check HTML dark class
     */
    checkDarkClass() {
        console.log('=== HTML Dark Class Status ===');
        const html = document.documentElement;
        console.log('HTML has dark class:', html.classList.contains('dark'));
        console.log('HTML classes:', html.className);
        return html.classList.contains('dark');
    },

    /**
     * Manually toggle theme
     */
    manualToggle() {
        console.log('=== Manual Theme Toggle ===');
        if (window.themeManager) {
            window.themeManager.toggle();
            console.log('Theme toggled to:', window.themeManager.getCurrentTheme());
        } else {
            console.error('Theme manager not available');
        }
    },

    /**
     * Set theme to dark
     */
    setDark() {
        console.log('=== Setting Dark Mode ===');
        if (window.themeManager) {
            window.themeManager.setTheme(true);
            console.log('Dark mode set');
        } else {
            console.error('Theme manager not available');
        }
    },

    /**
     * Set theme to light
     */
    setLight() {
        console.log('=== Setting Light Mode ===');
        if (window.themeManager) {
            window.themeManager.setTheme(false);
            console.log('Light mode set');
        } else {
            console.error('Theme manager not available');
        }
    },

    /**
     * Run all checks
     */
    runAllChecks() {
        console.log('╔════════════════════════════════════════╗');
        console.log('║   THEME SYSTEM DIAGNOSTIC REPORT       ║');
        console.log('╚════════════════════════════════════════╝');
        
        const managerOk = this.checkManager();
        const buttonOk = this.checkButton();
        const storageOk = this.checkStorage();
        const darkClassOk = this.checkDarkClass();

        console.log('\n╔════════════════════════════════════════╗');
        console.log('║   SUMMARY                              ║');
        console.log('╚════════════════════════════════════════╝');
        console.log('Manager OK:', managerOk ? '✓' : '✗');
        console.log('Button OK:', buttonOk ? '✓' : '✗');
        console.log('Storage OK:', storageOk ? '✓' : '✗');
        console.log('Dark Class OK:', darkClassOk ? '✓' : '✗');

        if (managerOk && buttonOk && storageOk) {
            console.log('\n✓ All systems operational!');
        } else {
            console.log('\n✗ Some issues detected. Check above for details.');
        }
    },

    /**
     * Print help
     */
    help() {
        console.log(`
╔════════════════════════════════════════╗
║   THEME DEBUG COMMANDS                 ║
╚════════════════════════════════════════╝

themeDebug.checkManager()    - Check if theme manager is loaded
themeDebug.checkButton()     - Check if toggle button exists
themeDebug.checkStorage()    - Check localStorage
themeDebug.checkDarkClass()  - Check HTML dark class
themeDebug.manualToggle()    - Manually toggle theme
themeDebug.setDark()         - Set dark mode
themeDebug.setLight()        - Set light mode
themeDebug.runAllChecks()    - Run all diagnostic checks
themeDebug.help()            - Show this help message
        `);
    }
};

// Auto-run checks when loaded
console.log('Theme Debug Helper loaded. Run: themeDebug.runAllChecks()');

