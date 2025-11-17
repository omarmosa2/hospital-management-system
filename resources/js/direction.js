/**
 * Direction Manager
 * Handles RTL/LTR direction switching based on language
 */

class DirectionManager {
    constructor() {
        this.init();
        this.setupLanguageChangeListener();
    }

    /**
     * Initialize direction based on current locale
     */
    init() {
        this.updateDirection();
        console.log('✓ Direction Manager initialized');
    }

    /**
     * Update document direction based on current HTML dir attribute
     */
    updateDirection() {
        const html = document.documentElement;
        const currentDir = html.getAttribute('dir');
        
        if (currentDir === 'rtl') {
            console.log('➡️ RTL direction applied');
        } else {
            console.log('⬅️ LTR direction applied');
        }

        // Dispatch custom event for other scripts to listen
        window.dispatchEvent(new CustomEvent('directionchange', {
            detail: { direction: currentDir }
        }));
    }

    /**
     * Setup listener for language changes
     */
    setupLanguageChangeListener() {
        // Listen for page navigation (language change causes page reload)
        window.addEventListener('load', () => {
            this.updateDirection();
        });

        // Listen for custom direction change events
        window.addEventListener('directionchange', (e) => {
            console.log('Direction changed to:', e.detail.direction);
        });
    }

    /**
     * Get current direction
     * @returns {string} 'rtl' or 'ltr'
     */
    getCurrentDirection() {
        return document.documentElement.getAttribute('dir') || 'ltr';
    }

    /**
     * Check if current direction is RTL
     * @returns {boolean}
     */
    isRTL() {
        return this.getCurrentDirection() === 'rtl';
    }
}

// Initialize direction manager
window.directionManager = new DirectionManager();

// Make it available globally
window.DirectionManager = DirectionManager;

export default DirectionManager;