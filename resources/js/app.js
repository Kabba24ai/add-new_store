import './bootstrap';

// Phone number formatting utility
window.formatPhoneNumber = function(input) {
    // Remove all non-digit characters
    let value = input.value.replace(/\D/g, '');
    
    // Format as (XXX) XXX-XXXX
    if (value.length >= 6) {
        value = value.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
    } else if (value.length >= 3) {
        value = value.replace(/(\d{3})(\d{0,3})/, '($1) $2');
    }
    
    input.value = value;
};

// Auto-format phone inputs on page load
document.addEventListener('DOMContentLoaded', function() {
    // Phone number formatting
    const phoneInputs = document.querySelectorAll('input[type="tel"]');
    phoneInputs.forEach(input => {
        input.addEventListener('input', function() {
            window.formatPhoneNumber(this);
        });
    });
    
    // Auto-hide flash messages
    const flashMessages = document.querySelectorAll('[x-data]');
    flashMessages.forEach(message => {
        if (message.getAttribute('x-init')) {
            // Already has Alpine.js handling
            return;
        }
        
        // Fallback for non-Alpine messages
        setTimeout(() => {
            message.style.opacity = '0';
            message.style.transform = 'translateX(100%)';
            setTimeout(() => {
                message.remove();
            }, 300);
        }, 5000);
    });
    
    // Form validation enhancements
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        const inputs = form.querySelectorAll('input, select, textarea');
        
        inputs.forEach(input => {
            // Real-time validation feedback
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            // Clear errors on input
            input.addEventListener('input', function() {
                clearFieldError(this);
            });
        });
    });
});

// Field validation helper
function validateField(field) {
    const value = field.value.trim();
    const fieldName = field.name;
    let isValid = true;
    let errorMessage = '';
    
    // Required field validation
    if (field.hasAttribute('required') && !value) {
        isValid = false;
        errorMessage = `${getFieldLabel(field)} is required.`;
    }
    
    // Email validation
    if (field.type === 'email' && value && !isValidEmail(value)) {
        isValid = false;
        errorMessage = 'Please enter a valid email address.';
    }
    
    // Phone validation
    if (field.type === 'tel' && value && !isValidPhone(value)) {
        isValid = false;
        errorMessage = 'Phone format must be (555) 123-4567.';
    }
    
    // ZIP code validation
    if (fieldName === 'zip' && value && !isValidZip(value)) {
        isValid = false;
        errorMessage = 'ZIP code format must be 12345 or 12345-6789.';
    }
    
    if (!isValid) {
        showFieldError(field, errorMessage);
    } else {
        clearFieldError(field);
    }
    
    return isValid;
}

// Helper functions
function getFieldLabel(field) {
    const label = document.querySelector(`label[for="${field.id}"]`);
    return label ? label.textContent.replace('*', '').trim() : field.name;
}

function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function isValidPhone(phone) {
    return /^\(\d{3}\) \d{3}-\d{4}$/.test(phone);
}

function isValidZip(zip) {
    return /^\d{5}(-\d{4})?$/.test(zip);
}

function showFieldError(field, message) {
    clearFieldError(field);
    
    field.classList.add('border-red-300', 'bg-red-50');
    field.classList.remove('border-gray-300');
    
    const errorElement = document.createElement('p');
    errorElement.className = 'text-sm text-red-600 flex items-center gap-1 mt-1';
    errorElement.innerHTML = `
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
        ${message}
    `;
    
    field.parentNode.appendChild(errorElement);
}

function clearFieldError(field) {
    field.classList.remove('border-red-300', 'bg-red-50');
    field.classList.add('border-gray-300');
    
    const existingError = field.parentNode.querySelector('.text-red-600');
    if (existingError) {
        existingError.remove();
    }
}

// Smooth scroll to top utility
window.scrollToTop = function() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
};

// Confirmation dialog utility
window.confirmAction = function(message, callback) {
    if (confirm(message)) {
        callback();
    }
};