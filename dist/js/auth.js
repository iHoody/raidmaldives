(function($) {
    'use strict';

    let auth = {

        validateEmail: function(email)
        {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(String(email).toLowerCase());
        },

        validatePassword: function(password)
        {
            if (password.length < 8) return false;
            if (!/[A-Z]/.test(password)) return false;
            if (!/[a-z]/.test(password)) return false;
            if (!/[0-9]/.test(password)) return false;
            if (!/[^A-Za-z0-9]/.test(password)) return false;
            return true;
        },

        validateName: function(name)
        {
            return name.length >= 2 && /^[a-zA-Z\s\-']+$/.test(name);
        },

        showError: function(form, message)
        {
            form.find('.form-error').remove();

            const errorHtml = '<div class="form-error">'+message+'</div>';
            form.prepend(errorHtml);

            setTimeout(function() {
                form.find('.form-error', function() {
                    $(this).remove();
                })
            }, 5000);
        },

        showSuccess: function(form, message)
        {
            form.find('.form-error, .form-success').remove();
            const successHtml = '<div class="form-success">'+message+'</div>';
            form.prepend(successHtml);
        },

        signup: function() {
            $('#form-signup').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const submitBtn = form.find('button[type="submit"]');
                const firstName = form.find('input[name="first_name"]').val();
                const lastName = form.find('input[name="last_name"]').val();
                const email = form.find('input[name="email"]').val();
                const password = form.find('input[name="password"]').val();

                // Clear errors
                form.find('.form-error').remove();
                form.find('.input-error').removeClass('input-error');

                // Validation
                let errors = [];

                if (!firstName) {
                    errors.push('First Name is required.');
                    form.find('input[name="first_name"]').addClass('input-error');
                } else if (!auth.validateName(firstName)) {
                    errors.push('First name must be at least 2 characters and contain only letters.');
                    form.find('input[name="first_name"]').addClass('input-error');
                }

                if (!lastName) {
                    errors.push('Last Name is required.');
                    form.find('input[name="last_name"]').addClass('input-error');
                } else if (!auth.validateName(lastName)) {
                    errors.push('Last name must be at least 2 characters and contain only letters.');
                    form.find('input[name="last_name"]').addClass('input-error');
                }

                if (!email) {
                    errors.push('Email is required.');
                    form.find('input[name="email"]').addClass('input-error');
                } else if (!auth.validateEmail(email)) {
                    errors.push('Please enter a valid email address.');
                    form.find('input[name="email"]').addClass('input-error');
                }

                if (!password) {
                    errors.push('Password is required.');
                    form.find('input[name="password"]').addClass('input-error');
                } else if (!auth.validatePassword(password)) {
                    errors.push('Password must be at least 8 characters with uppercase, lowercase, number and special character.');
                    form.find('input[name="password"]').addClass('input-error');
                }

                if (errors.length > 0) {
                    auth.showError(form, errors.join(' '));
                    return false;
                }

                // Disable submit button
                submitBtn.prop('disabled', true).text('Creating account...');

                // Submit Request via ajax
                $.ajax({
                    url: diveraidAuth.ajaxUrl,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'user_signup',
                        security: diveraidAuth.signupNonce,
                        first_name: firstName,
                        last_name: lastName,
                        email: email,
                        password: password
                    },
                    success: function(response) {
                        if (response.success) {
                            auth.showSuccess(form, response.data.message);
                            form[0].reset();

                            setTimeout(function() {
                                window.location.href = response.data.redirect;
                            }, 1500);
                        } else {
                            auth.showError(form, response.data.message || 'Signup failed. Please try again.');
                            submitBtn.prop('disabled', false).text('Sign Up');
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'An error occured. Please try again.';

                        if (xhr.responseJSON && xhr.responseJSON.data && xhr.responseJSON.data.message) {
                            errorMessage = xhr.responseJSON.data.message;
                        } else if (xhr.status === 429) {
                            errorMessage = 'Too many signup attempts. Please try again later.';
                        } else if (xhr.status === 403) {
                            errorMessage = 'Security verification failed. Please refresh the page.';
                        }

                        auth.showError(form, errorMessage);
                        submitBtn.prop('disabled', false).text('Sign Up');
                    }
                });

                return false;
            });
        },

        login: function() {
            $('#form-login').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const submitBtn = form.find('button[type="submit"]');
                const email = form.find('input[name="email"]').val();
                const password = form.find('input[name="password"]').val();

                // Clear errors
                form.find('.form-error').remove();
                form.find('.input-error').removeClass('input-error');

                // Validation
                let hasError = false;

                if (!email) {
                    auth.showError(form, 'Email is required.');
                    form.find('input[name="email"]').addClass('input-error');
                    hasError = true;
                } else if (!auth.validateEmail(email)) {
                    auth.showError(form, 'Please enter a valid email address.');
                    form.find('input[name="email"]').addClass('input-error');
                    hasError = true;
                }

                if (!password) {
                    auth.showError(form, 'Password is required.');
                    form.find('input[name="password"]').addClass('input-error');
                    hasError = true;
                }

                if (hasError) return false;

                submitBtn.prop('disabled', true).text('Logging in...');

                $.ajax({
                    url: diveraidAuth.ajaxUrl,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'user_login',
                        security: diveraidAuth.loginNonce,
                        email: email,
                        password: password
                    },
                    success: function(response) {
                        if (response.success) {
                            auth.showSuccess(form, response.data.message);
                            form[0].reset();

                            setTimeout(function() {
                                window.location.href = response.data.redirect;
                            }, 1500);
                        } else {
                            auth.showError(form, response.data.message || 'Login failed. Please try again.');
                            submitBtn.prop('disabled', false).text('Log In');
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'An error occured. Please try again.';

                        if (xhr.responseJSON && xhr.responseJSON.data && xhr.responseJSON.data.message) {
                            errorMessage = xhr.responseJSON.data.message;
                        } else if (xhr.status === 429) {
                            errorMessage = 'Too many login attempts. Please try again later.';
                        }

                        auth.showError(form, errorMessage);
                        submitBtn.prop('disabled', false).text('Log In');
                    }
                });

                return false;
            });
        },

        init: function() {
            this.signup();
            this.login();
        }
    };

    document.addEventListener('DOMContentLoaded', function () {
        auth.init();
    });

})(jQuery);