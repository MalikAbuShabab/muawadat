@extends('layouts.store', ['title' => __('Address Book')])
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

        .invalid-feedback {
            display: block;
        }

        .outer-box {
            min-height: 240px;
            display: flex;
            justify-content: space-between;
        }

        #address-map-container #pick-address-map {
            width: 100%;
            height: 100%;
        }

        .address-input-group {
            position: relative;
        }

        .address-input-group .pac-container {
            top: 35px !important;
            left: 0 !important;
        }

        .errors {
            color: #F00;
            background-color: #FFF;
        }
    </style>
    <section class="section-b-space pt-4">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="text-sm-left">
                        <h5 class="my-accout-heading">My Account</h5>
                        @if (\Session::has('success'))
                            <div class="alert alert-success">
                                <span>{!! \Session::get('success') !!}</span>
                            </div>
                        @endif
                        @if (($errors) && (count($errors) > 0))
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
            <div class="row">
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
                    <div class="dashboard-right dashboard-white">
                        <div class="dashboard">
                            <div class="address_main">
                                <div class="address_title">
                                    <div class="page-title">
                                        <h3>{{ __('Address') }}</h3>
                                        <p class="mb-0"><span>Please submit the following documents to
                                                process your application.</span></p>
                                    </div>
                                </div>
                                <div class="address_btn">
                                    <a class="add_edit_address_btn" href="javascript:void(0)" data-toggle="modal"
                                        data-target="#add_edit_address">
                                        <i class="fa fa-plus mr-2" aria-hidden="true"></i> {{ __('Add Address') }}
                                    </a>
                                </div>
                            </div>
                            <div class="box-account box-info order-address">
                                <div class="address-cards-row">
                                    @foreach($useraddress as $add)
                                            <div class="address-cards">
                                                <div class="outer-box-add">
                                                    <div class="address-type w-100">
                                                        <div class="default_address border-bottom">
                                                            <h6 class="mt-0 mb-0">
                                                                <!-- <i
                                                                                                                                                                        class="fa fa-{{ ($add->type == 1 || $add->type == 3) ? 'home' : 'building' }} mr-1"
                                                                                                                                                                        aria-hidden="true"></i> -->
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                                                    viewBox="0 0 25 25" fill="none">
                                                                    <path
                                                                        d="M3.77045 8.84343C5.82253 -0.177407 19.1871 -0.16699 21.2288 8.85384C22.4267 14.1455 19.135 18.6247 16.2496 21.3955C14.1559 23.4163 10.8434 23.4163 8.7392 21.3955C5.8642 18.6247 2.57253 14.1351 3.77045 8.84343Z"
                                                                        fill="#015158" />
                                                                    <path
                                                                        d="M12.5 13.9897C14.2949 13.9897 15.75 12.5347 15.75 10.7397C15.75 8.94482 14.2949 7.48975 12.5 7.48975C10.7051 7.48975 9.25 8.94482 9.25 10.7397C9.25 12.5347 10.7051 13.9897 12.5 13.9897Z"
                                                                        fill="#FEFEFE" />
                                                                </svg>
                                                                <span>{{ ($add->type == 1) ? __('Home') : (($add->type == 2) ? __('Office') : __('Others')) }}</span>
                                                            </h6>
                                                            <div>
                                                                <a class="btn btn-solid add_edit_address_btn"
                                                                    href="javascript:void(0)" data-toggle="modal"
                                                                    data-target="#add_edit_address" data-id="{{$add->id}}">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18"
                                                                        viewBox="0 0 19 18" fill="none">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M10.5118 0.80552C11.5849 -0.269234 13.3254 -0.269892 14.3994 0.804049L16.8912 3.2959C17.956 4.36068 17.9671 6.08444 16.916 7.16281L7.68291 16.6361C6.97738 17.3599 6.00972 17.7681 4.99928 17.7681L2.24714 17.768C0.96789 17.7679 -0.053723 16.7015 7.85806e-05 15.4224L0.118233 12.6134C0.157731 11.6744 0.54801 10.7844 1.21185 10.1195L10.5118 0.80552ZM13.3395 1.86551C12.8514 1.37736 12.0602 1.37766 11.5724 1.86618L9.90886 3.53227L14.1887 7.81207L15.8427 6.11505C16.3204 5.62488 16.3154 4.84136 15.8314 4.35737L13.3395 1.86551ZM2.27251 11.1802L8.84901 4.59374L13.1416 8.88634L6.60952 15.5883C6.18621 16.0226 5.60561 16.2675 4.99935 16.2675L2.2472 16.2674C1.82079 16.2674 1.48025 15.9119 1.49818 15.4856L1.61634 12.6765C1.64004 12.1131 1.8742 11.5791 2.27251 11.1802ZM17.5138 17.6967C17.9279 17.6967 18.2636 17.3608 18.2636 16.9464C18.2636 16.5321 17.9279 16.1962 17.5138 16.1962H11.3921C10.9781 16.1962 10.6424 16.5321 10.6424 16.9464C10.6424 17.3608 10.9781 17.6967 11.3921 17.6967H17.5138Z"
                                                                            fill="#015158" />
                                                                    </svg>
                                                                </a>
                                                                <a class="btn btn-solid delete_address_btn"
                                                                    href="javascript:void(0)" data-toggle="modal"
                                                                    data-target="#removeAddressConfirmation" data-id="{{$add->id}}">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="20"
                                                                        viewBox="0 0 17 20" fill="none">
                                                                        <path
                                                                            d="M10.8859 7.24609C10.6272 7.24609 10.4175 7.45579 10.4175 7.71448V16.5669C10.4175 16.8255 10.6272 17.0353 10.8859 17.0353C11.1447 17.0353 11.3543 16.8255 11.3543 16.5669V7.71448C11.3543 7.45579 11.1447 7.24609 10.8859 7.24609ZM5.35901 7.24609C5.10032 7.24609 4.89062 7.45579 4.89062 7.71448V16.5669C4.89062 16.8255 5.10032 17.0353 5.35901 17.0353C5.61774 17.0353 5.82739 16.8255 5.82739 16.5669V7.71448C5.82739 7.45579 5.61774 7.24609 5.35901 7.24609Z"
                                                                            fill="black" />
                                                                        <path
                                                                            d="M1.33027 5.95419V17.4942C1.33027 18.1763 1.58039 18.8168 2.0173 19.2764C2.23243 19.5044 2.49179 19.6861 2.77953 19.8106C3.06726 19.935 3.37734 19.9994 3.69083 20H12.5528C12.8663 19.9995 13.1764 19.935 13.4641 19.8106C13.7519 19.6862 14.0112 19.5044 14.2264 19.2764C14.6633 18.8168 14.9134 18.1763 14.9134 17.4942V5.95419C15.7819 5.72365 16.3447 4.88459 16.2286 3.9934C16.1122 3.10235 15.3531 2.43584 14.4543 2.43565H12.0562V1.85017C12.0576 1.60644 12.0105 1.36487 11.9177 1.13949C11.825 0.914104 11.6883 0.709396 11.5158 0.537249C11.3432 0.365119 11.1381 0.228993 10.9125 0.136776C10.6869 0.0445581 10.4451 -0.0019131 10.2014 6.07144e-05H6.0423C5.79855 -0.00191931 5.55683 0.0445489 5.33119 0.136767C5.10554 0.228984 4.90047 0.365114 4.72788 0.537249C4.55533 0.709396 4.4187 0.914104 4.32592 1.13949C4.23314 1.36487 4.18606 1.60644 4.18741 1.85017V2.43565H1.78938C0.890649 2.43584 0.131541 3.10235 0.0151478 3.9934C-0.101011 4.88459 0.461751 5.72365 1.33027 5.95419ZM12.5528 19.0632H3.69088C2.89004 19.0632 2.26704 18.3753 2.26704 17.4942V5.99536H13.9766V17.4942C13.9766 18.3753 13.3537 19.0632 12.5528 19.0632ZM5.12418 1.85017C5.12265 1.72942 5.14539 1.60958 5.19106 1.49779C5.23673 1.38599 5.30439 1.2845 5.39003 1.19936C5.47564 1.11416 5.57749 1.04702 5.68954 1.00193C5.80158 0.95683 5.92154 0.934693 6.0423 0.936827H10.2014C10.3222 0.934693 10.4421 0.95683 10.5542 1.00193C10.6662 1.04702 10.7681 1.11416 10.8537 1.19936C10.9393 1.2845 11.007 1.38598 11.0526 1.49778C11.0983 1.60958 11.121 1.72942 11.1195 1.85017V2.43565H5.12418V1.85017ZM1.78938 3.37242H14.4544C14.92 3.37242 15.2975 3.74989 15.2975 4.21551C15.2975 4.68113 14.92 5.0586 14.4544 5.0586H1.78934C1.32372 5.0586 0.946246 4.68113 0.946246 4.21551C0.946246 3.74989 1.32376 3.37242 1.78938 3.37242Z"
                                                                            fill="black" />
                                                                        <path
                                                                            d="M8.12268 7.24609C7.86399 7.24609 7.6543 7.45579 7.6543 7.71448V16.5669C7.6543 16.8255 7.86399 17.0353 8.12268 17.0353C8.38141 17.0353 8.59106 16.8255 8.59106 16.5669V7.71448C8.59106 7.45579 8.38141 7.24609 8.12268 7.24609Z"
                                                                            fill="black" />
                                                                    </svg></a>
                                                            </div>
                                                        </div>
                                                        <div class="p-2">
                                                            <p class="mb-1">
                                                                {{ ($add->house_number ?? false) ? $add->house_number . "," : '' }}
                                                                {{$add->address}}
                                                            </p>
                                                            <p class="mb-1">{{$add->street}}</p>
                                                            <p class="mb-1">{{$add->city}}, {{$add->state}} {{$add->pincode}}</p>
                                                            <p class="mb-1">{{$add->country ? $add->country : ''}}</p>
                                                        </div>
                                                    </div>
                                                    @if($add->latitude == '' || $add->longitude == '')
                                                        <span class="badge badge-warning ml-2">Incomplete</span>
                                                    @endif
                                                </div>
                                                <!-- <div
                                                                                                            class="address-btn d-flex align-items-center justify-content-start w-100 mt-sm-2 mb-2 px-2">
                                                                                                            @if($add->is_primary == 1)
                                                                                                                <a class="btn btn-solid disabled" href="#">{{ __('Primary') }}</a>
                                                                                                            @else
                                                                                                                @if($add->latitude != '' || $add->longitude != '')
                                                                                                                    <a class="btn btn-solid" href="{{ route('setPrimaryAddress', $add->id) }}"
                                                                                                                        class="mr-2">{{ __('Set As Primary') }}</a>
                                                                                                                @endif
                                                                                                            @endif

                                                                                                        </div> -->
                                            </div>
                                        </div>
                                    @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <div class="modal fade" id="removeAddressConfirmation" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="remove_addressLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title" id="remove_addressLabel">{{ __('Delete Address') }} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <rect x="1" y="1" width="16" height="16" rx="3.75" stroke="#858585" stroke-width="1.125" />
                            <path d="M5.80029 11.7632L11.7637 5.7998" stroke="#858585" stroke-width="1.2"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M5.80029 5.7998L11.7637 11.7632" stroke="#858585" stroke-width="1.2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <h6 class="m-0">
                        {{ __('Do you really want to delete this address ?') }}
                    </h6>
                </div>
                <div class="modal-footer flex-nowrap justify-content-center align-items-center">
                    <button type="button" class="btn btn-solid black-btn" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="button" class="btn btn-solid" id="remove_address_confirm_btn"
                        data-id="">{{ __('Delete') }}</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/template" id="add_address_template">
                                                                                                                                                                                    <div class="modal-header border-bottom">
                                                                                                                                                                                        <% if(title == 'Edit') { %>
                                                                                                                                                                                            <h5 class="modal-title" id="addedit-addressLabel">{{ __('Edit') }} {{ __('Address') }}</h5>
                                                                                                                                                                                        <% }else{ %>
                                                                                                                                                                                            <h5 class="modal-title" id="addedit-addressLabel">{{ __('Add') }} {{ __('Address') }}</h5>
                                                                                                                                                                                        <% } %>
                                                                                                                                                                                        <button type="button" class="close_cta close" data-dismiss="modal" aria-label="Close">
                                                                                                                                                                                          <span aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                                                                                                                                    <rect x="1" y="1" width="16" height="16" rx="3.75" stroke="#858585" stroke-width="1.125" />
                                                                                                                                                    <path d="M5.80029 11.7632L11.7637 5.7998" stroke="#858585" stroke-width="1.2"
                                                                                                                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                                                                                                                    <path d="M5.80029 5.7998L11.7637 11.7632" stroke="#858585" stroke-width="1.2"
                                                                                                                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                                                                                                                </svg></span>
                                                                                                                                                                                        </button>
                                                                                                                                                                                    </div>
                                                                                                                                                                                    <div class="modal-body">
                                                                                                                                                                                        <% if(title == 'Edit') { %>
                                                                                                                                                                                            <form id="add_edit_address_form" method="post"  enctype="multipart/form-data" action="{{route('address.update')}}/<%= address.id %>">
                                                                                                                                                                                        <% }else{ %>
                                                                                                                                                                                            <form id="add_edit_address_form" method="post"  enctype="multipart/form-data" action="{{route('address.store')}}">
                                                                                                                                                                                        <% } %>
                                                                                                                                                                                        @csrf
                                                                                                                                                                                        <div class="outer-box border-0 p-0"> 
                                                                                                                                                                                            <div class="row">
                                                                                                                                                                                                <div class="col-md-12" id="add_new_address_form">
                                                                                                                                                                                                    <div class="theme-card w-100">
                                                                                                                                                                                                        <div class="form-row no-gutters">
                                                                                                                                                                                                            <div class="col-12">
                                                                                                                                                                                                                <label for="type">{{ __('Address Type') }}</label>
                                                                                                                                                                                                            </div>
                                                                                                                                                                                                            <div class="col-3">
                                                                                                                                                                                                                <div class="delivery_box pt-0 pl-0  pb-2">
                                                                                                                                                                                                                    <label class="radio m-0">{{ __('Home') }}
                                                                                                                                                                                                                        <input type="radio" name="type" <%= (typeof address != 'undefined') ? ((address.type == 1) ? 'checked="checked"' : '') : 'checked="checked"' %> value="1">
                                                                                                                                                                                                                        <span class="checkround"></span>
                                                                                                                                                                                                                    </label>
                                                                                                                                                                                                                </div>
                                                                                                                                                                                                            </div>
                                                                                                                                                                                                            <div class="col-3">
                                                                                                                                                                                                            <div class="delivery_box pt-0 pl-0  pb-2">
                                                                                                                                                                                                                <label class="radio m-0">{{ __('Office') }}
                                                                                                                                                                                                                    <input type="radio" name="type" <%= ((typeof address != 'undefined') && (address.type == 2)) ? 'checked="checked"' : '' %> value="2">
                                                                                                                                                                                                                    <span class="checkround"></span>
                                                                                                                                                                                                                </label>
                                                                                                                                                                                                            </div>
                                                                                                                                                                                                        </div>
                                                                                                                                                                                                        <div class="col-3">
                                                                                                                                                                                                            <div class="delivery_box pt-0 pl-0  pb-2">
                                                                                                                                                                                                                <label class="radio m-0">{{ __('Others') }}
                                                                                                                                                                                                                    <input type="radio" name="type" <%= ((typeof address != 'undefined') && (address.type == 3)) ? 'checked="checked"' : '' %> value="3">
                                                                                                                                                                                                                    <span class="checkround"></span>
                                                                                                                                                                                                                </label>
                                                                                                                                                                                                            </div>
                                                                                                                                                                                                        </div>
                                                                                                                                                                                                        </div>
                                                                                                                                                                                                        <% if(title == 'Edit') { %>
                                                                                                                                                                                                        <input type="hidden" name="address_id" id="address_id" value="<%= address.id %>">
                                                                                                                                                                                                        <% } %>
                                                                                                                                                                                                        <input type="hidden" name="latitude" id="latitude" value="<%= (typeof address != 'undefined') ? address.latitude : '' %>">
                                                                                                                                                                                                        <input type="hidden" name="longitude" id="longitude" value="<%= (typeof address != 'undefined') ? address.longitude : '' %>">
                                                                                                                                                                                                        <div class="form-rows">

                                                                                                                                                                                                            <div class="">
                                                                                                                                                                                                                <label for="address">{{ __('Address') }}</label>
                                                                                                                                                                                                                <div class="input-group address-input-group">
                                                                                                                                                                                                                    <input type="text" name="address" class="form-control" id="address" placeholder="{{ __('Address') }}" aria-label="Recipient's Address" aria-describedby="button-addon2" value="<%= (typeof address != 'undefined') ? address.address : '' %>" autocomplete="off" required="required">
                                                                                                                                                                                                                    <div class="input-group-append">
                                                                                                                                                                                                                    <button class="btn btn-outline-secondary showMapHeader" type="button" id="button-addon2">
                                                                                                                                                                                                                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                                                                                                                                                                                                                    </button>
                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                <span class="text-danger" id="address_error"></span>
                                                                                                                                                                                                            </div>
                                                                                                                                                                                                            {{-- <div class="col-md-12 mb-2">
                                                                                                                                                                                                                <label for="address">{{ __('image') }}</label>
                                                                                                                                                                                                                <div class="input-group address-input-group">
                                                                                                                                                                                                                    <input type="file" name="image" class="form-control" id="address" placeholder="{{ __('Address') }}" >

                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                <span class="text-danger" id="address_error"></span>
                                                                                                                                                                                                            </div> --}}
                                                                                                                                                                                                        </div>
                                                                                                                                                                                                        <div class="form-rows">
                                                                                                                                                                                                            <div class="">
                                                                                                                                                                                                                <label for="house_number">{{ __('House / Apartment/ Flat No.') }}</label>
                                                                                                                                                                                                                <input type="text" class="form-control" id="house_number" placeholder="{{ __('House / Apartment/ Flat No.') }}" name="house_number" value="<%= ((typeof address != 'undefined') && (address.house_number != null)) ? address.house_number : '' %>">
                                                                                                                                                                                                                <span class="text-danger" id="house_number_error"></span>
                                                                                                                                                                                                            </div>
                                                                                                                                                                                                            <div class="">
                                                                                                                                                                                                                <label for="street">{{ __('Street') }}</label>
                                                                                                                                                                                                                <input type="text" class="form-control" id="street" placeholder="{{ __('Street') }}" name="street" value="<%= ((typeof address != 'undefined') && (address.street != null)) ? address.street : '' %>">
                                                                                                                                                                                                                <span class="text-danger" id="street_error"></span>
                                                                                                                                                                                                            </div>

                                                                                                                                                                                                        </div>
                                                                                                                                                                                                        <div class="form-rows">
                                                                                                                                                                                                            <div class="">
                                                                                                                                                                                                                <label for="city">{{ __('City') }}</label>
                                                                                                                                                                                                                <input type="text" class="form-control" id="city" name="city" placeholder="{{ __('City') }}" value="<%= ((typeof address != 'undefined') && (address.city != null)) ? address.city : '' %>" required="required">
                                                                                                                                                                                                                <span class="text-danger" id="city_error"></span>
                                                                                                                                                                                                            </div>
                                                                                                                                                                                                            <div class="">
                                                                                                                                                                                                                <label for="state">{{ __('State') }}</label>
                                                                                                                                                                                                                <input type="text" class="form-control" id="state" name="state" placeholder="{{ __('State') }}" value="<%= ((typeof address != 'undefined') && (address.state != null)) ? address.state : '' %>" required="required">
                                                                                                                                                                                                                <span class="text-danger" id="state_error"></span>
                                                                                                                                                                                                            </div>

                                                                                                                                                                                                        </div>
                                                                                                                                                                                                        <div class="form-rows mb-0">
                                                                                                                                                                                                            <div class="">
                                                                                                                                                                                                                <label for="country">{{ __('Select') }} {{ __('Country') }}</label>
                                                                                                                                                                                                                <select name="country" id="country" class="form-control" value="<%= ((typeof address != 'undefined') && (address.country_id != null)) ? address.country_id : '' %>" required="required">
                                                                                                                                                                                                                    <option value="">{{__('Select country')}}</option>
                                                                                                                                                                                                                    @foreach($countries as $co)
                                                                                                                                                                                                                        <option value="{{$co->id}}" <%= ((typeof address != 'undefined') && (address.country_id == {{$co->id}})) ? 'selected="selected"' : '' %>>{{$co->name}}</option>
                                                                                                                                                                                                                    @endforeach
                                                                                                                                                                                                                </select>
                                                                                                                                                                                                                <span class="text-danger" id="country_error"></span>
                                                                                                                                                                                                            </div>
                                                                                                                                                                                                            <div class="">
                                                                                                                                                                                                                <label for="pincode">{{ getNomenclatureName('Zip Code', true) }}</label>
                                                                                                                                                                                                                <input type="text" class="form-control" id="pincode" name="pincode" placeholder="{{ getNomenclatureName('Zip Code', true) }}" value="<%= ((typeof address != 'undefined') && (address.pincode != null)) ? address.pincode : ''%>" required="required">
                                                                                                                                                                                                                <span class="text-danger" id="pincode_error"></span>
                                                                                                                                                                                                            </div>
                                                                                                                                                                                                            <div class="">
                                                                                                                                                                                                                <label for="extra_instruction">{{ __('Extra Instructions') }}</label>
                                                                                                                                                                                                                <input type="text" class="form-control" id="extra_instruction" name="extra_instruction" placeholder="{{ __('Extra instruction for driver to follow..') }}" value="<%= ((typeof address != 'undefined') && (address.extra_instruction != null)) ? address.extra_instruction : ''%>">
                                                                                                                                                                                                                <span class="text-danger" id="extra_instruction_error"></span>
                                                                                                                                                                                                            </div>
                                                                                                                                                                                                            <div class="col-md-12">
                                                                                                                                                                                                            <div class="row mt-2">
                                                                                                                                                                                                                <div class="col-md-6">
                                                                                                                                                                                                                <button type="button" class="btn btn-solid black-btn" data-dismiss="modal">{{__('Cancel')}}</button>
                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                <div class="col-md-6">
                                                                                                                                                                                                                    <button type="button" class="btn btn-solid" id="<%= ((typeof address !== 'undefined') && (address !== false)) ? 'updateAddress' : 'saveAddress' %>">{{__('Add') }}</button>
                                                                                                                                                                                                                </div>
                                                                                                                                                                                                            </div>
                                                                                                                                                                                                            </div>
                                                                                                                                                                                                        </div>
                                                                                                                                                                                                    </div>
                                                                                                                                                                                                </div>
                                                                                                                                                                                            </div>
                                                                                                                                                                                        </div>
                                                                                                                                                                                        </form>
                                                                                                                                                                                    </div>
                                                                                                                                                                                </script>
    <div class="modal fade" id="add_edit_address" tabindex="-1" aria-labelledby="addedit-addressLabel" aria-hidden="true"
        data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered add_edit_address_dialog">
            <div class="modal-content">

            </div>
        </div>
    </div>
    <div class="modal fade pick-address" id="pick_address" tabindex="-1" aria-labelledby="pick-addressLabel"
        aria-hidden="true" data-backdrop="static" data-keyboard="false" style="background-color: rgba(0,0,0,0.8);">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title" id="pick-addressLabel">{{ __('Select Location') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <rect x="1" y="1" width="16" height="16" rx="3.75" stroke="#858585" stroke-width="1.125" />
                            <path d="M5.80029 11.7632L11.7637 5.7998" stroke="#858585" stroke-width="1.2"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M5.80029 5.7998L11.7637 11.7632" stroke="#858585" stroke-width="1.2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="address-map-container" class="w-100" style="height: 500px; min-width: 500px;">
                                <div id="pick-address-map" class="h-100"></div>
                            </div>
                            <div class="pick_address p-2 mb-2 position-relative">
                                <div class="text-center">
                                    <button type="button" class="btn btn-solid ml-auto pick_address_confirm w-100"
                                        data-dismiss="modal">{{ __('Ok') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        var user_store_address_url = "{{ route('address.store') }}";
        var user_address_url = "{{ route('user.address', ':id') }}";
        var update_address_url = "{{ route('address.update', ':id') }}";
        var delete_address_url = "{{ route('deleteAddress', ':id') }}";
        var verify_information_url = "{{ route('verifyInformation', Auth::user()->id) }}";


        var ajaxCall = 'ToCancelPrevReq';
        $('.verifyEmail').click(function () {
            verifyUser('email');
        });
        $('.verifyPhone').click(function () {
            verifyUser('phone');
        });
        $(document).delegate(".delete_address_btn", "click", function () {
            var addressID = $(this).attr("data-id");
            $("#remove_address_confirm_btn").attr("data-id", addressID);
        });
        $(document).delegate("#remove_address_confirm_btn", "click", function () {
            var addressID = $(this).attr("data-id");
            var url = delete_address_url.replace(':id', addressID);
            location.href = url;
        });
        $(document).ready(function () {
            $(document).delegate(".add_edit_address_btn", "click", function () {
                var addressID = $(this).attr("data-id");
                if (typeof addressID !== 'undefined' && addressID !== false) {
                    $.ajax({
                        type: "get",
                        dataType: "json",
                        url: user_address_url.replace(':id', addressID),
                        success: function (response) {
                            // console.log(response);
                            if (response.status == 'success') {
                                $("#add_edit_address .modal-content").html('');
                                let add_address_template = _.template($('#add_address_template').html());
                                $("#add_edit_address .modal-content").append(add_address_template({ title: 'Edit', address: response.address, countries: response.countries }));
                                initialize();
                            } else {
                                $('#add_new_address').modal('hide');
                            }
                        }
                    });
                }
                else {
                    $("#add_edit_address .modal-content").html('');
                    let add_address_template = _.template($('#add_address_template').html());
                    $("#add_edit_address .modal-content").append(add_address_template({ title: 'Add' }));
                    initialize();
                }
            });

        });

        $(document).on("click", "#saveAddress", function () {

            var latitude = $('#add_edit_address_form #latitude').val();
            var longitude = $('#add_edit_address_form #longitude').val();
            if (latitude != '' && longitude != '') {
                $("#add_edit_address_form").submit();
            } else {
                Swal.fire({
                    title: "Warning!",
                    text: "Please select address from suggessions or from map.",
                    icon: "warning",
                    button: "OK",
                });
                $(".showMapHeader").click();
            }
        });

        function verifyUser($type = 'email') {
            ajaxCall = $.ajax({
                type: "post",
                dataType: "json",
                url: verify_information_url,
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
                }
            });
        }

        $(document).on("click", "#updateAddress", function () {
            let city = $('#add_edit_address_form #city').val();
            let state = $('#add_edit_address_form #state').val();
            let street = $('#add_edit_address_form #street').val();
            let address = $('#add_edit_address_form #address').val();
            let country = $('#add_edit_address_form #country').val();
            let pincode = $('#add_edit_address_form #pincode').val();
            let type = $('input[name="type"]:checked').val();
            let latitude = $('#add_edit_address_form #latitude').val();
            let longitude = $('#add_edit_address_form #longitude').val();
            let address_id = $('#add_edit_address_form #address_id').val();
            let extra_info = $('#add_edit_address_form #extra_instruction').val();
            let house_number = $('#add_edit_address_form #house_number').val();
            $.ajax({
                type: "post",
                url: update_address_url.replace(':id', address_id),
                data: {
                    "city": city,
                    "type": type,
                    "state": state,
                    "street": street,
                    "address": address,
                    "country": country,
                    "pincode": pincode,
                    "latitude": latitude,
                    "extra_instruction": extra_info,
                    "house_number": house_number,
                    "longitude": longitude,
                },
                success: function (response) {
                    if ($("#add_edit_address").length > 0) {
                        $("#add_edit_address").modal('hide');
                        location.reload();
                    }
                    else {
                        $("#add_edit_address .modal-content").html('');
                        let add_address_template = _.template($('#add_address_template').html());
                        $("#add_edit_address .modal-content").append(add_address_template({ title: 'Edit', address: response.address }));
                    }
                },
                error: function (reject) {
                    if (reject.status === 422) {
                        var message = $.parseJSON(reject.responseText);
                        $.each(message.errors, function (key, val) {
                            $("#" + key + "_error").text(val[0]);
                        });
                    }
                }
            });
        });

        $(document).on('click', '.showMapHeader', function () {
            var lats = document.getElementById('latitude').value;
            var lngs = document.getElementById('longitude').value;
            if (lats == '') {
                lats = "{{ session()->has('latitude') ? session()->get('latitude') : 0 }}";
            }
            if (lngs == '') {
                lngs = "{{ session()->has('longitude') ? session()->get('longitude') : 0 }}";
            }
            if (lats == 0) {
                lats = userLatitude;
            }
            if (lngs == 0) {
                lngs = userLongitude;
            }

            var myLatlng = new google.maps.LatLng(lats, lngs);

            var infowindow = new google.maps.InfoWindow();
            var geocoder = new google.maps.Geocoder();
            var mapProp = {
                center: myLatlng,
                zoom: 13,
                mapTypeId: google.maps.MapTypeId.ROADMAP

            };
            var map = new google.maps.Map(document.getElementById("pick-address-map"), mapProp);
            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                draggable: true
            });
            // marker drag event
            google.maps.event.addListener(marker, 'dragend', function () {
                geocoder.geocode({
                    'latLng': marker.getPosition()
                }, function (results, status) {

                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            document.getElementById('latitude').value = marker.getPosition().lat();
                            document.getElementById('longitude').value = marker.getPosition().lng();
                            document.getElementById('address').value = results[0].formatted_address;

                            infowindow.setContent(results[0].formatted_address);

                            infowindow.open(map, marker);
                        }
                    }
                });
            });

            // google.maps.event.addListener(marker,'drag',function(event) {
            //     document.getElementById('latitude').value = event.latLng.lat();
            //     document.getElementById('longitude').value = event.latLng.lng();
            // });
            // //marker drag event end
            // google.maps.event.addListener(marker,'dragend',function(event) {
            //     document.getElementById('latitude').value = event.latLng.lat();
            //     document.getElementById('longitude').value = event.latLng.lng();
            // });
            $('#pick_address').modal('show');

        });


        function initialize() {

            // var myLatlng = new google.maps.LatLng(userLatitude, userLongitude);
            // var mapProp = {
            //     center:myLatlng,
            //     zoom:13,
            //     mapTypeId:google.maps.MapTypeId.ROADMAP

            // };
            // var addressMap=new google.maps.Map(document.getElementById("pick-address-map"), mapProp);
            var input = document.getElementById('address');
            var autocomplete = new google.maps.places.Autocomplete(input);
            if (is_map_search_perticular_country) {
                autocomplete.setComponentRestrictions({ 'country': [is_map_search_perticular_country] });
            }
            autocomplete.bindTo('bounds', bindMap);

            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var place = autocomplete.getPlace();
                // console.log(place);
                document.getElementById('longitude').value = place.geometry.location.lng();
                document.getElementById('latitude').value = place.geometry.location.lat();
                for (let i = 1; i < place.address_components.length; i++) {
                    let mapAddress = place.address_components[i];
                    if (mapAddress.long_name != '') {
                        let streetAddress = '';
                        if (mapAddress.types[0] == "street_number") {
                            streetAddress += mapAddress.long_name;
                        }
                        if (mapAddress.types[0] == "route") {
                            streetAddress += mapAddress.short_name;
                        }
                        if ($('#street').length > 0) {
                            document.getElementById('street').value = streetAddress;
                        }
                        if (mapAddress.types[0] == "locality") {
                            document.getElementById('city').value = mapAddress.long_name;
                        }
                        if (mapAddress.types[0] == "administrative_area_level_1") {
                            document.getElementById('state').value = mapAddress.long_name;
                        }
                        if (mapAddress.types[0] == "postal_code") {
                            document.getElementById('pincode').value = mapAddress.long_name;
                        } else {
                            document.getElementById('pincode').value = '';
                        }
                        if (mapAddress.types[0] == "country") {
                            var country = document.getElementById('country');
                            for (let i = 0; i < country.options.length; i++) {
                                if (country.options[i].text.toUpperCase() == mapAddress.long_name.toUpperCase()) {
                                    country.value = country.options[i].value;
                                    break;
                                }
                            }
                        }
                    }
                }
            });

            setTimeout(function () {
                $(".pac-container").appendTo("#add_new_address_form .address-input-group");
            }, 300);

        }
    </script>
@endsection