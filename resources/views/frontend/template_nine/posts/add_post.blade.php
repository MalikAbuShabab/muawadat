@extends('layouts.store', ['title' => 'Add Post'])

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/intlTelInput.css') }}">
    <link href="{{ asset('assets/libs/multiselect/multiselect.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/libs/jquery-toast-plugin/jquery-toast-plugin.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
@endsection
<style>
    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    :root {
        --blue-color: rgb(1 81 88 / 97%);
    }

    label {
        display: block;
        margin-bottom: 0.5rem;
    }

    input {
        display: block;
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ccc;
        border-radius: 0.25rem;
    }
    .ml-auto {
        margin-left: auto;
    }
    .input-group {
        margin: 0.5rem 0;
    }
    .form-step {
        display: none;
    }
    .form-step.active {
        display: block;
        transform-origin: top;
        animation: animate 0.5s;
    }
    /* Button */
    .btn-group {
        display: flex;
        justify-content: space-between;
    }
    .btn {
        padding: 0.75rem;
        display: block;
        text-decoration: none;
        width: min-content;
        border-radius: 5px;
        text-align: center;
        transition: all 0.3s;
        cursor: pointer;
    }

    .btn-next {
        background-color: var(--blue-color);
        color: white;
        float: right;
    }

    .btn-prev {
        background-color: #777;
        color: #fff;
    }

    .btn:hover {
        box-shadow: 0 0 0 2px #fff, 0 0 0 3px var(--blue-color);
    }

    textarea {
        resize: vertical;
    }

    /* Prefixes */

    .input-box {
        display: flex;
        align-items: center;
        /* max-width: 300px; */
        background: #fff;
        border: 1px solid #a0a0a0;
        border-radius: 4px;
        padding-left: 0.5rem;
        overflow: hidden;
        font-family: sans-serif;
    }

    .input-box .prefix {
        font-weight: 300;
        font-size: 14px;
        color: rgb(117, 114, 114);
    }

    .input-box input {
        border: none;
        outline: none;
    }

    .input-box:focus-within {
        border-color: #777;
    }

    /* End Prefixes */

    /* Progress bar */

    .step-progress-bar {
        position: relative;
        display: flex;
        justify-content: space-between;
        counter-reset: step;
        margin-bottom: 30px;
    }

    .step-progress-bar::before,
    .progress {
        content: "";
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        height: 4px;
        width: 100%;
        background-color: #dcdcdc;
        z-index: -1;
    }

    .progress {
        background-color: var(--blue-color);
        width: 0;
        transition: 0.5s;
    }

    .progress-step {
        width: 35px;
        height: 35px;
        background-color: #dcdcdc;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .progress-step::before {
        counter-increment: step;
        content: counter(step);
    }

    .progress-step::after {
        content: attr(data-title);
        position: absolute;
        top: calc(100% + 0.2rem);
        font-size: 0.85rem;
        color: black !important;
        width: 10%;
        text-align: center;
    }

    .progress-step.active {
        background-color: var(--blue-color);
        color: white;
    }

    @keyframes animate {
        from {
            transform: scale(1, 0);
            opacity: 0;
        }

        to {
            transform: scale(1, 1);
            opacity: 1;
        }
    }

    .add-exp-btn {
        color: #577d4c;
        border-right: 2px solid #577d4c;
        border-bottom: 2px solid #577d4c;
        padding: 0 10px 10px 0;
        text-decoration: none;
        font-weight: 600;
        border-bottom-right-radius: 6px;
        cursor: pointer;
    }

    .add-experience {
        margin-bottom: 20px;
    }

    .upload-box {
        width: 422px;
        height:171px;
        border: 2px dashed #ccc;
        border-radius: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        cursor: pointer;
    }
    .upload-box:hover {
        border-color: #007b7b;
    }
    .upload-box input[type="file"] {
        display: none;
    }
    .btn-next {
        display: block;
        margin: 20px auto 0;
        padding: 10px 20px;
        border: none;
        background-color: #007b7b;
        color: white;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }
    .btn-prev {
        display: block;
        margin: 20px auto 0;
        padding: 10px 20px;
        border: none;
        background-color: #007b7b;
        color: white;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }
    .btn-next:hover {
        background-color: #005f5f;
    }
    .dropify-wrapper {
        width:440 !important;
    }

    .inline-block {
        display: inline-block;
        width: 30%; /* Adjust width */
        margin-right: 20px; /* Add space between items */
        vertical-align: top; /* Aligns items to the top */
    }

    .upload-container {
        display: flex;
        gap: 20px; /* Space between items */
    }

    .dropify-wrapper {
        width: 30%; /* Adjust width if needed */
    }

    .error {
        color: red;
        font-size: 12px;
        margin-top: 5px;
        display: block;
    }

    .error-message {
        color: red;
        font-size: 12px;
        margin-top: 5px;
        display: block;
    }
    .banner_header{
        display: none;
    }
    .terominal_client{
        display: none;
    }

    #reason_for_sale {
        width: 100%;
        height: 120px;
        border-radius: 5px;
        border: 1px solid #ddd;
        padding: 5px;
        resize: none;
    }

    .al_body_template_one .iti__selected-flag{
        height:auto;
        padding: 6px 6px;
    }

    .validate_error {
        color: red;
        font-size: 12px;
        margin-top: 5px;
        display: block;
    }

    .dropify-clear {
        color: #fff !important;
        background-color: red !important;
    }

</style>

@section('content')
    <div class="wrapper Register_form">
        <div class="container">
            <div class="start_form_register">
                <div class="item">
                    <div class="alPostHead text-center bg-light position-relative py-3">
                        {{-- <h3>Post Your Ad</h3> --}}
                    </div>
                    <!-- Progress Bar -->
                    <div class="step-progress-bar">
                        <div class="progress" id="progress"></div>
                        <div class="progress-step active" data-title="{{ __('Company Basics') }}"></div>
                        <div class="progress-step" data-title="{{ __('Financial Information') }}"></div>
                        <div class="progress-step" data-title="{{ __('Upload Documents') }}"></div>
                    </div>
                    <!-- Steps 1-->
                    <div class="form-step active" id="form-1">
                        <form autocomplete="off" name="form1" id="form1" enctype="multipart/form-data" >
                            <div id="form1-message" class="alert alert-success d-none"></div>
                            <div class="input-group input-group">
                                <label for="full-name">{{__('Company Name')}}</label>
                                <input type="hidden" name="company_id" class="company_id" value ="">
                                <input type="text" name="company_name" id="company_name" placeholder="{{__('Enter company name')}}" class="validate-input" >
                                <span class="validate_error"></span>
                            </div>
                            {{--                                <div class="input-group">--}}
                            {{--                                    <label for="birth-date">{{__('Project Type')}}</label>--}}
                            {{--                                    --}}{{-- <input type="text" name="project_type" id="project_type" placeholder="Enter Sale type" class="validate-input" > --}}
                            {{--                                    <select class="form-control rounded w-100" name="project_type" id="project_type" >--}}
                            {{--                                        <option value="">{{__('Select Type')}}</option>--}}
                            {{--                                        @foreach($projectType as $key => $val)--}}
                            {{--                                            <option value="{{$val->id}}">{{ $val->translation_one->title ?? $val->title; }}</option>--}}
                            {{--                                        @endforeach--}}
                            {{--                                    </select>--}}
                            {{--                                    <span class="validate_error" style="color: red;"></span>--}}
                            {{--                                </div>--}}
                            {{--                                <div class="input-group">--}}
                            {{--                                    <label for="company_type" class="w-100">{{__('Company Type')}}</label>--}}
                            {{--                                    <select class="form-control rounded w-100" name="company_type" id="company_type" >--}}
                            {{--                                        --}}{{-- <option value="">Select Type</option> --}}
                            {{--                                        --}}{{-- @foreach($categories as $key => $val)--}}
                            {{--                                            <option value="{{$val->id}}">{{ $val->slug}}</option>--}}
                            {{--                                        @endforeach --}}
                            {{--                                    </select>--}}
                            {{--                                </div>--}}
                            <div class="input-group">
                                <label for="birth-date">{{__('name')}}</label>
                                {{--                                     <input type="text" name="name" id="name" style="display: none;">--}}
                                <input type="text" name="name" id="name" placeholder="{{__('Enter name')}}" class="validate-input" autocomplete="new-password" >
                                <span class="validate_error" style="color: red;"></span>
                            </div>
                            <div class="input-group">
                                <label for="birth-date">{{__('Website')}}</label>
                                <input type="text" name="website" id="website" placeholder="{{__('Enter website')}}" class="validate-input" >
                                <span class="validate_error" style="color: red;"></span>
                            </div>
                            {{-- <div class="input-group">
                                <label for="birth-date">Sale Type</label>
                                <input type="text" name="sale_type" id="sale_type" placeholder="Enter Sale type" class="validate-input" >
                                <span class="validate_error" style="color: red;"></span>
                            </div> --}}
                            <div class="input-group">
                                <label for="birth-date">{{__('Launch date')}}</label>
                                <input type="text" name="launch_date" id="launch_date" placeholder="{{__('Select launch date')}}" autocomplete="off" readonly >
                                <span id="date_error" style="color: red;"></span>
                            </div>

                            <div class="input-group">
                                <label for="country" class="w-100">Country</label>
                                <select class="form-control rounded w-100" name="country" id="country" >
                                    <option value="">{{__('Select country')}}</option>
                                    @foreach($countries as $key => $val)
                                        <option value="{{$val->nicename}}">{{ $val->nicename}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group">
                                <label for="birth-date">{{__('Team Size')}}</label>
                                <input type="text" name="team_size" id="team_size" placeholder="{{__('Enter team size')}}" min="1" class="validate-input">
                                <span class="validate_error" style="color: red;"></span>
                            </div>
                            {{--                                <div class="input-group">--}}
                            {{--                                    <label for="birth-date">{{__('Business Model')}}</label>--}}
                            {{--                                    <input type="text" name="business_modal" id="business_modal" placeholder="{{__('Enter business model')}}" class="validate-input">--}}
                            {{--                                    <span class="validate_error" style="color: red;"></span>--}}
                            {{--                                </div>--}}
                            <div class="input-group">
                                <label for="birth-date">{{__('Project Overview')}}</label>
                                <input type="text" name="company_description" id="company_description" placeholder="{{__('Project Overview')}}" class="validate-input" >
                                <span class="validate_error" style="color: red;"></span>
                            </div>
                            {{--                                <div class="input-group">--}}
                            {{--                                    <label for="birth-date">{{__('Technology')}}</label>--}}
                            {{--                                    <input type="text" name="company_technology" id="company_technology" placeholder="{{__('Enter your technologies')}}" class="validate-input" >--}}
                            {{--                                    <span class="validate_error" style="color: red;"></span>--}}
                            {{--                                </div>--}}
                            <div class="input-group">
                                <label for="inputAddress" class="w-100">{{__('City Availability')}} *</label>
                                <input type="hidden" name="lat" id="latitude" value="">
                                <input type="hidden" name="long" id="longitude" value="">
                                <input type="text" name="address" class="form-control rounded w-100" id="address"
                                       placeholder="{{__('Address') }}"aria-label="Recipient's Address"
                                       aria-describedby="button-addon2" value=""
                                       autocomplete="off" required="required" class="validate-input" >
                                <span class="validate_error" style="color: red;"></span>
                            </div>
                            <div class="input-group">
                                <label for="birth-date">{{__('Upload Ad Images')}}</label>
                                <input type="file" class="form-control-file" required="" id="file" name="file[]" accept="image/*" multiple="">
                            </div>
                            <div id="dynamic_fields"> </div> <!-- Div to show dynamic fields -->
                            <div class="input-group">
                                <div class="modal-footer1">
                                    <button type="submit"  class="btn rounded btn-next btn-info waves-effect text-white darkgreen w-100 mb-3 p-2" id="add_company_data">{{__('Continue')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Steps 2 -->
                    <div class="form-step" id="form-2">
                        <div id="form2-message" class="alert alert-success d-none"></div>
                        <form  name="form2" id="form2">
                            <div id="form3-message" class="alert alert-success d-none"></div>
                            <div class="input-group">
                                <label for="email">{{__('Growth Opportunity')}}</label>
                                <input type="hidden" name="company_id" class="company_id" value ="">
                                <input type="hidden" name="financial_info_id" class="financial_info_id" value ="" >
                                <input type="text" name="growth_opportunity" id="growth_opportunity" placeholder="{{__('Enter growth opportunities')}}" class="validate-input" autocomplete="off" >
                                <span class="validate_error" style="color: red;"></span>
                            </div>
                            <div class="input-group">
                                <label for="phone">{{__('Financial Data')}}</label>
                                <input type="text" name="finanical_data" id="finanical_data" placeholder="{{__('Enter financial data')}}" class="validate-input" autocomplete="off" >
                                <span class="validate_error" style="color: red;"></span>
                            </div>
                            <div class="input-group">
                                <label for="summary" class="w-100">{{__('Metrics')}}</label>
                                <input name="matrix" id="matrix" class="w-100" placeholder="{{__('Enter earning before interst')}}" autocomplete="off" >
                            </div>
                            <div class="input-group">
                                <label for="phone">{{__('Data Room')}}</label>
                                <input type="text" name="data_room" id="data_room" placeholder="{{__('No of data room')}}" autocomplete="off" >
                            </div>
                            <div class="input-group">
                                <label for="phone">{{__('Marketing')}}</label>
                                <input type="text" name="marketing" id="marketing" placeholder="{{__('Marketing')}}" class="validate-input" autocomplete="off" >
                                <span class="validate_error" style="color: red;"></span>
                            </div>
                            <div class="input-group">
                                <label for="phone">{{__('Price')}}</label>
                                <input type="text" name="price" id="price" placeholder="{{__('Enter price')}}" autocomplete="off" >
                            </div>
                            <div class="input-group">
                                <label for="phone">{{__('Offer Type')}} (Percentage)</label>
                                <input type="text" name="offer_type" id="offer_type" placeholder="{{__('Enter offer type')}}" class="validate-input" autocomplete="off" >
                                <span class="validate_error" style="color: red;"></span>
                            </div>
                            <div class="input-group">
                                <label for="phone">{{__('proposed Price')}}</label>
                                <input type="text" name="propsal_price" id="propsal_price" placeholder="{{__('Enter proposed price')}}" autocomplete="off" >
                            </div>
                            <div class="input-group">
                                <label for="phone">{{__('Notes of Offer')}}</label>
                                <input type="text" name="offer_note" id="offer_note" placeholder="{{__('Notes on offer')}}" class="validate-input" autocomplete="off" >
                                <span class="validate_error" style="color: red;"></span>
                            </div>
                            <div class="form-group mb-3 input-group">
                                <label for="">{{ __('Phone No.') }}</label>
                                <input type="tel"
                                       class="form-control @error('phone_number') is-invalid @enderror"
                                       id="phone" placeholder="{{ __('Phone No.') }}" name="phone_number"
                                       value="{{ old('full_number') }}" >

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
                            <div class="input-group">
                                <label for="phone">{{__('Email Address')}}</label>
                                <input type="email" name="email_address" id="email_address"  placeholder="{{__('Enter email address')}}" autocomplete="off" >
                            </div>
                            <div class="input-group">
                                <label for="phone">{{__('Shares Percentage')}}</label>
                                <input type="text" name="share_percentange" id="share_percentange" placeholder="{{__('Enter share percentage')}}"  class="validate-input" autocomplete="off" >
                                <span class="validate_error" style="color: red;"></span>
                            </div>
                            <div class="flex flex-col space-y-2">
                                <label for="nda" class="text-gray-700 font-medium">{{__("NDA")}}</label>
                                <select name="nda" id="nda" class="w-100 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none ">
                                    <option selected disabled>{{__('Select NDA')}}</option>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="input-group">
                                <label for="birth-date">{{__('Start date')}}</label>
                                <input type="text" name="start_date" id="start_date" placeholder="{{__('Select start date')}}"  autocomplete="off" readonly >
                            </div>
                            <div class="input-group">
                                <label for="reason_for_sale">{{__('Reason for Sale')}}</label>
                                <textarea name="reason_for_sale" id="reason_for_sale" cols="42" rows="6" placeholder="{{__('Reason for Sale')}}" class="validate-input" autocomplete="off" ></textarea>
                                <span class="validate_error" style="color: red;"></span>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-prev btn-info waves-effect waves-light darkgreen w-100 mb-3 p-2 text-white rounded">{{__('Previous')}}</button>&nbsp;
                                <button type="submit" class="btn btn-next btn-info waves-effect waves-light darkgreen w-100 mb-3 p-2 text-white rounded" id="add_financial_info">{{__('Continue')}}</button>
                            </div>
                        </form>
                    </div>

                    <!-- Steps 3 -->
                    <div class="form-step upload-step-form">
                        <form name="form3" method="POST" action="{{ route('posts.uploadCompanyDoc') }}" enctype="multipart/form-data" >
                            @csrf
                            <div class="experiences-group">
                                <div class="experience-item">
                                    <div class="input-group">
                                        <input type="hidden" name="company_id" class="company_id" value ="">
                                    </div>
                                    <div class="input-group">
                                        <div class="card px-2">
                                            <div class="upload-container">
                                                <div class="dropify-wrapper report-upload-subt w-30 inline-block" data-bs-toggle="tooltip" data-bs-placement="top" title="Upload Financial Documents" >
                                                    <div class="dropify-loader"></div>
                                                    <div class="dropify-errors-container">
                                                        <ul></ul>
                                                    </div>
                                                    <input required type="file" accept="image/*,.pdf,.doc" data-plugins="dropify" name="financial_statement_file" class="dropify" data-default-file="">
                                                    <button type="button" class="dropify-clear">Remove</button>
                                                    <div class="dropify-preview">
                                                        <span class="dropify-render"></span>
                                                        <div class="dropify-infos">
                                                            <div class="dropify-infos-inner">
                                                                <p class="dropify-filename">
                                                                    <span class="file-icon"></span>
                                                                    <span class="dropify-filename-inner"></span>
                                                                </p>
                                                                <p class="dropify-infos-message">Drag and drop or click to
                                                                    replace</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="dropify-wrapper report-upload-subt w-30 inline-block" data-bs-toggle="tooltip" data-bs-placement="top" title="Upload Financial Documents" >
                                                    <div class="dropify-loader"></div>
                                                    <div class="dropify-errors-container">
                                                        <ul></ul>
                                                    </div>
                                                    <input required type="file" accept="image/*,.pdf,.doc" data-plugins="dropify" name="valuation_report_file" class="dropify" data-default-file="">
                                                    <button type="button" class="dropify-clear">Remove</button>
                                                    <div class="dropify-preview">
                                                        <span class="dropify-render"></span>
                                                        <div class="dropify-infos">
                                                            <div class="dropify-infos-inner">
                                                                <p class="dropify-filename">
                                                                    <span class="file-icon"></span>
                                                                    <span class="dropify-filename-inner"></span>
                                                                </p>
                                                                <p class="dropify-infos-message">Drag and drop or click to
                                                                    replace</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="dropify-wrapper report-upload-subt w-30 inline-block" data-bs-toggle="tooltip" data-bs-placement="top" title="Upload Financial Documents">
                                                    <div class="dropify-loader"></div>
                                                    <div class="dropify-errors-container">
                                                        <ul></ul>
                                                    </div>
                                                    <input required type="file" accept="image/*,.pdf,.doc" data-plugins="dropify" name="legal_document_file" class="dropify" data-default-file="">
                                                    <button type="button" class="dropify-clear">Remove</button>
                                                    <div class="dropify-preview">
                                                        <span class="dropify-render"></span>
                                                        <div class="dropify-infos">
                                                            <div class="dropify-infos-inner">
                                                                <p class="dropify-filename">
                                                                    <span class="file-icon"></span>
                                                                    <span class="dropify-filename-inner"></span>
                                                                </p>
                                                                <p class="dropify-infos-message">Drag and drop or click to
                                                                    replace</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-prev btn-info waves-effect waves-light darkgreen w-100 mb-3 p-2 text-white rounded">{{__('Previous')}}</button>&nbsp;
                                    <button type="submit" class=" btn btn-next btn-info waves-effect waves-light darkgreen w-100 mb-3 p-2 text-white rounded" id="upload_company_doc">Complete</button>
                                </div>
                        </form>
                    </div>


                    <!-- Over Step Form -->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <link href="{{ asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/dropify/dropify.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('assets/libs/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/libs/dropify/dropify.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-toast-plugin/jquery-toast-plugin.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/toastr.init.js') }}"></script>
    <script src="{{asset('assets/libs/flatpickr/flatpickr.min.js')}}"></script>
    <script src="{{ asset('js/multi_form.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="{{ asset('assets/js/intlTelInput.js') }}"></script>
    <script src="{{asset('js/phone_number_validation.js')}}"></script>
    <script>

        // Tooltip
        document.addEventListener("DOMContentLoaded", function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        $(document).ready(function () {
            $(document).on('change', '#project_type', function () {
                var brand_id = $(this).val();
                // Check if a brand is selected

                if (brand_id) {

                    $.ajax({
                        url: "{{ url('get-brand-categories') }}/" + brand_id,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            console.log(data);
                            $('#company_type').empty();
                            $('#company_type').append('<option value="">Select Type</option>');
                            $.each(data, function (key, value) {
                                $('#company_type').append('<option value="' + value.category_id
                                    + '">' + value.category_translation['name'] + '</option>');
                            });
                        }
                    });
                } else {
                    $('#company_type').empty();
                    $('#company_type').append('<option value="">Select Category</option>');
                }
            });
        });

        $(document).ready(function () {

            document.querySelectorAll(".validate-input").forEach((input) => {
                input.addEventListener("input", function() {
                    validateInput(this);
                });
            });

            function validateInput(input) {
                let errorMessage = input.nextElementSibling;
                let trimmedValue = input.value.trim();

                if (trimmedValue == "") {
                    errorMessage.textContent = "Input cannot be empty or contain only spaces!";
                    input.value = "";
                    return;
                }
                let regex = /^[a-zA-Z0-9\u0600-\u06FF]/;

                if (!regex.test(input.value)) {
                    errorMessage.textContent = "First character must be a letter or number. No special characters allowed!";
                    input.value = input.value.replace(/[^a-zA-Z0-9\u0600-\u06FF\s]/g, "");
                } else {
                    errorMessage.textContent = "";
                }
            }

            function restrictToNumbers(selector) {
                $(selector).on("input", function () {
                    this.value = this.value.replace(/[^0-9]/g, ''); // Allow only numbers
                }).on("keydown", function (e) {
                    if (e.key === "ArrowUp" || e.key === "ArrowDown") {
                        e.preventDefault(); // Prevent arrow keys from changing value
                    }
                });
            }
            restrictToNumbers("#team_size, #matrix, #data_room, #price, #propsal_price");

            // DATE PICKER
            $("#launch_date").datepicker({
                dateFormat: "yy-mm-dd", // Format: YYYY-MM-DD
                changeMonth: true,
                changeYear: true,
                yearRange: "1900:2100", // Restrict year range
                onSelect: function(dateText) {
                    $("#date_error").text(""); // Clear error on valid selection
                }
            });

            $("#start_date").datepicker({
                dateFormat: "yy-mm-dd", // Format: YYYY-MM-DD
                changeMonth: true,
                changeYear: true,
                yearRange: "1900:2100", // Restrict year range
                onSelect: function(dateText) {
                    $("#start_date").text(""); // Clear error on valid selection
                }
            });


            // Prevent form submission if the date is invalid
            // $("#form1").submit(function (e) {
            //     let dateValue = $("#launch_date").val();
            //     if (dateValue === "") {
            //         $("#date_error").text("Please select a valid date.");
            //         e.preventDefault();
            //     }
            // });

        });

        $(document).on('click', '.category-list', function() {
            $('.category-list').find('.select-category').removeClass('active');
            $(this).find('.select-category').addClass('active');
            $(this).show();
            $('.choose-category').show();
        });

        $('.dropify').dropify();
        $(document).on('click', '.select-category', function() {
            var category_id = $(this).data('id');
            $("#category_id").val(category_id);
            $(".selected-category").text($(this).data('name'));
            var type_id = $(this).data('type-id');
            $(".p2p-category-form").removeClass('d-none');
            if(type_id == '10'){
                $(".rental-cat-fields").removeClass('d-none');
                $(".p2p-cat-fields").addClass('d-none');
            }else{
                $(".rental-cat-fields").addClass('d-none');
                $(".p2p-cat-fields").removeClass('d-none');
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            });
            $.ajax({
                url: "{{ route('category.attributes') }}",
                type: "GET",
                data: {
                    category_id: category_id
                },
                success: function(response) {
                    if (response.success) {
                        $("#productAttributes").html(response.html);
                    }
                },
            });
        });

        function checkAddressString(obj, name) {
            if ($(obj).val() == "") {
                document.getElementById('latitude').value = '';
                document.getElementById('longitude').value = '';
            }
        }

        //calender and day_price

        $(document).on('keyup', '#day_price', function() {
            var dayPrice = $('#day_price').val();
            var weekPrice = (dayPrice * 4) / 7;
            var monthPrice = (dayPrice * 4 * 3) / 30;
            $('#week_price').val(weekPrice.toFixed(2));
            $('#month_price').val(monthPrice.toFixed(2));
        });

        $(function() {
            var date = new Date();
            var currentMonth = date.getMonth();
            var currentDate = date.getDate();
            var currentYear = date.getFullYear();
            $('input[name="date_availability"]').daterangepicker({
                minDate: new Date(currentYear, currentMonth, currentDate),
                dateFormat: 'yy-mm-dd',
                //startDate: moment(date).add(1,'days'),
                // endDate: moment(date).add(2,'days'),
                locale: {
                    format: 'DD.MM.YYYY'
                }
            });
        });

        var form = document.getElementById("product_form");
        document.getElementById("save-post").addEventListener("click", function (e) {


            e.preventDefault();
            const elements = document.querySelectorAll('.select-category.active');
            const hasElements = elements.length > 0;
            var productName = $('input[name="product_name"]').val();
            var description = $('textarea[name="product_description"]').val();
            var address = $('input[name="address"]').val();
            var files = $('input[name="file[]')[0].files;

            // Validate form fields.
            if (productName === '') {
                sweetAlert.error('Product name is required', '');
                return;
            }
            if (description === '') {
                sweetAlert.error('Description is required', '');
                return;
            }
            if (address === '') {
                sweetAlert.error('Address is required', '');
                return;
            }


            if (files.length === 0) {
                sweetAlert.error('Image file is required', '');
                return;
            }
            if (hasElements) {
                $('.cat-error').addClass('d-none');
                form.submit();
            } else {
                $('.cat-error').removeClass('d-none');
            }
        });

        $(document).on('change', '#category_filter', function(){
            var value = $(this).val();
            var $viewAllCats = $('.view-all_cats');
            var $viewP2PSellCats = $('.view-p2psell_cats');
            var $viewRentalCats = $('.view-rental_cats');
            var $categoryID = $("#category_id");
            var $selectedCategory = $(".selected-category");
            var $p2pCategoryForm = $(".p2p-category-form");

            $viewAllCats.addClass('d-none');
            $viewP2PSellCats.addClass('d-none');
            $viewRentalCats.addClass('d-none');
            switch (value) {
                case '10':
                    $viewRentalCats.removeClass('d-none');

                    break;
                case '13':
                    $viewP2PSellCats.removeClass('d-none');
                    // $(".slick-arrow").click();
                    break;
                default:
                    $viewAllCats.removeClass('d-none');
                    break;
            }
            $('.category_responsive').slick('refresh');
            $categoryID.val('');
            $selectedCategory.text('');
            $p2pCategoryForm.addClass('d-none');
        });

    </script>


    <script>
        $(document).ready(function () {

            $("#form1").submit(function(e) {
                e.preventDefault();
                alert('ss');
                let company_name = $('#company_name').val();
                // let company_type = $('#company_type').val();
                let name = $('#name').val();
                let website = $('#website').val();
                // let project_type = $('#project_type').val();
                let launch_date = $('#launch_date').val();
                let country = $('#country').val();
                let team_size = $('#team_size').val();
                let business_modal = $('#business_modal').val();
                let company_description = $('#company_description').val();
                let company_technology = $('#company_technology').val();
                let company_id = $('.company_id').val();
                let address = $('#address').val();
                let lat = $('#latitude').val();
                let long = $('#longitude').val();
                console.log($('#latitude').val());
                console.log($('#longitude').val());
                console.log(lat);
                console.log(long);
                let formData = new FormData();

                formData.append('_token', '{{ csrf_token() }}');
                formData.append('company_name', company_name);
                //     formData.append('company_type', company_type);
                formData.append('name', name);
                formData.append('website', website);
                //  formData.append('project_type', project_type);
                // formData.append('sale_type', sale_type);
                formData.append('launch_date', launch_date);
                formData.append('country', country);
                formData.append('team_size', team_size);
                formData.append('business_modal', business_modal);
                formData.append('company_description', company_description);
                formData.append('company_technology', company_technology);
                formData.append('company_id', company_id);
                formData.append('address', address);
                formData.append('lat', lat);
                formData.append('long', long);

                document.querySelectorAll('.dynamic-input').forEach(input => {
                    formData.append('dynamic_fields[][name]', input.name); // Field name
                    formData.append('dynamic_fields[][value]', input.value); // Field value
                });


                let files = $('#file')[0].files;
                for (let i = 0; i < files.length; i++) {
                    formData.append('file[]', files[i]);
                }
                document.querySelectorAll(".validate_error").forEach((span) => {
                    span.textContent = ""; // Clear custom error messages on form submit
                });

                if ($(this).valid()) {
                    $.ajax({
                        url: "{{ route('posts.storeCompanyData') }}",
                        method: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if(response.status==200){
                                $('.company_id').val(response.product.id);
                                $("#form1-message").removeClass("d-none").text("Company Info Submit Successfully!").fadeIn();
                                setTimeout(() => { $("#form1-message").fadeOut(); }, 3000);
                            }
                        },
                        error: function (xhr) {
                            // alert('Error submitting Step 2');
                            console.log(xhr.responseText);
                        }
                    });
                }


            });
        });

        // STORE COMPANY FINANCIAL INFO

        $(document).ready(function () {
            $("#form2").submit(function(e) {
                e.preventDefault();
                let growth_opportunity = $('#growth_opportunity').val();
                let finanical_data = $('#finanical_data').val();
                let matrics = $('#matrix').val();
                let data_room = $('#data_room').val();
                let marketing = $('#marketing').val();
                let price = $('#price').val();
                let offer_type = $('#offer_type').val();
                let proposed_price = $('#propsal_price').val();
                let notes_offer = $('#offer_note').val();
                let phone = $('#phone').val();
                let email_address = $('#email_address').val();
                let share_percentange = $('#share_percentange').val();
                let nda = $('#nda').val();
                let start_date = $('#start_date').val();
                let reason_for_sale = $('#reason_for_sale').val();
                let company_id = $('.company_id').val();
                let financial_info_id = $('.financial_info_id').val();
                if ($(this).valid()) {
                    $.ajax({
                        url: "{{ route('posts.storeCompanyFinancialInfo') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}", growth_opportunity:growth_opportunity, finanical_data:finanical_data, matrics:matrics, data_room:data_room, marketing:marketing,price:price,offer_type:offer_type,proposed_price:proposed_price,notes_offer:notes_offer ,phone:phone, email_address:email_address, share_percentange:share_percentange, nda:nda, start_date:start_date, reason_for_sale:reason_for_sale, company_id:company_id, financial_info_id:financial_info_id,
                        },
                        success: function (response) {
                            console.log(response);
                            if(response.status==200){
                                $('.company_id').val(response.financialInfo.company_id);
                                $('.financial_info').val(response.financialInfo.id);
                                $('.upload-step-form').css('display', 'block');
                                $("#form2-message").removeClass("d-none").text("Financial Info submitted successfully!").fadeIn();
                                setTimeout(() => { $("#form2-message").fadeOut(); }, 3000);
                            }
                        },
                        error: function (xhr) {
                            // alert('Error submitting Step 2');
                            console.log(xhr.responseText);
                        }
                    });
                }

            });
        });

    </script>

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

    <script>
        $(document).ready(function () {
            function loadFormFields() {
                $.ajax({
                    url: "{{ route('listing-documents')}}",
                    type: "GET",
                    success: function (response) {
                        console.log(response);
                        $("#dynamic_fields").html(""); // Clear existing fields
                        response.forEach(function (field) {
                            let formattedName = field.primary.name.charAt(0).toUpperCase() +
                                field.primary.name.slice(1).toLowerCase().replace(' ', '_');
                            let inputField = '';

                            if (field.file_type === "Text") {
                                inputField = `<div class="input-group">
                                            <label>${formattedName}</label>
                                            <input type="text" name="${field.primary.name.toLowerCase().replace(/ /g, '_')}"
                                                class="form-control rounded w-100 pac-target-input dynamic-input"
                                                ${field.is_required ? 'required' : ''}>
                                        </div>`;
                            } else if (field.file_type === "selector") {
                                let options = field.options.map(option => `<option value="${option.translation.name}">${option.translation.name}</option>`).join('');
                                inputField = `<div class="input-group">
                                            <label>${formattedName}</label>
                                            <select name="${field.primary.name.toLowerCase().replace(/ /g, '_')}"
                                                    class="form-control rounded w-100 pac-target-input dynamic-input"
                                                    ${field.is_required ? 'required' : ''}>
                                                <option value="">Select an option</option>
                                                ${options}
                                            </select>
                                        </div>`;
                            }

                            $("#dynamic_fields").append(inputField);
                        });
                    }
                });
            }

            loadFormFields(); // Load fields on page load

            // Optionally, refresh fields after admin updates
            $("#refresh-fields").click(function () {
                loadFormFields();
            });
        });
    </script>


        <?php
        // dd(Session::get('toaster'));
        if (Session::has('toaster')) {
            $toast = Session::get('toaster');
            echo '<script>
                $(document).ready(function(){
                    $.NotificationApp.send("' .
                $toast['title'] .
                '", "' .
                $toast['body'] .
                '", "top-right", "' .
                $toast['color'] .
                '", "' .
                $toast['type'] .
                '");
                });
            </script>';
        }
        ?>
@endsection
