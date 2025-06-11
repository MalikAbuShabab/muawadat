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
                                <h2>{{ __('Identity Verification') }}</h2>
                            </div>
                                                      
                            <p>Please submit the following documents to process your application.</p>
                            <form action="{{ route('user.identity-proof-store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row mt-3 profile-page pro-file">
                                    <div class="col-md-6 col-lg-5">

                                        <label class="d-block text-start">Front Side</label>
                                        <div class="card-box p-4 shadow-sm rounded bg-white text-center border-dashed-box">
                                            @foreach($vendor_docs as $doc)
                                                @if(!empty($doc->image_file['storage_url']) && $doc->file_type == 1)
                                                    <div
                                                        style="margin-bottom: 20px; width: 190px; height: 120px; display: flex; align-items: center; justify-content: center; overflow: hidden; margin-left: auto; margin-right: auto;">
                                                        <img src="{{ $doc->image_file['storage_url'] }}" alt="Document Image"
                                                            style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                                                    </div>
                                                    @if(Auth::user()->front_identity_doc_verified == 1)
                                                        <!-- Verified Icon -->
                                                        <div class="position-absolute top-0 end-0 m-2"
                                                            style="background-color: #28a745; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;"
                                                            title="Verified">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="white" viewBox="0 0 16 16">
                                                                <path d="M13.485 1.929a.75.75 0 0 1 1.06 1.06l-8 8a.75.75 0 0 1-1.06 0l-4-4a.75.75 0 1 1 1.06-1.06L6 9.439l7.485-7.51z"/>
                                                            </svg>
                                                        </div>
                                                    @else
                                                        <!-- Waiting for Verification Icon -->
                                                        <div class="position-absolute top-0 end-0 m-2"
                                                            style="background-color: #ffc107; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;"
                                                            title="Waiting for verification">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="white" viewBox="0 0 16 16">
                                                                <path d="M8 3.5a.5.5 0 01.5.5v3.25l2.25 1.35a.5.5 0 01-.5.866l-2.5-1.5A.5.5 0 017.5 7V4a.5.5 0 01.5-.5z"/>
                                                                <path d="M8 16A8 8 0 108 0a8 8 0 000 16zM1 8a7 7 0 1114 0A7 7 0 011 8z"/>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                @endif
                                            @endforeach

                                            <div class="upload-wrapper position-relative">
                                                <input type="file" name="front_side" class="file-input" />
                                                <div class="upload-content">

                                                    <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M12.4992 12.0002V21.0002M12.4992 12.0002L9.99923 14.0002M12.4992 12.0002L14.9992 14.0002M5.53323 9.11719C4.58744 9.35518 3.76111 9.93035 3.20948 10.7346C2.65786 11.5389 2.41891 12.5169 2.53754 13.485C2.65616 14.453 3.12419 15.3444 3.85369 15.9917C4.5832 16.639 5.52396 16.9976 6.49923 17.0002H7.49923"
                                                            stroke="#015158" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                        <path
                                                            d="M16.3287 7.13821C15.9869 5.78478 15.1433 4.61195 13.9688 3.85746C12.7944 3.10298 11.377 2.8233 10.004 3.07511C8.63093 3.32692 7.40503 4.09139 6.57476 5.21354C5.74448 6.3357 5.37195 7.73157 5.53269 9.11821C5.53269 9.11821 5.68569 10.0002 5.99869 10.5002"
                                                            stroke="#015158" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                        <path
                                                            d="M17.5 17C18.206 16.9995 18.904 16.8495 19.5479 16.5599C20.1917 16.2702 20.767 15.8475 21.2357 15.3195C21.7045 14.7915 22.0561 14.1702 22.2674 13.4965C22.4787 12.8229 22.545 12.1121 22.4618 11.4109C22.3786 10.7098 22.1479 10.0343 21.7848 9.42874C21.4217 8.82321 20.9345 8.30145 20.3552 7.89778C19.776 7.49412 19.1178 7.21772 18.424 7.08676C17.7302 6.9558 17.0166 6.97327 16.33 7.138L15 7.5"
                                                            stroke="#015158" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </svg>

                                                    <p class="upload-text">Browse and choose the files you want to<br>
                                                        upload from your computer</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-5">
                                        <label class="d-block text-start">Back Side</label>
                                        <div class="card-box p-4 shadow-sm rounded bg-white text-center border-dashed-box">
                                            @foreach($vendor_docs as $doc)
                                                @if(!empty($doc->image_file['storage_url']) && $doc->file_type == 2)
                                                    <div
                                                        style="margin-bottom: 20px; width: 190px; height: 120px; display: flex; align-items: center; justify-content: center; overflow: hidden; margin-left: auto; margin-right: auto;">
                                                        <img src="{{ $doc->image_file['storage_url'] }}" alt="Document Image"
                                                            style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                                                    </div>
                                                    @if(Auth::user()->back_identity_doc_verified == 1)
                                                        <!-- Verified Icon -->
                                                        <div class="position-absolute top-0 end-0 m-2"
                                                            style="background-color: #28a745; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;"
                                                            title="Verified">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="white" viewBox="0 0 16 16">
                                                                <path d="M13.485 1.929a.75.75 0 0 1 1.06 1.06l-8 8a.75.75 0 0 1-1.06 0l-4-4a.75.75 0 1 1 1.06-1.06L6 9.439l7.485-7.51z"/>
                                                            </svg>
                                                        </div>
                                                    @else
                                                        <!-- Waiting for Verification Icon -->
                                                        <div class="position-absolute top-0 end-0 m-2"
                                                            style="background-color: #ffc107; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;"
                                                            title="Waiting for verification">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="white" viewBox="0 0 16 16">
                                                                <path d="M8 3.5a.5.5 0 01.5.5v3.25l2.25 1.35a.5.5 0 01-.5.866l-2.5-1.5A.5.5 0 017.5 7V4a.5.5 0 01.5-.5z"/>
                                                                <path d="M8 16A8 8 0 108 0a8 8 0 000 16zM1 8a7 7 0 1114 0A7 7 0 011 8z"/>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                @endif
                                            @endforeach
                                            <div class="upload-wrapper position-relative">
                                                <input type="file" name="back_side" class="file-input" />
                                                <div class="upload-content">

                                                    <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M12.4992 12.0002V21.0002M12.4992 12.0002L9.99923 14.0002M12.4992 12.0002L14.9992 14.0002M5.53323 9.11719C4.58744 9.35518 3.76111 9.93035 3.20948 10.7346C2.65786 11.5389 2.41891 12.5169 2.53754 13.485C2.65616 14.453 3.12419 15.3444 3.85369 15.9917C4.5832 16.639 5.52396 16.9976 6.49923 17.0002H7.49923"
                                                            stroke="#015158" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                        <path
                                                            d="M16.3287 7.13821C15.9869 5.78478 15.1433 4.61195 13.9688 3.85746C12.7944 3.10298 11.377 2.8233 10.004 3.07511C8.63093 3.32692 7.40503 4.09139 6.57476 5.21354C5.74448 6.3357 5.37195 7.73157 5.53269 9.11821C5.53269 9.11821 5.68569 10.0002 5.99869 10.5002"
                                                            stroke="#015158" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                        <path
                                                            d="M17.5 17C18.206 16.9995 18.904 16.8495 19.5479 16.5599C20.1917 16.2702 20.767 15.8475 21.2357 15.3195C21.7045 14.7915 22.0561 14.1702 22.2674 13.4965C22.4787 12.8229 22.545 12.1121 22.4618 11.4109C22.3786 10.7098 22.1479 10.0343 21.7848 9.42874C21.4217 8.82321 20.9345 8.30145 20.3552 7.89778C19.776 7.49412 19.1178 7.21772 18.424 7.08676C17.7302 6.9558 17.0166 6.97327 16.33 7.138L15 7.5"
                                                            stroke="#015158" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </svg>

                                                    <p class="upload-text">Browse and choose the files you want to<br>
                                                        upload from your computer</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="cm-wrapper mt-2">
                                    <button type="submit" class="btn custom-verify-btn cm text-white">Continue</button>
                                </div>
                            </form>

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