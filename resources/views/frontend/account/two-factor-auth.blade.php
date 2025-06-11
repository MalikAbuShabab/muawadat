@extends('layouts.store', ['title' => 'Two-factor authentication'])

@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/intlTelInput.css')}}">
    <style type="text/css">
        .main-menu .brand-logo {
            display: inline-block;
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .auth-container {
            margin: 0 auto;
            padding: 28px 38px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            min-height: 521px;
        }

        .auth-header {
            margin-bottom: 20px;
        }

        .auth-header h2 {
            color: rgba(34, 34, 34, 1);
            margin: 0 0 12px;
            font-family: Mulish;
            font-weight: 700;
            font-size: 24px;
            line-height: 100%;
            letter-spacing: 1.3%;
            text-transform: inherit;
        }

        .auth-description {
            margin-bottom: 30px;
            color: #555;
        }

        .auth-option {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .auth-option.selected {
            border-color: #015158;
            background-color: rgba(1, 81, 88, 0.05);
        }

        .auth-option-radio {
            margin-right: 15px;
            margin-top: 3px;
        }

        .auth-option-content {
            flex: 1;
        }

        .auth-option-title {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .auth-option-description {
            color: #666;
            font-size: 12px;
        }

        .btn-continue {
            transition: background-color 0.3s;
            color: #76ff5d !important;
            background: #015158;
            padding: 10.5px;
            font-weight: 600;
            font-size: 16px;
            line-height: 28px;
            letter-spacing: -0.2px;
            text-align: center;
            border: none;
            text-transform: capitalize;
            border-radius: 9px !important;
            width: 474px;
        }

        .btn-continue:hover {
            background-color: #013a40;
        }

        /* Custom radio button styling */
        input[type="radio"] {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #015158;
            border-radius: 50%;
            outline: none;
            transition: all 0.2s ease;
        }

        input[type="radio"]:checked {
            background-color: #015158;
            box-shadow: inset 0 0 0 4px white;
        }

        .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            padding: 20px 20px 0;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-title {
            font-weight: 600;
            color: #333;
        }

        #dial_code {
            border-right: none;
            min-width: 120px;
        }

        #phone_number {
            border-left: none;
        }

        .btn-primary {
            padding: 10px 25px;
            font-weight: 500;
        }

        .btn-light {
            background-color: #f8f9fa;
            border-color: #f8f9fa;
            color: #333;
            padding: 10px 25px;
            font-weight: 500;
        }

        .form-control:focus {
            border-color: #015158;
            box-shadow: 0 0 0 0.2rem rgba(1, 81, 88, 0.25);
        }

        .otp-input {
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 20px;
            font-weight: 600;
            margin: 0 5px;
            border-radius: 8px;
            border: 1px solid #ddd;
            background-color: #f5f5f5;
        }

        .otp-input:focus {
            border-color: #015158;
            box-shadow: 0 0 0 0.2rem rgba(1, 81, 88, 0.25);
            background-color: #fff;
        }

        .otp-input.filled {
            background-color: #fff;
        }

        /* Fix for international telephone input */
        .iti {
            width: 100%;
            display: block;
        }

        .iti__flag-container {
            display: flex;

            align-items: center;
        }

        .iti__selected-flag {
            padding: 0 12px;
            display: flex;
            align-items: center;
        }

        .iti__country-list {
            max-height: 200px;
            overflow-y: auto;
        }

        .auth-options {
            display: grid;
            grid-template-columns: 343px 343px;
            gap: 24px;
        }

        /* Ensure the phone input has proper padding for the flag */
        #phone_number {
            padding-left: 90px !important;
        }
    </style>
@endsection
@section('content')
    <section class="section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 mt-4">
                    <div class="text-sm-left">
                        @if (\Session::has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                                <span>{!! \Session::get('success') !!}</span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @if (($errors) && (count($errors) > 0))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
                                <ul class="m-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row my-md-3 mt-5 pt-4">
                <div class="col-lg-3">
                    <div class="account-sidebar"><a class="popup-btn">{{ __('My Account') }}</a></div>
                    @include('layouts.store/profile-sidebar')
                </div>
                <div class="col-lg-9">
                    <div class="dashboard-right">
                        <div class="dashboard">
                            <div class="auth-container">
                                <div class="auth-header">
                                    <h2>Two-factor authentication</h2>
                                </div>
                                <div class="auth-description">
                                    <p>Muawadat requires you to protect your account with 2FA. How would you like to<br>
                                        receive one-time passwords (OTPs)?</p>
                                </div>
                                <form action="{{ route('user.setup-2fa') }}" method="POST">
                                    @csrf
                                    <div class="auth-options">
                                        <div class="auth-option selected">
                                            <input type="radio" name="auth_method" id="mobile_number" value="sms"
                                                class="auth-option-radio" checked>
                                            <div class="auth-option-content">
                                                <div class="auth-option-title">Mobile Number (SMS)</div>
                                                <div class="auth-option-description">Use a mobile Number to generate
                                                    verification codes.</div>
                                            </div>
                                        </div>
                                        <div class="auth-option">
                                            <input type="radio" name="auth_method" id="email" value="email"
                                                class="auth-option-radio">
                                            <div class="auth-option-content">
                                                <div class="auth-option-title">Email</div>
                                                <div class="auth-option-description">Receive Verification codes via email
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <button type="submit" class="btn-continue text-white">Continue</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Two-Factor Authentication Modal -->
    <div class="modal fade" id="twoFactorModal" tabindex="-1" role="dialog" aria-labelledby="twoFactorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="twoFactorModalLabel">Two-factor authentication</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-4">We'll text a verification code to this mobile number whenever you sign in to your
                        account.</p>

                    <form id="phoneVerificationForm" action="{{ route('user.setup-2fa') }}" method="POST">
                        @csrf
                        <input type="hidden" name="auth_method" value="sms">
                        <input type="hidden" name="enable" value="1">

                        {{-- <div class="form-group">
                            <label for="phone_number">Phone Number</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="phone_number" name="phone_number"
                                    placeholder="Enter Phone number" required>
                            </div>
                        </div> --}}
                        <div class="form-group mb-3">
                            <label for="">{{ __('Phone No.') }}</label>
                            <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" id="phone"
                                placeholder="{{ __('Phone No.') }}" name="phone_number" value="{{ old('full_number') }}">

                            <input type="hidden" id="dialCode" name="dialCode"
                                value="{{ old('dialCode') ? old('dialCode') : Session::get('default_country_phonecode', '1') }}">
                            <input type="hidden" id="countryData" name="countryData"
                                value="{{ old('countryData') ? old('countryData') : Session::get('default_country_code', 'US') }}">
                            @error('phone_number')
                                <span class="invalid-feedback" role="alert" style="display:block">
                                    <strong>{{ __($message) }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary btn-continue-sms"
                                style="background-color: #015158; border-color: #015158;">Continue</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SMS OTP Verification Modal -->
    <div class="modal fade" id="otp-verification-modal" tabindex="-1" role="dialog"
        aria-labelledby="otpVerificationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="otpVerificationModalLabel">Two-factor authentication</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-4">Enter the authentication code below we sent to <span id="masked-phone-number">+971 6769
                            535 49</span>.</p>

                    <form id="otpVerificationForm" action="" method="POST">
                        @csrf
                        {{-- <input type="hidden" name="phone_number" id="hidden-phone-number"> --}}
                        <input type="hidden" name="selected_method" id="selected_method" value="sms">
                        <div class="form-group">
                            <div class="d-flex justify-content-between mb-4">
                                <input type="text" class="form-control otp-input otp-input-sms" maxlength="1"
                                    pattern="[0-9]" inputmode="numeric" required>
                                <input type="text" class="form-control otp-input otp-input-sms" maxlength="1"
                                    pattern="[0-9]" inputmode="numeric" required>
                                <input type="text" class="form-control otp-input otp-input-sms" maxlength="1"
                                    pattern="[0-9]" inputmode="numeric" required>
                                <input type="text" class="form-control otp-input otp-input-sms" maxlength="1"
                                    pattern="[0-9]" inputmode="numeric" required>
                                <input type="text" class="form-control otp-input otp-input-sms" maxlength="1"
                                    pattern="[0-9]" inputmode="numeric" required>
                                <input type="text" class="form-control otp-input otp-input-sms" maxlength="1"
                                    pattern="[0-9]" inputmode="numeric" required>
                                <input type="hidden" name="otp_code" id="otp-code-input">
                            </div>
                            <div class="text-right">
                                <a href="#" id="resend-code" class="text-primary">Resend code</a>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-light" data-dismiss="modal"
                                style="border-radius: 4px; padding: 10px 20px;">Cancel</button>
                            <button type="button" class="btn btn-primary verify-otp"
                                style="background-color: #015158; border-color: #015158; border-radius: 4px; padding: 10px 20px;">Verify</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- EMAIL OTP Verification Modal -->
    <div class="modal fade" id="email-otp-verification-modal" tabindex="-1" role="dialog"
        aria-labelledby="otpVerificationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="emailOtpVerificationModalLabel">Two-factor authentication</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-4">Enter the authentication code below we sent to <span
                            id="masked-phone-number">customer@gmail.com</span>.</p>

                    <form id="otpVerificationForm" action="" method="POST">
                        @csrf
                        <input type="hidden" id="selected_method" value="email">
                        <div class="form-group">
                            <div class="d-flex justify-content-between mb-4">
                                <input type="text" class="form-control otp-input otp-input-email" maxlength="1"
                                    pattern="[0-9]" inputmode="numeric" required>
                                <input type="text" class="form-control otp-input otp-input-email" maxlength="1"
                                    pattern="[0-9]" inputmode="numeric" required>
                                <input type="text" class="form-control otp-input otp-input-email" maxlength="1"
                                    pattern="[0-9]" inputmode="numeric" required>
                                <input type="text" class="form-control otp-input otp-input-email" maxlength="1"
                                    pattern="[0-9]" inputmode="numeric" required>
                                <input type="text" class="form-control otp-input otp-input-email" maxlength="1"
                                    pattern="[0-9]" inputmode="numeric" required>
                                <input type="text" class="form-control otp-input otp-input-email" maxlength="1"
                                    pattern="[0-9]" inputmode="numeric" required>
                                <input type="hidden" name="otp_code" id="otp-code-input">
                            </div>
                            <div class="text-right">
                                <a href="#" id="resend-code" class="text-primary">Resend code</a>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-light" data-dismiss="modal"
                                style="border-radius: 4px; padding: 10px 20px;">Cancel</button>
                            <button type="button" class="btn btn-primary verify-otp"
                                style="background-color: #015158; border-color: #015158; border-radius: 4px; padding: 10px 20px;">Verify</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SUCCESS MESSAGE MODAL -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div class="success-icon mb-4">
                        <div
                            style="background-color: #005e63; width: 70px; height: 70px; border-radius: 50%; display: inline-flex; justify-content: center; align-items: center;">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z" fill="white" />
                            </svg>
                        </div>
                    </div>
                    <h4 class="mb-3" style="color: #005e63; font-weight: 600; font-size: 22px;">2FA Successfully enabled
                    </h4>
                    <p class="mb-1" style="color: #666;">Your phone number is set to <span id="success-phone-number"
                            style="font-weight: 500;">+971 6769 53549</span></p>
                    <p style="color: #666;">Authentication codes will be texted to this number for logging in.</p>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script src="{{asset('assets/js/intlTelInput.js')}}"></script>
    <script src="{{asset('js/phone_number_validation.js')}}"></script>
    <script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
    <script>
        $(document).ready(function () {
            $("#success-alert").fadeTo(5000, 500).slideUp(500, function () {
                $("#success-alert").slideUp(500);
            });
            $("#error-alert").fadeTo(5000, 500).slideUp(500, function () {
                $("#error-alert").slideUp(500);
            });
            $('.auth-option-radio').change(function () {
                $('.auth-option').removeClass('selected');
                $(this).closest('.auth-option').addClass('selected');
            });

            $('.btn-continue').click(function (e) {
                e.preventDefault();
                var selectedMethod = $('input[name="auth_method"]:checked').val();

                if (selectedMethod === 'sms') {
                    $('#twoFactorModal').modal('show');
                } else {
                    $('#email-otp-verification-modal').modal('show');
                    $.ajax({
                        url: "{{ route('user.setup-2fa') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            selectedMethod: selectedMethod
                        },
                        // beforeSend: function() {
                        //     // Show loading state
                        //     $('.btn-continue-sms').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...');
                        // },
                        success: function (response) {
                            if (response.success) {


                                // Show the OTP modal
                                // $('#otp-verification-modal').modal('show');

                                // Focus on the first OTP input
                                setTimeout(function () {
                                    $('.otp-input:first').focus();
                                }, 500);
                            } else {
                                // Show error message
                                alert(response.message || 'Failed to send OTP. Please try again.');
                            }
                        },
                        error: function (xhr) {
                            // Show error message
                            var errorMessage = 'Failed to send OTP. Please try again.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            alert(errorMessage);
                        },
                        complete: function () {
                            // Reset button state
                            $('.btn-continue-sms').prop('disabled', false).html('Continue');
                        }
                    });
                }
            });

            // Initialize intlTelInput for phone number field
            var phoneInput = document.querySelector("#phone_number");
            if (phoneInput) {
                var iti = window.intlTelInput(phoneInput, {
                    initialCountry: "ae", // Default to UAE
                    separateDialCode: true,
                    utilsScript: "{{asset('assets/js/utils.js')}}", // Path to utils.js
                    customContainer: "form-control-lg"
                });

                // Update the hidden dial_code field when country changes
                phoneInput.addEventListener("countrychange", function () {
                    var countryData = iti.getSelectedCountryData();
                    document.querySelector("#dial_code").value = "+" + countryData.dialCode;
                });
            }
        });

        // SHOW MODAL TO FILL OTP

        $('.btn-continue-sms').click(function (e) {
            e.preventDefault();
            var selectedMethod = $('input[name="auth_method"]:checked').val();

            if (selectedMethod === 'sms') {
                $('#twoFactorModal').modal('hide');
                var phoneNumber = $('#phone').val();
                var countryCode = $('#dialCode').val();
                var fullPhoneNumber = countryCode + phoneNumber;
                // Send AJAX request to generate and send OTP
                $.ajax({
                    url: "{{ route('user.setup-2fa') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        phone_number: phoneNumber,
                        countryCode: countryCode,
                        fullPhoneNumber: fullPhoneNumber,
                        selectedMethod: selectedMethod
                    },
                    beforeSend: function () {
                        // Show loading state
                        $('.btn-continue-sms').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...');
                    },
                    success: function (response) {
                        if (response.success) {
                            // Close the phone modal and open the OTP modal
                            $('#twoFactorModal').modal('hide');
                            $('#otp-verification-modal form')[0].reset();
                            // Set the phone number in the OTP modal
                            $('#masked-phone-number').text(fullPhoneNumber);
                            $('#hidden-phone-number').val(fullPhoneNumber);

                            // Show the OTP modal
                            $('#otp-verification-modal').modal('show');

                            // Focus on the first OTP input
                            setTimeout(function () {
                                $('.otp-input:first').focus();
                            }, 500);
                        } else {
                            // Show error message
                            alert(response.message || 'Failed to send OTP. Please try again.');
                        }
                    },
                    error: function (xhr) {
                        // Show error message
                        var errorMessage = 'Failed to send OTP. Please try again.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        alert(errorMessage);
                    },
                    complete: function () {
                        // Reset button state
                        $('.btn-continue-sms').prop('disabled', false).html('Continue');
                    }
                });
            } else {
                alert('Server connection error');
            }
        });

        // Initialize intlTelInput for phone number field
        var phoneInput = document.querySelector("#phone_number");
        if (phoneInput) {
            var iti = window.intlTelInput(phoneInput, {
                initialCountry: "ae", // Default to UAE
                separateDialCode: true,
                utilsScript: "{{asset('assets/js/utils.js')}}", // Path to utils.js
                customContainer: "form-control-lg"
            });
        }

        // Initially disable the continue button
        $('.btn-continue-sms').prop('disabled', true);

        // Add input event listener to phone field
        $('#phone').on('input change', function () {
            validatePhoneAndToggleButton();
        });

        // Also validate when country changes
        $('#phone').on('countrychange', function () {
            validatePhoneAndToggleButton();
        });

        function validatePhoneAndToggleButton() {
            var phoneNumber = $('#phone').val();

            // Check if phone is valid
            if (phoneNumber && iti.isValidNumber()) {
                // Valid phone number - enable button
                $('.btn-continue-sms').prop('disabled', false);
                $('#phone').removeClass('is-invalid');
                $('.phone-error-message').remove();
            } else {
                // Invalid phone number - disable button
                $('.btn-continue-sms').prop('disabled', true);

                // Only show error message if there's some input
                if (phoneNumber) {
                    $('#phone').addClass('is-invalid');
                    if (!$('.phone-error-message').length) {
                        $('<div class="invalid-feedback phone-error-message">Please enter a valid phone number for the selected country.</div>').insertAfter('#phone');
                    }
                }
            }
        }

        // Show OTP modal after phone verification
        $('.btn-continue-sms').click(function (e) {
            e.preventDefault();

            var phoneNumber = $('#phone').val();

            // Double-check validation before proceeding
            if (!phoneNumber || !iti.isValidNumber()) {
                $('#phone').addClass('is-invalid');
                // Add error message
                if (!$('.phone-error-message').length) {
                    $('<div class="invalid-feedback phone-error-message">Please enter a valid phone number for the selected country.</div>').insertAfter('#phone');
                }
                return false;
            }

            // Format phone number for display
            var formattedNumber = iti.getNumber();

            // Set the phone number in the OTP modal
            $('#masked-phone-number').text(formattedNumber);
            $('#hidden-phone-number').val(formattedNumber);

            // Close the phone modal and open the OTP modal
            $('#twoFactorModal').modal('hide');
            $('#otp-verification-modal form')[0].reset();
            $('#otp-verification-modal').modal('show');

            // Focus on the first OTP input
            setTimeout(function () {
                $('.otp-input:first').focus();
            }, 500);
        });

        // Handle OTP input
        $(document).on('input', '.otp-input', function () {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));

            if ($(this).val()) {
                $(this).addClass('filled');
                // Move to next input
                $(this).next('.otp-input').focus();
            } else {
                $(this).removeClass('filled');
            }

            // Combine all inputs into the hidden field
            updateOtpValue();
        });

        // Handle backspace
        $(document).on('keydown', '.otp-input', function (e) {
            if (e.keyCode === 8 && !$(this).val()) {
                // Move to previous input on backspace if current is empty
                $(this).prev('.otp-input').focus().val('').removeClass('filled');
                updateOtpValue();
            }
        });

        // Update the hidden OTP input with combined values
        function updateOtpValue() {
            var otp = '';
            $('.otp-input').each(function () {
                otp += $(this).val();
            });
            $('#otp-code-input').val(otp);
        }

        // Handle resend code
        $('#resend-code').click(function (e) {
            e.preventDefault();

            // Add your resend code logic here
            // For example, an AJAX call to resend the OTP

            // Show a message that code was resent
            $(this).text('Code resent');
            setTimeout(function () {
                $('#resend-code').text('Resend code');
            }, 5000);
        });

        // Handle OTP verification when the verify-otp button is clicked
        $(document).on('click', '.verify-otp', function (e) {
            e.preventDefault();

            // Collect all OTP digits
            var otp = '';
            var selectedAuth = $('input[name="auth_method"]:checked').val();

            if (selectedAuth == 'sms') {
                $('.otp-input-sms').each(function () {
                    otp += $(this).val();
                });
            } else if (selectedAuth == 'email') {
                $('.otp-input-email').each(function () {
                    otp += $(this).val();
                });
            }

            if (otp.length !== 6 || !/^\d+$/.test(otp)) {
                alert('Please enter a valid 6-digit OTP');
                return false;
            }

            // Set up CSRF token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Send AJAX request to verify OTP
            alert
            $.ajax({
                url: "{{ route('user.verify-2fa-otp') }}",
                type: "POST",
                data: {
                    selectedAuth: selectedAuth,
                    otp: otp
                },
                beforeSend: function () {
                    // Show loading state
                    $('.verify-otp').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Verifying...');
                },
                success: function (response) {
                    $('.verify-otp').prop('disabled', false).html('Verify OTP');

                    if (response.success) {
                        $('#otp-verification-modal').modal('hide');
                    } else {
                        alert(response.message || 'Invalid OTP. Please try again.');
                        $('.otp-input').val('').removeClass('filled');
                        $('.otp-input:first').focus();
                    }
                },
                error: function (xhr) {
                    $('.verify-otp').prop('disabled', false).html('Verify OTP');
                    alert('Something went wrong! Please try again.');
                }
            });
        });

    </script>

    <script>
        jQuery(window.document).ready(function () {
            jQuery("body").addClass("register_body");
        });
        jQuery(document).ready(function ($) {
            setTimeout(function () {
                var footer_height = $('.footer-light').height();
                console.log(footer_height);
                $('article#content-wrap').css('padding-bottom', footer_height);
            }, 500);
            setTimeout(function () {
                $("#phone").val({{ old('phone_number') }});
            }, 2500);
        });
        var input = document.querySelector("#phone");
        var iti = window.intlTelInput(input, {
            separateDialCode: true,
            hiddenInput: "full_number",
            utilsScript: "{{ asset('assets/js/utils.js') }}",
            initialCountry: "{{ Session::get('default_country_code', 'US') }}",
        });

        phoneNumbervalidation(iti, input);

        $(document).ready(function () {
            $("#phone").keypress(function (e) {
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
                return true;
            });
        });
        $('.iti__country').click(function () {
            var code = $(this).attr('data-country-code');
            $('#countryData').val(code);
            var dial_code = $(this).attr('data-dial-code');
            $('#dialCode').val(dial_code);
        });
        $(document).on('change', '[id^=input_file_logo_]', function (event) {
            var rel = $(this).data('rel');
            // $('#plus_icon_'+rel).hide();
            readURL(this, '#upload_logo_preview_' + rel);
        });

        function getExtension(filename) {
            return filename.split('.').pop().toLowerCase();
        }

        function readURL(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                var extension = getExtension(input.files[0].name);
                reader.onload = function (e) {
                    if (extension == 'pdf') {
                        $(previewId).attr('src', "{{ asset('assets/images/pdf-icon-png-2072.png') }}");
                    } else if (extension == 'csv') {
                        $(previewId).attr('src', text_image);
                    } else if (extension == 'txt') {
                        $(previewId).attr('src', text_image);
                    } else if (extension == 'xls') {
                        $(previewId).attr('src', text_image);
                    } else if (extension == 'xlsx') {
                        $(previewId).attr('src', text_image);
                    } else {
                        $(previewId).attr('src', e.target.result);
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

@endsection