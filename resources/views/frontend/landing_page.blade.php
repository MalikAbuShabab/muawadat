@extends('layouts.store', ['title' => __('Home')]) @section('content')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/landing-page-fonts/stylesheet.css') }}">

    <style>
        * {
            box-sizing: border-box;
            padding: 0;
            margin: 0;
        }

        header,
        footer {
            display: none;
        }

        body h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        span,
        a,
        li,
        ul,
        ol,
        label,
        input,
        select,
        textarea,
        button {
            font-family: "LT Wave" !important;
        }

        @media (max-width: 767px) {
            .al_body_template_one article.al_new_wrapper_design {
                padding-top: 0px !important;
            }

            br {
                display: none;
            }

            body {
                overflow-x: hidden;
            }

            .al_body_template_one article#content-wrap {
                overflow-x: clip;
            }
        }
  
        .logout-button {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }
        
        .logout-button .tooltip-text {
            visibility: hidden;
            width: 60px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;
            font-size: 12px;
        
            /* Position the tooltip */
            position: absolute;
            z-index: 1;
            bottom: 125%; /* Position above the button */
            left: 50%;
            margin-left: -30px;
        
            /* Fade in tooltip */
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .logout-button:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }
    </style>

@php
    $clientData = \App\Models\Client::select('id', 'logo', 'dark_logo')
    ->where('id', '>', 0)
    ->first();
    if(Session::get('config_theme') == 'dark'){
        $urlImg = $clientData ? $clientData->dark_logo['original'] : ' ';
    }else{
        $urlImg = $clientData ? $clientData->logo['original'] : ' ';
    }
    $compId = session()->get('company_id')??null;
    if(!empty($compId) ||  @auth()->user()->company_id)
    {
        $compId = (($compId)?base64_decode($compId):auth()->user()->company_id);
        $compdata =  \App\Models\Company::where('id',$compId)->first();
        if($compdata){
            $urlImg = get_file_path($compdata->logo,'FILL_URL');
        }else{
            $urlImg = '';
        }
        
    }

    $languageList = \App\Models\ClientLanguage::with('language')
    ->where('is_active', 1)
    ->orderBy('is_primary', 'desc')
    ->get();
    $currencyList = \App\Models\ClientCurrency::with('currency')
    ->orderBy('is_primary', 'desc')
    ->get();
    $pages = \App\Models\Page::with([
    'translations' => function ($q) {
    $q->where('language_id', session()->get('customerLanguage') ?? 1);
    },
    ])
    ->whereHas('translations', function ($q) {
    $q->where(['is_published' => 1, 'language_id' => session()->get('customerLanguage') ?? 1]);
    })
    ->orderBy('order_by', 'ASC')
    ->get();
@endphp

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- header -->
    <div class="muawadat_header">
        <div class="container">
            <div class="muawadat_header_wrapper">
                <div class="muawadat_header_logo">
                    <a href="/">
                        <img class="mb-1" alt="logo" src="{{asset('images/black_logo.png')}}" />
                    </a>
                </div>

                <!-- Toggle Button for Mobile -->
                <button class="menu-toggle d-lg-none">
                    <i class="bi bi-list"></i> <!-- Bootstrap icon (hamburger) -->
                </button>

                <!-- Navigation Menu -->
                <div class="muawadat_header_menu">
                    <ul>
                        <li><a href="{{route('userHome')}}" class="muawadat_header_menu_active">{{__('Home')}}</a></li>
                        <li><a href="{{ url('page/about-us') }}">{{__('about.us')}}</a></li>
                        <li><a href="#">{{__('services')}}</a></li>
                        <li><a href="{{route('contact-us')}}">{{__('Contact Us')}}</a></li>
                        <li class="onhover-dropdown change-language">
                            <a href="javascript:void(0)">{{ session()->get('locale') }}
                                <span class="icon-ic_lang align-middle"></span>
                                <span class="language ml-1 align-middle">{{__('Language')}}</span>
                            </a>
                            <ul class="onhover-show-div" style="color:#000">
                                @foreach ($languageList as $key => $listl)
                                <li
                                    class="{{ session()->get('locale') == $listl->language->sort_code ? 'active' : '' }}">
                                    <a href="javascript:void(0)" class="customerLang"
                                        langId="{{ $listl->language_id }}">{{ $listl->language->name }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="d-lg-none"><a href="#">Log In</a></li>
                        <li class="d-lg-none"><a href="#">Sign Up</a></li>
                    </ul>
                </div>

                <div class="muawadat_header_buttons">
                    @guest
                        <a href="{{ url('user/login') }}">
                            <button class="muawadat_header_login">Log In</button>
                        </a>
                        <a href="{{ url('user/register') }}">
                            <button class="muawadat_header_signup">Sign Up</button>
                        </a>
                    @endguest
                
                    @auth
                        <a href="{{ url('authdashboard') }}">
                            <button class="muawadat_header_login">{{__('Dashboard')}}</button>
                        </a>
                        <a href="{{ route('user.logout.landpage') }}">
                            <button class="muawadat_header_login logout-button">
                                <i class='fas fa-sign-out-alt' style='font-size:24px'></i>
                                <span class="tooltip-text">Logout</span>
                            </button>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- banner -->
    <div class="muawadat_banner">
        <div class="container">
            <div class="muawadat_banner_wrapper">
                <div class="muawadat_banner_wrap">
                    <img alt="waves" class="muawadat_banner_waves" src="{{asset('images/landing-page/wave.png')}}" />
                    <div class="muawadat_banner_text">
                        <h1>{{ __('A Digital Platform Designed to Connect Sellers of Ownership Shares with Investors')}}
                        <span></span>
                        </h1>
                        <p>{{__('muawadat.digital.plateform')}}
                        </p>
                        <div class="muawadat_banner_buttons">
                            <a href="#">
                                <img alt="app store" src="{{asset('images/landing-page/appstore.png')}}" />
                            </a>
                            <a href="#">
                                <img alt="gplay" src="{{asset('images/landing-page/gplay.png')}}" />
                            </a>
                        </div>
                        <div class="muawadat_banner_stars">
                            <img alt="trustpilot" class="trustpilot"
                                src="{{asset('images/landing-page/trustpilot.png')}}" />
                            <img alt="stars" class="stars" src="{{asset('images/landing-page/stars.png')}}" />
                        </div>
                    </div>
                </div>
                <div class="muawadat_banner_image">
                    <img alt="app store" src="{{asset('images/landing-page/bannerimage.png')}}" />
                </div>
                <img alt="ellipse" class="ellipse" src="{{asset('images/landing-page/ellipse.png')}}" />
            </div>
        </div>
    </div>

    <!-- counter -->
    <div class="muawadat_counter">
        <div class="container">
            <div class="muawadat_counter_wrapper">
                <div class="counter_card">
                    <div class="counter_image">
                        <img alt="counter" src="{{asset('images/landing-page/deals.png')}}" />
                    </div>
                    <div class="counter_text">
                        <h3>90k+</h3>
                        <p>{{ __('Deals') }} </p>
                    </div>
                </div>
                <div class="counter_card">
                    <div class="counter_image">
                        <img alt="counter" src="{{asset('images/landing-page/customers.png')}}" />
                    </div>
                    <div class="counter_text">
                        <h3>30+</h3>
                        <p>{{ __('Customers') }}  </p>
                    </div>
                </div>
                <div class="counter_card">
                    <div class="counter_image">
                        <img alt="counter" src="{{asset('images/landing-page/bids.png')}}" />
                    </div>
                    <div class="counter_text">
                        <h3>50+</h3>
                        <p> {{ __('Bids') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- about -->
    <div class="muawadat_about">
        <div class="container">
            <div class="muawadat_about_wrapper">
                <div class="muawadat_about_title">
                    <h2>{{__('Who is the Muawadat Platform Designed For')}}?</h2>
                </div>
                <div class="muawadat_about_content">
                    <div class="muawadat_about_image">
                        <img alt="for-image" class="for-image" src="{{asset('images/landing-page/for-image.png')}}" />
                        <img alt="for-top" class="for-top" src="{{asset('images/landing-page/for-top.png')}}" />
                        <img alt="for-bottom" class="for-bottom" src="{{asset('images/landing-page/for-bottom.png')}}" />
                    </div>
                    <div class="muawadat_about_text">
                        <h6>{{__('For Investors') }}</h6>
                        <p> {{__('We provide investors with opportunities to explore innovative and profitable investments across diverse sectors. You can also co-invest with other investors in the same project')}}.</p>
                        <h6>{{__('For Business Owners and Entrepreneurs')}}</h6>
                        <p class="mb-0">{{__('we.empower.business')}}.
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- counter -->
    <div class="muawadat_counte">
        <div class="container">
            <div class="muawadat_counte_wrapper">
                <div class="counte_card">
                    <img alt="counte" src="{{asset('images/landing-page/signup.png')}}" />
                    <h5>{{__("Sign up")}}</h5>
                </div>
                <div class="counte_card">
                    <img alt="counte" src="{{asset('images/landing-page/listing.png')}}" />
                    <h5>{{ __('Listing') }}</h5>
                </div>
                <div class="counte_card">
                    <img alt="counte" src="{{asset('images/landing-page/biding.png')}}" />
                    <h5>{{ __('Biding') }}</h5>
                </div>
                <div class="counte_card">
                    <img alt="counte" src="{{asset('images/landing-page/contract.png')}}" />
                    <h5>{{ __('E-Contract') }}<br>
                        {{ __('Sign')}} </h5>
                </div>
                <div class="counte_card">
                    <img alt="counte" src="{{asset('images/landing-page/deal.png')}}" />
                    <h5>Deal</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- services -->
    <div class="muawadat_services">
        <div class="container">
            <div class="muawadat_services_wrapper">
                <div class="muawadat_services_title">
                    <h3>{{__("Our Services")}}</h3>
                    <h4>{{__("What Can You Sell")}}?</h4>
                </div>
                <div class="muawadat_services_content">
                    <div class="muawadat_services_text">
                        <ul>
                            <li>
                                <span>1. </span>
                                <mark>{{__("Entire Companies for Sale or Fractional Shares")}}</mark>
                            </li>
                            <li>
                                <span>2. </span>
                                <mark>{{__("Shares in Non-Listed Companies")}}</mark>
                            </li>
                            <li>
                                <span>3. </span>
                                <mark>{{__("Trademarks")}}</mark>
                            </li>
                            <li>
                                <span>4. </span>
                                <mark>{{__("Patents")}}</mark>
                            </li>
                        </ul>
                    </div>
                    <div class="muawadat_services_image">
                        <img class="d-md-none" alt="laptop" src="{{asset('images/landing-page/round-tab.png')}}" />
                        <img class="d-none d-md-block" alt="laptop" src="{{asset('images/landing-page/frame.png')}}" />
                    </div>
                    <div class="muawadat_services_text">
                        <ul>
                            <li>
                                <span>5. </span>
                                <mark>{{__("Intellectual Property Rights")}}</mark>
                            </li>
                            <li>
                                <span>6. </span>
                                <mark>{{__("Copyrights")}} </mark>
                            </li>
                            <li>
                                <span>7. </span>
                                <mark>{{__("Apps")}}</mark>
                            </li>
                            <li>
                                <span>8. </span>
                                <mark>{{__("E-commerce Stores")}}</mark>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- invest -->
    <div class="muawadat_invest">
        <div class="container">
            <div class="muawadat_invest_wrapper">
                <div class="muawadat_invest_title">
                    <h3>{{__("Invest with Safety and Confidence on Muawadat")}}</h3>
                    <p>{{__("Secure your personal loan in 60 seconds, powered by breakthrough")}}<br> {{__("technology!")}}</p>
                </div>
                <div class="muawadat_invest_cards">
                    <div class="invest_cards">
                        <div class="invest_count">1</div>
                        <h4>{{__("Explore Listed Businesses")}}</h4>
                        <p>{{__("Browse investment opportunities")}}<br> {{__("across multiple sectors.")}}</p>
                    </div>
                    <div class="invest_cards">
                        <div class="invest_count">2</div>
                        <h4>{{__("Bid and Negotiate Offers")}}</h4>
                        <p>{{__("Participate in transparent auctions")}}<br> {{__("to secure the best deals")}}<br> {{__("at competitive prices.")}}</p>
                    </div>
                    <div class="invest_cards">
                        <div class="invest_count">3</div>
                        <h4>{{__("E-Sign Contracts")}}</h4>
                        <p>{{__("Complete transactions easily and")}}<br> {{__("securely using electronic")}}<br> {{__("signatures")}}</p>
                    </div>
                    <div class="invest_cards">
                        <div class="invest_count">4</div>
                        <h4>{{__("Track Transaction Progress")}}</h4>
                        <p>{{__("Monitor every step of the process")}}<br> {{__("to ensure your objectives are met.")}}</p>
                    </div>
                    <div class="invest_cards">
                        <div class="invest_count">5</div>
                        <h4>{{__("Full Financial Security")}}</h4>
                        <p>{{__("Invest with peace of mind, knowing your")}}<br> {{__("data and funds are protected.")}}</p>
                    </div>
                    <div class="invest_cards">
                        <div class="invest_count">6</div>
                        <h4>{{__("Funds in Minutes")}}</h4>
                        <p>{{__("Swift disbursal means no waiting! Your")}}<br> {{__("finances are sorted the moment your")}}<br> {{__("application is complete.")}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- partners -->
    <div class="muawadat_partners">
        <div class="container">
            <div class="muawadat_partners_wrapper">
                <img alt="partners" src="{{asset('images/landing-page/trustpilot.png')}}" />
                <img alt="partners" src="{{asset('images/landing-page/amazon.png')}}" />
                <img alt="partners" src="{{asset('images/landing-page/visa.png')}}" />
                <img alt="partners" src="{{asset('images/landing-page/google.png')}}" />
            </div>
        </div>
    </div>

    <!-- platform -->
    <div class="muawadat_platform">
        <div class="container">
            <div class="muawadat_platform_wrapper">
                <div class="muawadat_platform_text">
                    <h4>{{ __("muawadat.platform") }} </h4>
                    <p>{{ __('muawadat.intro') }}</p>
                    <p>{{ __('muawadat.support') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- features -->
    <div class="muawadat_features">
        <div class="container">
            <div class="muawadat_features_wrapper">
                <div class="muawadat_features_title">
                    <h3>{{__('key.features')}}</h3>
                </div>
                <div class="muawadat_features_cards">
                    <div class="features_cards">
                        <div class="features_count">1</div>
                        <h4>{{__('explore.businesses')}}</h4>
                        <p>{{__('enables.investors')}}<br> {{__('invest.opportunities')}}<br>{{__("goal.sinterests")}}<br>{{__('user.friendly')}}</p>
                    </div>
                    <div class="features_cards">
                        <div class="features_count">2</div>
                        <h4>{{__('bid.negotiate.offers')}}</h4>
                        <p>{{__('platform.empowers')}}<br> {{__('negotiate.optimal')}}<br> {{__('returns')}}</p>
                    </div>
                    <div class="features_cards">
                        <div class="features_count">3</div>
                        <h4>{{__('E-Sign Contracts')}}</h4>
                        <p>{{__('electronic.signature')}}<br> {{__('finalize.transactions')}}
                            <br>{{__('swiftly.eliminating')}}</p>
                    </div>
                    <div class="features_cards">
                        <div class="features_count">4</div>
                        <h4>{{__('track.progress')}}</h4>
                        <p>{{__('platform.offers')}}<br> {{__('investment.processes')}}<br>
                            {{__('achieved.clarity')}}
                        </p>
                    </div>
                    <div class="features_cards">
                        <div class="features_count">5</div>
                        <h4>{{__('financial.security')}}</h4>
                        <p>{{__('platform.guarantees')}} <br>{{__('user.data')}}
                            <br> {{__('security.systems')}}<br> {{__('secure.transactions')}}
                            <br>{{__('dhamin')}}
                        </p>
                    </div>
                    <div class="features_cards">
                        <div class="features_count">6</div>
                        <h4>{{__('connecting.sellers')}}<br>
                             {{__('For Investors')}}</h4>
                        <p>{{__('platform.guarantees')}}<br> {{__('user.data')}}<br> {{__('security.systems')}} <br>{{__('secure.transactions')}}
                            <br>
                            {{__('dhamin')}}</p>
                    </div>
                    <div class="features_cards">
                        <div class="features_count">7</div>
                        <h4>{{__('guidance.technical') }}<br>
                            {{ __('support.experts') }}
                        </h4>
                        <p>{{__('platform.services')}}<br> {{__('technical.support')}}<br>{{__('ensure.technical')}}<br> {{__('processes.')}}</p>
                    </div>
                    <div class="features_cards">
                        <div class="features_count">8</div>
                        <h4>{{__('premier.gateway')}}<br>
                            {{__('investment.market')}}</h4>
                        <p>{{__('muawadat.anyone')}}<br> {{__('seeking.enter')}}<br> {{__('businesses.confidently')}}<br>{{__('professional.transparent')}}<br> {{__('procedures')}}</p>
                        </p>
                    </div>
                    <div class="features_cards">
                        <div class="features_count">9</div>
                        <h4>{{__('easy.integrated')}}</h4>
                        <p>{{__('platform.provides.users')}}<br> {{__('comprehensive.experience')}}<br>
                            {{__('exploring.opportunities')}}<br>{{__('evaluating.finalizing')}}<br> {{__('financial.investment')}}<br>{{__('achieve')}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- opp -->
    <div class="muawadat_opp">
        <div class="container">
            <div class="muawadat_opp_wrapper">
                <h4>{{__('golden.opportunities')}}<br>
                    {{__('every.day.but')}}<br>
                    {{__('your.hands')}}
                </h4>
                <p>{{__('dont.miss')}}<br>{{__('strategic.partner')}}<br> {{__('benefit.register')}}
                </p>
                <button>{{__('start.now')}}</button>
                <div class="text-right d-md-none">
                    <img class="" alt="client" src="{{asset('images/landing-page/opp-image.png')}}" />
                </div>
            </div>
        </div>
    </div>

    <!-- testimonial -->
    <div class="muawadat_testimonial">
        <div class="container">
            <div class="muawadat_testimonial_title">
                <h3>{{__('happy.customers')}}</h3>
                <p>{{__('customer.story')}}</p>
            </div>
            <div class="muawadat_testimonial_slider">
                <div class="testimonial-slider">

                    <!-- Card 1 -->
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <img alt="client" src="{{asset('images/landing-page/clientt.png')}}" />
                            <div class="info">
                                <h6 class="mb-0">{{__('viez.robert')}}</h6>
                                <small class="text-muted">{{__('warsaw.poland')}}</small>
                            </div>
                            <div class="rating"> <span style="margin-right:5.38px;">&#9733;</span>4.5</div>
                        </div>
                        <div class="testimonial-text">
                            {{__('testimonial_message')}}
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <img alt="client" src="{{asset('images/landing-page/clientt.png')}}" />
                            <div class="info">
                                <h6 class="mb-0">{{__('yessica.christy')}}</h6>
                                <small class="text-muted">{{__('shanxi.china')}}</small>
                            </div>
                            <div class="rating"> <span style="margin-right:5.38px;">&#9733;</span>4.5</div>
                        </div>
                        <div class="testimonial-text">
                            “{{__('user.pointof.view')}}”
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <img alt="client" src="{{asset('images/landing-page/clientt.png')}}" />
                            <div class="info">
                                <h6 class="mb-0">{{__('kim.koung.jou')}}</h6>
                                <small class="text-muted">{{__('seoul.south.korea')}}</small>
                            </div>
                            <div class="rating"> <span style="margin-right:5.38px;">&#9733;</span>4.5</div>
                        </div>
                        <div class="testimonial-text">
                            “{{__('business.currently')}}”
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <img alt="client" src="{{asset('images/landing-page/clientt.png')}}" />
                            <div class="info">
                                <h6 class="mb-0">{{__('kim.koung.jou')}}</h6>
                                <small class="text-muted">{{__('seoul.south.korea')}}</small>
                            </div>
                            <div class="rating"> <span style="margin-right:5.38px;">&#9733;</span>4.5</div>
                        </div>
                        <div class="testimonial-text">
                            “{{__('business.currently')}}”
                        </div>
                    </div>

                </div>
                <div class="testimonial-slider-arr" @if(session()->get('customerLanguage') == '8')style="direction: ltr;"@endif  @if(session()->get('customerLanguage') == '1') style="direction: rtl;" @endif>
                    <button class="prev-arrow">
                        <i class="bi bi-arrow-left"></i>
                    </button>
                    <button class="next-arrow">
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- newsletter -->
    <div class="muawadat_newsletter">
        <div class="container">
            <div class="muawadat_newsletter_wrapper">
                <h5>{{__('subscribe.to')}}<br> <span class="line"></span>{{__('our.newsletter')}}</h5>
                <div class="muawadat_newsletter_text">
                    <p>{{__('weekly.update')}} ✌️</p>
                    <form action="#">
                        <div class="email-f">
                            <img alt="email" src="{{asset('images/landing-page/email-icon.png')}}" />
                            <input type="email" placeholder="youremail123@gmail.com" />
                        </div>
                        <div class="text-right">
                            <button type="submit">{{__('Subscribe')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <div class="muawadat_footer">
        <div class="container">
            <div class="muawadat_footer_wrapper">
                <div class="muawadat_footer_links">
                    <div class="muawadat_footer_quick_links">
                        <h6>{{__('Quick Links')}}</h6>
                        <ul>
                            <li>
                                <a href="#">{{__('Home')}}</a>
                            </li>
                            <li>
                                <a href="#">{{__('about.us')}}</a>
                            </li>
                            <li>
                                <a href="#">{{__('services')}}</a>
                            </li>
                            <li>
                                <a href="#">{{__('Contact Us')}}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="muawadat_footer_quick_links">
                        <h6>{{__('Other Information')}}</h6>
                        <ul>
                            <li>
                                <a href="#">{{__('FAQ')}}</a>
                            </li>
                            <li>
                                <a href="#">{{__('Blog')}}</a>
                            </li>
                            <li>
                                <a href="#">{{__('Support')}}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="muawadat_footer_quick_links">
                        <h6>{{__('registration.forms')}}</h6>
                        <ul>
                            <li>
                                <a href="#">{{__('For Investors')}}</a>
                            </li>
                            <li>
                                <a href="#">{{__('for.businesses')}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="muawadat_footer_download">
                    <h5>{{__('Download')}} {{__('App')}}</h5>
                    <div class="muawadat_footer_download_buttons">
                        <a href="#">
                            <img alt="app store" src="{{asset('images/landing-page/appstore2.png')}}" />
                        </a>
                        <a href="#">
                            <img alt="app store" src="{{asset('images/landing-page/gplay2.png')}}" />
                        </a>
                    </div>
                </div>
            </div>
            <div class="muawadat_copyright_wrapper">
                <div class="muawadat_copyright_logo">
                    <img alt="app store" src="{{asset('images/footer_logo.png')}}" />
                </div>
                <div class="muawadat_copyright_links">
                    <ul>
                        <li>
                            <a href="#">{{__('Terms')}}</a>
                        </li>
                        <li>
                            <a href="#">{{__('Privacy')}}</a>
                        </li>
                        <li>
                            <a href="#">{{__('Cookies')}}</a>
                        </li>
                    </ul>
                </div>
                <div class="muawadat_copyright_social">
                    <ul>
                        <li>
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13"
                                    fill="none" class="">
                                    <path
                                        d="M1.73367 3.24444C2.55301 3.24444 3.21722 2.58024 3.21722 1.76089C3.21722 0.941552 2.55301 0.277344 1.73367 0.277344C0.91433 0.277344 0.250122 0.941552 0.250122 1.76089C0.250122 2.58024 0.91433 3.24444 1.73367 3.24444Z"
                                        fill="black" />
                                    <path
                                        d="M2.96984 4.23535H0.497258C0.360772 4.23535 0.25 4.34612 0.25 4.48261V11.9004C0.25 12.0368 0.360772 12.1476 0.497258 12.1476H2.96984C3.10633 12.1476 3.2171 12.0368 3.2171 11.9004V4.48261C3.2171 4.34612 3.10633 4.23535 2.96984 4.23535Z"
                                        fill="black" />
                                    <path
                                        d="M10.338 3.82375C9.28126 3.46176 7.95942 3.77973 7.16671 4.34991C7.13951 4.24359 7.04258 4.16447 6.92736 4.16447H4.45478C4.31829 4.16447 4.20752 4.27524 4.20752 4.41173V11.8295C4.20752 11.966 4.31829 12.0767 4.45478 12.0767H6.92736C7.06385 12.0767 7.17462 11.966 7.17462 11.8295V6.49858C7.57419 6.1544 8.08898 6.04462 8.51031 6.22363C8.91878 6.39622 9.15269 6.81755 9.15269 7.37882V11.8295C9.15269 11.966 9.26346 12.0767 9.39994 12.0767H11.8725C12.009 12.0767 12.1198 11.966 12.1198 11.8295V6.88085C12.0916 4.84888 11.1357 4.09672 10.338 3.82375Z"
                                        fill="black" />
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="8" height="13" viewBox="0 0 8 13"
                                    fill="none">
                                    <path
                                        d="M5.3432 2.29813H6.95158C7.09955 2.29813 7.21964 2.18496 7.21964 2.04553V0.529942C7.21964 0.390508 7.09955 0.277344 6.95158 0.277344H5.3432C3.71766 0.277344 2.3945 1.52366 2.3945 3.05592V4.82411H0.518063C0.370092 4.82411 0.25 4.93727 0.25 5.0767V6.59229C0.25 6.73173 0.370092 6.84489 0.518063 6.84489H2.3945V12.1494C2.3945 12.2889 2.5146 12.402 2.66257 12.402H4.27095C4.41892 12.402 4.53901 12.2889 4.53901 12.1494V6.84489H6.41545C6.53072 6.84489 6.63312 6.77517 6.67011 6.67211L7.20624 5.15653C7.23358 5.07974 7.21964 4.99486 7.16924 4.92868C7.11831 4.86301 7.03789 4.82411 6.95158 4.82411H4.53901V3.05592C4.53901 2.63812 4.89982 2.29813 5.3432 2.29813Z"
                                        fill="black" />
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="11" viewBox="0 0 13 11"
                                    fill="none">
                                    <path
                                        d="M12.4702 1.54202C12.389 1.45024 12.2581 1.42715 12.1507 1.48376C12.0839 1.51894 11.9583 1.56511 11.8092 1.61072C11.9973 1.35351 12.1485 1.06551 12.2153 0.806647C12.2442 0.695077 12.202 0.577461 12.1101 0.510958C12.0182 0.445005 11.8958 0.445005 11.8039 0.510958C11.6591 0.614834 10.9602 0.927011 10.5183 1.02814C9.51957 0.128431 8.35738 0.0349975 7.14924 0.76048C6.16712 1.35021 5.95338 2.54945 5.99506 3.28043C3.74709 3.05784 2.34979 1.83661 1.56324 0.825884C1.5082 0.754984 1.4195 0.717611 1.33614 0.723107C1.24851 0.729702 1.16943 0.779716 1.12454 0.857211C0.752641 1.503 0.649513 2.21694 0.827449 2.92209C0.924699 3.30681 1.09462 3.64592 1.29179 3.92073C1.19721 3.87291 1.10584 3.813 1.01981 3.74155C0.940729 3.6745 0.83012 3.66186 0.736611 3.70638C0.643635 3.752 0.584323 3.84873 0.584323 3.9548C0.584323 5.16559 1.32065 5.97351 2.00834 6.39561C1.8972 6.38187 1.78125 6.35659 1.66423 6.31977C1.56377 6.28844 1.45476 6.31977 1.3853 6.40111C1.31584 6.4819 1.29927 6.59732 1.34255 6.6957C1.72888 7.57452 2.46093 8.17909 3.36664 8.39838C2.57581 8.87599 1.51728 9.11013 0.547988 8.99526C0.422418 8.97712 0.302726 9.05901 0.263184 9.18322C0.223643 9.30744 0.275474 9.44374 0.386083 9.50749C1.85659 10.3566 3.18603 10.66 4.33486 10.66C6.00682 10.66 7.29725 10.0181 8.08273 9.48111C10.2003 8.03564 11.5201 5.44039 11.3363 3.1183C11.6756 2.86053 12.1833 2.38457 12.498 1.87289C12.5632 1.76956 12.5514 1.63326 12.4702 1.54202Z"
                                        fill="black" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.testimonial-slider').slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                arrows: true,
                prevArrow: $('.prev-arrow'),
                nextArrow: $('.next-arrow'),
                 
                dots: false,
                responsive: [
                    {
                        breakpoint: 992, // Larger first
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 768, // Smaller second
                        settings: {
                            slidesToShow: 1
                        }
                    }
                ]
            });
        });
    </script>

    <script>

        $(document).ready(function () {
            $('.menu-toggle').on('click', function () {
                $('.muawadat_header_menu').toggleClass('show');
            });
        });
    </script>
@endsection