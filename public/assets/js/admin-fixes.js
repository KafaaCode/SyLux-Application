/**
 * Admin Panel JavaScript Fixes
 * Fixes for Bootstrap 4 Tabs and Modals
 */

// Wait for DOM to be ready
$(document).ready(function () {
    console.log('Admin fixes loaded');

    // Initialize tabs
    initializeTabs();

    // Initialize modals
    initializeModals();

    // Initialize tooltips
    initializeTooltips();
});

/**
 * Initialize Bootstrap 4 Tabs
 */
function initializeTabs() {
    console.log('Initializing tabs...');

    // Handle tab clicks
    $('.nav-tabs .nav-link').on('click', function (e) {
        e.preventDefault();

        const target = $(this).attr('href');
        const tabId = target.replace('#', '');

        console.log('Switching to tab:', tabId);

        // Remove active class from all tabs and panes
        $('.nav-tabs .nav-link').removeClass('active');
        $('.tab-content .tab-pane').removeClass('active show').hide();

        // Add active class to clicked tab
        $(this).addClass('active');

        // Show corresponding pane
        $(target).addClass('active show').show();
    });

    // Ensure first tab is active by default
    $('.nav-tabs .nav-link:first').addClass('active');
    $('.tab-content .tab-pane:first').addClass('active show').show();

    console.log('Tabs initialized');
}

/**
 * Initialize Bootstrap 4 Modals
 */
function initializeModals() {
    console.log('Initializing modals...');

    // Initialize all modals
    $('.modal').modal({
        backdrop: true,
        keyboard: true,
        show: false
    });

    // Handle modal events
    $('.modal').on('show.bs.modal', function (e) {
        console.log('Modal opening:', e.target.id);

        // Reset form when opening create modal
        if (e.target.id === 'createCategoryModal') {
            setTimeout(() => {
                resetCreateForm();
            }, 100);
        }
    });

    $('.modal').on('shown.bs.modal', function (e) {
        console.log('Modal shown:', e.target.id);
    });

    $('.modal').on('hidden.bs.modal', function (e) {
        console.log('Modal hidden:', e.target.id);

        // Clean up when modal is closed
        const modal = $(e.target);
        modal.find('form')[0]?.reset();
        modal.find('.image-preview').hide();
        modal.find('.is-invalid').removeClass('is-invalid');
    });

    // Handle modal button clicks
    $('[data-toggle="modal"]').on('click', function (e) {
        e.preventDefault();

        const target = $(this).data('target');
        console.log('Opening modal:', target);

        if (target) {
            $(target).modal('show');
        }
    });

    console.log('Modals initialized. Found', $('.modal').length, 'modals');
}

/**
 * Initialize Bootstrap 4 Tooltips
 */
function initializeTooltips() {
    if (typeof $ !== 'undefined' && $.fn.tooltip) {
        $('[data-toggle="tooltip"]').tooltip();
        console.log('Tooltips initialized');
    }
}

/**
 * Reset create form
 */
function resetCreateForm() {
    const form = document.getElementById('createCategoryForm');
    if (form) {
        form.reset();

        const imagePreview = document.getElementById('createImagePreview');
        if (imagePreview) {
            imagePreview.style.display = 'none';
        }

        // Remove validation classes
        form.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });

        console.log('Form reset completed');
    }
}

/**
 * Switch tab programmatically
 */
function switchTab(locale) {
    console.log('Switching to tab:', locale);

    // Remove active class from all tabs
    $('.nav-link').removeClass('active');
    $('.tab-pane').removeClass('active show').hide();

    // Add active class to clicked tab
    $('#' + locale + '-tab').addClass('active');
    $('#' + locale).addClass('active show').show();
}

/**
 * Test modal functionality
 */
function testModal(modalId = 'createCategoryModal') {
    console.log('Testing modal:', modalId);

    const modal = document.getElementById(modalId);
    if (modal) {
        console.log('Modal found:', modal);

        if (typeof $ !== 'undefined' && $.fn.modal) {
            $('#' + modalId).modal('show');
        } else {
            console.error('Bootstrap modal not available');
        }
    } else {
        console.error('Modal not found:', modalId);
    }
}

/**
 * Test tab functionality
 */
function testTab(tabId = 'en') {
    console.log('Testing tab:', tabId);
    switchTab(tabId);
}

// Make functions available globally
window.switchTab = switchTab;
window.testModal = testModal;
window.testTab = testTab;
window.resetCreateForm = resetCreateForm;

// Debug information
console.log('Admin fixes loaded successfully');
console.log('Available functions: switchTab, testModal, testTab, resetCreateForm');
