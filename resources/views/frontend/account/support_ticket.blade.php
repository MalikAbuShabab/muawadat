@extends('layouts.store', ['title' => __('Change Password')])
@section('css-links')
@endsection
@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
<style type="text/css">
    .main-menu .brand-logo {
        display: inline-block;
        padding-top: 20px;
        padding-bottom: 20px;
    }
    .productVariants .firstChild{
        min-width: 150px;
        text-align: left !important;
        border-radius: 0% !important;
        margin-right: 10px;
        cursor: default;
        border: none !important;
    }
    .product-right .color-variant li, .productVariants .otherChild{
        height: 35px;
        width: 35px;
        border-radius: 50%;
        margin-right: 10px;
        cursor: pointer;
        border: 1px solid #f7f7f7;
        text-align: center;
    }
    .productVariants .otherSize{
        height: auto !important;
        width: auto !important;
        border: none !important;
        border-radius: 0%;
    }
    .product-right .size-box ul li.active {
        background-color: inherit;
    }
    .iti__flag-container li, .flag-container li{
        display: block;
    }
    .iti.iti--allow-dropdown, .allow-dropdown {
        position: relative;
        display: inline-block;
        width: 100%;
    }
    .iti.iti--allow-dropdown .phone, .flag-container .phone {
        padding: 17px 0 17px 100px !important;
    }
    .social-logins{
        text-align: center;
    }
    .social-logins img{
        width: 100px;
        height: 100px;
        border-radius: 100%;
        margin-right: 20px;
    }
    .register-page .theme-card .theme-form input {
        margin-bottom: 5px;
    }
    .invalid-feedback{
        display: block;
    }
    .errors {
        color: #F00;
        background-color: #FFF;
    }
</style>
@endsection
@section('content')
<section class="section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="text-sm-left">
                    {{-- @if (\Session::has('success'))
                        <div class="alert alert-success">
                            <span>{!! \Session::get('success') !!}</span>
                        </div>
                    @endif
                    @if (\Session::has('error'))
                        <div class="alert alert-danger">
                            <span>{!! \Session::get('error') !!}</span>
                        </div>
                    @endif --}}
               
                </div>
            </div>
        </div>
        <div class="row my-md-3 mt-5 pt-4">
            <div class="col-lg-3">
                <div class="account-sidebar"><a class="popup-btn">{{ __('My Account') }}</a></div>
                <div class="dashboard-left mb-3">
                    <div class="collection-mobile-back">
                        <span class="filter-back d-lg-none d-inline-block">
                            <i class="fa fa-angle-left" aria-hidden="true"></i>{{ __('Back') }}
                        </span>
                    </div>
                    @include('layouts.store/profile-sidebar')
                </div>
            </div>
            <div class="col-lg-9">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="dashboard-right">
                    <div class="dashboard">
                        <div class="page-title">
                            <h2>{{__('Customer Support')}}</h2>
                        </div>
                        <div class="outer-box">
                            <form name="support_form" id="support_form" action="{{route('customer.support.store')}}" class="theme-form" method="post">
                                @csrf
                                <div class="form-row mb-2">
                                    <div class="col-md-12 mb-3">
                                        <label for="title">{{ __('Subject') }}</label>
                                        <input type="text" class="form-control mb-0" id="subject" placeholder="{{ __('Enter Subject') }}" name="subject" required>
                                        <span class="text-danger" id="title_error"></span>
                                        @if($errors->has('title'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <div class="col-md-12 mb-3">
                                        <label for="message">{{ __('Message') }}</label>
                                        <textarea class="form-control mb-0" id="message" placeholder="{{ __('Enter your message') }}" name="message" rows="4" required></textarea>
                                        <span class="text-danger" id="message_error"></span>
                                        @if($errors->has('message'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('message') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                            
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-solid submitSupport w-100" id="submitSupport">
                                            {{ __('Submit') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                            
                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<script>
	var url =  "{{route('user.submitChangePassword')}}";    
    $(document).on("click","#submitRegister",function() {
        $.ajax({
            type: "POST",
            url: url,
            data: $("#register").serialize(),
            success: function(response) {
                 $('#register')[0].reset();    
                 toastr.options.timeOut = 3000;
                 toastr.success('{{__('Your Password has been changed successfully')}}');
            },
            error: function (reject) {
                if( reject.status === 422 ) {
                    var message = $.parseJSON(reject.responseText);
                    $.each(message.errors, function (key, val) {
                        $("#" + key + "_error").text(val[0]);
                    });
                }
            }
        });
    });
</script>
@endsection