<?php
/**
 * Ajax Login
 *
 * @package DiveRaid
 */

defined('ABSPATH') || exit;

add_action('wp_ajax_user_signup', 'userSignUp');
add_action('wp_ajax_nopriv_user_signup', 'userSignUp');

function userSignUp(): void
{
    // Validate signup nonce
    check_ajax_referer('diveraid_signup_nonce', 'security');
    
    // Rate limiting check
    $ip = $_SERVER['REMOTE_ADDR'];
    $transientKey = 'signup_attempts_' . bin2hex($ip);
    $attempts = get_transient($transientKey);
    
    if ( $attempts && $attempts >= 5 ) {
        wp_send_json_error([
            'message' => 'Too many signup attempts. Please try again in 15 minutes.',
        ], 429);
    }
    
    // Validate input and sanitize
    $firstName = sanitize_text_field($_POST['first_name'] ?? '');
    $lastName = sanitize_text_field($_POST['last_name'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $username = sanitize_text_field(strtolower($firstName) . '-' . strtolower($lastName) . '-' . explode('@', $email)[0] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Validation
    $errors = [];
    
    if ( empty($firstName) ) {
        $errors[] = 'First name is required.';
    } elseif ( strlen($firstName) < 2 ) {
        $errors[] = 'First name must be at least 2 characters.';
    } elseif ( ! preg_match("/^[a-zA-Z]*$/", $firstName) ) {
        $errors[] = 'First name contains invalid characters.';
    }
    
    if ( empty($lastName) ) {
        $errors[] = 'Last name is required.';
    } elseif ( strlen($lastName) < 2 ) {
        $errors[] = 'Last name must be at least 2 characters.';
    } elseif ( ! preg_match("/^[a-zA-Z]*$/", $lastName) ) {
        $errors[] = 'Last name contains invalid characters.';
    }
    
    if ( empty($email) ) {
        $errors[] = 'Email is required.';
    } elseif (! filter_var($email, FILTER_VALIDATE_EMAIL) ) {
        $errors[] = 'Email is not a valid email address.';
    } elseif ( email_exists($email) ) {
        $errors[] = 'Email already exists.';
    }
    
    if ( empty($username) ) {
        $errors[] = 'Username is required.';
    } elseif ( strlen($username) < 4 ) {
        $errors[] = 'Username must be at least 4 characters.';
    } elseif ( username_exists($username) ) {
        $errors[] = 'Username already exists.';
    }
    
    if ( empty($password) ) {
        $errors[] = 'Password is required.';
    } elseif ( strlen($password) < 8 ) {
        $errors[] = 'Password must be at least 8 characters.';
    } elseif ( ! preg_match('/[A-Z]/', $password ) ) {
        $errors[] = 'Password must contain at least one uppercase and lowercase letter.';
    } elseif ( ! preg_match('/[a-z]/', $password ) ) {
        $errors[] = 'Password must contain at least one lowercase letter.';
    } elseif ( ! preg_match('/[0-9]/', $password ) ) {
        $errors[] = 'Password must contain at least one number.';
    } elseif ( ! preg_match('/[A-Za-z0-9]/', $password ) ) {
        $errors[] = 'Password must contain at least one uppercase and lowercase letter.';
    }
    
    // Return errors if any
    if ( ! empty($errors) ) {
        // Increment attempts
        set_transient($transientKey, ( $attempts ? $attempts + 1 : 1), 15 * MINUTE_IN_SECONDS);
        
        wp_send_json_error([
            'message' => implode(' ', $errors),
        ], 400);
    }
    
    // Create user
    $userId = wp_create_user($username, $password, $email);
    
    if ( is_wp_error($userId) ) {
        wp_send_json_error([
            'message' => $userId->get_error_message(),
        ], 400);
    }
    
    // Update user meta with first and last name
    wp_update_user([
       'ID' => $userId,
       'first_name' => $firstName,
       'last_name' => $lastName,
       'display_name' => $firstName . ' ' . $lastName,
    ]);
    
    // Set user role
    $user = new WP_User($userId);
    $user->set_role('customer');
    
    // Mark user as unverified
    update_user_meta($userId, 'email_verified', 0);
    
    // Create verification token
    $token = wp_generate_password( 32, false );
    update_user_meta($userId, 'email_verify_token', $token);
    
    // Send verification email
    sendVerificationEmail($userId);
    
    // Clear rate limiting
    delete_transient($transientKey);
    
    // Return
    wp_send_json_success([
        'message' => 'Account created! Please check your email and verify your account before logging in.',
        'redirect' => wc_get_page_permalink('account'),
    ]);
}

function sendVerificationEmail($userId): void
{
    $user = get_userdata($userId);
    if (!$user) return;
    
    $token = get_user_meta($userId, 'email_verify_token', true);
    
    if ( ! $token ) {
        $token = wp_generate_password( 32, false );
        update_user_meta($userId, 'email_verify_token', $token);
    }
    
    $url = add_query_arg([
        'verify_email' => 1,
        'uid' => $userId,
        'token' => $token,
    ], site_url('/'));
    
    $subject = 'Verify your email address';
    $message = "Hello {$user->display_name},\n\nPlease verify your email by clicking the link below:\n\n{$url}\n\nThanks!";
    
    wp_mail($user->user_email, $subject, $message);
}