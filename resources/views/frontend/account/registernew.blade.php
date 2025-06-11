@extends('layouts.store', ['title' => __('Register')])
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/intlTelInput.css') }}">
    <style type="text/css">
        .file>label,
        .file.upload-new>label {
            width: 100%;
            border: 1px solid #ddd;
            padding: 30px 0;
            height: 216px;
        }

        .file .update_pic img,
        .file.upload-new img {
            height: 130px;
            width: auto;
        }

        .update_pic,
        .file.upload-new .update_pic {
            width: 100%;
            height: auto;
            margin: auto;
            text-align: center;
            border: 0;
            border-radius: 0;
        }

        .file--upload>label {
            margin-bottom: 0;
        }

        .errors {
            color: #F00;
            background-color: #FFF;
        }
        .al_body_template_one .iti__selected-flag{
            height:auto;
            padding: 6px 6px;
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
@endsection
@section('content')
    <section class="wrapper-main signup-form-main d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mb-lg-0 mb-3">
                    {{-- <h3 class="mb-2">{{ __('New Customer') }}</h3> --}}

                    
                    <div class="row align-items-center rounded bg-white">
                        @if (session('preferences'))
                        <div class="col-lg-6 muawadat_login_1 text-center p-0">
                            <div class="create_box muawadat_login">
                                <div class="top_text">
                                    <h1 class="title">Welcome to <br> Muawadat</h1>
                                    <p class="subtitle">Lorem ipsum dolor sit amet consectetur. Lectus libero integer justo nec eget pharetra dui.</p>
                                </div>
                                <div class="bottom_text">
                                <div class="stars">★★★★★</div>
                                <p class="testimonial">"We love Landingfolio! Our designers were using it for their projects, so we already knew what kind of design they want."</p>
                                <div class="profile">
                                    <img src="{{ asset('assets/images/dummy_user.png')}}" alt="Devon Lane">
                                    <div class="profile-info">
                                        <strong>Devon Lane</strong><br>
                                        Co-Founder, ABC Company
                                    </div>
                                </div>
                                </div>
                                {{-- <a href="{{url('auth/twitter')}}"><img class="w-100 vh-100" src="{{asset('assets/img/auth-page.png')}}" alt=""></a> --}}
                            </div>
                        </div>
                        <div class="col-lg-6 muawadat_login_2 mb-lg-0 mb-3 pb-sm-0">

                        <div class="max-form">
                        <div class="text-left">
                            <a href="/">
                                <img class="mb-1" alt="" src="{{asset('images/black_logo.png')}}"
                                    style="margin-right: auto">
                            </a>
                        </div>
                        <h5 class="mb-2">{{ __("Let’s sign in to your account") }}</h5>
                        <div class="text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="126" height="126" viewBox="0 0 126 126" fill="none">
<path d="M125.2 62.6195C125.2 97.1373 97.2178 125.12 62.7 125.12C28.1822 125.12 0.200012 97.1373 0.200012 62.6195C0.200012 28.1017 28.1822 0.119507 62.7 0.119507C97.2178 0.119507 125.2 28.1017 125.2 62.6195Z" fill="url(#pattern0_858_2792)"/>
<defs>
<pattern id="pattern0_858_2792" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0_858_2792" transform="scale(0.00277778)"/>
</pattern>
<image id="image0_858_2792" width="360" height="360" preserveAspectRatio="none" xlink:href="data:image/png;base64,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"/>
</defs>
</svg>
                        </div>

                        <div class="row mt-3 arabic-language">
                            <div class="col-md-12 text-left">


                        <div class="{{ (@session('preferences')->concise_signup == 1)? 'mx-auto':'' }}">
                            <form name="register" id="register" enctype="multipart/form-data" action="{{ route('customer.register') }}"
                             method="post"> @csrf
                                @if(@session('preferences')->concise_signup == 1)
                                <input type="hidden" name="name" value="guest">
                                <input type="hidden" name="email" id="guest-email" value="">
                                @endif
                                <div class="form-group mb-3 {{ (@session('preferences')->concise_signup == 1)? 'mx-auto':'' }}">
                                    @if(@session('preferences')->concise_signup == 0)
                                    <div class="form-group">
                                        <label for="">{{ __('Full Name') }}</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            placeholder="{{ __('Enter Full name') }}" name="name" value="{{ old('name') }}">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    @endif
                                <div class="form-group mb-3 {{ (@session('preferences')->concise_signup == 1)? 'mx-auto':'' }}">
                                    @if(@session('preferences')->concise_signup == 0)
                                        <label for="">{{ __('Email address') }}</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            placeholder="{{ __('Enter Email address') }}" name="email" value="{{ old('email') }}">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ __($message) }}</strong>
                                            </span>
                                        @enderror
                                    @endif

                                </div>
                                    <div class="form-group mb-3">
                                        <label for="">{{ __('Phone Number') }}</label>
                                        <input type="tel"
                                            class="form-control @error('phone_number') is-invalid @enderror"
                                            id="phone" placeholder="{{ __('Enter Phone number') }}" name="phone_number"
                                            value="{{ old('full_number') }}">

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
                                </div>
                                    <div class="form-group mb-3">
                                        <label for="">{{ __('Password') }}</label>
                                        <div class="position-relative">
                                            <input type="password" id="password-field"
                                                class="form-control @error('password') is-invalid @enderror" id="review"
                                                placeholder="{{ __('Enter New Password') }}" name="password">
                                            <span toggle="#password-field" class="fa fa-eye-slash toggle-password"
                                                style="right:20px"></span>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ __($errors->first('password')) }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- <div class="col-md-{{ (@session('preferences')->concise_signup == 1)? '12 text-left':'6' }}mb-3"> --}}
                                        <div class="form-group mb-3">
                                        <label for="">{{ __('Confirm Password') }}</label>
                                        <div class="position-relative">
                                                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="{{ __('Enter Confirm Password') }}" class="form-control" required>
                                            <span toggle="#password_confirmation" class="fa fa-eye-slash toggle-password"
                                                style="right:20px"></span>
                                            @error('password_confirmation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ __($message) }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                @if(@getAdditionalPreference(['is_enable_allergic_items'])['is_enable_allergic_items'])
                                <label for="">{{ __('Allergic Items') }}</label>
                                    <div class="form-group">
                                        <select class="form-control select2-multiple" id="multiple" multiple name="allergic_item_ids[]"  data-placeholder="Select Allergic Item">
                                            @foreach ($allergic_items as $item)
                                            <option value="{{$item->id}}">{{$item->title??''}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" class="form-control" name="custom_allergic_items" placeholder="Enter Custom Allergic Items" value="{{ auth()->user()->custom_allergic_items ?? ''}}">
                                    </div>
                                @endif

                                @if (count($user_registration_documents) > 0)    
                                    <div class="user-info d-block w-100">
                                        <h5 class="py-1">User Document</h5>
                                    </div>
                                @endif
                                <div class="form-group mb-0 ">
                                    @foreach ($user_registration_documents as $vendor_registration_document)
                                        @if (isset($vendor_registration_document->primary->slug) && !empty($vendor_registration_document->primary->slug))
                                            @if (strtolower($vendor_registration_document->file_type) == 'selector')
                                                <div class="form-group"
                                                    id="{{ $vendor_registration_document->primary->slug ?? '' }}Input">
                                                    <label
                                                        for="">{{ $vendor_registration_document->primary ? $vendor_registration_document->primary->name : '' }}</label>
                                                    <select
                                                        class="form-control {{ !empty($vendor_registration_document->is_required) ? 'required' : '' }}"
                                                        name="{{ $vendor_registration_document->primary->slug }}"
                                                        id="input_file_selector_{{ $vendor_registration_document->id }}">
                                                        <option value="">
                                                            {{ __('Please Select ') .($vendor_registration_document->primary ? $vendor_registration_document->primary->name : '') }}
                                                        </option>
                                                        @foreach ($vendor_registration_document->options as $key => $value)
                                                            <option value="{{ $value->id }}">
                                                                {{ $value->translation ? $value->translation->name : '' }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <span class="invalid-feedback"
                                                        id="{{ $vendor_registration_document->primary->slug }}_error"><strong></strong></span>
                                                </div>
                                            @else
                                                <div class="form-group"
                                                    id="{{ $vendor_registration_document->primary->slug ?? '' }}Input">
                                                    <label
                                                        for="">{{ $vendor_registration_document->primary ? $vendor_registration_document->primary->name : '' }}</label>
                                                    @if (strtolower($vendor_registration_document->file_type) == 'text')
                                                        <input id="input_file_logo_{{ $vendor_registration_document->id }}"
                                                            type="text"
                                                            name="{{ $vendor_registration_document->primary->slug }}"
                                                            class="form-control {{ !empty($vendor_registration_document->is_required) ? 'required' : '' }}">

                                                        @error($vendor_registration_document->primary->slug)
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first($vendor_registration_document->primary->slug) }}</strong>
                                                            </span>
                                                        @enderror
                                                    @else
                                                        <div class="file file--upload">
                                                            <label
                                                                for="input_file_logo_{{ $vendor_registration_document->id }}">
                                                                <span class="update_pic pdf-icon">
                                                                    <img src=""
                                                                        id="upload_logo_preview_{{ $vendor_registration_document->id }}">
                                                                </span>
                                                                <span class="plus_icon"
                                                                    id="plus_icon_{{ $vendor_registration_document->id }}">
                                                                    <i class="fa fa-plus"></i>
                                                                </span>
                                                            </label>
                                                            @if (strtolower($vendor_registration_document->file_type) == 'image')
                                                                <input
                                                                    class="{{ !empty($vendor_registration_document->is_required) ? 'required' : '' }}"
                                                                    id="input_file_logo_{{ $vendor_registration_document->id }}"
                                                                    type="file"
                                                                    name="{{ $vendor_registration_document->primary->slug }}"
                                                                    accept="image/*"
                                                                    data-rel="{{ $vendor_registration_document->id }}">
                                                            @else
                                                                <input
                                                                    class="{{ !empty($vendor_registration_document->is_required) ? 'required' : '' }}"
                                                                    id="input_file_logo_{{ $vendor_registration_document->id }}"
                                                                    type="file"
                                                                    name="{{ $vendor_registration_document->primary->slug }}"
                                                                    accept=".pdf"
                                                                    data-rel="{{ $vendor_registration_document->id }}">
                                                            @endif

                                                            @error($vendor_registration_document->primary->slug)
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first($vendor_registration_document->primary->slug) }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                                <div class="form-check mb-2 d-none">
                                    <input type="checkbox" name="term_and_condition" class="form-check-input @error('term_and_condition') is-invalid @enderror" id="html" checked>
                                            @if(session()->get("customerLanguage") == "59")
                                            <a href="{{ $terms ? route('extrapage', $terms->slug) : '#' }}"
                                                target="_blank"> {{ __('By clicking next, I agree to COMPANY NAME, Terms & Conditions.') }}
                                            </a>
                                             @else

                                            <label for="html" class="mr-3">{{ __('I accept the') }}
                                            <a href="{{ $terms ? route('extrapage', $terms->slug) : '#' }}"
                                                target="_blank">{{ __('Terms And Conditions') }} </a>
                                                {{ __('and have read the') }}
                                                <a href="{{ $privacy ? route('extrapage', $privacy->slug) : '#' }}"
                                                target="_blank">
                                                {{ __('Privacy Policy') }}
                                                </a>
                                            </label>
                                            @endif
                                       
                                    @if($errors->first('term_and_condition'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('term_and_condition') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-checked-register">
                                By clicking next, I agree to COMPANY NAME, Terms & Conditions
                                </div>
                                {{-- @include('frontend.consent') --}}
                                <div class="row form-group mb-0 align-items-center">
                                    <!-- <div class="col-12 checkbox-input">
                                        <input type="checkbox" id="html" name="term_and_condition"
                                            class="form-control @error('term_and_condition') is-invalid @enderror">



                                        <label for="html">{{ __('I accept the') }}
                                            <a href="{{ $terms ? route('extrapage', $terms->slug) : '#' }}"
                                                target="_blank">{{ __('Terms And Conditions') }} </a>
                                            {{ __('and have read the') }}
                                            <a href="{{ $privacy ? route('extrapage', $privacy->slug) : '#' }}"
                                                target="_blank">
                                                {{ __('Privacy Policy') }}.
                                            </a>
                                        </label>
                                        @if ($errors->first('term_and_condition'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('term_and_condition') }}</strong>
                                            </span>
                                        @endif

                                     

                                    </div> -->
                                    {{-- <div class="col-md-6 ">
                                        <label for="">Referral Code</label>
                                        <input type="text" class="form-control" id="refferal_code"
                                            placeholder="Refferal Code" name="refferal_code"
                                            value="{{ old('refferal_code', $code ?? '') }}">
                                        @if ($errors->first('refferal_code'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('refferal_code') }}</strong>
                                            </span>
                                        @endif
                                    </div> --}}
                                </div>
                                <div class="form-group">
                                        <input type="hidden" name="device_type" value="web">
                                        <input type="hidden" name="device_token" value="web">
                                        <button type="submit"
                                            class="text-white darkgreen btn btn-primary rounded w-100">{{ __('Next') }}</button>
                                </div>
                            </form>
                            @if (session('preferences'))
                            @if (@session('preferences')->fb_login == 1 || @session('preferences')->twitter_login == 1 || @session('preferences')->google_login == 1 || @session('preferences')->apple_login == 1)
                                <div class="divider_line m-auto">
                                    <span>{{ __('Or') }}</span>
                                </div>
                                <ul class="social-links d-flex align-items-center mx-auto mb-4 mt-3">
                                    @if (session('preferences')->google_login == 1)
                                        <li>
                                            <a href="{{ url('auth/google') }}">
                                                <img src="{{ asset('front-assets/images/google.svg') }}">
                                            </a>
                                        </li>
                                    @endif
                                    @if (@session('preferences')->fb_login == 1)
                                        <li>
                                            <a href="{{ url('auth/facebook') }}">
                                                <img src="{{ asset('front-assets/images/facebook.svg') }}">
                                            </a>
                                        </li>
                                    @endif
                                    @if (@session('preferences')->twitter_login)
                                        <li>
                                            <a href="{{ url('auth/twitter') }}">
                                                <img src="{{ asset('front-assets/images/twitter.svg') }}">
                                            </a>
                                        </li>
                                    @endif
                                    @if (@session('preferences')->apple_login == 1)
                                        <li>
                                            <a href="javascript::void(0);">
                                                <img src="{{ asset('front-assets/images/apple.svg') }}">
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            @endif
                        @endif<div class="form-group text-center have_acc">

<h5>Don't Have An Account? <span style="color:#000000;"><a
            href="{{route('customer.login')}}">{{ __('Sign In') }}</a></span>
</h5>
</div>
                        </div>

                        </div>
                        </div>
                    </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script src="{{ asset('assets/js/intlTelInput.js') }}"></script>
    <script src="{{asset('js/phone_number_validation.js')}}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
    <script>
        $(document).ready(function() {
            @if (session('preferences'))
                @if(@session('preferences')->concise_signup == 1)
                    $('#phone').change(function() {
                        var custPhone = $(this).val();
                        $('#guest-email').val(custPhone+'@gmail.com');
                    });
                @endif
            @endif

            jQuery.validator.addMethod("indianMobile", function(value, element) {
                var dialCode = $("#dialCode").val();
                // Regular expression for Indian mobile numbers
                if(dialCode == 91) {
                    var regex = /^[6-9]\d{9}$/;
                    return this.optional(element) || regex.test(value);
                } else {
                    return true;
                }
                
                }, "Please enter a valid Indian mobile number.");

            jQuery.validator.addMethod("alphanumeric", function(value, element) {
                return this.optional(element) || /^[a-zA-Z0-9 ]+$/i.test(value);
            }, "Name should contains alphanumeric data.");
            $("#register").validate({
                errorClass: 'errors',
                rules: {
                    name : {
                        required: true,
                        minlength: 3,
                        alphanumeric: true
                    },
                    phone_number: {
                        required: true,
                        //number: true,
                        indianMobile: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
                    },
                    password_confirmation: {
                        required: true
                    }
                },
                onfocusout: function(element) {
                    this.element(element); // triggers validation
                },
                onkeyup: function(element, event) {
                    this.element(element); // triggers validation
                },
                messages : {
                    name: {
                        required:"{{ __('Please enter your name')}}",
                        minlength:"{{__('The name must be at least 3 characters.')}}",
                        alphanumeric:"{{ __('Name should contains alphanumeric data')}}"
                    },
                    phone_number: {
                        required: "{{ __('Please enter your phone')}}",
                        number: "{{ __('Please enter a numerical value')}}"
                    },
                    email: "{{ __('The email should be in the format:')}} abc@domain.tld",
                    password: "{{ __('Please enter your password')}}",
                    password_confirmation: "{{ __('Please Enter confirm password!')}}",
                }
            });

            $("#register").submit(function() {
                if($("#phone").hasClass("is-invalid")){
                    $("#phone").focus();
                    return false;
                }
            });
        });
        jQuery(window.document).ready(function () {
            jQuery("body").addClass("register_body");
        });
        jQuery(document).ready(function($) {
            setTimeout(function(){
                var footer_height = $('.footer-light').height();
                console.log(footer_height);
                $('article#content-wrap').css('padding-bottom',footer_height);
            }, 500);
            setTimeout(function(){
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

        $(document).ready(function() {
            $("#phone").keypress(function(e) {
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
                return true;
            });
        });
        $('.iti__country').click(function() {
            var code = $(this).attr('data-country-code');
            $('#countryData').val(code);
            var dial_code = $(this).attr('data-dial-code');
            $('#dialCode').val(dial_code);
        });
        $(document).on('change', '[id^=input_file_logo_]', function(event) {
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
                reader.onload = function(e) {
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
