@extends('layouts.store', ['title' => 'Identity Verification'])
@section('css')
    <link href="{{asset('assets/libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/dropify/dropify.min.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <style type="text/css">
        .main-menu .brand-logo {
            display: inline-block;
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .custom-verify-btn {
            background-color: #004d40;
            /* Dark green background */
            color: #8dfc03;
            /* Bright neon green text */
            padding: 12px 0;
            width: 100%;
            max-width: 320px;
            border: none;
            font-weight: 600;
            font-size: 16px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .custom-verify-btn:hover {
            background-color: #003a30;
        }

        .invoice_div {
            background-color: rgba(230, 238, 239, 1) !important;
            height: 68px;
            padding: 14px !important;
            border-radius: 8px;
        }
    </style>
    <link rel="stylesheet" href="{{asset('assets/css/intlTelInput.css')}}">
@endsection
@php 
                                            $multiply = session()->get('currencyMultiplier') ?? 1;
    $currencysymbol = session()->get('currencySymbol') . ' '; 
@endphp
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


        .border-dashed {
            border: 2px dashed #ccc;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .btn-darkgreen {
            background-color: #004d40;
            /* Adjust to match the green in the image */
        }

        .upload-box p {
            margin: 0;
            font-size: 14px;
            color: #555;
        }

        .form-control {
            background-color: #f3f6f6;
            border-radius: 10px;
            height: 48px;
            padding-left: 15px;
        }

        .btn:hover {
            background-color: #00665c;
            color: #aaff9c;
        }

        .bg-primary {
            background-color: #015158 !important;
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
                            {{-- @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif --}}
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
                            <div class="page-title mb-4">
                                <h2 class="text-2xl font-bold">{{ __('Money Verification') }}</h2>
                                <p class="text-gray-600 mt-2">Please submit the following documents to process your
                                    application.</p>
                            </div>

                            <div class="mone-wrapper"> <!-- g-3 adds space between items -->
                                @for ($i = 0; $i < 6; $i++)
                                    <div class="mone">
                                        <div class="d-flex align-items-center bg-light  invoice_div">
                                            <!-- Left Icon -->
                                            <div class="bg-primary text-white d-flex align-items-center justify-content-center rounded-circle"
                                                style="width: 40px; height: 40px; margin-right: 10px;">
                                                <i class="bi bi-file-earmark-text" style="font-size: 24px;"></i>
                                                <!-- Bootstrap Icon -->
                                            </div>

                                            <!-- Middle Text -->
                                            <div class="flex-grow-1">
                                                <h6 class="">Invoice.PDF</h6>
                                                <small class="text-muted">1.00 MB</small>
                                            </div>

                                            <!-- Right Download Icon -->
                                            <div class="ms-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 22 20" fill="none">
<path d="M7 6L5 6C2.79086 6 1 7.79086 1 10L1 15C1 17.2091 2.79086 19 5 19L17 19C19.2091 19 21 17.2091 21 15L21 10C21 7.79086 19.2091 6 17 6L15 6" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
<path d="M8 11L10.2929 13.2929C10.6834 13.6834 11.3166 13.6834 11.7071 13.2929L14 11" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
<path d="M11 13L11 1" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
</svg>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>

                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>
@endsection
@section('script')

    <script src="{{asset('assets/libs/dropzone/dropzone.min.js')}}"></script>
    <script src="{{asset('assets/libs/dropify/dropify.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/form-fileuploads.init.js')}}"></script>
    <script src="{{asset('assets/js/intlTelInput.js')}}"></script>
    <script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>

    <script>

        // Show selected file name in the upload-text paragraph
        $('.file-input').on('change', function () {
            var fileName = $(this).val().split('\\').pop(); // Get the file name only
            $(this).closest('.upload-wrapper').find('.upload-text').text(fileName);
        });



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


@endsection