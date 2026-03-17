<?php
/**
 * Ajax Login
 *
 * @package DiveRaid
 */

defined('ABSPATH') || exit;

add_action('wp_ajax_user_login', 'userLogin');
add_action('wp_ajax_nopriv_user_login', 'userLogin');

function userLogin(): void
{
    if ( ! check_ajax_referer( 'diveraid_login_nonce', 'security', false ) ) {
        wp_send_json_error([
            'message' => 'Security verification failed. Please refresh the page and try again.',
        ], 403);
    }
    
    if (checkLoginRateLimit()) {
        wp_send_json_error([
            'message' => 'Too many login attempts. Please try again in 15 minutes.',
        ], 429);
    }
    
    // Sanitize
    $email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
    $password = $_POST['password'] ?? '';
    
    // Validate
    $validationErrors = validateLoginInput($email, $password);
    if ( ! empty($validationErrors) ) {
        wp_send_json_error([
            'message' => implode(' ', $validationErrors),
        ], 400);
    }
    
    // Get user by email
    $user = get_user_by('email', $email);
    if ( ! $user ) {
        incrementFailedLoginAttempts();
        wp_send_json_error([
            'message' => 'Invalid email or password.',
        ], 401);
    }
    
    // Verify Password
    if ( ! wp_check_password($password, $user->user_pass, $user->ID) ) {
        incrementFailedLoginAttempts();
        
        // Log failed attempt
        logFailedLoginAttempts( $user->ID, $email );
        
        wp_send_json_error([
            'message' => 'Invalid password.',
        ], 401);
    }
    
    // Set authentication
    wp_set_current_user($user->ID);
    wp_set_auth_cookie($user->ID, true, is_ssl());
    
    // Update the user's last login time
    update_user_meta($user->ID, 'last_login', current_time('mysql'));
    update_user_meta($user->ID, 'last_login_ip', getClientIP());
    
    // Clear failed login attempts
    clearFailedLoginAttempts();
    
    // Log successful attempts
    logSuccessfulLogin($user->ID);
    
    // User data response
    $userData = [
        'ID' => $user->ID,
        'display_name' => $user->display_name,
        'email' => $user->user_email,
        'roles' => $user->roles,
    ];
    
    $redirectUrl = getLoginRedirectUrl($user);
    
    wp_send_json_success([
        'message' => 'Logged in successfully. Redirecting...',
        'user' => $userData,
        'redirect' => $redirectUrl,
    ], 200);
}

function validateLoginInput($email, $password): array
{
    $errors = [];
    
    if ( empty($email) ) {
        $errors[] = 'Email is required.';
    } elseif (!is_email($email)) {
        $errors[] = 'Email is not a valid email address.';
    }
    
    if ( empty($password) ) {
        $errors[] = 'Password is required.';
    } elseif ( strlen($password) < 8 ) {
        $errors[] = 'Password must be at least 8 characters long.';
    }
    
    return $errors;
}

function incrementFailedLoginAttempts(): void
{
    $ip = getClientIP();
    $transientKey = 'login_attempts_' . bin2hex($ip);
    $attempts = get_transient($transientKey);
    
    if ( ! $attempts ) {
        $attempts = 0;
    }
    
    $attempts++;
    set_transient( $transientKey, $attempts, 15 * MINUTE_IN_SECONDS );
}

function clearFailedLoginAttempts(): void
{
    $ip = getClientIP();
    $transientKey = 'login_attempts_' . bin2hex($ip);
    delete_transient($transientKey);
}

function logFailedLoginAttempts(int $userId, string $email): void
{
    $logEntry = [
        'user_id' => $userId,
        'email' => $email,
        'ip' => getClientIP(),
        'timestamp' => current_time('mysql'),
        'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field(wp_unslash($_SERVER['HTTP_USER_AGENT'])) : '',
    ];
    
    $failedAttempts = get_user_meta($userId, 'failed_login_attempts', true);
    if ( ! is_array( $failedAttempts ) ) {
        $failedAttempts = [];
    }
    
    $failedAttempts[] = $logEntry;
    
    // Only until the last 10 attempts
    $failedAttempts = array_slice($failedAttempts, -10);
    
    update_user_meta($userId, 'failed_login_attempts', $failedAttempts);
}

function checkLoginRateLimit(): bool
{
    $ip = getClientIP();
    $transientKey = 'login_attempts_' . bin2hex($ip);
    $attempts = get_transient($transientKey);
    
    return $attempts && $attempts >= 5;
}

function getClientIP(): string
{
    $ip = '';
    
    if ( ! empty ( $_SERVER['HTTP_CLIENT_IP'] ) ) {
        $ip = sanitize_text_field( wp_unslash( $_SERVER['HTTP_CLIENT_IP'] ) );
    } elseif ( ! empty ( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
        $ip = sanitize_text_field( wp_unslash( $_SERVER['HTTP_X_FORWARDED_FOR'] ) );
    } else {
        $ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
    }
    
    return filter_var( $ip, FILTER_VALIDATE_IP ) ? $ip : '0.0.0.0';
}

function logSuccessfulLogin(int $userId): void
{
    $logEntry = [
        'user_id' => $userId,
        'ip' => getClientIP(),
        'timestamp' => current_time('mysql'),
        'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field(wp_unslash($_SERVER['HTTP_USER_AGENT'])) : '',
    ];
    
    $loginHistory = get_user_meta($userId, 'login_history', true);
    if ( ! is_array( $loginHistory ) ) {
        $loginHistory = [];
    }
    
    $loginHistory[] = $logEntry;
    
    // Only up to 20 logins
    $loginHistory = array_slice($loginHistory, -20);
    
    update_user_meta($userId, 'login_history', $loginHistory);
}

function getLoginRedirectUrl(WP_User $user): ?string
{
    // Check if redirect parameter was passed
    if ( ! empty( $_POST['redirect_to']) ) {
        $redirect = esc_url_raw( wp_unslash( $_POST['redirect_to'] ) );
        // Ensure redirect is within the site
        if (str_starts_with($redirect, home_url())) {
            return $redirect;
        }
    }
    
    // Role-based redirects
    if ( in_array( 'administrator', $user->roles, true ) ) {
        return admin_url();
    }
    
    return home_url( '/account' );
}