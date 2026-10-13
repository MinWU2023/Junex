<?php

/**
 * Front JS i18n key whitelist.
 * Exported to /front/lang/{locale}.js for window.__() / FrontI18n.t().
 *
 * Custom front JS files that must use __():
 * - public/front/js/i18n.js          (runtime)
 * - public/front/js/main.js          (ajax / toast / attach / prefer)
 * - public/front/js/inquiry-cart.js  (inquiry float / PDP toggle)
 * - public/front/js/pages/home.js    (partners aria-label)
 * - public/front/js/swiper-common.js (nav aria-label)
 * - blade inline scripts under resources/views/front/*
 *
 * Libraries (do NOT wrap): jquery.min.js, swiper-bundle.min.js, tailwindcss.js
 * No user-facing copy: sns-share.js, section-spacing.js
 */
return [
    // Common UI
    'Success',
    'Search...',
    'Loading...',
    'Removing...',
    'Remove',
    'Invalid request.',
    'Request failed.',
    'Partner logos',
    'Previous',
    'Next',
    'Qty:',
    'Review image',
    'Cancel',
    'Confirm',
    'FILE',
    'stars',
    'Previous certificates',
    'Next certificates',
    'Certificate slides',

    // Forms / inquiry
    'Please fill in required fields.',
    'Message successfully!',
    'Submit failed',
    'Please add products to your inquiry list first.',
    'You can upload up to :count files.',
    'Each file must be smaller than 10MB.',
    'Unsupported file type.',
    'Drag & drop files here, or',
    'browse',
    'PDF / Office / Images / ZIP · each ≤ 10MB',
    'Drop files to upload',

    // Network
    'Network error',
    'Network Error',
    'HTTP Error',
    'Invalid JSON response',
    'Timeout',

    // Favorites / inquiry cart
    'Please refresh and try again.',
    'Added to favorites.',
    'Removed from favorites.',
    'Action failed',
    'Added to inquiry list.',
    'Removed from inquiry list.',
    'Add to inquiry',
    'Remove from inquiry',
    'ADD TO INQUIRY',
    'REMOVE FROM INQUIRY',

    // Auth API messages
    'Login successful.',
    'The provided credentials are incorrect.',
    'Registration successful.',
    'If the email exists, reset instructions have been sent.',
];
