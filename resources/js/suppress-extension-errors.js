// Suppress harmless browser extension errors
// These errors are caused by browser extensions (password managers, ad blockers, etc.)
// and don't affect the application functionality

// Override console.error to filter out extension-related errors
const originalError = console.error;
console.error = function(...args) {
    const message = args.join(' ');
    // Filter out Chrome extension errors
    if (message.includes('runtime.lastError') || 
        message.includes('message channel closed') ||
        message.includes('Extension context invalidated') ||
        message.includes('Unchecked runtime.lastError')) {
        return;
    }
    originalError.apply(console, args);
};

// Also suppress errors from window.onerror
const originalOnError = window.onerror;
window.onerror = function(message, source, lineno, colno, error) {
    if (message && (
        message.includes('runtime.lastError') || 
        message.includes('message channel closed') ||
        message.includes('Extension context invalidated')
    )) {
        return true; // Suppress the error
    }
    if (originalOnError) {
        return originalOnError.apply(this, arguments);
    }
    return false;
};

