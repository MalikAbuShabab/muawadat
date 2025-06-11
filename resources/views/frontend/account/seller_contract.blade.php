@extends('layouts.store', ['title' => 'Loyalty'])
@section('css')
<link href="{{asset('assets/libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/dropify/dropify.min.css')}}" rel="stylesheet" type="text/css" />
<style type="text/css">
    .main-menu .brand-logo {
        display: inline-block;
        padding-top: 20px;
        padding-bottom: 20px;
    }
    .child-card {
        background: #0151585e;
    }
</style>
<link rel="stylesheet" href="{{asset('assets/css/intlTelInput.css')}}">
@endsection
@section('content')

<section class="section-b-space">
    <div class="container">
        <div class="row my-md-3 mt-5 pt-4">
            <div class="col-lg-3">
                <div class="account-sidebar"><a class="popup-btn">{{ __('My Account') }}</a></div>
                @include('layouts.store/profile-sidebar')
            </div>
            <div class="col-lg-9">
                <div class="dashboard-right">
                    <div class="dashboard">
                        <div class="page-title">
                            <h2>{{ __('As Seller Contracts') }}</h2>
                        </div>
                        <div class="card-box al_inner_card">
                            <div class="row">
                            <div class="offset-md-2 col-md-8">
                                    @if(@$signatureImgs)
                                        @foreach ($signatureImgs as $signatureImg) 
                                            <div class="card-box child-card">
                                                <div class="row align-items-center">
                                                    <div class="col-3">
                                                        <h5 class="mt-0"><b>{{ __('Seller Sign') }}</b></h5>
                                                        <div class="medal-img">
                                                            <img src="{{@$signatureImg['image_fit'].'400/400/sm/0/plain/'.$signatureImg['original_image']}}" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <h4 class="mt-0"><b>{{ __('Signed Contracts') }}</b></h3>
                                                        <div class="loalty-title" style="font-size:18px;">
                                                            Bid No  #0000{{ $signatureImg['bidData']->id ?? '00' }}
                                                        </div>
                                                        <div class="loalty-title" style="font-size:18px;">
                                                            Company -: {{ $signatureImg['bidData']['product']->title ?? 'N/A' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <h5 class="mt-0"><b>{{ __('Buyer Sign') }}</b></h5>
                                                        <div class="medal-img">
                                                            <img src="{{@$signatureImg['image_fit'].'400/400/sm/0/plain/'.$signatureImg['original_buyer_image']}}" alt="">
                                                        </div>
                                                    </div>
                                                    <a href="{{ url('p2p/download-signed-agreement/' . $signatureImg['bidData']->id) }}" class="p-1 text-center text-white rounded mt-3 w-100" style="background: #015158">
                                                        Download as PDF
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-md-12 text-center">
                                            <div class="card-box earn-points p-2">
                                                <div class="points-title1" style="color:red;">
                                                    <div class="text-center" ><strong>{{__('Seller Contract Signed Not Found !')}} </strong></div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    @endif

                                        {{-- <div class="row">
                                            <div class="col-md-6 text-center">
                                                <div class="card-box earn-points p-2">
                                                    <div class="points-title">
                                                         
                                                    </div>
                                                    <div class="ponits-heading">
                                                       
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 text-center">
                                                <div class="card-box spend-points p-2">
                                                    <div class="points-title">
                                                      
                                                    </div>
                                                    <div class="ponits-heading">
                                                       
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                          

                           {{-- <div class="row">
                                <div class="offset-lg-1 col-lg-10">
                                    @if($upcoming_loyalty->isNotEmpty())
                                    <div class="row">
                                        <div class="col-12 ">
                                            <h4 style="color: var(--theme-color)">{{__('Upcoming')}}</h4>
                                        </div>
                                        @foreach($upcoming_loyalty as $loyalty)
                                        <div class="col-md-4 mt-3 text-center">
                                            <div class="card-box al_gold_box">
                                                <div class="point-img-box">
                                                    <img src="{{ $loyalty->image['proxy_url'] .'200/200'. $loyalty->image['image_path'] }}" alt="">
                                                </div>
                                                <h4 class="mb-0 mt-3"><b><span class="alLoyaltyPrice"> {{$loyalty->points_to_reach}}</span> points to <span class="alLoyaltyName"> {{$loyalty->name}} </span></b></h4>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                               </div>
                           </div> --}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('script')

@endsection
