<?php
/** 
 * Add additional headers.
 *
 * @package Blockprint
 */

// Add headers
function add_headers() {
    // Strict Transport Security (https://scotthelme.co.uk/hsts-the-missing-link-in-tls)
    header('Strict-Transport-Security: max-age=31536000');

    // X-Frame-Options (https://scotthelme.co.uk/hardening-your-http-response-headers/#x-frame-options)
    header('X-Frame-Options: SAMEORIGIN');

    // X-Content-Type-Options (https://scotthelme.co.uk/hardening-your-http-response-headers/#x-content-type-options)
    header('X-Content-Type-Options: nosniff');

    // Referrer-Policy (https://scotthelme.co.uk/a-new-security-header-referrer-policy)
    header('Referrer-Policy: strict-origin-when-cross-origin');

    // Permissions-Policy (https://scotthelme.co.uk/goodbye-feature-policy-and-hello-permissions-policy)
    // header('Permissions-Policy: geolocation=(self "https://example.com")');
}
add_action( 'send_headers', 'add_headers' );