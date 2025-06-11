@extends('layouts.store', ['title' => 'My Profile'])
@section('css')
    <link href="{{asset('assets/libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/dropify/dropify.min.css')}}" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <style type="text/css">
        .main-menu .brand-logo {
            display: inline-block;
            padding-top: 20px;
            padding-bottom: 20px;
        }
    </style>
    <link rel="stylesheet" href="{{asset('assets/css/intlTelInput.css')}}">
@endsection
@section('content')

    <style type="text/css">
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

        .login-page .theme-card .theme-form input {
            margin-bottom: 5px;
        }

        .errors {
            color: #F00;
            background-color: #FFF;
        }

        .invalid-feedback {
            display: block;
        }

        .card-box {
            border: 1px solid #e3e6f0;
            border-radius: 10px;
            padding: 20px;
            background-color: #ffffff;
        }

        .info-text label {
            font-size: 16px;
            font-weight: 600;
            color: #015158;
            /* Custom dark blue color */
        }

        .info-text p {
            font-size: 15px;
            color: #333;
            margin: 5px 0 0;
        }

        .email-link {
            font-size: 15px;
            font-weight: bold;
            color: #d35400;
            /* Attractive email color */
            text-decoration: none;
            transition: color 0.3s ease-in-out;
        }

        .email-link:hover {
            color: #e74c3c;
            /* Change color on hover */
        }

        .highlighted-link {
            font-size: 15px;
            font-weight: bold;
            color: #015158 !important;
            /* Distinct email/web link color */
            text-decoration: underline !important;
            /* Ensures visibility */
            transition: color 0.3s ease-in-out;
        }

        .highlighted-link:hover {
            color: #e74c3c;
            /* Changes color on hover for better interactivity */
        }

        .btn-solid:hover {
            background-color: #000 !important;
            color: #fff !important;
        }

        .alert {
            position: relative;
            padding: 1rem 1.5rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: .25rem;
        }

        .alert-dismissible .close {
            position: absolute;
            top: 0;
            right: 0;
            padding: .75rem 1.25rem;
            color: inherit;
            cursor: pointer;
        }

        .fade {
            transition: opacity .15s linear;
        }

        .fade.show {
            opacity: 1;
        }
    </style>

    <section class="section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 mt-4">
                    <div class="text-sm-left">
                        <h5 class="my-accout-heading">My Account</h5>
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
            <div class="row">
                <div class="col-lg-3">
                    <div class="account-sidebar"><a class="popup-btn">{{ __('My Account') }}</a></div>
                    @include('layouts.store/profile-sidebar')
                </div>
                <div class="col-lg-9">
                    <div class="dashboard-right">
                        <div class="dashboard myacc">
                            <div class="page-title">
                                <h2>{{ __('My Profile') }}</h2>
                            </div>
                            <div class="card-box">
                                <div class="row align-items-center">
                                    <div class="col-sm-6 d-flex align-items-center">
                                        <div class="file file--upload">
                                            <label>
                                                <span class="update_pic">
                                                    <img src="{{$user->image['proxy_url'] . '1000/1000' . $user->image['image_path']}}"
                                                        alt="">
                                                </span>
                                            </label>
                                        </div>
                                        <div class="name_location">
                                            <h5 class="mt-0 mb-1">{{$user->name}}</h5>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 text-right mt-0 mt-md-0">
                                        <button type="button"
                                            class="btn btn-solid darkgreen rounded openProfileModal">{{ __('Edit Profile') }}</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-box">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h4 class="m-0">{{ __('About Me') }}</h4>
                                </div>
                                <div class="text-16">
                                    <p class="m-0">{{$user->description}}</p>
                                </div>
                            </div>
                            <hr class="mt-2">
                            {{-- <div class="row welcome-msg justify-content-between">
                                <div class="col-12">
                                    <h4 class="d-inline-block m-0">
                                        <span>{{ __('Your ') }} {{__(getNomenclatureName('Referral Code'))}}:
                                            {{(isset($userRefferal['refferal_code'])) ? $userRefferal['refferal_code'] :
                                            ''}}</span>
                                    </h4>
                                    <sup class="position-relative">
                                        <a class="copy-icon ml-2" id="copy_icon"
                                            data-url="{{url('/'.'?ref=')}}{{(isset($userRefferal['refferal_code'])) ? $userRefferal['refferal_code'] : ''}}"
                                            style="cursor:pointer;">
                                            <i class="fa fa-copy"></i>
                                        </a>
                                        <p id="copy_message" class="copy-message"></p>
                                    </sup>
                                </div>
                            </div> --}}
                            <div class="row mt-3 profile-page">
                                <div class="col-lg-6">
                                    <div class="card-box p-4 shadow-sm rounded bg-white">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="info-text mb-3">
                                                    <label class="m-0 text-primary fw-bold">{{ __('Name :') }}</label>
                                                    <p class="text-dark">{{ $user->name }}</p>
                                                </div>

                                                <div class="info-text mb-3">
                                                    <label class="m-0 text-primary fw-bold">{{ __('Email :') }}</label>
                                                    <p>
                                                        <a href="mailto:{{$user->email}}"
                                                            class="email-link highlighted-link">{{ $user->email }}</a>
                                                    </p>
                                                </div>

                                                <div class="info-text mb-3">
                                                    <label
                                                        class="m-0 text-primary fw-bold">{{ __('Phone Number :') }}</label>
                                                    <p class="text-dark">
                                                        {{ '+' . $user->dial_code . ' ' . $user->phone_number }}
                                                    </p>
                                                </div>

                                                <div class="info-text mb-3">
                                                    <form method="post" action="{{ route('user.updateTimezone') }}"
                                                        id="user_timezone_form">
                                                        @csrf
                                                        <label class="mb-1">
                                                            <h4 class="text-dark fw-bold">{{ __('Time Zone') }}</h4>
                                                        </label>
                                                        {!! $timezone_list !!}
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade edit_profile_modal" id="profile-modal" tabindex="-1" aria-labelledby="profile-modalLabel"
        data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title" id="profile-modalLabel">{{ __('Edit Profile') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editProfileForm" method="post" action="{{route('user.updateAccount')}}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body" id="editProfileBox">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-solid w-100 darkgreen rounded">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')

    <script src="{{asset('assets/libs/dropzone/dropzone.min.js')}}"></script>
    <script src="{{asset('assets/libs/dropify/dropify.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/form-fileuploads.init.js')}}"></script>
    <script src="{{asset('assets/js/intlTelInput.js')}}"></script>
    <script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>

    <script>
        // Auto hide success message after 5 seconds
        $(document).ready(function () {
            // Success alert
            $("#success-alert").fadeTo(5000, 500).slideUp(500, function () {
                $("#success-alert").slideUp(500);
            });

            // Error alert
            $("#error-alert").fadeTo(5000, 500).slideUp(500, function () {
                $("#error-alert").slideUp(500);
            });
        });
    </script>

    <script type="text/javascript">
        var ajaxCall = 'ToCancelPrevReq';
        $('.verifyEmail').click(function () {
            verifyUser('email');
        });
        $('.verifyPhone').click(function () {
            verifyUser('phone');
        });
        function verifyUser($type = 'email') {
            ajaxCall = $.ajax({
                type: "post",
                dataType: "json",
                url: "{{ route('verifyInformation', Auth::user()->id) }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "type": $type,
                },
                beforeSend: function () {
                    if (ajaxCall != 'ToCancelPrevReq' && ajaxCall.readyState < 4) {
                        ajaxCall.abort();
                    }
                },
                success: function (response) {
                    var res = response.result;
                },
                error: function (data) { },
            });
        }

        $(document).ready(function () {
            jQuery.validator.addMethod("alphanumeric", function (value, element) {
                return this.optional(element) || /^[a-zA-Z0-9 ]+$/i.test(value);
            }, "Name should contains alphanumeric data.");
            $("#editProfileForm").validate({
                errorClass: 'errors',
                rules: {
                    name: {
                        required: true,
                        minlength: 3,
                        alphanumeric: true
                    },
                    phone_number: {
                        required: true,
                        number: true,
                        minlength: 7,
                        maxlength: 15,
                        regex: /^[1-9][0-9]*$/
                    },
                    email: {
                        required: true,
                        email: true
                    }
                },
                onfocusout: function (element) {
                    this.element(element); // triggers validation
                },
                onkeyup: function (element, event) {
                    this.element(element); // triggers validation
                },
                messages: {
                    name: {
                        required: "{{ __('Please enter your name')}}",
                        minlength: "{{__('The name must be at least 3 characters.')}}",
                        alphanumeric: "{{ __('Name should contains alphanumeric data')}}"
                    },
                    phone_number: {
                        required: "{{ __('Please enter your phone')}}",
                        number: "{{ __('Please enter a numerical value')}}",
                        minlength: "{{ __('minimum 7 digits allowed')}}",
                        maxlength: "{{ __('maximum 15 digits required')}}"
                    },
                    email: "{{ __('The email should be in the format:')}} abc@domain.tld",
                }
            });

            $("#editProfileForm").submit(function () {
                if ($("#phone").hasClass("is-invalid")) {
                    $("#phone").focus();
                    return false;
                }
            });
        });


        $(".openProfileModal").click(function (e) {
            e.preventDefault();
            var uri = "{{route('user.editAccount')}}";
            $.ajax({
                type: "get",
                url: uri,
                data: '',
                dataType: 'json',
                success: function (data) {
                    $('#editProfileForm #editProfileBox').html(data.html);
                    $('#profile-modal').modal('show');
                    var input = document.querySelector("#phone");
                    window.intlTelInput(input, {
                        separateDialCode: true,
                        hiddenInput: "full_number",
                        utilsScript: "{{asset('assets/js/utils.js')}}",
                        initialCountry: "{{ Session::get('default_country_code', 'US') }}",
                    });
                    // Initialize Dropify
                    var drEvent = $('.dropify').dropify();

                    drEvent.on('dropify.beforeClear', function (event, element) {
                        return confirm("Are you sure you want to remove this image?");
                    });

                    // Set up the event listener for afterClear
                    drEvent.on('dropify.afterClear', function (event, element) {
                        var removeUri = "{{route('user.removeProfileImage')}}"; // Define the route for removing the image
                        $.ajax({
                            type: "POST",
                            url: removeUri,
                            data: {
                                _token: "{{ csrf_token() }}", // Include CSRF token for security
                                user_id: "{{ $user->id }}" // Pass any necessary data
                            },
                            success: function (response) {
                                console.log("Profile image removed successfully.");
                            },
                            error: function (response) {
                                alert("An error occurred while removing the profile image.");
                            }
                        });
                    });
                },
                error: function (data) {
                }
            });
        });

        $("#timezone").change(function () {
            $("#user_timezone_form").submit();
        });
        $("#copy_icon").click(function () {
            var temp = $("<input>");
            var url = $(this).data('url');
            $("body").append(temp);
            temp.val(url).select();
            document.execCommand("copy");
            temp.remove();
            $("#copy_message").text("{{ __('URL Copied!') }}").show();
            setTimeout(function () {
                $("#copy_message").text('').hide();
            }, 3000);
        });
    </script>
    <script>
        var loadFile = function (event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>
    <script>
        $(document).ready(function () {
            $("#phone").keypress(function (e) {
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
                return true;
            });
        });
        $(document).delegate('.iti__country', 'click', function () {
            var code = $(this).attr('data-country-code');
            $('#countryData').val(code);
            var dial_code = $(this).attr('data-dial-code');
            $('#dialCode').val(dial_code);
        });


        $('.modal .close').on('click', function () {
            $(this).closest('.modal').modal('hide');
        });
    </script>
@endsection