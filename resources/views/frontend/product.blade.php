@extends('layouts.store', [
'title' => (!empty($product->translation) && isset($product->translation[0])) ? $product->translation[0]->title : '',
'meta_title'=>(!empty($product->translation) && isset($product->translation[0])) ? $product->translation[0]->meta_title:'',
'meta_keyword'=>(!empty($product->translation) && isset($product->translation[0])) ? $product->translation[0]->meta_keyword:'',
'meta_description'=>(!empty($product->translation) && isset($product->translation[0])) ? $product->translation[0]->meta_description:'',
])
@php
    $clientData = \App\Models\Client::select('socket_url')->first();
    $totalMilestone = \App\Models\ClientPreference::select('total_payment_milestone')->first();
    $lastSegment = Request::segment(count(Request::segments())); // check request detail
    $multiply =  session()->get('currencyMultiplier') ?? 1;
    $currencysymbol = session()->get('currencySymbol').' ';                              
@endphp
@section('css')
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css"/>
    <link rel="stylesheet" href="{{ asset('front-assets/css/swiper.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front-assets/css/easyzoom.css') }}" />
    <link rel="stylesheet" href="{{ asset('front-assets/css/main.css') }}" /> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{asset('css/jquery.exzoom.css')}}">
    @if($product->is_recurring_booking == 1)
        <link href="{{asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    @endif
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style type="text/css">
        /* .main-menu .brand-logo{display:inline-block;padding-top:20px;padding-bottom:20px}.btn-disabled{opacity:.5;pointer-events:none}.fab{font:normal normal normal 14px/1 FontAwesome;font-size:inherit}
        #number{display:block}#exzoom{display:none}.exzoom .exzoom_btn a.exzoom_next_btn{right:-12px} .exzoom .exzoom_nav .exzoom_nav_inner{-webkit-transition:all .5s;-moz-transition:all .5s;transition:all .5s}

        @media screen and (max-width:768px){
            .exzoom .exzoom_zoom_outer{display:none}
            }
        */
    .border-product.al_disc ol,.border-product.al_disc ul{padding-left:30px}.border-product.al_disc ol li,.border-product.al_disc ul li{display:list-item;padding-left:0;padding-top:8px;list-style-type:disc;font-size:14px}.border-product.al_disc ol li{list-style-type:decimal}.productVariants .firstChild{min-width:150px;text-align:left!important;border-radius:0!important;margin-right:10px;cursor:default;border:none!important}.product-right .color-variant li,.productVariants .otherChild{height:35px;width:35px;border-radius:50%;margin-right:10px;cursor:pointer;border:1px solid #f7f7f7;text-align:center}.productVariants .otherSize{height:auto!important;width:auto!important;border:none!important;border-radius:0}.product-right .size-box ul li.active{background-color:inherit}
    #more  {display:  none;}

    .img-zoom-lens {
      position: absolute;
      border: 1px solid #d4d4d4;
      width: 150px;
      height: 150px;
      background-color: #fff;
      opacity: .2;
      display: block;
    }

    .img-zoom-result {
        border: 1px solid #d4d4d4;
        width: 100%;
        height: 500px;
        position: absolute;
        top: 0;
        right: -100%;
        z-index: 10;
        display: none;
        background-color: #fff;
    }
    body[dir="rtl"] .img-zoom-result {
        border: 1px solid #d4d4d4;
        width: 100%;
        height: 500px;
        position: absolute;
        top: 0;
        right: auto;
        left: -100%;
        z-index: 10;
        display: none;
    }
    .review-date.mt-2 { margin-left: 10px; }
    .review-images img { min-height: 60px;border-radius: 8px;}
    .review-images a {display: inline-block;width: auto;padding: 0;}
    .review-images a:first-child img{margin-left: 10px;}
    .select2-results__option{width:100%;}
    .select2-container{width:100%!important;}
    .customer_review .item{padding:10px;border:1px solid #ccc;}
    .review_header{display:flex;padding-bottom:5px;}
    .review_header p{font-size:14px;margin-bottom:0px;padding-left:10px;}
    .customer_review .heading{border-bottom:1px solid #ccc;}
    .customer_review .heading h2{font-size:30px;line-height:1.3;font-weight:700;}
    .customer_review_item_row{display:flex;align-items:center;padding:10px 0;}
    .customer_review_item_row  img{width:50px;height: 50px;border-radius:50%;}
    .customer_review_item_row h4{margin-bottom:0;font-size:18px;font-weight:600;padding-left:15px;margin-top:0;}
    .review-images img {width: 100%;max-width: 100px;margin: 10px 10px 10px 0px;}
    .label-disabled {pointer-events: none;opacity: 0.5;}

    .flex-container {
    display: flex;
    justify-content: space-between; /* Distribute items evenly */
}

.item-price {
    text-align: center;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin: 10px;
    flex: 1; /* Distribute available space evenly */
    background-color: #f7f7f7;
}

#summary-table {
    width: 100%;
    border-collapse: collapse;
    margin: 30px 0px;
}
#summary-table  > th, td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}
#summary-table > .text-right {
    text-align: right;
}

.related-products .product-card-box {
    border-radius: 10px !important;
    overflow: hidden;
    box-shadow: 0 4px 14px 0 rgb(0 0 0 / 8%);
    padding: 0 !important;
}
.dark .related-products .product-card-box {
    background: #000 !important;
}
.related-products .product-card-box .media-body {
    padding: 0 20px 20px;
}

.slick-slide .inner_spacing p {
    display: block;
}

.border-product {
    border: 1px solid #e0e0e0;
    padding: 15px;
    border-radius: 5px;
    margin-top: 20px;
    background-color: #f9f9f9;
}

.product-title {
    font-size: 1.5em;
    font-weight: bold;
    margin-bottom: 10px;
    color: #333;
}

.table-responsive {
    overflow-x: auto;
}

.table {
    margin-bottom: 0;
}

.table thead {
    background-color: #343a40;
    color: #fff;
}

.table-hover tbody tr:hover {
    background-color: #f1f1f1;
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: #f9f9f9;
}

/* SCC FOR COMPANY BID FLOW*/
.hidden_bid_amount {
    display: none;
}
.modal-body {
    padding: 0rem;
}
.swiper-button-next:after, .swiper-button-prev:after {
    font-weight: 700;
    font-size: 20px;
    color: #fff !important;
    background: #0000006e;
    width: 50px !important;
    height: 30px;
    text-align: center;
    line-height: 30px;
    border-radius: 50px;
}
     
    .modal-content {
      background-color: #fefefe;
      margin: 5% auto;
      padding: 20px;
      border: 1px solid #888;
      max-width: 500px;
    }
    .view_details_slider .carousel-control-prev, .view_details_slider .carousel-control-prev {
        display: flex !important;
    }
    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }

    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    }

    /* Popup Styles */
    .popup {
        display: none; /* Hidden by default */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .popup-content {
        background-color: white;
        padding: 50px;
        border-radius: 8px;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        width: 500px;
    }

    button {
        padding: 10px 20px;
        margin: 10px;
        cursor: pointer;
        border: none;
        border-radius: 4px;
        font-size: 16px;
    }
    .no_cancel {
    background: #015158;
}
.mySwiper .swiper-wrapper {
    align-items: center;
}
.popup-content input{
    height: 50px;
    width: 100%;
    border: 1px solid;
    margin-bottom: 20px;
}

.popup-content textarea {
    height: 80px;
    width: 100%;
    border: 1px solid;
    margin-bottom: 20px;
    resize: none;
    border-radius: 5px;
    padding: 12px;
}
.popup-content button {
    margin: 0;
}
.eSignModalContent {
    width:100% !important;
}

.eSignModalContentBuyer {
    width:100% !important;
}
.Documents img {
    width: 80px;
    height: 80px;
    object-fit: contain;
    background: #abc8cb;
    padding: 10px;
    border-radius: 10px;
}
span.Submit_offer a {
    color: #76FF5D !important;
    padding: 10px !important;
}
.Company_name h3, .Liabilities h4, .dollar_aed h4:first-child, .financial h4 {
    color: #01383D;
    font-size: 16px;
    font-family: 'Mulish' !important;
    font-weight: 700;
}
.reject-raise-bid-modal {
    width:100%;
}

.btn-close {
    color: black !important;
}

#signatureCanvas, #signatureCanvasBuyer {
    border: 2px dotted black; /* Dotted border */
    display: block; /* Ensures no extra spacing */
    background: #0c3a301a;
}

    textarea {
        width: 100%;
        margin-bottom: 10px;
        height: 60px;
        padding: 8px;
        border-radius: 10px;
        border: 1px solid #ccc;
    }

    .upload-wrapper {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background-color: #e9f1f2;
      border-radius: 10px;
      padding: 12px 16px;
      width: 459px;
      position: relative;
    }

    .upload-icon {
      background-color: #004c4c;
      color: white;
      padding: 10px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 10px;
    }

    .upload-label {
      flex: 1;
      color: #333;
      font-weight: 500;
    }

    .upload-right-icon {
      color: #004c4c;
    }

    .upload-wrapper input[type="file"] {
      opacity: 0;
      position: absolute;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      cursor: pointer;
    }


</style>

@endsection
@section('css-compare')
@endsection

@section('content')

@if(!empty($category))
@include('frontend.included_files.products_breadcrumb')
@endif
@php
$category_name =  ($category->translation->first()) ? $category->translation->first()->name : $category->slug;
  $img = '';
  $additionalPreference = getAdditionalPreference(['is_token_currency_enable','token_currency', 'add_to_cart_btn']);
@endphp
<!-- <div class="toast">
    <div class="toast-header">
      Toast Header
    </div>
    <div class="toast-body">
      Some text inside the toast body
    </div>
  </div> -->

<section class="section-b-space alSingleProducts product_ddetails_page">
    <div class="collection-wrapper al">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="text-sm-left">
                        @if (\Session::has('success'))
                            <div class="alert alert-success">
                                <span>{!! \Session::get('success') !!}</span>
                            </div>
                        @endif
                        @if (\Session::has('error'))
                            <div class="alert alert-danger">
                                <span>{!! \Session::get('error') !!}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="container-fluid">

                        <!-- p2p bid product detail -->
                            <section class="buy_details">
                            <div class="view_details_slider">
                                <div class="container">
                                  <div class="row">
                                    <div class="col-md-7">
                                      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner">
                                            @if(!empty($product->media) && count($product->media) > 0)
                                            @foreach($product->media as $k => $image)
                                            @php
                                                if(isset($image->pimage)){
                                                    $img = $image->pimage->image;
                                                }else{
                                                    $img = $image->image;
                                                }
                                            @endphp
                                            @if(!is_null($img) && $image->is_default=='1') <!-- /is defualt is use to check p image or doc/ -->
                                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                    <img src="{{@$img->path['image_fit'].'1000/1000'.@$img->path['image_path']}}" class="d-block w-100" style="height:520 px !important"/>
                                                </div>
                                            @endif
                                            @endforeach
                                            @endif
                                        </div>
                                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                          <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                          <span class="carousel-control-next-icon"  aria-hidden="true"></span>
                                          <span class="sr-only">Next</span>
                                        </a>
                                      </div>
                                      <div class="row mt-3 mb-3">
                                        <div class="col-md-6 shadow p-3 rounded  border-right">
                                          <span class="financial">
                                            <h4 class="mt-2 mb-2">Operational Information</h4>
                          
                                            <label class="d-flex justify-content-between mb-0">
                                              <h6 class="mt-0 mb-0">No. of Employees</h6>
                                              <h6 class="mt-0 mb-0">{{$product->company_team_size.'.00' ?? '0.00'}}</h6>
                                            </label>
                                            <label class="d-flex justify-content-between mb-0">
                                              <h6 class="mt-0 mb-0">Key Assists</h6>
                                              <h6 class="mt-0 mb-0">{{$product->company_sale_type ?? 'N/A'}}</h6>
                                            </label>
                                            <label class="d-flex justify-content-between mb-0">
                                              <h6 class="mt-0 mb-0">Business Model</h6>
                                              <h6 class="mt-0 mb-0">{{$product->company_technology ?? 'N/A'}}</h6>
                                            </label>
                                            <label class="d-flex justify-content-between mb-0">
                                              <h6 class="mt-0 mb-0">Amortization</h6>
                                              <h6 class="mt-0 mb-0">{{$currencysymbol}} 12,542.01</h6>
                                            </label>
                                          </span>
                          
                                          <span class="financial">
                                            <h4 class="mt-2 mb-2">Customer Base</h4>
                                            <label class="d-flex justify-content-between mb-0">
                                                <h6 class="mt-0 mb-0">Name</h6>
                                                <h6 class="mt-0 mb-0">{{ $vendorDetail->name ?? 'N/A' }}</h6>
                                              </label>
                                              <label class="d-flex justify-content-between mb-0">
                                                <h6 class="mt-0 mb-0">Email</h6>
                                                <h6 class="mt-0 mb-0">{{ $vendorDetail->email ?? 'N/A' }}</h6>
                                              </label>
                                              <label class="d-flex justify-content-between mb-0">
                                                <h6 class="mt-0 mb-0">Address</h6>
                                                <h6 class="mt-0 mb-0">{{$product->address ?? 'N/A'}}</h6>
                                              </label>
                                              <label class="d-flex justify-content-between mb-0">
                                                <h6 class="mt-0 mb-0">Income</h6>
                                                <h6 class="mt-0 mb-0">{{$currencysymbol}} 12,542.01</h6>
                                              </label>
                                            {{-- <label class="d-flex justify-content-between mb-0">
                                              <h6 class="mt-0 mb-0">Size</h6>
                                              <h6 class="mt-0 mb-0">2,540 Yards</h6>
                                            </label>
                                            <label class="d-flex justify-content-between mb-0">
                                              <h6 class="mt-0 mb-0">Age</h6>
                                              <h6 class="mt-0 mb-0">{{$currencysymbol}} 12,542.01</h6>
                                            </label>
                                            <label class="d-flex justify-content-between mb-0">
                                              <h6 class="mt-0 mb-0">Gender</h6>
                                              <h6 class="mt-0 mb-0">{{$currencysymbol}} 12,542.01</h6>
                                            </label>
                                            <label class="d-flex justify-content-between mb-0">
                                              <h6 class="mt-0 mb-0">Income</h6>
                                              <h6 class="mt-0 mb-0">{{$currencysymbol}} 12,542.01</h6>
                                            </label> --}}
                                          </span>
                                        </div>
                          
                                        <div class="col-md-6 shadow p-3 rounded">
                                          <div class="Liabilities">
                                            <h4>Debt & Liabilities</h4>
                                            <p>
                                                {{$product->financialInfo->notes_offer ?? 'N/A'}}   
                                            </p>
                                          </div>
                                            <hr>
                                          <div class="Liabilities">
                                            <h4>Reason for Sale</h4>
                                            <p>
                                               {{$product->financialInfo->sale_reason ?? 'N/A'}}
                                            </p>
                                          </div>
                                        </div>
                                        @if(!empty($product->dynamicFormData) && $product->dynamicFormData->count() > 0)
                                        <div class="col-md-12 shadow p-3 rounded">
                                            <span class="financial">
                                                <h4 class="mt-2 mb-2">Dynamic Attributes</h4>
                                                @foreach ($product->dynamicFormData as $field)
                                                    <label for="{{ $field->field_name }}" class="d-flex justify-content-between mb-0">
                                                    <h6 class="mt-0 mb-0"> {{ ucwords(str_replace('_', ' ', $field->field_name ?? '')) }}</h6>
                                                    <h6 class="mt-0 mb-0">{{ $field->field_value ?? '' }}</h6>
                                                    </label>
                                                @endforeach
                                            </span>
                                        </div>
                                        @endif
                                      </div>
                                    </div>
                                          
                                    <div class="col-md-5">
                                      <div class="Company_name shadow p-3 rounded">
                                        <span class="release_seller d-flex justify-content-between">
                                          <a class="darkgreen_bg" href="#">New Release</a>
                                          @if($lastSegment != 'seller_request') 
                                          <a class="darkblack_border" href="{{ url($product->vendor->slug . '/product-page/' . $product->url_slug.'/'.'seller_request') }}">Contact with seller</a>
                                          @endif
                                        </span>
                                        @php $productData = json_decode($product->translation, true);@endphp
                                       
                          
                                        <h3>{{ $productData[0]['title'] ?? '' }}</h3>
                          
                                        <span class="dollar_aed d-flex">
                                          <h4 class="mr-3">{{$currencysymbol}} {{@$product->financialInfo->price.'.00' ?? '0.00'}}</h4>
                                          <h4>{{$currencysymbol}} {{@$product->financialInfo->proposed_price.'.00' ?? '0.00'}}</h4>
                                        </span>
                          
                                        <ul class="grot d-flex justify-content-between pt-2 pb-2">
                                          <li>Company Type-: {{ ucfirst($product->category->categoryDetail->slug) }}</li>
                                          {{-- <li>Launch Date</li> --}}
                                          <li>Launch Date -: {{ $product->company_launch_date ? \Carbon\Carbon::parse($product->launch_date)->format('d M, Y') : 'N/A' }}</li>
                                        </ul>
                          
                                        <span class="financial">
                                          <h4 class="mb-1">Financial Information</h4>
                          
                                          <label class="d-flex justify-content-between mb-0">
                                            <h6 class="mb-0">Annual Revenue</h6>
                                            <h6 class="mb-0">{{$currencysymbol}} 12,542.01</h6>
                                          </label>
                                          <label class="d-flex justify-content-between mb-0">
                                            <h6>Net Profit</h6>
                                            <h6>{{$currencysymbol}} 12,542.01</h6>
                                          </label>
                                        </span>
                          
                                        <span class="financial">
                                          <h4 class="mt-1 mb-1">EBITDA</h4>
                          
                                          <label class="d-flex justify-content-between mb-0">
                                            <h6 class="mb-1">Earning before interest (Matrics)</h6>
                                            <h6 class="mb-1">{{$currencysymbol}} {{ $product->financialInfo->matrics ?? '0.00' }}</h6>
                                          </label>
                                          <label class="d-flex justify-content-between mb-0">
                                            <h6 class="mb-1">Taxes</h6>
                                            <h6 class="mb-1">{{$currencysymbol}} 40.00</h6>
                                          </label>
                                          <label class="d-flex justify-content-between mb-0">
                                            <h6 class="mb-1">Depreciation</h6>
                                            <h6 class="mb-1">{{$currencysymbol}} 500.01</h6>
                                          </label>
                                          <label class="d-flex justify-content-between mb-0">
                                            <h6 class="mb-1">Amortization</h6>
                                            <h6 class="mb-1">{{$currencysymbol}} 000.10</h6>
                                          </label>
                                          <label class="d-flex justify-content-between mb-0">
                                            <h6 class="mb-1">Asking Price</h6>
                                            <h6 class="mb-1">{{$currencysymbol}} {{@$product->financialInfo->proposed_price.'.00' ?? '0.00'}}</h6>
                                          </label>
                                        </span>
                          
                                        <span
                                          class="financial bg-light d-inline-block p-2 mt-3 mb-3 w-100 rounded"
                                        >
                                          <h4>Ownership & Stake</h4>
                                          <label class="d-flex justify-content-between mb-0">
                                            <h6 class="mt-0 mb-0">Ownership Structure</h6>
                                            <h6 class="mt-0 mb-0">Single Owner</h6>
                                          </label>
                                          <label class="d-flex justify-content-between mb-0">
                                            <h6 class="mt-0 mb-0">Stake available for sale</h6>
                                            <h6 class="mt-0 mb-0">20%</h6>
                                          </label>
                                        </span>
                                    </span>
                                             
                                        @if(!empty($bid_type) && $bid_type =='incoming')

                                                <!-- Start Chat Button -->
                                                @auth
                                                {{-- @if ( $user_vendor->vendor_id != $product->vendor_id) --}}
                                                @if(isset($reqestToSeller) && $reqestToSeller->bid_status == 'rejected')
                                                    <span class="Submit_offer1">
                                                        <label class="d-flex justify-content-between mb-0">
                                                            <a style="background: #015158"
                                                        class="p-1 w-100 text-center text-white rounded"
                                                    disabled> Bid Rejected</a>
                                                        </label>
                                                    </span>
                                                @endif    
                                                @if(isset($reqestToSeller) && $reqestToSeller->bid_status == 'matched')
                                                    <div class="chat-button p-1 w-100 d-flex justify-content-between text-center offer_submit text-white rounded" style="gap: 10px;">
                                                        <a class="start_chat chat-icon btn btn-solid w-75 p-1 rounded darkgreen"  data-vendor_order_id="" data-chat_type="userToUser" data-vendor_id="{{$product->vendor_id}}" data-orderid="" data-order_id="" data-product_id="{{$product->id}}"><i class="fa fa-comments" aria-hidden="true"> Messages</i></a>
                                                        
                                                        @php
                                                            $isFavorite = Auth::check() && $product->isFavoritedByUser(Auth::id());
                                                        @endphp
                                                        <a href="javascript:void(0);" class="bg-light w-25 p-1 rounded favorite-btn" data-product-id="{{ $product->id }}">
                                                            @if($isFavorite)
                                                                <i class="fa fa-heart favorite-icon" style="padding-top: 8px; color:#37af19; font-size: x-large;"></i>
                                                            @else
                                                                <i class="fa fa-heart-o favorite-icon" style="padding-top: 8px; color:#015158; font-size: x-large;"></i>
                                                            @endif
                                                        </a>
                                                    </div>    
                                                @endif

                                                @if(isset($reqestToSeller) && $reqestToSeller->bid_status == 'closed' || $reqestToSeller->withdraw_by!='')
                                                    <span class="Submit_offer1">
                                                        <label class="d-flex justify-content-between mb-0">
                                                            <a style="background: #015158"
                                                        class="p-1 w-100 text-center text-white rounded"
                                                    disabled>Bid Closed </a>
                                                        </label>
                                                    </span>
                                                @endif 
                                                {{-- @endif --}}
                                                @endauth
                                                <!-- Start Chat Button Over -->
                                                <div class="chat-button pt-2">
                                                    @if(isset($reqestToSeller) && $reqestToSeller->bid_status == 'open')
                                                       
                                                            {{-- <label class="d-flex justify-content-between mb-0"  style="gap: 10px" >
                                                            <a style="background: #e61216" class="p-2 text-center text-white rounded bid_reject_update" href="#" data-bid-id="{{ $reqestToSeller->id }}" data-bid-status="reject">Reject</a>

                                                            <a style="background: #015158" class="p-2  text-center text-white rounded bid_status_update" href="#" data-bid-id="{{ $reqestToSeller->id }}" data-bid-status="accept">  Accept </a>
                                                            </label> --}}
                                                        @endif
                                                        @if(isset($reqestToSeller) && $reqestToSeller->bid_status == 'matched')
                                                        {{-- @if($reqestToSeller->bid_status=='matched') --}}
                                                            {{-- <a style="background: #e61216;font-size: 15px;" class="m-common p-2  text-center text-white rounded" href="{{route('marketpalce.view-contracts')}}"
                                                            @if($bidDocuments->isNotEmpty()) href="{{route('marketpalce.view-contracts')}}" @endif 
                                                            data-bid-id="{{ $reqestToSeller->id }}" >Doc Centre</a> --}}
                                                            <a style="background: #e61216;font-size: 15px;" class="m-common p-2  text-center text-white rounded" href="{{route('marketpalce.view-contracts')}}"
                                                            data-bid-id="{{ $reqestToSeller->id }}" data-bs-toggle="modal" data-bs-target="#uploadDocCenter">Doc Centre</a> 

                                                            @if($bidDocuments->isEmpty() || $bidDocuments[0]['document_path'] =='')
                                                                <a style="background: #015158" class="p-2 m-common text-center text-white rounded"  data-bs-toggle="modal" data-bs-target="#eSignModal" data-bid-id="{{ $reqestToSeller->id }}" data-bid-status="accept" >E-Sign Contract
                                                                </a>
                                                            @else
                                                                <a class="m-common p-2 text-center rounded" style="font-size: 15px; background-color: #c1d9ab;">
                                                                    <b> Contract </b> <i class="fa fa-check" style="font-size:29px;color:rgb(55, 175, 25)"></i>
                                                                </a>    
                                                            @endif
                                                                @if($reqestToSeller->withdraw_reason =='' && $reqestToSeller->bidMilestones && @$reqestToSeller->bidMilestones[0]['is_approved']==0)
                                                                    <button type="button" style="font-size: 15px;" class="m-common text-center text-white rounded bg-dark" id ="withdraw_continue" data-bs-toggle="modal"  onclick="showPopup()" data-user_type="seller" data-bid_id="{{$reqestToSeller->id}}" data-seller_id="{{$reqestToSeller->seller_id}}" data-seller_name="{{$reqestToSeller->seller->name}}" data-seller_email="{{$reqestToSeller->seller->email}}" >  WithDraw </button>
                                                                @endif
                                                                @if($reqestToSeller->withdraw_reason !='')
                                                                    <button type="button" style="font-size: 15px;" class="m-common text-center text-white rounded bg-dark" data-bs-toggle="modal"> Bid Withdraw  <i class="fa fa-undo" aria-hidden="true"></i></button>
                                                                @endif
                                                            @if($reqestToSeller->bidMilestones && @$reqestToSeller->bidMilestones[0]['is_approved']==0 )
                                                                    <a style="background: #015158;font-size: 15px;" class="p-2 text-center text-white rounded m-common"  data-bs-toggle="modal" data-bs-target="#eMileStoneModal" data-bid-id="{{ $reqestToSeller->id }}"  >Create Milestone
                                                                    </a>
                                                            @else
                                                                {{-- <a style="background: #015158;font-size: 15px;" class="p-2 text-center text-white rounded m-common"  data-bs-toggle="modal" data-bs-target="#eMileStoneModal" data-bid-id="{{ $reqestToSeller->id }}"  >Create Milestone
                                                                </a> --}}
                                                                <a class=" p-2 text-center rounded" style="font-size: 15px; background-color: #c1d9ab;">
                                                                    <b> Milestone </b> <i class="fa fa-check" style="font-size:29px;color:rgb(55, 175, 25)"></i>
                                                                </a>
                                                                 
                                                            @endif
                                                        @endif
                                                        @if(isset($reqestToSeller) && $reqestToSeller->bid_status == 'closed')
                                                        
                                                            @if($bidDocuments->isNotEmpty() && $bidDocuments[0]['document_path'] !='')
                                                                <a class="m-common p-2 text-center rounded"  style="background: {{ $reqestToSeller->withdraw_reason ? '#b62121' : '#015158' }};" 
                                                                class="btn darkgreen w-100 mb-5 text-white rounded" 
                                                                data-bs-toggle="modal">
                                                                {!! $reqestToSeller->withdraw_reason ==''
                                                                    ? 'Bid Withdraw  <i class="fa fa-undo" aria-hidden="true"></i>' 
                                                                    : 'Bid Closed <i class="fa fa-check" aria-hidden="true"></i> ' !!}
                                                                 </a>    
                                                                <button type="button" style="font-size: 15px;" class=" text-center text-white rounded bg-dark" data-bs-toggle="modal"  onclick="showPopup()">  WithDraw </button>

                                                                 
                                                            @endif
                                                        {{-- @else
                                                            <a style="background: {{ $reqestToSeller->withdraw_reason ? '#b62121' : '#015158' }};" 
                                                                class="btn darkgreen w-100 mb-5 text-white rounded" 
                                                                data-bs-toggle="modal">
                                                                {!! $reqestToSeller->withdraw_reason 
                                                                    ? 'Bid Withdraw  <i class="fa fa-undo" aria-hidden="true"></i>' 
                                                                    : 'Bid Closed <i class="fa fa-check" aria-hidden="true"></i> ' !!}
                                                            </a>   --}}
                                                            @endif
                                                </div>  
                                               
                                            </div>
                                        @else
                                            <!-- BUYER SESSION START -->
                                            @if ($lastSegment == 'seller_request' || @$checkproductBid->bid_status == 'matched')
                                                @auth
                                                @if ( @$user_vendor->vendor_id != $product->vendor_id)
                                                    <div class="chat-button mb-2 p-1 w-100 d-flex justify-content-between text-center offer_submit text-white rounded" style="gap: 10px;">
                                                        <a class="start_chat chat-icon btn w-75 p-1 rounded darkgreen"  data-vendor_order_id="" data-chat_type="userToUser" data-vendor_id="{{$product->vendor_id}}" data-orderid="" data-order_id="" data-product_id="{{$product->id}}"><i class="fa fa-comments" aria-hidden="true"> Messages</i></a>
                                                        @php
                                                        $isFavorite = Auth::check() && $product->isFavoritedByUser(Auth::id());
                                                        @endphp
                                                        <a href="javascript:void(0);" class="bg-light w-25 p-1 rounded favorite-btn" data-product-id="{{ $product->id }}">
                                                            @if($isFavorite)
                                                                <i class="fa fa-heart favorite-icon" style="padding-top: 8px; color:#37af19; font-size: x-large;"></i>
                                                            @else
                                                                <i class="fa fa-heart-o favorite-icon" style="padding-top: 8px; color:#015158; font-size: x-large;"></i>
                                                            @endif
                                                        </a>

                                                    </div>
                                                @endif
                                                @endauth
                                            @else
                                                @if(!$checkproductBid)
                                                    <div class="mb-2 p-1 w-100 d-flex justify-content-between text-center offer_submit rounded" style="gap: 10px; color:#015158">
                                                        <a class="w-75 p-1 rounded btn-light" href="{{ url($product->vendor->slug . '/product-page/' . $product->url_slug.'/'.'seller_request') }}">Request Detail</a>
                                                        @php
                                                        $isFavorite = Auth::check() && $product->isFavoritedByUser(Auth::id());
                                                        @endphp
                                                        <a href="javascript:void(0);" class="bg-light w-25 p-1 rounded favorite-btn" data-product-id="{{ $product->id }}">
                                                            @if($isFavorite)
                                                                <i class="fa fa-heart favorite-icon" style="padding-top: 8px; color:#37af19; font-size: x-large;"></i>
                                                            @else
                                                                <i class="fa fa-heart-o favorite-icon" style="padding-top: 8px; color:#015158; font-size: x-large;"></i>
                                                            @endif
                                                        </a>
                                                    </div>
                                                @endif
                                            @endif    
                                                <!-- Start Chat Button Over -->
                                            <form method="POST" id="bidForm">
                                                @csrf
                                                    <input type="hidden" name="buyer_id" value="{{ auth()->id() }}">
                                                    <input type="hidden" name="seller_id" value="{{ $product->vendor_id }}">
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                @if($checkproductBid)
                                                    @if($checkproductBid->bid_status == 'open')
                                                        @if($soldOutProduct)
                                                            <span class="Submit_offer1">
                                                                <label class="d-flex justify-content-between mb-0">
                                                                    <a style="background: #015158"
                                                                class="p-1 w-100 text-center text-white rounded"
                                                            disabled> Sold Out <i class="fa fa-check-circle" aria-hidden="true"></i> </a>
                                                                </label>
                                                            </span>
                                                        @else 
                                                        <div id="bidAmountInput" class="hidden_bid_amount1">
                                                            <div class="form-group mb-2">
                                                            <label for="bid_amount">Enter Bid Amount:</label>
                                                            <input class="form-control .bg-light" type="number" name="bid_amount" id="bid_amount" required  placeholder="Enter amount" min="{{@$product->financialInfo->price.'.00' ?? '0.00'}}"  value="{{ $checkproductBid->bid_amount }}" @if($checkproductBid->bid_status == 'matched') disabled @endif disabled>
                                                            </div>
                                                            <label class="d-flex justify-content-between mb-0">
                                                                <h6 class="mt-0 mb-0">Recomended price minimum {{$currencysymbol}} {{@$product->financialInfo->price.'.00' ?? '0.00'}}</h6>
                                                            </label>
                                                            <div class="form-group mb-1">
                                                                <button type="submit" class="p-1 w-100 text-center offer_submit text-white rounded" style="background: #015158" disabled>Bid Ongoing</button>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    @endif
                                                    @if($checkproductBid->bid_status == 'matched')
                                                        <div id="bidAmountInput" class="{{ $checkproductBid ? '' : 'hidden_bid_amount' }}">
                                                            <div class="form-group mb-2">
                                                            <label for="bid_amount">Enter Bid Amount:</label>
                                                            <input class="form-control .bg-light" type="number" name="bid_amount" id="bid_amount" required min="1" placeholder="Enter amount" value="{{ $checkproductBid->bid_amount }}" @if($checkproductBid->bid_status == 'matched') disabled @endif>
                                                            </div>
                                                            <label class="d-flex justify-content-between mb-0">
                                                                <h6 class="mt-0 mb-0">Recomended price minimum {{$currencysymbol}} {{@$product->financialInfo->price.'.00' ?? '0.00'}}</h6>
                                                            </label>
                                                            <div class="form-group mt-2">
                                                                @if(empty($checkproductBid->bidDocument->buyer_signature))
                                                                    <a style="background: #e61216" class="p-2  text-center text-white rounded" href="{{route('p2p.view-buyer-contracts')}}"  data-bid-id="{{ $checkproductBid->buyer_id }}" disabled>Document Centre</a>
                                                                    <a style="background: #015158" class="p-2 text-center text-white rounded"  data-bs-toggle="modal" data-bs-target="#eSignModalBuyer" data-bid-id="{{ $checkproductBid->buyer_id  }}" data-bid-status="accept" >E-Sign Contract
                                                                    </a>
                                                                @else
                                                                <a style="background: #e61216" class="p-2  text-center text-white rounded" href="{{route('p2p.view-buyer-contracts')}}"  data-bid-id="{{ $checkproductBid->buyer_id }}" disabled>Document Centre</a>
                                                                <a class=" p-2 text-center rounded" style="font-size: 15px; background-color: #c1d9ab;">
                                                                    <b> Contract </b> <i class="fa fa-check" style="font-size:29px;color:rgb(55, 175, 25)"></i>
                                                                </a>
                                                                @if($checkproductBid->withdraw_reason=='' && $checkproductBid->bidMilestones && @$checkproductBid->bidMilestones[0]['is_approved']==0)
                                                                         
                                                                        <button type="button" class=" text-center text-white rounded bg-dark" id ="withdraw_continue_buyer" data-bs-toggle="modal" data-user_type="buyer"
                                                                        data-bid_id="{{$checkproductBid->id}}" data-seller_id="{{$checkproductBid->buyer_id}}" data-seller_name="{{$checkproductBid->buyer->name}}" data-seller_email="{{$checkproductBid->buyer->email}}"
                                                                        onclick="showPopupBuyer()" >  WithDraw </button>
                                                                    @else
                                                                        <button type="submit" class="p-1 mt-4 w-100 text-center offer_submit text-white rounded" style="background: #015158" @if($checkproductBid->bid_status == 'matched') disabled  @endif>  
                                                                    @if($checkproductBid->bid_status == 'matched')
                                                                        Ongoing Bid
                                                                    @else
                                                                        Update Raised Bid
                                                                    @endif
                                                                        </button>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </div>
                                                        {{-- @else
                                                        <a style="background: {{ $checkproductBid->withdraw_reason ? '#b62121' : '#015158' }};" 
                                                            class="btn darkgreen w-100 mb-5 text-white rounded" 
                                                            data-bs-toggle="modal">
                                                            {!! $checkproductBid->withdraw_reason 
                                                                ? 'Bid Withdraw  <i class="fa fa-undo" aria-hidden="true"></i>' 
                                                                : 'Bid Closed <i class="fa fa-check" aria-hidden="true"></i> ' !!}
                                                        </a> --}}
                                                    @endif
                                                    @if($checkproductBid->bid_status=='rejected')
                                                        <span class="Submit_offer1">
                                                            <label class="d-flex justify-content-between mb-0">
                                                                <a style="background: #015158"
                                                            class="p-1 w-100 text-center text-white rounded"
                                                        disabled> Bid Rejected</a>
                                                            </label>
                                                        </span>
                                                    @endif
                                                    @if($checkproductBid->bid_status=='closed' || $checkproductBid->withdraw_by !='')
                                                        <span class="Submit_offer1">
                                                            <label class="d-flex justify-content-between mb-0">
                                                                <a style="background: #015158"
                                                            class="p-1 w-100 text-center text-white rounded"
                                                        disabled> Bid Closed</a>
                                                            </label>
                                                        </span>
                                                    @endif
                                                    @if(isset($reqestToSeller) && $reqestToSeller->bid_status == 'closed')
                                                    <span class="Submit_offer1">
                                                        <label class="d-flex justify-content-between mb-0">
                                                            <a style="background: #015158"
                                                        class="p-1 w-100 text-center text-white rounded"
                                                    disabled> Bid Closed <i class="fa fa-check-circle" aria-hidden="true"></i> </a>
                                                        </label>
                                                    </span>
                                                    @endif 
                                                     
                                                @else
                                                <div id="bidAmountInput" class="hidden_bid_amount">
                                                    <div class="form-group mb-2">
                                                    <label for="bid_amount">Enter Bid Amount:</label>
                                                    <input class="form-control .bg-light" type="number" name="bid_amount" id="bid_amount" required  placeholder="Enter amount" min="{{@$product->financialInfo->price.'.00' ?? '0.00'}}" >
                                                    </div>
                                                    <label class="d-flex justify-content-between mb-0">
                                                        <h6 class="mt-0 mb-0">Recomended price minimum {{$currencysymbol}} {{@$product->financialInfo->price.'.00' ?? '0.00'}}</h6>
                                                    </label>
                                                    <div class="form-group mb-1">
                                                        <button type="submit" class="p-1 w-100 text-center offer_submit text-white rounded" style="background: #015158">Raise A Bid</button>
                                                    </div>
                                                </div>
                                                    <span class="Submit_offer">
                                                        <label class="d-flex justify-content-between mb-0">
                                                            <a style="background: #015158"
                                                        class="p-1 w-100 text-center offer_submit text-white rounded"
                                                        id="showBidInput"> Submit an Offer </a>
                                                        </label>
                                                    </span>
                                                @endif
                                            </form>
                                        @endif
                                        <span class="Documents bg-light d-inline-block p-3 mt-3 mb-3 w-100 rounded" >
                                          <h4 class="mb-3">Documents</h4>
                          
                                          <ul class="list-style-none d-flex justify-content-between p-0">
                                            @if(!empty($product->media) && count($product->media) > 0)
                                                @php 
                                                    $cnt = 1;
                                                    $uniqueImages = [];
                                                    $sliderImages = [];
                                                @endphp
                                        
                                                @foreach($product->media as $image)
                                                    @php
                                                        $img = isset($image->pimage) ? $image->pimage->image : $image->image;
                                                        $imgPath = isset($img->path['image_fit'], $img->path['image_path']) 
                                                            ? $img->path['image_fit'] . '1000/1000' . $img->path['image_path']
                                                            : null;
                                        
                                                        $thumbPath = isset($img->path['image_fit'], $img->path['image_path']) 
                                                            ? $img->path['image_fit'] . '100/100' . $img->path['image_path']
                                                            : null;
                                        
                                                        $originalPath = $img->path['original_image'] ?? null;
                                                        $extension = strtolower(pathinfo($originalPath, PATHINFO_EXTENSION));
                                                        $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                                        $isPDF = $extension === 'pdf';
                                                        $isTXT = $extension === 'txt';
                                        
                                                        $isDuplicate = false;
                                        
                                                        if ($isImage && $imgPath) {
                                                            $imageContent = @file_get_contents($imgPath);
                                                            if ($imageContent !== false) {
                                                                $hash = md5($imageContent);
                                                                if (in_array($hash, $uniqueImages)) {
                                                                    $isDuplicate = true;
                                                                } else {
                                                                    $uniqueImages[] = $hash;
                                                                    $sliderImages[] = $imgPath; // Collect for slider
                                                                }
                                                            } else {
                                                                $isDuplicate = true;
                                                            }
                                                        }
                                                    @endphp
                                        
                                                    @if(!$isDuplicate && $image->is_default == '0')
                                                        <li class="text-center" style="margin-right: 12px;">
                                                            @if($isImage)
                                                                <img src="{{ $thumbPath }}" class="slider-thumb" data-index="{{ count($sliderImages) - 1 }}" style="cursor:pointer;" />
                                                                <p>Image {{ $cnt++ }}</p>
                                        
                                                            @elseif($isPDF || $isTXT)
                                                                <a href="{{ $originalPath }}" target="_blank" style="text-decoration: none;">
                                                                    <img src="{{ asset('images/p2p-images/' . ($isPDF ? 'pdf-icon.png' : 'txt-icon.png')) }}" alt="{{ strtoupper($extension) }} Icon" style="width: 60px; height: auto;" />
                                                                    <p style="margin-top: 8px; color: #555;">Document {{ $cnt++ }}</p>
                                                                </a>
                                        
                                                            @else
                                                                <a href="{{ $originalPath }}" target="_blank">
                                                                    <p>Document {{ $cnt++ }}</p>
                                                                </a>
                                                            @endif
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </ul>
                                        
                                            
                                        
                                        
                                        </span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </section>  
                         <!-- p2p bid product detail over -->

                        <div class="row mt-1">
                            <div class="col-md-12">
                                @if($client_preference_detail && $client_preference_detail->rating_check == 1 && !is_category_p2p($product->category))
                                <section class="tab-product custom-tabs">
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-12">
                                            <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                                                <!-- <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-toggle="tab" href="#top-home" role="tab" aria-selected="true"><i class="icofont icofont-ui-home"></i>{{__('Description')}}</a>
                                                    <div class="material-border"></div>
                                                </li>
                                                <li class="nav-item"><a class="nav-link" id="profile-top-tab" data-toggle="tab"
                                                        href="#top-profile" role="tab" aria-selected="false"><i
                                                            class="icofont icofont-man-in-glasses"></i>Details</a>
                                                    <div class="material-border"></div>
                                                </li> -->
                                                @if($client_preference_detail && $client_preference_detail->rating_check == 1 && count($rating_details)>0)
                                                <li class="nav-item "><a class="nav-link active" id="review-top-tab" data-toggle="tab" href="#top-review" role="tab" aria-selected="false"><i class="icofont icofont-contacts"></i>{{__('Ratings & Reviews')}}</a>
                                                    <div class="material-border"></div>
                                                </li>
                                                @endif

                                                @if(@getAdditionalPreference(['is_enable_compare_product'])['is_enable_compare_product'] &&
                                                (in_array($product->category->category_id,getVendorAdditionalPreference($product->vendor_id,'compare_categories'))))

                                                <li class="nav-item ml-3"><a class="nav-link {{(count($rating_details)>0)?'':'active'}}" id="compare-product-tab" data-toggle="tab" href="#compare-product" role="tab" aria-selected="false"><i class="icofont icofont-contacts"></i>{{__('Compare products')}}</a>
                                                    <div class="material-border"></div>
                                                </li>
                                @endif
                                            </ul>
                                            <div class="tab-content nav-material" id="top-tabContent">
                                                {{-- <div class="tab-pane fade" id="top-home" role="tabpanel" aria-labelledby="top-home-tab">
                                                    <p>{!! (!empty($product->translation) && isset($product->translation[0])) ?
                                                        $product->translation[0]->body_html : ''!!}</p>
                                                </div>
                                                <div class="tab-pane fade" id="top-profile" role="tabpanel" aria-labelledby="profile-top-tab">
                                                    <p>{!! (!empty($product->translation) && isset($product->translation[0])) ?
                                                        $product->translation[0]->body_html : ''!!}</p>
                                                </div> --}}
                                                <div class="tab-pane show {{(count($rating_details)>0)?'active':''}}" id="top-review" role="tabpanel" aria-labelledby="review-top-tab">
                                                    @forelse ($rating_details as $rating)
                                                    <div v-for="item in list" class="w-100 d-flex justify-content-between mb-2">
                                                        <div class="review-box customer_review">
                                                            <div class="">
                                                                <div class="customer_review_item_row">
                                                                    <div class="image">
                                                                        <img src="{{$rating->user->image['proxy_url'].'400/160'.$rating->user->image['image_path']}}" alt="{{$rating->user->name??'NA'}}">
                                                                    </div>
                                                                    <div class="">
                                                                        <h4>{{$rating->user->name??'NA'}}</h4>
                                                                    </div>
                                                                </div>
                                                                <div class="star review-author">
                                                                    <p>
                                                                        <i class="fa fa-star{{ $rating->rating >= 1 ? '' : '-o' }}" aria-hidden="true"></i>
                                                                        <i class="fa fa-star{{ $rating->rating >= 2 ? '' : '-o' }}" aria-hidden="true"></i>
                                                                        <i class="fa fa-star{{ $rating->rating >= 3 ? '' : '-o' }}" aria-hidden="true"></i>
                                                                        <i class="fa fa-star{{ $rating->rating >= 4 ? '' : '-o' }}" aria-hidden="true"></i>
                                                                        <i class="fa fa-star{{ $rating->rating >= 5 ? '' : '-o' }}" aria-hidden="true"></i>
                                                                    </p>
                                                                </div>
                                                                <div class="review-date mt-2">
                                                                    <time> {{ $rating->time_zone_created_at->diffForHumans();}} </time>
                                                                </div>
                                                                <div class="review-images">
                                                                    @if(isset($rating->reviewFiles))
                                                                        @foreach ($rating->reviewFiles as $files)
                                                                            <a target="_blank" href="{{$files->file['image_fit'].'900/900'.$files->file['image_path']}}" class="col review-photo mt-2 lightBoxGallery" data-gallery="">
                                                                                <img class="blur-up lazyload" data-src="{{$files->file['image_fit'].'300/300'.$files->file['image_path']}}">
                                                                            </a>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="review_dis">
                                                                <p>{{$rating->review??''}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @empty
                                                    <p>{{__('No Reviews Yet')}}</p>
                                                    @endforelse
                                                </div>
                                                @include('frontend.compare-product-table')
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- Related Products --}}
                    @if(!empty($set_template) && !empty($set_template->template_id) && ($set_template->template_id == '8' || $set_template->template_id == '9'))
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            @php
                                $similar_title = getNomenclatureName('Similar Product', true);
                                $similar_title_label = ($similar_title=="Similar Product")?__('Similar Product'):__($similar_title);
                            @endphp
                            @include('frontend.product-component.category-related-product', ['realted_produuct' => $suggested_category_products, 'title' => $similar_title_label.' In '.$category_name ])
                            @include('frontend.product-component.category-related-product', ['realted_produuct' => $suggested_brand_products, 'title' => 'Brand Related Product'])
                            @include('frontend.product-component.category-related-product', ['realted_produuct' => $suggested_vendor_products, 'title' => $similar_title_label.' By '. $product->vendor->name])
                        </div>
                    </div>
                    @endif
                    {{-- End of Related Products --}}


                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/template" id="variant_image_template">
    <% if(variant.media != '') { %>
        <div class="swiper-container gallery-top">
            <div class="swiper-wrapper">
                <% _.each(variant.media, function(img, key){ %>
                    <div class="swiper-slide easyzoom easyzoom--overlay">
                        <a href="<%= img.pimage.image.path['image_fit'] %>600/600<%= img.pimage.image.path['image_path'] %>">
                        <img class="blur-up lazyload" data-src="<%= img.pimage.image.path['image_fit'] %>600/600<%= img.pimage.image.path['image_path'] %>" alt="">
                        </a>
                    </div>
                <% }); %>
            </div>
            <!-- Add Arrows -->
            <div class="swiper-button-next swiper-button-white"></div>
            <div class="swiper-button-prev swiper-button-white"></div>
        </div>
        <div class="swiper-container gallery-thumbs">
            <div class="swiper-wrapper">
                <% _.each(variant.media, function(img, key){ %>
                    <div class="swiper-slide">
                        <img class="blur-up lazyload" data-src="<%= img.pimage.image.path['image_fit'] %>300/300<%= img.pimage.image.path['image_path'] %>" alt="">
                    </div>
                <% }); %>
            </div>
        </div>
    <% }else{ %>
        <div class="swiper-container gallery-top">
            <div class="swiper-wrapper">
                <% _.each(variant.product.media, function(img, key){ %>
                    <% if(img.image != null) {%>
                        <div class="swiper-slide easyzoom easyzoom--overlay">
                            <a href="<%= img.image.path['image_fit'] %>600/600<%= img.image.path['image_path'] %>">
                            <img class="blur-up lazyload" data-src="<%= img.image.path['image_fit'] %>600/600<%= img.image.path['image_path'] %>" alt="">
                            </a>
                        </div>
                    <% }; %>
                <% }); %>
            </div>
            <!-- Add Arrows -->
            <div class="swiper-button-next swiper-button-white"></div>
            <div class="swiper-button-prev swiper-button-white"></div>
        </div>
        <div class="swiper-container gallery-thumbs">
            <div class="swiper-wrapper">
                <% _.each(variant.product.media, function(img, key){ %>
                    <% if(img.image != null) {%>
                        <div class="swiper-slide">
                            <img class="blur-up lazyload" data-src="<%= img.image.path['image_fit'] %>300/300<%= img.image.path['image_path'] %>" alt="">
                        </div>
                    <% }; %>
                <% }); %>
            </div>
        </div>
    <% } %>
</script>
<script type="text/template" id="variant_template">
    <input type="hidden" name="variant_id" id="prod_variant_id" value="<%= variant.id %>">
    <% if(variant.product.inquiry_only == 0) { %>
        <h3 id="productPriceValue" class="mb-md-3">
            <% if(is_token_enable == 1) { %>
                    <b class="mr-1"><i class='fa fa-money' aria-hidden='true'></i><span class="product_fixed_price"> <%= Helper.formatPrice(variant.productPrice * tokenAmount) %></span></b>
                    <% if(variant.compare_at_price > 0 ) { %>
                        <span class="org_price"><i class='fa fa-money' aria-hidden='true'></i><span class="product_original_price"> <%= Helper.formatPrice(variant.compare_at_price * tokenAmount) %></span></span>
                    <% } %>
                <% }else{%>
                    <b class="mr-1">{{Session::get('currencySymbol')}}<span class="product_fixed_price"><%= Helper.formatPrice(variant.productPrice) %></span></b>
                    <% if(variant.compare_at_price > 0 ) { %>
                        <span class="org_price">{{Session::get('currencySymbol')}}<span class="product_original_price"><%= Helper.formatPrice(variant.compare_at_price) %></span></span>
                    <% } %>
            <% } %>
        </h3>
    <% } %>
</script>
<script type="text/template" id="variant_options_template">
    <% _.each(availableSets, function(type, kkey){ %>
        <% if(type.variant_detail.type == 1 || type.variant_detail.type == 2) { %>
            <div class="size-box">
                <ul class="productVariants">
                    <li class="firstChild"><%= type.variant_detail.title %></li>
                    <li class="otherSize">
                        <% _.each(type.option_data, function(opt, key){ %>
                        <label class="radio d-inline-block txt-14 mr-2"><%= opt.title %>
                            <input id="lineRadio-<%= opt.id %>" name="var_<%= opt.variant_id %>" vid="<%= opt.variant_id %>" optid="<%= opt.id %>" value="<%= opt.id %>" type="radio" class="changeVariant dataVar<%= opt.variant_id %>">
                            <span class="checkround"></span>
                        </label>
                        <% }); %>
                    </li>
                </ul>
            </div>
        <% } %>
    <% }); %>
</script>
<script type="text/template" id="variant_quantity_template">
    <% if(variant.product.inquiry_only == 0) { %>
    <div class="product-description border-product pb-0">
        <h6 class="product-title mt-0">{{__('Quantity')}}:
            <% if(variant.product.has_inventory && !(variant.quantity > 0) && (variant.product.sell_when_out_of_stock != 1)){ %>
                <span id="outofstock" style="color: red;">{{__('Out of Stock')}}</span>
            <% }else{ %>
                <input type="hidden" id="instock" value="<%= variant.quantity %>">
            <% } %>
        </h6>
        <% if(!variant.product.has_inventory || (variant.quantity > 0) || (variant.product.sell_when_out_of_stock == 1)){ %>
        <div class="qty-box mb-3">
            <div class="input-group">
                <span class="input-group-prepend">
                    <button type="button" class="btn quantity-left-minus" data-type="minus" data-field="" data-batch_count="<%= variant.product.batch_count %>" data-minimum_order_count="<%= variant.product.minimum_order_count %>"><i class="ti-angle-left"></i>
                    </button>
                </span>
                <input type="text" onkeypress="return event.charCode > 47 && event.charCode < 58;" pattern="[0-9]{5}" name="quantity" id="quantity" class="form-control input-qty-number quantity_count" value="<%= variant.product.minimum_order_count %>" data-minimum_order_count="<%= variant.product.minimum_order_count %>">
                <span class="input-group-prepend quant-plus">
                    <button type="button" class="btn quantity-right-plus " data-type="plus" data-field="" data-batch_count="<%= variant.product.batch_count %>" data-minimum_order_count="<%= variant.product.minimum_order_count %>">
                        <i class="ti-angle-right"></i>
                    </button>
                </span>
            </div>
        </div>
        <% } %>
    </div>
    <% } %>
</script>
@if($product->related_products->count() > 0)


<section class="section-b-space ratio_asos alProductsPage">
    <div class="container">
        <div class="row m-0">
            <div class="col-12 p-0">
                <h3>{{__('Related products')}}</h3>
            </div>
        </div>
    </div>
    <div class="container pb-md-4">
        <div class="product-m  related-products pb-2  related-css">
            @forelse($product->related_products as $related_product)
            <div class="product-card-box position-relative al_box_third_template al ">
                {{-- <a class="common-product-box scale-effect text-center" href="{{route('productDetail',[$related_product->vendor->slug,$related_product->url_slug])}}"> </a> --}}
                <div class="img-outer-box position-relative">
                    <a class="common-product-box scale-effect text-center" href="{{route('productDetail',[$related_product->vendor->slug,$related_product->url_slug])}}">
                    <img class="img-fluid blur-up lazyload" data-src="{{ $related_product->image_url }}" alt="">
                    </a>
                    <!-- <div class="pref-timing">
                        <span>5-10 min</span>
                    </div> -->
                    <!-- <i class="fa fa-heart-o fav-heart" aria-hidden="true"></i> -->
                </div>
                <div class="media-body align-self-center">
                    <div class="inner_spacing px-0">
                        <div class="product-description">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 class="card_title ellips">{{ $related_product->translation_title }}</h6>
                            </div>
                            <p>{{ $related_product->vendor_name }}</p>
                            <p class="border-bottom pb-1">In {{$related_product->category_name}}</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <b>
                                    @if($related_product->inquiry_only == 0)
                                    {{ Session::get('currencySymbol') . $related_product->variant_price }}
                                    @endif
                                </b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            @endforelse
        </div>
    </div>
</section>
@endif

<!-- Seller  E-Sign MODAL --->
    <div class="modal fade" id="eSignModal" tabindex="-1" aria-labelledby="eSignModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content eSignModalContent">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel1">Seller Agreement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Binding Commitment</h6>
                    <p>The bidder understands that submitting a bid constitutes a legally binding offer to purchase the item or service at the specified bid amount.</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    
                    <h6> Bid Rejection & Withdrawal </h6>
                    <p>The bid may be accepted or rejected at the discretion of the seller. Once submitted, bids cannot be withdrawn without prior approval.</p>
    
                    <h6>Payment Obligation</h6>
                    <p>If the bid is accepted, the bidder agrees to complete the transaction and make the required payment within the stipulated time frame</p>
    
                    <!-- Example Table -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Bid No</th>
                                <th>Status</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> #000{{ request()->query('url_bid_id', '') }}</td>
                                <td style="color:#015158"> {{ ucfirst($reqestToSeller->bid_status ?? '') }}</td>
                                <td> {{ $reqestToSeller->bid_amount ?? '' }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <p>The bidder agrees to abide by all applicable terms, conditions, and policies set forth in this agreement.</p>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn-draw-signature p-1 w-100 text-center  text-white rounded" id="drawSignatureButton" style="background: #015158" data-bs-target="#signature_pad" data-bid-id="{{ $reqestToSeller->id }}">Draw Signature</button> --}}
                    <a style="background: #015158" class="p-2 text-center text-white rounded" data-bs-toggle="modal" data-bs-target="#eSignPadModal" data-bid-id="{{ request()->query('url_bid_id', '') }}" data-bid-status="accept">
                    E-Sign Contract
                    </a>
                </div>
            </div>
        </div>
    </div>
<!-- Seller E-Sign MODAL Over ---> 

<!--- Seller signature pad --->
    <div class="modal fade eSignPadModal" id="eSignPadModal" tabindex="-1" aria-labelledby="product_ratingLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form name="form_sig" id="form_sig" enctype="multipart/form-data">
            <div class="modal-content eSignModalContentBuyer" id="canvasContainer" style="position: relative; display: inline-block;">
                <div class="signature-container" >
                    <button id="closeSellerCanvasBtn" style="position: absolute; top: -8px; right: -4px;border: none; border-radius: 50%; width: 16px; height: 37px; cursor: pointer;">×</button>
                    <canvas id="signatureCanvas" width="500" height="200"></canvas>
                   
                    <div class="button-container">
                        <button id="clearButton"  style="background: #015158" class="p-1 text-center text-white rounded">Clear</button>
                        <button id="saveButton"  style="background: #015158" class="p-1 text-center text-white rounded">Confirm Signature</button>
                    </div>
                
                </div>
            </div>
            {{-- <input type="hidden" name="bid_id" id="bid_id" value="{{ $reqestToSeller->id ?? '' }}"> --}}
            <input type="hidden" name="bid_id" id="bid_id" value="{{ request()->query('url_bid_id', '') }}">
             
            <img id="signatureImage" alt="Saved Signature" style="display:none; margin-top: 20px; border: 1px solid #ccc;">
            </form>
        </div>
    </div>
<!--- Seller signature pad  Over --->

<!-- Buyer  E-Sign MODAL --->
    <div class="modal fade" id="eSignModalBuyer" tabindex="-1" aria-labelledby="eSignModalBuyerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content eSignModalContentBuyer">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Buyer Agreement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Binding Commitment</h6>
                <p>The bidder understands that submitting a bid constitutes a legally binding offer to purchase the item or service at the specified bid amount.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

                <h6> Bid Rejection & Withdrawal </h6>
                <p>The bid may be accepted or rejected at the discretion of the seller. Once submitted, bids cannot be withdrawn without prior approval.</p>

                <h6>Payment Obligation</h6>
                <p>If the bid is accepted, the bidder agrees to complete the transaction and make the required payment within the stipulated time frame</p>

                <!-- Example Table -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Bid No</th>
                            <th>Status</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> #000{{ $checkproductBid->id ?? ''}}</td>
                            <td style="color:#015158"> {{ ucfirst($checkproductBid->bid_status ?? '') }}</td>
                            <td> {{ $checkproductBid->bid_amount ?? '' }}</td>
                        </tr>
                    </tbody>
                </table>

                <p>The bidder agrees to abide by all applicable terms, conditions, and policies set forth in this agreement.</p>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn-draw-signature p-1 w-100 text-center  text-white rounded" id="drawSignatureButton" style="background: #015158" data-bs-target="#signature_pad" data-bid-id="{{ $checkproductBid->buyer_id }}">Draw Signature</button> --}}
                <a style="background: #015158" class="p-2 text-center text-white rounded" data-bs-toggle="modal" data-bs-target="#eSignPadModalBuyer" data-bid-id="{{ $checkproductBid->buyer_id ?? '' }}" data-bid-status="accept">
                E-Sign Contract
                </a>
            </div>
        </div>
    </div>
    </div>
<!-- Buyer E-Sign MODAL  Over--->

<!--- Buyer signature pad --->
    <div class="modal fade eSignPadModalBuyer" id="eSignPadModalBuyer" tabindex="-1" aria-labelledby="product_ratingLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form name="form_sig" id="form_sig_buyer" enctype="multipart/form-data">
        <div class="modal-content eSignModalContentBuyer" id="canvasContainerBuyer" style="position: relative; display: inline-block;">
            <div class="signature-container">
                <button id="closeBuyerCanvasBtn" style="position: absolute; top: -8px; right: -4px;border: none; border-radius: 50%; width: 16px; height: 37px; cursor: pointer;">×</button>
                <canvas id="signatureCanvasBuyer" width="500" height="200"></canvas>
                <div class="button-container">
                    <button id="clearBtn"  style="background: #015158" class="p-1 text-center text-white rounded">Clear</button>
                    <button id="saveBtn"  style="background: #015158" class="p-1 text-center text-white rounded">Confirm Signature</button>
                </div>
            </div>
        </div>
        {{-- <input type="hidden"  id="buyer_bid_id" value="{{ $checkproductBid->id ?? '' }}"> --}}
        <input type="hidden"  id="buyer_bid_id" value="{{ request()->query('url_bid_id', '') }}">
        <img id="signatureImage" alt="Saved Signature" style="display:none; margin-top: 20px; border: 1px solid #ccc;">
        </form>
    </div>
    </div>
<!--- Buyer signature pad  Over --->

<!-- Create MileStone popup -->
<div id="eMileStoneModal" class="modal fade" tabindex="-1" aria-hidden="true">
    @php
    $collection = collect([$reqestToSeller]);
        $milestones = [];
        if(isset($reqestToSeller->product_id) && isset($reqestToSeller->id)){
        $milestones = \DB::table('payments_milestones')
            ->where('product_id', $reqestToSeller->product_id) // Fixed variable typo
            ->where('bid_id', $reqestToSeller->id)
            ->get();
        }      
    @endphp
    <div class="modal-dialog">

        <div class="modal-content" style="width:100% !important;">
            <div class="modal-header p-0 mb-3">
                <h5 class="modal-title pl-0" id="eMileStoneModalTermsModalLabel">
                    @if(isset($reqestToSeller->bidMilestones))
                        {{  $collection->isEmpty() ? 'Edit Milestone' : 'Create Milestone' }} 
                    @endif
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                {{-- <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" id="closeMilStoneModal">
                    <span aria-hidden="true">&times;</span>
                </button> --}}
            </div>
        <form id="milestoneModalForm">
            <label for="selection">Select By:</label>
            <span class="d-flex align-items-center bg-light pl-2 pr-2 rounded mb-2" style="gap:10px;">
                <input type="radio" id="milestone_type" name="milestone_type" value="1" 
                {{ !empty($milestones) && old('milestone_type', $milestones[0]->milestone_type ?? 1) == 1 ? 'checked' : '' }} 
                onchange="toggleMilestones(true)"
                > By Milestone</span>
            <span class="d-flex align-items-center bg-light pl-2 pr-2 rounded mb-2" style="gap:10px;">
                <input type="radio" id="milestone_type" name="milestone_type" value="0"  
                {{ !empty($milestones) && old('milestone_type', $milestones[0]->milestone_type ?? 0) == 0 ? 'checked' : '' }} 
                onchange="toggleMilestones(false)"
                > By Project</span>

            
                <label for="amount">Agreement Amount:</label>
                <input type="number" id="agreed_amount" class="input-group bg-light border-0 mb-2" value="{{ @$reqestToSeller->bid_amount }}" readonly>
            <input type="hidden" id="bid_id" name="bid_id" value="{{ @$reqestToSeller->id }}">
            <input type="hidden" id="product_id" name="product_id" value=" {{ @$reqestToSeller->product_id }}">
            <input type="hidden" id="agreed_amount" name="amount" value=" {{ @$reqestToSeller->bid_amount }}">
            <label for="milestone_count">Select Number of Milestones:</label>
            <select id="milestone_count" name="milestone_count" class="form-control bg-light rounded mb-2" onchange="updateMilestones()">
                @for($i=1; $i<= $totalMilestone->total_payment_milestone; $i++)
                <option value="{{$i}}" 
                @if(!empty($milestones) && $milestones->isNotEmpty())
                    @if(old('milestone_count', count($milestones)) == $i) selected @endif 
                @endif>{{$i}}</option>
                @endfor
            </select>
            <div id="milestonesContainer" class="mb-2">
                @if(!empty($milestones) && $milestones->isNotEmpty())
                @foreach($milestones as $key => $milestone)
                    <div class="milestone mb-2">
                        <label for="amount">Amount:</label>
                        <input type="number" id="amount{{$key + 1}}" name="amount[]" 
                            class="input-group bg-light border-0 mb-2" value="{{ old('amount.'.$key, $milestone->amount) }}" required>

                        <label for="dueDate{{$key + 1}}">Due Date:</label>
                        <input type="date" id="dueDate{{$key + 1}}" name="dueDate[]" 
                            class="input-group bg-light border-0" value="{{ old('dueDate.'.$key, $milestone->due_date) }}" required>
                    </div>
                @endforeach
                @else
                    <div class="milestone mb-2">
                        <label for="amount">Amount:</label>
                        <input type="number" id="amount" name="amount[]" 
                            class="input-group bg-light border-0 mb-2" value="{{ @$reqestToSeller->bid_amount }}" readonly required>

                        <label for="dueDate">Due Date:</label>
                        <input type="date" id="dueDate" name="dueDate[]" 
                            class="input-group bg-light border-0" required>
                    </div>
                @endif
            </div>
            {{-- <a href="#" type="button" id="addNewButton" class="mb-2"><i class="fa fa-plus-circle " aria-hidden="true"></i>
                Add New</a> --}}
            <button type="submit"  class="btn darkgreen w-100 mb-2 text-white rounded">Submit</button>
        </form>
        </div>
    </div>    
</div>
<!-- End milestone over -->


<!--- Withdraw modal popup -->
    <div id="alertPopup" class="popup">
        <div class="popup-content">
            <i class="fa fa-warning" style="font-size:48px;color:red"></i>
            <p class="pt-2">Withdraw the Contract ?</p>
            <span class="d-flex" style="gap: 10px;">
                <button class="no_cancel text-white w-50" onclick="handleCancel()">NO</button>
                <button id="withdrawButton" class="withdraw_contract w-50" onclick="handleOk()">Withdraw</button>
            </span>
        </div>
    </div>

    <div id="codePopup" class="popup">
        <div class="popup-content">
            <p>Confirmation Code:</p>
            <input type="text" id="codeInput" placeholder="Enter code">
            <button class="no_cancel text-white w-100" id="verifyWithdrawOtpCode" onclick="verifyWitdrawOtp()">Submit</button>
        </div>
    </div>

    <div id="withDrawReason" class="popup">
        <div class="popup-content">
            <p>Reason Of Withdraw:</p>
            <input type="hidden" id="withdraw_by" value="{{ Auth::user()->id ?? '0' }}" >
                @if(isset($reqestToSeller->id))
                <input type="hidden" id="contract_id" value="{{ isset($reqestToSeller->id) ? $reqestToSeller->id : '' }}" >
                <input type="hidden" id="user_type" value="seller" >
                @elseif(isset($checkproductBid->id))
                <input type="hidden" id="contract_id" value="{{ isset($checkproductBid->id) ? $checkproductBid->id : '' }}" >
                <input type="hidden" id="user_type" value="buyer" >
                @else
            @endif
             <textarea type="text" id="reasonInput" placeholder="Enter withdraw reason"></textarea>
            <button class="no_cancel text-white w-100" onclick="submitWithdrawReason()">Submit</button>
        </div>
    </div>
<!-- Withdraw modal popup over -->


<!-- Raise and reject bid by seller Modal -->
<div class="modal fade" id="bidModal" tabindex="-1" aria-labelledby="bidModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content reject-raise-bid-modal">
        <div class="modal-header py-0 pt-2">
          <h5 class="modal-title pl-0" id="bidModalLabel">Reject Reason</h5>
          <span id="hideRejectModal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </div>
        <div class="modal-body">
          <p>Please select an option and provide a reason for the action:</p>
          <div class="d-flex align-items-center" style="gap: 10px;">
            <span class="d-flex align-items-center bg-light pl-2 pr-2 rounded mb-2 w-50" style="gap:10px;">
              <input type="radio" name="action_status" value="1" id="actionAccept">
              Accept
            </span>
            <span class="d-flex align-items-center bg-light pl-2 pr-2 rounded mb-2 w-50" style="gap:10px;">
              <input type="radio" name="action_status" value="2" id="actionReject">
              Reject
            </span>
        </div>
         
          <div class="mt-3">
            <textarea id="reason" class="form-control" rows="4" placeholder="Enter reason here..."></textarea>
          </div>
        </div>
        <div class="modal-footer" style="flex-wrap: inherit;">
          <button style="background: #e61216" id="closeButton" type="button" class="btn darkgreen w-50 mb-2 text-white rounded" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn darkgreen w-50 mb-2 text-white rounded" id="submitAction">Submit</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Raise and reject bid by seller Modal stop -->

<!-- Image Document Slider Modal -->
<div id="imageModal" class="modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-body">
          <div class="swiper mySwiper">
            <div class="swiper-wrapper">
              @foreach($sliderImages as $img)
                <div class="swiper-slide">
                  <img src="{{ $img }}" style="width:100%;" />
                </div>
              @endforeach
            </div>
            <!-- Add navigation -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
          </div>
        </div>
      </div>
    </div>
</div>

<!-- upload document centre Modal -->
<div id="uploadDocCenter" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width:100% !important;">
            <div class="modal-header p-0 mb-3">
                <h5 class="modal-title pl-0" id="uploadDocTitle"> Upload Document </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="docCentreUploadForm" method="post" action="{{ route('p2p.documents.upload')}}" enctype="multipart/form-data" >
                @csrf
                <input type="hidden" id="product_id" name="product_id" value="{{ @$reqestToSeller->product_id }}">
                @if(auth()->check())
                    <input type="hidden" id="auth_id" name="auth_id" value="{{ auth()->id() }}">
                @endif
                <div class="mb-2">
                    <div class="milestone mb-2">
                        <label>Document Info 1</label>
                            <textarea name="info_one" id="info_one" placeholder="Info 1" required></textarea>
                        <label>Document Info 2</label>
                            <textarea name="info_two" id="info_two" placeholder="Info 2" required></textarea></textarea>
                    </div>
                    @for($i=1; $i<= 2; $i++)
                    <div class="upload-wrapper mb-2" >
                        <div class="upload-icon">
                            <i class="fas fa-file-upload"></i>
                        </div>
                        <span class="upload-label">Upload file</span>
                        <div class="upload-right-icon">
                            <i class="fas fa-arrow-up-right-from-square"></i>
                        </div>
                        <input type="file" name="doc_{{$i}}" id="doc_{{$i}}" class="upload-input" required>
                    </div>
                    @endfor
                    <button type="submit" class="btn darkgreen w-100 mb-2 text-white rounded">Upload</button>
                </div>
                 
            </form>
        </div>
    </div>    
</div>
<!-- End -->


@php
    $user_type = 'user';
    $to_message = 'to_tuser';
    $from_message = 'from_user';
    $chat_type = 'user_to_user';
    $startChatype = 'user_to_user';
    $apiPre = 'client';
    $rePre = 'user/chat/userToUser';
    $fetchDe = 'fetchRoomByUserIdUserToUser';
@endphp
@endsection
@section('js-script')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
{{-- <script src="{{asset('assets/js/chat/user_vendor_chat.js')}}"></script> --}}
<script src="{{asset('assets/js/chat/commonChat.js')}}"></script>
<script type="text/javascript"src="{{asset('front-assets/js/slick.js')}}"></script>
<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
<script type="text/javascript" src="{{asset('front-assets/js/jquery.elevatezoom.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
@endsection
@section('script')

<script>

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-center", // Centers the message
        "preventDuplicates": true,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "4000", // Auto-hide in 4 seconds
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

 
    function toggleMilestones(enable) {
        const milestonesDropdown = document.getElementById("milestone_count");
        const amountInput = document.getElementById("amount1");
        const dueDateInput = document.getElementById("dueDate1");
        const amount = document.getElementById("agreed_amount").value;

        if (enable) {
            // Enable milestone dropdown
            milestonesDropdown.disabled = false;
            amountInput.removeAttribute("readonly");
        } else {
            // Disable milestone dropdown when "By Project" is selected
            milestonesDropdown.disabled = true;
            milestonesDropdown.value = "1";
            amountInput.value = amount;
            amountInput.setAttribute("readonly", true);
            dueDateInput.value = "";
            milestonesContainer.innerHTML = `
            <div id="milestone1">
                <label>Amount:</label>
                <input type="text" id="amount1" name="amount[]" placeholder="Amount" value="${amount}" class="input-group bg-light border-0 mb-2" readonly>
                <label>Due Date:</label>
                <input type="date" id="dueDate1" name="dueDate[]" placeholder="dd/mm/yyyy" class="input-group bg-light border-0 mb-2">
            </div>
        `;
        }
    }

    function updateMilestones() {
        const milestones = document.getElementById("milestone_count").value;
        const amount = document.getElementById("agreed_amount").value;
        const milestonesContainer = document.getElementById("milestonesContainer");
    
        milestonesContainer.innerHTML = "";

        if (amount && milestones) {
            const perMilestoneAmount = (amount / milestones).toFixed(2);

            for (let i = 1; i <= milestones; i++) {
                const milestoneDiv = document.createElement("div");
                // milestoneDiv.innerHTML = `
                //     <label>Milestone ${i} Amount:</label>
                //     <input type="text" value="${perMilestoneAmount}" readonly />
                //     <label>Due Date:</label>
                //     <input type="date" />
                // `;

                var milestoneCount = document.querySelectorAll(".milestone").length + 1;
                var newMilestone = document.createElement("div");
                newMilestone.classList.add("milestone");
                newMilestone.setAttribute("id", `milestone${milestoneCount}`);

                newMilestone.innerHTML = `
            <label for="amount${milestoneCount}">Amount:</label>
            <input type="number" id="amount${milestoneCount}" name="amount[]"  value="${perMilestoneAmount}" class="input-group bg-light border-0 mb-2" readonly1>
            
            <label for="dueDate${milestoneCount}">Due Date:</label>
            <input type="date" id="dueDate${milestoneCount}" name="dueDate[]"  class="input-group bg-light border-0 mb-2" required>
            <span type="button" class="removeButton" onclick="removeMilestone('milestone${milestoneCount}')"><i class="fa fa-trash" aria-hidden="true"></i></span>
        `;
        document.getElementById("milestonesContainer").appendChild(newMilestone);

                // milestonesContainer.appendChild(milestoneDiv);
            }
        }
    }
    $(document).ready(function() {
       
        $('.favorite-btn').on('click', function() {
            
            var button = $(this);
            var productId = button.data('product-id');
             
            $.ajax({
                url: "{{ route('toggle.favorite') }}",
                type: "POST",
                data: {
                    product_id: productId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    var icon = button.find('.favorite-icon');
                    if (response.status === 'added') {
                        icon.removeClass('fa-heart-o').addClass('fa-heart').css('color', '#37af19');
                    } else {
                        icon.removeClass('fa-heart').addClass('fa-heart-o').css('color', '#015158');
                    }
                },
                error: function(response) {
                    alert(response.responseJSON.message);
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Hide Rejet Reason Modal 
        document.getElementById('hideRejectModal').addEventListener('click', function () {
          $('#bidModal').modal('hide');
        });
        document.getElementById('closeButton').addEventListener('click', function () {
          $('#bidModal').modal('hide');
        });
  
        // When the "Reject" or "Accept" link is clicked
        $('.bid_reject_update').click(function(event) {
            event.preventDefault(); // Prevent the default action (navigation)
  
            // Get the bid ID and status from data attributes
            var bidId = $(this).data('bid-id');
            var bidStatus = $(this).data('bid-status');
  
            // Optionally, set this data into hidden fields or elements inside the modal if needed
            $('#submitAction').data('bid-id', bidId);
            $('#submitAction').data('bid-status', bidStatus);
  
            // Show the modal
            $('#bidModal').modal('show');
        });
  
        // When the "Submit" button inside the modal is clicked
        $('#submitAction').click(function() {
    
            var bidId = $(this).data('bid-id');
            var bidStatus = $(this).data('bid-status');
            var actionStatus = $('input[name="action_status"]:checked').val();
            var reason = $('#reason').val();
            
            if (!actionStatus) {
                alert("Please select an action (Accept or Reject).");
                return;
            }
            if (!reason.trim()) {
                alert("Please enter a reason.");
                return;
            }
            
            var uri = "{{route('marketpalce.reject-raised-bid')}}";
            $.ajax({
                url: uri,  // Replace with your route
                method: 'POST',
                data: {
                    bid_id: bidId,
                    bid_status: bidStatus,
                    action_status: actionStatus,
                    reason: reason,
                    _token: $('meta[name="csrf-token"]').attr('content')  // CSRF token
                },
                success: function(response) {
                    $('#bidModal').modal('hide');
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });  
                },
                error: function(xhr, status, error) {
                    // Handle error (e.g., show an error message)
                    alert('Error submitting the action.');
                }
            });
        });
    });
  </script>

<script>
    $(document).ready(function() {
        document.getElementById('closeMilStoneModal').addEventListener('click', function() {
            let modal = document.getElementById('eMileStoneModal');
            let modalInstance = bootstrap.Modal.getInstance(modal); // Get Bootstrap modal instance
            modalInstance.hide(); // Hide the modal
        });
    });

    function showPopup() { //show popup for seller
        let withdraw_continue = document.getElementById("withdraw_continue");
            let bid_id = withdraw_continue.getAttribute("data-bid_id");
            let seller_id = withdraw_continue.getAttribute("data-seller_id");
            let seller_name = withdraw_continue.getAttribute("data-seller_name");
            let seller_email = withdraw_continue.getAttribute("data-seller_email");
        let withdrawButton = document.getElementById("withdrawButton");
            withdrawButton.setAttribute("data-bid_id", bid_id);
            withdrawButton.setAttribute("data-seller_id", seller_id);
            withdrawButton.setAttribute("data-seller_name", seller_name);
            withdrawButton.setAttribute("data-seller_email", seller_email);

        document.getElementById("alertPopup").style.display = "flex";
    }


    function showPopupBuyer() {
        let withdraw_continue_buyer = document.getElementById("withdraw_continue_buyer");
            let bid_id = withdraw_continue_buyer.getAttribute("data-bid_id");
            let buyer_id = withdraw_continue_buyer.getAttribute("data-seller_id");
            let buyer_name = withdraw_continue_buyer.getAttribute("data-seller_name");
            let buyer_email = withdraw_continue_buyer.getAttribute("data-seller_email");
        let withdrawButton = document.getElementById("withdrawButton");
            withdrawButton.setAttribute("data-bid_id", bid_id);
            withdrawButton.setAttribute("data-seller_id", buyer_id);
            withdrawButton.setAttribute("data-seller_name", buyer_name);
            withdrawButton.setAttribute("data-seller_email", buyer_email);
        document.getElementById("alertPopup").style.display = "flex";
    }

    function handleCancel() {
        document.getElementById("alertPopup").style.display = "none";
    }

    function closeCodePopup() {
        document.getElementById("codePopup").style.display = "none";
    }

    function closeWithDrawReason() {
        document.getElementById("withDrawReason").style.display = "none";
    }


    function handleOk() {
        document.getElementById("alertPopup").style.display = "none";
        document.getElementById("codePopup").style.display = "flex";

        let withdrawButton = document.getElementById("withdrawButton");
        let bid_id = withdrawButton.getAttribute("data-bid_id");
        let seller_id = withdrawButton.getAttribute("data-seller_id");
        let seller_name = withdrawButton.getAttribute("data-seller_name");
        let seller_email = withdrawButton.getAttribute("data-seller_email");
       
        // Attach data with submit and verify code button
        let verifyWithdrawOtpCode = document.getElementById("verifyWithdrawOtpCode");
        verifyWithdrawOtpCode.setAttribute("data-bid_id", bid_id);
        verifyWithdrawOtpCode.setAttribute("data-seller_id", seller_id);
 

        let randomCode = Math.floor(100000 + Math.random() * 900000);

        sendWithDrawCodeEmail(randomCode, bid_id, seller_id, seller_name, seller_email);
    }

    

    function sendWithDrawCodeEmail(code, bid_id, seller_id, seller_name, seller_email) {
       
        // let userEmail = "mylogicforyou@gmail.com"; //Replace with the actual email
        let userEmail = seller_email;
        fetch("/p2p/send-withdraw-verification-code", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: JSON.stringify({ email: userEmail, code: code,bid_id: bid_id, seller_id: seller_id, seller_name: seller_name, seller_email: seller_email })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toastr.success("OTP sent on registered email account!");
            } else {
                alert("Failed to send verification code.");
            }
        })
        .catch(error => console.error("Error:", error));
    }

    function verifyWitdrawOtp() {
        const code = document.getElementById("codeInput").value;
        const bid_id = document.getElementById("verifyWithdrawOtpCode").getAttribute("data-bid_id");
        const seller_id = document.getElementById("verifyWithdrawOtpCode").getAttribute("data-seller_id");
        
        if (code.trim() === "") {
            alert("Please enter a valid code !");
            return;
        }
        $.ajax({
            url: "/p2p/verify-withdraw-otp",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                bid_id: bid_id,
                seller_id: seller_id,
                otp_code: code
            },
            success: function(response) {
                if (response.success) {
                    document.getElementById("codePopup").style.display = "none";

                    Swal.fire({
                        title: 'Success!',
                        text: 'Code Confirmed',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.value) {
                            document.getElementById("withDrawReason").style.display = "flex";
                        }
                    });

                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: 'Try Again'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'Something went wrong. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
    });
          
    }

    function submitWithdrawReason() {
      
        const reasonWithDraw = document.getElementById("reasonInput").value;
        const withDrawBy = document.getElementById("withdraw_by").value;
        const bidId = document.getElementById("contract_id").value;
        const user_type = document.getElementById("user_type").value;
        
        if (reasonWithDraw.trim() === "") {
            alert("Please Enter The Valid Reason!");
            return;
        }
        var url = '{{ route("p2p.store.withdraw-reason") }}';
 
    $.ajax({
        url: url,
        method: 'POST',
        data: {
            _token: "{{ csrf_token() }}",
            bid_id: bidId,
            withdraw_by: withDrawBy,
            withdraw_reason: reasonWithDraw,
        }, 
        success: function(response) {
            console.log('Response received:');
            console.log(response);

            if (response.success) {
                document.getElementById("withDrawReason").style.display = "none";
                Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        if(user_type == 'seller'){
                            window.location.href = "{{ route('p2p.marketpalce.list') }}";
                        }
                        if(user_type == 'buyer'){
                            window.location.href = "{{ route('p2p.bid.list') }}";
                        }
                         
                    }
                });
            }
        },
        error: function(xhr) {
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                var errors = xhr.responseJSON.errors;
                let errorMessages = Object.values(errors).map(err => err.join(' ')).join('\n');
                alert('Error:\n' + errorMessages);
            } else {
                alert('An error occurred. Please try again.');
            }
        }
    });
          
    }
</script>

<script>
    
    // Add New Milestone Fields
    // document.getElementById("addNewButton").onclick = function() {
    //   var milestoneCount = document.querySelectorAll(".milestone").length + 1;
    //   var newMilestone = document.createElement("div");
    //   newMilestone.classList.add("milestone");
    //   newMilestone.setAttribute("id", `milestone${milestoneCount}`);
  
    //   newMilestone.innerHTML = `
    //     <label for="amount${milestoneCount}">Amount:</label>
    //     <input type="number" id="amount${milestoneCount}" name="amount[]"  class="input-group bg-light border-0 mb-2" required>
        
    //     <label for="dueDate${milestoneCount}">Due Date:</label>
    //     <input type="date" id="dueDate${milestoneCount}" name="dueDate[]"  class="input-group bg-light border-0 mb-2" required>
    //     <span type="button" class="removeButton" onclick="removeMilestone('milestone${milestoneCount}')"><i class="fa fa-trash" aria-hidden="true"></i></span>
    //   `;
    //   document.getElementById("milestonesContainer").appendChild(newMilestone);
    // }

    function removeMilestone(milestoneId) {
        var milestoneElement = document.getElementById(milestoneId);
        if (milestoneElement) {
            milestoneElement.remove(); // Remove the milestone element
        }
    }
     
    $(document).ready(function() {
          
        $('#milestoneModalForm').on('submit', function(e) {
            
            e.preventDefault();
            var formData = new FormData(this);
            var url = '{{ route("marketplace.store-milestone") }}';
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                processData: false, 
                contentType: false,
                success: function(response) {
                    if(response.success) {
                        $('#eMileStoneModal').modal('hide');
                        Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.value) {
                                window.location.href = "{{ route('marketplace.list-milestone') }}"
                            }
                        });
                         
                    }
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    alert('Error: ' + errors);
                }
            });
        });

        // Update specific milestone via AJAX (if updating)
        function updateMilestone(id) {
            var formData = {
                amount: $('#amount' + id).val(),
                dueDate: $('#dueDate' + id).val()
            };

            $.ajax({
                url: '/milestone/update/' + id,
                method: 'POST',
                data: formData,
                success: function(response) {
                    // alert(response.message);
                    $('#eMileStoneModal').modal('hide');
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.message);
                }
            });
        }
    });



</script>

<script>
    //BUYER CANVAS SIGNATURE PAD
    const canvas1 = document.getElementById('signatureCanvasBuyer');
    const ctx1 = canvas1.getContext('2d');
    let isDrawing1 = false;

    // Event listeners for mouse actions
    canvas1.addEventListener('mousedown', startDrawing);
    canvas1.addEventListener('mousemove', draw);
    canvas1.addEventListener('mouseup', stopDrawing);
    canvas1.addEventListener('mouseout', stopDrawing);

    // Start drawing
    function startDrawing(e) {
        isDrawing1 = true;
        ctx1.beginPath();
        ctx1.moveTo(e.offsetX, e.offsetY);
    }

    // Draw on the canvas
    function draw(e) {
        if (!isDrawing1) return;
        ctx1.lineTo(e.offsetX, e.offsetY);
        ctx1.strokeStyle = 'black';
        ctx1.lineWidth = 2;
        ctx1.stroke();
    }

    // Stop drawing
    function stopDrawing() {
        isDrawing1 = false;
        ctx1.closePath();
    }

    // Clear the canvas
    document.getElementById('clearBtn').addEventListener('click', (e) => {
        e.preventDefault();
        ctx1.clearRect(0, 0, canvas1.width, canvas1.height);
    });

    // Upload canvas image on s3 bucket
    document.getElementById('saveBtn').addEventListener('click', function(e) {
        e.preventDefault();
        if (isCanvasBlank(canvas1)) {
            Swal.fire({
                title: 'Error!',
                text: 'Signature is required. Please sign before submitting.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return; // Stop form submission
        }
        const signatureData = canvas1.toDataURL('image/png');  
        const signatureBlob = dataURLtoBlob(signatureData);  
         
        const formData = new FormData();
        const bidId = document.getElementById('buyer_bid_id').value;
        formData.append('signature', signatureBlob, 'signature.png');  
        formData.append('bid_id', bidId); 
        
        $.ajax({
            url: "{{ route('p2p.upload.signature') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false, 
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')  // CSRF token
            },
            success: function(response) {
                console.log(response);
                if (response.success) {
                    // document.getElementById('signatureImage').src = response.image_url;
                    $('#eSignPadModal').closest('.modal').modal('hide');
                    Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.value) {
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: response.message || 'Something went wrong. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Error uploading signature:", error);
                alert("An error occurred while uploading the signature.");
            }
        });
    });
    function dataURLtoBlob(dataUrl) {
        const byteString = atob(dataUrl.split(',')[1]);
        const arrayBuffer = new ArrayBuffer(byteString.length);
        const uintArray = new Uint8Array(arrayBuffer);
        for (let i = 0; i < byteString.length; i++) {
            uintArray[i] = byteString.charCodeAt(i);
        }
        return new Blob([uintArray], { type: 'image/png' });
    }
</script>

<script>
    // Select the canvas and set up variables
    const canvas = document.getElementById('signatureCanvas');
    const ctx = canvas.getContext('2d');
    let isDrawing = false;

    // Event listeners for mouse actions
    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mouseout', stopDrawing);

    // Start drawing
    function startDrawing(e) {
        isDrawing = true;
        ctx.beginPath();
        ctx.moveTo(e.offsetX, e.offsetY);
    }

    // Draw on the canvas
    function draw(e) {
        if (!isDrawing) return;
        ctx.lineTo(e.offsetX, e.offsetY);
        ctx.strokeStyle = 'black';
        ctx.lineWidth = 2;
        ctx.stroke();
    }

    // Stop drawing
    function stopDrawing() {
        isDrawing = false;
        ctx.closePath();
    }

    // Clear the canvas
    document.getElementById('clearButton').addEventListener('click', (e) => {
        e.preventDefault();
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    });

    // Upload canvas image on s3 bucket
    document.getElementById('saveButton').addEventListener('click', function(e) {
        e.preventDefault();
        
        if (isCanvasBlank(canvas)) {
            Swal.fire({
                title: 'Error!',
                text: 'Signature is required. Please sign before submitting.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return; // Stop form submission
        }

        const signatureData = canvas.toDataURL('image/png');  
        const signatureBlob = dataURLtoBlob(signatureData);  
         
        const formData = new FormData();
        const bidId = document.getElementById('bid_id').value;
        formData.append('signature', signatureBlob, 'signature.png');  
        formData.append('bid_id', bidId); 
        
        $.ajax({
            url: "{{ route('marketpalce.upload.signature') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false, 
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')  // CSRF token
            },
            success: function(response) {
                if (response.success) {
                    // document.getElementById('signatureImage').src = response.image_url;
                    $('#eSignPadModal').closest('.modal').modal('hide');
                    Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.value) {
                            location.reload();
                        }
                    });
                } else {
                    alert("Failed to upload signature.");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error uploading signature:", error);
                alert("An error occurred while uploading the signature.");
            }
        });
    });
    function dataURLtoBlob(dataUrl) {
        const byteString = atob(dataUrl.split(',')[1]);
        const arrayBuffer = new ArrayBuffer(byteString.length);
        const uintArray = new Uint8Array(arrayBuffer);
        for (let i = 0; i < byteString.length; i++) {
            uintArray[i] = byteString.charCodeAt(i);
        }
        return new Blob([uintArray], { type: 'image/png' });
    }

    function isCanvasBlank(canvas) {
        const context = canvas.getContext('2d');
        const pixelBuffer = new Uint32Array(
            context.getImageData(0, 0, canvas.width, canvas.height).data.buffer
        );
        return !pixelBuffer.some(color => color !== 0);
    }
</script>


<script>
    var to_message = `<?php echo $to_message; ?>`;
    var user_type = `<?php echo $user_type; ?>`;
    var from_message = `<?php echo $from_message; ?>`;
    var chat_type = `<?php echo $chat_type; ?>`;
    var startChatype = `<?php echo $startChatype; ?>`;
    var apiPre = `<?php echo $apiPre; ?>`;
    var rePre = `<?php echo $rePre; ?>`;
    var fetchDe = `<?php echo $fetchDe; ?>`;
</script>

<script>
    $(document).on('click', '#showBidInput', function(e) {
    // Hide the "Raise Bid" button
    
    this.style.display = 'none';

    // Show the bid amount input and submit button
    document.getElementById('bidAmountInput').classList.remove('hidden_bid_amount');
    });

    $(document).ready(function() {
    $('#bidForm').on('submit', function(e) {
       
        e.preventDefault(); // Prevent default form submission
        var formData = new FormData(this);
        formData.append('_token', '{{ csrf_token() }}');
        $.ajax({
            url: '{{ route("p2p.raisebid.store") }}', // Replace with your form submission URL
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                 
                if(response.success==true){
                    Swal.fire({
                        title: 'Success!',
                        text: response.message, // Adjust the response message as needed
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.value) {
                            window.location.href = "{{ route('p2p.bid.list') }}"
                        }
                    });
                }else{
                    Swal.fire({
                    title: 'Error!',
                    text: 'Unauthorized. Please log in first',
                    icon: 'error',
                    confirmButtonText: 'Login'
                }).then((result) => {
                        if (result.value) {
                            window.location.href = "{{ url('user/login') }}"
                        }
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Error!',
                    text: 'There was an issue with the form submission.',
                    icon: 'error',
                    confirmButtonText: 'Try Again'
                });
            }
        });
    });
    });
 
    $(".bid_status_update").click(function (e) {
        e.preventDefault();
        const bidId = this.getAttribute('data-bid-id');
        const bidStatus = this.getAttribute('data-bid-status');
        var uri = "{{route('marketpalce.update-bid-status')}}";
        $.ajax({
            type: "get",
            url: uri,
            data: {
                      _token: "{{ csrf_token() }}",bid_id:bidId,bid_status:bidStatus,
                  }, 
            dataType: 'json',
            success: function(response) {
                  Swal.fire({
                      title: 'Success!',
                      text: response.message,
                      icon: 'success',
                      confirmButtonText: 'OK'
                  }).then((result) => {
                      if (result.value) {
                        location.reload();
                      }
                  });
              },
              error: function(xhr, status, error) {
                  console.log(error);
                  Swal.fire({
                      title: 'Error!',
                      text: 'There was an issue with the form submission.',
                      icon: 'error',
                      confirmButtonText: 'Try Again'
                  });
              }
        });
    });
  </script>


<!----------------------           ---------------->

<script>
    var recurringformPost = {};
    var maximumquantitylert = "{{__('Quantity is not available in stock')}}";
    var minimumquantitylert = "{{__('Minimum Quantity count is')}}";

    $(document).on('click', '.submitInquiryForm', function(e) {
        e.preventDefault();
        var formData = new FormData(document.getElementById("inquiry-form"));
        formData.append("variant_id", $('#prod_variant_id').val());
        var submit_url = "{{ route('inquiryMode.store') }}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "post",
            headers: {
                Accept: "application/json"
            },
            url: submit_url,
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#inquiry_form').modal('hide');
            },
            error: function(response) {
                // console.log(response);
                $('.messageError').html(response.responseJSON.errors.message[0]);
                $('.agreeError').html(response.responseJSON.errors.agree[0]);
                $('.numberError').html(response.responseJSON.errors.number[0]);
                $('.emailError').html(response.responseJSON.errors.email[0]);
                $('.nameError').html(response.responseJSON.errors.name[0]);
            },
            complete: function() {}
        });
    });

    $("#pincode").blur(function(e){
        e.preventDefault();
        var vendor_id = $(this).data('vendor-id');
        var pincode = $(this).val();
        var url = "{{ route('pincode.checkVendorPincode') }}";
        if(pincode != ''){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "post",
                headers: {
                    Accept: "application/json"
                },
                url: url,
                data: {vendor_id:vendor_id,pincode:pincode},
                dataType: "json",
                success: function(response) {
                    if(response.success == true){
                        $('#date_input').prop("disabled", false);
                        $('.pincode-err').text('');
                    }else{
                        $('#date_input').val("");
                        $('#date_input').prop("disabled", true);
                        $('.pincode-err').text('This product cannot be delivered here');
                    }
                },
                error: function(response) {
                    console.log(response);
                },
                complete: function() {}
            });
        }
    });

    // $('#date_input').change(function(){
    //     var input_date = $(this).val();
    //     $.ajax({
    //         url: "{{route('pincode.getShippingMethod')}}",
    //         type: "get",
    //         datatype: "html",
    //         data: {input_date:input_date},
    //         success: function(data){
    //             $('#delivery_form').modal('show');
    //             $("#delivery_option").empty().html(data);
    //         },
    //         error: function() {
    //             $("#delivery_option").empty().html('Something went wrong');
    //         }
    //     });
    // });

    $('#date_input').change(function(){
        var input_date = $(this).val();
        var product_id = "{{$product->id}}";
        // var vendor_cutOff_time = "{{$product->vendor->cutOff_time??''}}";
        if(input_date != ''){
            $.ajax({
                url: "{{route('product.getShippingProductDeliverySlots')}}",
                type: "get",
                datatype: "html",
                data: {input_date:input_date,product_id:product_id}, //,vendor_cutOff_time:vendor_cutOff_time
                success: function(data){
                    $('#delivery_form').modal({backdrop: 'static', keyboard: false});
                    $("#delivery_option").empty().html(data);
                },
                error: function() {
                    $("#delivery_option").empty().html('Something went wrong');
                }
            });
        }
    });

    // $(document).on('change', '#delivery_form .delivery_option', function(){
    //     var shipping_method_id = $(this).val();
    //     var product_id = "{{$product->id}}";
    //     $.ajax({
    //         url: "{{route('product.getShippingProductDeliverySlots')}}",
    //         type: "get",
    //         datatype: "html",
    //         data: {shipping_method_id:shipping_method_id, product_id:product_id},
    //         success: function(data){
    //             $('#delivery_form .modal-title').text('Select Delivery Slots');
    //             $("#delivery_option").empty().html(data);
    //         },
    //         error: function() {
    //             $("#delivery_option").empty().html('Something went wrong');
    //         }
    //     });
    // });

    $(document).on('change', '#delivery_form .delivery_slot', function(){
        $.ajax({
            url: "{{route('product.getShippingSlotsInterval')}}",
            type: "get",
            datatype: "html",
            data: {slot_id:$(this).val()},
            success: function(data){
                $('#delivery_form .modal-title').text('Select Delivery Slots');
                $("#delivery_option").empty().html(data);
            },
            error: function() {
                $("#delivery_option").empty().html('Something went wrong');
            }
        });
    });

    $(document).on('change', '#delivery_form .delivery_slot_interval', function(){
        var slot_price = $(this).data('price');
        var slot_id = $(this).val();
        var slot_text = $(this).data('slot-text');
        $('#sele_slot_id').val(slot_id);
        $('#sele_slot_price').val(slot_price);
        $('#selected_slot').text(slot_text);
        $('#delivery_form').modal('hide');
    });


    $(document).ready(function(){
        var cutOff_time = "{{@$current_time_response}}";
        var date_var;

        if( cutOff_time == 1) {
            date_var = new Date();
        } else {
            date_var = new Date();
            date_var.setDate(date_var.getDate()+1);
        }

        $('.flatpickr').flatpickr({
            enableTime: false,
            startDate: date_var,
            minDate: date_var,
            dateFormat: "Y-m-d" //H:i
        });
    });

    var valueHover = 0;

    function calcSliderPos(e, maxV) {
        return (e.offsetX / e.target.clientWidth) * parseInt(maxV, 10);
    }

    $(".starrate").on("click", function() {
        $(this).data('val', valueHover);
        $(this).addClass('saved')
    });

    $(".starrate").on("mouseout", function() {
        upStars($(this).data('val'));
    });


    $(".starrate span.ctrl").on("mousemove", function(e) {
        var maxV = parseInt($(this).parent("div").data('max'))
        valueHover = Math.ceil(calcSliderPos(e, maxV) * 2) / 2;
        upStars(valueHover);
    });


    function upStars(val) {
        var val = parseFloat(val);
        $("#test").html(val.toFixed(1));

        var full = Number.isInteger(val);
        val = parseInt(val);
        var stars = $("#starrate i");

        stars.slice(0, val).attr("class", "fa fa-star");
        if (!full) {
            stars.slice(val, val + 1).attr("class", "fa fa-star-half-o");
            val++
        }
        stars.slice(val, 5).attr("class", "fa fa-star-o");
    }


    $(document).ready(function() {
        $(".starrate span.ctrl").width($(".starrate span.cont").width());
        $(".starrate span.ctrl").height($(".starrate span.cont").height());
        // $(document).on("click",".color_var", function() {
        // 	var name  = $(this).attr("data-id");
        //     $(".var_"+name).removeClass("var-active");
        //     $(this).toggleClass("var-active");
        // });
        // $(document).on("click",".radio_var", function() {
        // 	var name  = $(this).attr("data-id");
        //     $(".radio_"+name).removeClass("radio-active");
        //     //$(this).toggleClass("radio-active");
        // });
        $(document).on("click",".radio", function() {
             var name = $(this).find(".changeVariant").attr("vid");
            $(`.var_${name}`).removeClass("radio-active");
            $(this).children().last().addClass("radio-active");

        });
    });
</script>

<script type="text/javascript">
    var ajaxCall = 'ToCancelPrevReq';
    var is_token_currency_enable = "{{$additionalPreference['is_token_currency_enable']}}";
    var token_currency = "{{$additionalPreference['token_currency']}}";
    let vendor_id = "{{ $product->vendor_id }}";
    let product_id = "{{ $product->id }}";
    var add_to_cart_url = "{{ route('addToCart') }}";
    $(document).on('click', '.changeVariant', function() {
        var $this = $(this);

        // var data_id = $(this).attr('data-variant-id');
        // // Set session variable
        // sessionStorage.setItem('selected_variant', data_id);
        // var myValue = sessionStorage.getItem('selected_variant');
        var myValue = []; // Initialize an empty array

        $('.selected_variant:checked').each(function() {
            var value = $(this).attr('data-variant-id'); // Get the value of the 'data' attribute
            myValue.push(value); // Push the value into the array
        });

        var variant_val = $(this).val();
        var option_title = $(this).data('option-title');
        $('.changeVariant_'+option_title).removeAttr('checked');
        $this.attr('checked', 'checked');
       $key =  $(this).data('row-key');
        updatePrice(myValue ,$key);
    });

    $(document).on('click', '.selected_variant', function() {
        var $this = $(this);
        var option_title = $(this).data('option-title');
        $('.changeVariant_'+option_title).removeAttr('checked');
        // $this.attr('checked', 'checked');
        // var isSelected = $this.is(':checked');
        // if(isSelected){
        //     // alert($(this).data('variant-id'));
        //     $('#prod_variant_id').val($(this).data('variant-id'));
        // }
    });

    function updatePrice(myValue ,key){
        var variants = [];
        var options = [];
        var firstCheckedSelectedTitle = $('.changeVariant:checked').first().parent().data('title');
        $('.changeVariant').each(function() {
            if (this.checked == true) {
                var that = this;
                variants.push($(that).attr('vid'));
                options.push($(that).attr('optid'));
            }
        });
        $.ajax({
            url: "{{ route('productVariant', $product->sku) }}",
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                "variants": variants,
                "options": options,
                "selected_variant_title": firstCheckedSelectedTitle,
                "key": key,
                'is_variant_checked':myValue
            },
            success: function(response) {
                if(response.status == "Success"){
                    // if(response.html != ''){
                    //     $("#variant_options").html('');
                    //     $("#variant_options").html(response.html);
                        $('#prod_variant_id').val(response.selected_variant.product_variant_id);
                    //}

                    if(response.selected_variant.price != null){
                        let price = parseFloat(response.selected_variant.price);
                        let compare_at_price = parseFloat(response.selected_variant.compare_at_price);
                        $('.product_fixed_price').html(price.toFixed(2));
                        $('.product_original_price').html(compare_at_price.toFixed(2));
                    }

                }
                // Handle the successful response
            },
            error: function(xhr) {
                console.log(xhr);
                // Handle the error
            }
        });
    }


    // function updatePrice(){
    //     var variants = [];
    //     var options = [];
    //     var selected_variant_title = "";
    //     $('.changeVariant').each(function() {
    //         var that = this;
    //         if (this.checked == true) {
    //             variants.push($(that).attr('vid'));
    //             options.push($(that).attr('optid'));
    //             selected_variant_title = $(that).parent().attr('data-title');
    //         }
    //     });
    //     ajaxCall = $.ajax({
    //         type: "post",
    //         dataType: "json",
    //         url: "{{ route('productVariant', $product->sku) }}",
    //         data: {
    //             "_token": "{{ csrf_token() }}",
    //             "variants": variants,
    //             "options": options,
    //             "selected_variant_title": selected_variant_title
    //         },
    //         beforeSend: function() {
    //             if (ajaxCall != 'ToCancelPrevReq' && ajaxCall.readyState < 4) {
    //                 ajaxCall.abort();
    //             }
    //         },
    //         success: function(resp) {
    //             console.log(resp);
    //             if(resp.status == 'Success'){
    //                 $("#variant_response span").html('');
    //                 var response = resp.data;
    //                 if(response.variant != ''){
    //                     if(vendor_type == 'rental'){
    //                         // $('.incremental_hrs').val(0);
    //                         // $('.base_hours_min').val();
    //                         $('.incremental_hrs').val(0);
    //                         $('#incremental_hrs_hidden').val(base_hours_min);
    //                         $('.incremental-left-minus').click();
    //                         //$('#blocktime, #blocktime2').change();
    //                     }
    //                     // if(additionalPreference != 0){
    //                     //     response.variant.productPrice = token_currency * response.variant.productPrice;
    //                     // }
    //                     $('#product_variant_wrapper').html('');
    //                     let variant_template = _.template($('#variant_template').html());
    //                     response.variant.productPrice = (parseFloat(checkAddOnPrice()) + parseFloat(response.variant.productPrice)).toFixed(digit_count);
    //                     response.variant.compare_at_price = (parseFloat(checkAddOnPrice()) + parseFloat(response.variant.compare_at_price)).toFixed(digit_count);
    //                     $("#product_variant_wrapper").append(variant_template({ Helper: NumberFormatHelper, variant:response.variant, tokenAmount: response.tokenAmount, is_token_enable: response.is_token_enable}));
    //                     $('#product_variant_quantity_wrapper').html('');
    //                     let variant_quantity_template = _.template($('#variant_quantity_template').html());
    //                     $("#product_variant_quantity_wrapper").append(variant_quantity_template({variant:response.variant}));
    //                     // console.log(response.variant.quantity);
    //                     if(!response.is_available){
    //                         $(".addToCart, #addon-table").hide();
    //                     }else{
    //                         $(".addToCart, #addon-table").show();
    //                     }
    //                     let variant_image_template = _.template($('#variant_image_template').html());
    //                     $(".product__carousel .gallery-parent").html('');
    //                     $(".product__carousel .gallery-parent").append(variant_image_template({variant:response.variant}));
    //                     // easyZoomInitialize();
    //                     // $('.easyzoom').easyZoom();

    //                     if(response.variant.media != ''){
    //                         $(".product-slick").slick({ slidesToShow: 1, slidesToScroll: 1, arrows: !0, fade: !0, asNavFor: ".slider-nav" });
    //                         $(".slider-nav").slick({ vertical: !1, slidesToShow: 3, slidesToScroll: 1, asNavFor: ".product-slick", arrows: !1, dots: !1, focusOnSelect: !0 });
    //                     }
    //                 }
    //             }else{
    //                 $("#variant_response span").html(resp.message);
    //                 $(".addToCart, #addon-table").hide();
    //             }
    //         },
    //         error: function(data) {

    //         },
    //     });
    // }

    function checkAddOnPrice()
    {
        price  = 0;
        $('.productDetailAddonOption').each(function(){
            if($(this).prop('checked') == true){
                var cp = $(this).data('price');
                price = price + parseFloat(cp);
            }
        });
        return price;
    }
</script>
<script>
    var addonids = [];
    var addonoptids = [];
    $(function() {
        $(".productDetailAddonOption").click(function(e) {
           // var addon_elem = $(this).closest('tr');
            var addon_elem = $(this).parents('.productAddonSetOptions');

            var addon_minlimit = addon_elem.data('min');
            var addon_maxlimit = addon_elem.data('max');
            if(addon_elem.find(".productDetailAddonOption:checked").length > addon_maxlimit) {
                this.checked = false;
            }else{
                var addonId = $(this).attr("addonId");
                var addonOptId = $(this).attr("addonOptId");
                if ($(this).is(":checked")) {
                    addonids.push(addonId);
                    addonoptids.push(addonOptId);
                } else {
                    addonids.splice(addonids.indexOf(addonId), 1);
                    addonoptids.splice(addonoptids.indexOf(addonOptId), 1);
                }
                if($('.changeVariant').length > 0)
                {
                    updatePrice();
                }else{
                    addOnPrice = parseFloat(checkAddOnPrice());
                    org_price = parseFloat($(this).data('original_price')) + addOnPrice;
                    fixed_price = parseFloat($(this).data('fixed_price')) + addOnPrice;
                    if(is_token_currency_enable > 0){
                        org_price = token_currency * org_price;
                        fixed_price = token_currency * fixed_price;
                    }
                    $('.product_fixed_price').html(fixed_price.toFixed(digit_count));
                    $('.product_original_price').html(org_price.toFixed(digit_count));
                }
            }
        });
    });
</script>

<script>
    let swiper = new Swiper(".mySwiper", {
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });

    document.querySelectorAll('.slider-thumb').forEach(function (img) {
        img.addEventListener('click', function () {
            let index = parseInt(this.dataset.index);
            swiper.slideTo(index);
            let modal = new bootstrap.Modal(document.getElementById('imageModal'));
            modal.show();
        });
    });
</script>

<!-----  rating product if delivered -->

<script type="text/javascript">
    $(document).ready(function(e) {
        $('.rating-star-click').click(function() {
            $('.rating_files').show();
            $('.form-row').show();
            $('#product_rating').modal('show');
        });
        $('body').on('click', '.add_edit_review', function(event) {
            event.preventDefault();
            var id = $(this).data('id');
            $.get('/rating/get-product-rating?id=' + id, function(markup) {
                $('#product_rating').modal('show');
                $('#review-rating-form-modal').html(markup);
            });
        });


        var enableDates = {!! $productAvailability !!};



        if (typeof enableDates === 'string') {
            enableDates = enableDates.split(',').map(function(dateString) {
                return dateString.trim();
            });
        }
        $("#range-datepicker").flatpickr({
                dateFormat: "Y-m-d",
                mode: "range",
                enable : enableDates,
                onChange: function (selectedDates, dateStr, instance) {
                    // Update the summary-data template
                    updateSummary(selectedDates);
                }
            });
            // Function to update summary data
            function updateSummary(selectedDates) {
                const startDate = selectedDates[0];
                const endDate = selectedDates[selectedDates.length - 1];
                const days = Math.round((endDate - startDate) / (24 * 60 * 60 * 1000)) + 1;



                let dailyRate;
                if (days < 7) {
                    dailyRate = {{@$product->variant[0]->price}};
                } else if (days >= 7 && days < 30) {
                    dailyRate = {{@$product->variant[0]->week_price ?? 0 }};
                } else {
                    dailyRate = {{@$product->variant[0]->month_price ?? 0 }};
                }
                const totalAmount = days * dailyRate ;


                // Update values in the template
                $(".summary-box").show();
                $(".days-count").text(days);
                $(".applied-total-amount").text(showCurrencySymbol(days * dailyRate));
                $(".applied-price").text(showCurrencySymbol(dailyRate));
                $(".date-range").text(startDate.toDateString() + " - " + endDate.toDateString());
                $(".total-amount").text(showCurrencySymbol(totalAmount));
            }
            function showCurrencySymbol(amount){
                return "{{Session::get('currencySymbol')}}" + amount;
            }
    });

    // $(document).ready(function() {
    //     $('.measurmentClick').on('click', function() {
    //         $('.measurmentDiv').toggle('5');
    //          // Toggle the icon
    //             var icon = $(this).find('i');
    //             if (icon.hasClass('fa-plus')) {
    //                 icon.removeClass('fa-plus').addClass('fa-minus');
    //             } else {
    //                 icon.removeClass('fa-minus').addClass('fa-plus');
    //             }
    //     });
    // });

</script>



<script>
    var timeout= null;
    var width =250;
    var height = 250;
    function imageZoom(imgID, resultID) {
        var img, lens, result, cx, cy;
        img = document.getElementById(imgID);
        result = document.getElementById(resultID);
        /*create lens:*/
        lens = document.createElement("DIV");
        lens.setAttribute("class", "img-zoom-lens");
        /*insert lens:*/
        img.parentElement.insertBefore(lens, img);
        /*calculate the ratio between result DIV and lens:*/
        cx = result.offsetWidth / width;
        cy = result.offsetHeight / height;
        console.log(cx+4);
        /*set background properties for the result DIV:*/

        result.style.backgroundImage = "url('" + img.src + "')";
        result.style.backgroundSize = (img.width * cx) + "px " + (img.height * cy) + "px";
        /*execute a function when someone moves the cursor over the image, or the lens:*/
        lens.addEventListener("mousemove", moveLens);
        img.addEventListener("mousemove", moveLens);
        /*and also for touch screens:*/
        lens.addEventListener("touchmove", moveLens);
        img.addEventListener("touchmove", moveLens);
        function moveLens(e) {
          var pos, x, y;
          /*prevent any other actions that may occur when moving over the image:*/
          e.preventDefault();
          /*get the cursor's x and y positions:*/
          pos = getCursorPos(e);
          /*calculate the position of the lens:*/
          x = pos.x - (lens.offsetWidth / 2);
          y = pos.y - (lens.offsetHeight / 2);
          /*prevent the lens from being positioned outside the image:*/
          if (x > img.width - lens.offsetWidth) {x = img.width - width;}
          if (x < 0) {x = 0;}
          if (y > img.height - lens.offsetHeight) {y = img.height - height;}
          if (y < 0) {y = 0;}
          /*set the position of the lens:*/
          lens.style.left = x + "px";
          lens.style.top = y + "px";
          /*display what the lens "sees":*/
        //   console.log(x)
        //   console.log(y)
          result.style.backgroundPosition = "-" + (x * cx) + "px -" + (y * cy) + "px";
        }
        function getCursorPos(e) {
          var a, x = 0, y = 0;
          e = e || window.event;
          /*get the x and y positions of the image:*/
          a = img.getBoundingClientRect();
          /*calculate the cursor's x and y coordinates, relative to the image:*/
          x = e.pageX - a.left;
          y = e.pageY - a.top;
          /*consider any page scrolling:*/
          x = x - window.pageXOffset;
          y = y - window.pageYOffset;
          return {x : x, y : y};
        }
      }
        $('#main_image').mouseover(function() {
            var imageId = this.id;
            $('.img-zoom-lens').remove();
            $('.img-zoom-result').show();
            imageZoom(imageId, "myresult");
        });

        $('.myimage1').click(function(){
            var new_image = $(this).attr('src');
            $('#main_image').attr('src',new_image);
        })
        $('.exzoom_img_ul').mouseleave(() =>{
            $('.img-zoom-result').hide();
            $('.img-zoom-lens').remove();
        });

        $(".suggested-product").slick({
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 1,
            responsive: [
            { breakpoint: 1199, settings: { slidesToShow: 3, slidesToScroll: 1, infinite: true, dots: false, centerMode: true, } },
            { breakpoint: 991, settings: { slidesToShow: 2, slidesToScroll: 1, dots: false, centerMode: true, } },
            { breakpoint: 767, settings: { slidesToShow: 1, slidesToScroll: 1, dots: false, centerMode: true, } },
            { breakpoint: 576, settings: { slidesToShow: 1, slidesToScroll: 1, dots: false, centerMode: true, centerPadding: '0', } }
        ]
        });




        $(document).ready(function() {
            $(".img_active").click(function(){

                $(".img_active").find('img').removeClass("active");
                $(this).find('img').addClass("active");
            });
        });


        $(document).on("click",".color_name",function(){
        	if($(this).hasClass("ellipsis")){
        		$(this).removeClass("ellipsis");
        	}else{
        		$(this).addClass("ellipsis");
        	}
        });

        function showLessTextFunction() {
            $("#show_product_text_less").attr("style", "display:none");
            $("#show_product_text_more").attr("style", "display:block");
        }

        function showMoreTextFunction() {
            $("#show_product_text_less").attr("style", "display:block");
            $("#show_product_text_more").attr("style", "display:none");
        }


        document.addEventListener("DOMContentLoaded", function() {
        var content = document.getElementById("productContent");
        var readMoreLink = document.getElementById("readMoreLink");
        var fullContent = <?= json_encode($fullContent ?? "") ?>;
        var isFullContentDisplayed = false;

    if (readMoreLink) { // Check if readMoreLink exists
        readMoreLink.addEventListener("click", function(e) {
            e.preventDefault();
            if (isFullContentDisplayed) {
                content.innerHTML = <?= json_encode($content ?? "") ?>;
                readMoreLink.innerText = "Read More";
            } else {
                content.innerHTML = fullContent;
                readMoreLink.innerText = "Read Less";
            }
            isFullContentDisplayed = !isFullContentDisplayed;
        });
    }
});

        </script>
        <script>
        document.getElementById('closeSellerCanvasBtn').addEventListener('click', function() {
            document.getElementById('canvasContainer').style.display = 'none'; // Hide the canvas
        });
        document.getElementById('closeBuyerCanvasBtn').addEventListener('click', function() {
            document.getElementById('canvasContainerBuyer').style.display = 'none'; // Hide the canvas
        });
        </script>

@endsection

