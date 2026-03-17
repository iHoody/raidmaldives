<?php
/**
 * Template Name: Login Template
 *
 * @package DiveRaid
 */
 
$banner = get_field('banner');
$bannerBackground = $banner['background_image'];
get_header();
?>
    
    <div class="site-content">
        
        <section class="login-banner site-banner" style="background-image: url('<?= esc_attr($bannerBackground) ?>');">
            <div class="site-banner__container container login-container">
                <div class="site-information">
                    <h3 class="banner-title"><?= esc_attr(get_the_title()) ?></h3>
                </div>
            </div>
        </section>
        
        <section class="login-section">
            <div class="container">
                
                <div class="auth-register">
                    <h2>Sign Up</h2>
                    <form id="form-signup" method="post" novalidate>
                        
                        <div class="form-element form-stack">
                            <label for="first-name" class="form-label">First Name <span class="required">*</span></label>
                            <input type="text" id="first-name" name="first_name" value="" placeholder="First Name" required autocomplete="given-name" />
                        </div>
                        
                        <div class="form-element form-stack">
                            <label for="last-name" class="form-label">Last Name <span class="required">*</span></label>
                            <input type="text" id="last-name" name="last_name" value="" placeholder="Last Name" required autocomplete="family-name" />
                        </div>
                        
                        <div class="form-element form-stack">
                            <label for="email" class="form-label">Email <span class="required">*</span></label>
                            <input type="email" id="email" name="email" value="" placeholder="Email" required autocomplete="email" />
                        </div>
                        
                        <div class="form-element form-stack">
                            <label for="password" class="form-label">Password <span class="required">*</span></label>
                            <input type="password" id="password" name="password" value="" placeholder="Password" required autocomplete="new-password" />
                            <small class="password-hint">Minimum of 8 characters, include uppercase, lowercase, number & special character.</small>
                        </div>
                        
                        <div class="form-element form-submit">
                            <button id="signup" class="signup" type="submit" name="signup">Sign Up</button>
                        </div>
                    
                    </form>
                </div>
                
                <div class="auth-login">
                    <h2>Login</h2>
                    <form id="form-login" method="post" novalidate>
                        
                        <div class="form-element form-stack">
                            <label for="email-login" class="form-label">Email <span class="required">*</span></label>
                            <input type="email" id="email-login" name="email" value="" placeholder="Email" required autocomplete="email" />
                        </div>
                        
                        <div class="form-element form-stack">
                            <label for="password-login" class="form-label">Password <span class="required">*</span></label>
                            <input type="password" id="password-login" name="password" value="" placeholder="Password" required autocomplete="new-password" />
                        </div>
                        
                        <div class="form-element form-submit">
                            <button id="login" class="login">Log In</button>
                        </div>
                    
                    </form>
                </div>
                
            </div>
        </section>
    
    </div>

<?php
    get_footer();
