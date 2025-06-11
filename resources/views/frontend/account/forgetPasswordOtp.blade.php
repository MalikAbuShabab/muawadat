@extends('layouts.store', ['title' => "Forget Password OTP"])

@section('css')
    <style type="text/css">
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

        body {
            height: 100vh;
            align-items: center;
            justify-content: center;
            background-color: #f5f8fa;
        }

        .container-fluid {
            max-width: 1000px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .left-section {
            background-color: #004e5a;
            color: white;
            padding: 40px;
            text-align: center;
        }

        .left-section h1 {
            font-size: 2rem;
            font-weight: bold;
        }

        .left-section p {
            margin-top: 10px;
            font-size: 1rem;
        }

        .rating {
            margin-top: 20px;
        }

        .rating i {
            color: gold;
        }

        .right-section {
            padding: 38px 21px 6px 28px !important;
        }

        .right-section h2 {
            font-size: 40px;
            font-weight: bold;
            color: #015158;
        }

        .right-section p strong {
            color: #015158;
        }

        .otp-input {
            width: 60px;
            height: 50px;
            font-size: 1.5rem;
            text-align: center;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .resend-link strong {
            color: #004e5a;
        }

        a.resend-link1 {
            color: #000 !important;
        }

        .otp-input:focus {
            border-color: #004e5a;
            outline: none;
        }

        .btn-continue {
            background-color: #004e5a;
            color: #76FF5D !important;
            width: 100%;
            margin-top: 20px;
            margin-left: 0;
            padding: 13px;
            border-radius: 10px;
        }

        .right-section {
            padding: 0 6rem !important;
        }

        .btn-continue:hover {
            background-color: #003b44;
        }

        .resend-link {
            margin-top: 10px;
            display: block;
            text-align: center;
            color: #004e5a;
        }

        .resend-link1 {
            margin-top: 10px;
            display: block;
            text-align: center;
            color: #004e5a;
        }

        .forget-password-otp-container {
            margin-top: 57px;
        }

        .otp-form-row {
            margin-left: 0;
            justify-content: center;
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


        .otp-input {
            width: 60px;
            height: 60px;
            font-size: 32px;
            text-align: center;
            border: 2px solid teal;
            border-radius: 10px;
            margin-right: 10px;
            transition: background-color 0.3s ease;
        }

        .otp-input.filled {
            background-color: #015158 !important;
            /* Green */
            color: #fff;
        }
    </style>

    <link rel="stylesheet" href="{{asset('assets/css/intlTelInput.css')}}">
@endsection
@section('content')

    <section class="register-page wrapper-main section-b-spacew ">
        @if (Session::has('error'))
            <div class="alert alert-danger text-center mt-4">
                {{ Session::get('error') }}
            </div>
        @endif
        <div class="alert alert-success text-center mt-4" id="alert-div" style="display: none;">
            <span class="text-success" id="success-msg"></span>
        </div>
        <div class="row otp-form-row my-0">
            <div class="row align-items-center rounded bg-white">
                <!-- Left Section -->
                <div class="col-md-6 muawadat_login_1 left-section p-0">
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
                                <img src="{{ asset('assets/images/dummy_user.png')}}" alt="Devon Lane">
                                <div class="profile-info">
                                    <strong>Devon Lane</strong><br>
                                    Co-Founder, ABC Company
                                </div>
                            </div>
                        </div>
                        {{-- <a href="{{url('auth/twitter')}}"><img class="w-100 vh-100"
                                src="{{asset('assets/img/auth-page.png')}}" alt=""></a> --}}
                    </div>
                </div>

                <!-- Right Section -->

                <div class="col-md-6 muawadat_login_2 right-section">
                    <div class="max-form forgot_max">
                        <h2>Password
                            <br>Reset
                        </h2>
                        <p>We sent a code to <strong>{{ $forgetMail }}</strong></p>
                        <form id="otpForm" action="{{ route('customer.verify.forgotPass.otp') }}" method="POST">
                            @csrf
                            <div class="d-flex justify-content-start">
                                <input type="number" maxlength="1" name="otp_1" class="otp-input" required>
                                <input type="number" maxlength="1" name="otp_2" class="otp-input" required>
                                <input type="number" maxlength="1" name="otp_3" class="otp-input" required>
                                <input type="number" maxlength="1" name="otp_4" class="otp-input" required>
                                <input type="hidden" id="email" name="email" value="{{ $forgetMail }}">
                            </div>
                            <button type="submit" name="verify-otp-submit"
                                class="text-white darkgreen btn btn-primary rounded w-100 btn-continue">Continue</button>
                        </form>
                        <a href="#" class="resend-link" id="resend_password_reset_otp"> Didn't receive an Email ? <strong>
                                Click
                                to Resend </strong></a>

                        <a href="{{ url('user/login') }}" class="resend-link1"> Back to Log in</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
<script type="text/javascript">
    var forgot_password_url = "{{route('customer.forgotPass')}}";
    var forgot_password_otp = "{{route('customer.forgotPass.otp')}}";
</script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
{{--
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script> --}}
<script src="{{asset('js/forgot_password.js')}}"></script>
<script>
    $('#resend_password_reset_otp').click(function () {
        $('.custom_loader').removeClass('d-none');
        var that = $(this);
        var email = $('#email').val();
        $('.invalid-feedback').html('');
        $.ajax({
            type: "POST",
            dataType: "json",
            data: { "email": email },
            url: forgot_password_otp,
            success: function (response) {
                if (response.status == "Success") {
                    $('.custom_loader').addClass('d-none');
                    Swal.fire({
                        title: 'OTP send successfully!',
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonText: 'Ok',
                    });
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
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const inputs = document.querySelectorAll('.otp-input');
        inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                const value = e.target.value;
                // Allow only digits
                if (!/^\d$/.test(value)) {
                    e.target.value = '';
                    return;
                }
                // Move to the next input field if available
                const nextInput = inputs[index + 1];
                if (nextInput) {
                    nextInput.focus();
                }
            });

            input.addEventListener('keydown', (e) => {
                // Handle backspace
                if (e.key === 'Backspace' && !e.target.value) {
                    const prevInput = inputs[index - 1];
                    if (prevInput) {
                        prevInput.focus();
                    }
                }
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.otp-input').forEach((input, index, inputs) => {
            input.addEventListener('input', () => {
                if (input.value.trim() !== '') {
                    input.classList.add('filled');
                    if (inputs[index + 1]) {
                        inputs[index + 1].focus();
                    }
                } else {
                    input.classList.remove('filled');
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && input.value === '' && inputs[index - 1]) {
                    inputs[index - 1].focus();
                }
            });
        });
    });
</script>