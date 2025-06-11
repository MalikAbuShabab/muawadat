@extends('layouts.store', ['title' => 'Register'])
@section('css')
    <style type="text/css">
        .main-menu .brand-logo {
            display: inline-block;
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .productVariants .firstChild {
            min-width: 150px;
            text-align: left !important;
            border-radius: 0% !important;
            margin-right: 10px;
            cursor: default;
            border: none !important;
        }

        .product-right .color-variant li,
        .productVariants .otherChild {
            height: 35px;
            width: 35px;
            border-radius: 50%;
            margin-right: 10px;
            cursor: pointer;
            border: 1px solid #f7f7f7;
            text-align: center;
        }

        .productVariants .otherSize {
            height: auto !important;
            width: auto !important;
            border: none !important;
            border-radius: 0%;
        }

        .product-right .size-box ul li.active {
            background-color: inherit;
        }

        .iti__flag-container li,
        .flag-container li {
            display: block;
        }

        .iti.iti--allow-dropdown,
        .allow-dropdown {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .iti.iti--allow-dropdown .phone,
        .flag-container .phone {
            padding: 17px 0 17px 100px !important;
        }

        .social-logins {
            text-align: center;
        }

        .social-logins img {
            width: 100px;
            height: 100px;
            border-radius: 100%;
            margin-right: 20px;
        }

        .register-page .theme-card .theme-form input {
            margin-bottom: 5px;
        }

        .invalid-feedback {
            display: block;
        }

        .create_box {
            height: auto;
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

    <section class="register-page wrapper-main section-b-spacew">
        @if (Session::has('success'))
            <div class="alert alert-success text-center mt-4">
                {{ Session::get('success') }}
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
                <div class="alert alert-success mt-4" role="alert" style="display:none;"></div>
                <div
                    class="col-lg-6 muawadat_login_2 right-section mb-lg-0 mb-3 pb-sm-0 {{(@$getAdditionalPreference['is_phone_signup'] == 1) ? 'offset-lg-3' : '' }}">
                    <div class="max-form">
                        <div class="text-left forgot_max">
                            <h2>Password
                                <br>Reset
                            </h2>
                        </div>
                        <h5 class="mb-2">
                            {{ __("No worries, well send you reset instructions") }}
                        </h5>

                        <div class="row mt-3 arabic-language">
                            <div class="col-md-12 text-left">
                                <div class="">
                                    <div class="alert alert-success mt-4" role="alert" style="display:none;"></div>
                                    <div class="card-header>{{__('Reset Password')}}</div>
                                                                                                                                            <div class="
                                        card-body">
                                        <form method="POST" id="reset_password_form">
                                            @csrf
                                            <input type="hidden" name="token" value="{{ $token }}">
                                            <div class="form-group position-relative">
                                                <label for="password" class="">{{__('Password')}}</label>
                                                <div class="">
                                                    <input id="password" type="password" class="form-control"
                                                        placeholder="Enter New Password" name="password"
                                                        autocomplete="new-password" id="password">
                                                    <span toggle="#password" class="fa fa-eye-slash toggle-password"
                                                        aria-hidden="true"></span>
                                                    <span class="invalid-feedback" role="alert" id="password_err"></span>

                                                </div>
                                            </div>
                                            <div class="form-group position-relative">
                                                <label for="password-confirm" class="">{{__('Confirm Password')}}</label>
                                                <div class="">
                                                    <input type="password" class="form-control" name="password_confirmation"
                                                        placeholder="Enter Confirm Password" autocomplete="new-password"
                                                        id="password_confirmation">
                                                    <span toggle="#password_confirmation"
                                                        class="fa fa-eye-slash toggle-password" aria-hidden="true"></span>
                                                    <span class="invalid-feedback" role="alert"
                                                        id="password_confirmation_err"></span>
                                                </div>
                                            </div>
                                            <div class="form-group mb-0">
                                                <div class="">
                                                    <button type="button"
                                                        class="text-white darkgreen btn btn-primary rounded w-100"
                                                        id="reset_password_btn">{{__('Reset Password')}}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('script')
    <script type="text/javascript">
        var login_url = "{{url('user/login')}}";
        var reset_password_url = "{{route('reset-password')}}";
    </script>
    <script src="{{asset('js/forgot_password.js')}}"></script>
@endsection