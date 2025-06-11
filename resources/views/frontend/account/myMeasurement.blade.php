@extends('layouts.store', ['title' =>  __('My Measurement')  ])
@section('css')
<style type="text/css">
    .main-menu .brand-logo {
        display: inline-block;
        padding-top: 20px;
        padding-bottom: 20px;
    }
</style>
@endsection
@section('content')

<style type="text/css">
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
    .login-page .theme-card .theme-form input {
        margin-bottom: 5px;
    }
    .invalid-feedback{
        display: block;
    }
    .outer-box{
        min-height: 240px;
        display: flex;
        justify-content: space-between;
    }
    #address-map-container #pick-address-map {
        width: 100%;
        height: 100%;
    }
    .address-input-group{
        position: relative;
    }
    .address-input-group .pac-container{
        top:35px!important;
        left:0!important;
    }
    .errors {
        color: #F00;
        background-color: #FFF;
    }
</style>
<section class="section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="text-sm-left">
                    @if (\Session::has('success'))
                        <div class="alert alert-success">
                            <span>{!! \Session::get('success') !!}</span>
                        </div>
                    @endif
                    @if ( ($errors) && (count($errors) > 0) )
                        <div class="alert alert-danger">
                            <ul class="m-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
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
                <div class="dashboard-right">
                    <div class="dashboard">
                        <div class="page-title">
                            <h2>{{ __('My Measurement') }}</h2>
                        </div>
                        <div class="row">
                            <!-- Left side: Form -->
                            <div class="col-md-6">
                                <div class="container mt-5">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Key Name</th>
                                                <th scope="col">Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($keys as $key => $value)
                                            <tr>
                                                <td>{{$value->key_name}}</td>
                                                <td>{{@$user_measurement[$key]['measurement_value']}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Right side: Other content -->
                            <div class="col-md-6">
                                <div class="container mt-5">
                                    <form action="{{ route('user.measurement') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            @foreach($keys as $key => $value)
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="measurement_label" class="form-label">{{$value->key_name}}</label>
                                                    <input type="hidden" name="measurement_key_id[]" value="{{$value->id}}">
                                                    <input type="text" name="measurement_value[{{$value->id}}]" class="form-control" id="measurement_value" value={{@$user_measurement[$key]['measurement_value']}}>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
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

