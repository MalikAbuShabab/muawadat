@extends('layouts.store', ['title' => ('Forgot Password')])
@section('css')
    <style type="text/css">
        .main-menu .brand-logo {
            display: inline-block;
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .register-page .theme-card .theme-form input {
            margin-bottom: 5px;
        }

        .invalid-feedback {
            display: block;
        }

        .resend-link1 {
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            /* Remove underline */
            font-size: 16px;
            /* Adjust as needed */
            color: #333;
            /* Adjust color */
        }

        .resend-link1::before {
            content: "←";
            margin-right: 0px;
            font-size: 30px;
            color: rgba(1, 81, 88, 1);
        }

        a.resend-link1 {
            color: #000 !important;
        }

        .resend-link1 {
            margin-top: 10px;
            display: block;
            text-align: center;
            color: #004e5a;
        }

        .right-section h2 {
            font-size: 40px;
            font-weight: bold;
            color: #015158;
        }

        .forgot_max h2 {
            margin-bottom: 18px;
            font-family: Poppins !important;
            font-weight: 600 !important;
            font-size: 65.24px !important;
            line-height: 71.77px;
            letter-spacing: -2.17px;
            text-transform: capitalize;
        }

        .forgot_max p {
            color: rgba(82, 82, 91, 1);
            font-family: Poppins;
            font-weight: 500;
            font-size: 18px;
            line-height: 30px;
            letter-spacing: 0px;
            margin-bottom: 38px;
        }

        .forgot_max button.btn.btn-continue {
            margin-top: 38px;
        }

        header,
        footer {
            display: none;
        }

        article#page-container {
            height: auto;
            overflow-y: auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media (max-width:991px) {
            article#page-container {
                align-items: flex-start;
            }


        }
    </style>
    <link rel="stylesheet" href="{{asset('assets/css/intlTelInput.css')}}">
@endsection
@section('content')
    @php
        $getAdditionalPreference = getAdditionalPreference(['is_phone_signup']);
    @endphp
    {{-- <section class="register-page section-b-space fh">
        <div class="container">
            <div class="row">
                <div class="offset-lg-3 col-lg-6">
                    <h3>{{__('Enter Email Address')}}</h3>
                    <div class="card mt-4">
                        <div class="alert alert-success" role="alert" style="display:none;"></div>
                        <form name="register" id="register" action="" class="theme-form" method="post">
                            <div class="form-row mb-3">
                                <div class="col-md-12">
                                    <div class="input-group d-md-flex d-block text-center">
                                        <input type="email" class="form-control text-left mb-0" id="email"
                                            placeholder="{{__('Enter Email')}}" required="" name="email" value="">
                                        <button class="btn btn-solid mx-auto mt-3 mt-md-0" type="button"
                                            id="send_password_reset_link">{{__('Send Password Reset Link')}}</button>
                                    </div>
                                </div>
                                <div class="px-3">
                                    <span class="invalid-feedback" role="alert" id="email_validation_error"></span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <section class="wrapper-main d-flex align-items-center">
        @if (Session::has('error'))
            <div class="alert alert-danger text-center mt-4">
                {{ Session::get('error') }}
            </div>
        @endif
        <div class="container">
            <div class="row align-items-center rounded bg-white" id="login-section">
                @if(@$getAdditionalPreference['is_phone_signup'] != 1)
                    <div class="col-lg-6 muawadat_login_1 text-center p-0">
                        <div class="create_box muawadat_login">
                            <div class="top_text">
                                <h1 class="title">Welcome to <br> Muawadat</h1>
                                <p class="subtitle">Lorem ipsum dolor sit amet consectetur. Lectus libero integer justo nec eget
                                    pharetra dui.</p>
                            </div>
                            <div class="bottom_text">
                                <div class="stars">★★★★★</div>
                                <p class="testimonial">"We love Landingfolio! Our designers were using it for their projects, so
                                    we already knew what kind of design they want."</p>
                                <div class="profile">
                                    <img src="{{ asset('assets/images/dummy_user.png')}}" width="45" height="45"
                                        alt="Devon Lane">
                                    <div class="profile-info">
                                        <strong>Devon Lane</strong><br>
                                        Co-Founder, ABC Company
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div
                    class="col-lg-6 muawadat_login_2 right-section mb-lg-0 mb-3 pb-sm-0 {{(@$getAdditionalPreference['is_phone_signup'] == 1) ? 'offset-lg-3' : '' }}">
                    <div class="max-form">
                        <div class="alert alert-success" role="alert" style="display:none;"></div>
                        <div class="text-left forgot_max">
                            <h2>Forgot
                                <br>Password?
                            </h2>
                        </div>
                        <h5 class="mb-2">
                            {{ __("No worries, well send you reset instructions") }}
                        </h5>

                        <div class="row mt-3 arabic-language">
                            <div class="col-md-12 text-left">
                                <form id="login-form-new" action="">
                                    @csrf
                                    <input type="hidden" name="device_type" value="web">
                                    <input type="hidden" name="device_token" value="web">
                                    <input type="hidden" id="dialCode" name="dialCode"
                                        value="{{ old('dialCode') ? old('dialCode') : Session::get('default_country_phonecode', '1') }}">
                                    <input type="hidden" id="countryData" name="countryData"
                                        value="{{ strtolower(Session::get('default_country_code', 'US')) }}">

                                    <div class="login-with-username">
                                        <div class="form-group">
                                            <label>Email address</label>
                                            <input type="email" class="form-control text-left mb-0" id="username"
                                                placeholder="{{__('Enter Email')}}" required="" name="username" value="">
                                        </div>


                                        <div class="form-group">
                                            <span id="error-msg" class="font-14 text-danger" style="display:none"></span>
                                            <span id="success-msg" class="font-14 text-success" style="display:none"></span>
                                        </div>
                                        <div class="form-group">
                                            <button id="send_password_reset_link_otp"
                                                class="text-white darkgreen btn btn-primary rounded w-100"
                                                type="submit">{{__('Reset Password')}}</button>
                                        </div>

                                        <div class="form-group text-center have_acc">
                                            <a href="{{ url('user/login') }}" class="resend-link1"> Back to Log in</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row justify-content-center" id="verify-phone-section" style="display:none">
                <div class="verify-login-code col-4">
                    <form id="verify-otp-form" class="px-lg-4" action="">
                        <h3 class="mb-2 text-center">{{ __('Verify OTP') }}</h3>
                        <div method="get" class="digit-group otp_inputs d-flex justify-content-between"
                            data-group-name="digits" data-autosubmit="false" autocomplete="off">
                            <input class="form-control" type="text" id="digit-1" name="digit-1" data-next="digit-2"
                                onkeypress="return isNumberKey(event)" />
                            <input class="form-control" type="text" id="digit-2" name="digit-2" data-next="digit-3"
                                data-previous="digit-1" onkeypress="return isNumberKey(event)" />
                            <input class="form-control" type="text" id="digit-3" name="digit-3" data-next="digit-4"
                                data-previous="digit-2" onkeypress="return isNumberKey(event)" />
                            <input class="form-control" type="text" id="digit-4" name="digit-4" data-next="digit-5"
                                data-previous="digit-3" onkeypress="return isNumberKey(event)" />
                            <input class="form-control" type="text" id="digit-5" name="digit-5" data-next="digit-6"
                                data-previous="digit-4" onkeypress="return isNumberKey(event)" />
                            <input class="form-control" type="text" id="digit-6" name="digit-6" data-next="digit-7"
                                data-previous="digit-5" onkeypress="return isNumberKey(event)" />
                        </div>
                        <span
                            class="invalid_phone_otp_error invalid-feedback2 w-100 d-block text-center text-danger"></span>
                        <span id="phone_otp_success_msg" class="font-14 text-success text-center w-100 d-block"
                            style="display:none"></span>
                        <div class="row text-center mt-2">
                            <div class="col-12 resend_txt">
                                <a href="javascript:void(0)" class="mb-2 back-login font-12">
                                    Change Number
                                </a>
                                <p class="mb-1">{{__('If you didn’t receive a code?')}}</p>
                                <a class="verifyPhone" href="javascript:void(0)"><u>{{__('RESEND')}}</u></a>
                            </div>
                            <div class="col-md-12 mt-3">
                                <button type="submit" class="btn btn-solid"
                                    id="verify_phone_token">{{__('VERIFY')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            </form>
        </div>
    </section>
@endsection
@section('script')
    <script type="text/javascript">
        var forgot_password_url = "{{route('customer.forgotPass')}}";
    </script>
    <script src="{{asset('js/forgot_password.js')}}"></script>
    <script type="text/javascript">
        var forgot_password_url = "{{route('customer.forgotPass')}}";
        var forgot_password_otp = "{{route('customer.forgotPass.otp')}}";
    </script>
    <script src="{{asset('js/forgot_password.js')}}"></script>
    <script>
        $('#send_password_reset_link_otp').click(function (e) {
            e.preventDefault();
            var that = $(this);
            var email = $('#username').val();
            $('.invalid-feedback').html('');
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { "email": email },
                url: forgot_password_otp,
                success: function (response) {
                    if (response.status == "Success") {
                        window.location.href = response.redirect;
                        // $('#success-msg').html(res.message).show();
                        // setTimeout(function(){
                        // 	$('#success-msg').html('').hide();
                        // }, 5000);
                    }
                },
                error: function (error) {
                    var response = $.parseJSON(error.responseText);
                    let error_messages = response.errors;
                    $.each(error_messages, function (key, error_message) {
                        $('#error-msg').html(error_message[0]).show();
                    });
                }
            });
        });
    </script>
@endsection