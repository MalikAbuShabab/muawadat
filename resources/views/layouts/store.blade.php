@php
$set_template = \App\Models\WebStylingOption::where('web_styling_id',1)->where('is_selected',1)->first();
$set_common_business_type = $client_preference_detail->business_type??'';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  @include('layouts.store.title-meta')
  @include('layouts.store.head-content', ["demo" => "creative"])
</head>
@yield('customcss')

@yield('cssnew')
@php

$dark_mode = '';
if($client_preference_detail->show_dark_mode == 1){
  $dark_mode = 'dark';
}else if($client_preference_detail->show_dark_mode == 2){
  if(session()->has('config_theme')){
    $dark_mode = session()->get('config_theme');
  }
}
$analytics = getAdditionalPreference(['gtag_id', 'fpixel_id','is_service_product_price_from_dispatch','is_service_price_selection']);
$getOnDemandPricingRule = getOnDemandPricingRule(Session::get('vendorType'),'',$analytics);
//pr($getOnDemandPricingRule);
$is_ondemand_multi_pricing = $getOnDemandPricingRule['is_ondemand_multi_pricing'];

//pr($is_ondemand_multi_pricing);
$body_class = "al_body_template_one";
$left_sidebar = 'layouts.store/left-sidebar-template-one';
$footer_content = 'layouts.store/footer-content-template-one';
if(isset($set_template))
{
  $selectedTemplate = $set_template->template_id ?? 1;
  

  switch($selectedTemplate) {
    case 1:
      $body_class = "al_body_template_one";
      $left_sidebar = 'layouts.store/left-sidebar-template-one';
      $footer_content = 'layouts.store/footer-content-template-one';
      break;
    case 2:
    $body_class = "al_body_template_two";
    $left_sidebar = 'layouts.store/left-sidebar-template-two';
    $footer_content = 'layouts.store/footer-content-template-two';
      break;
    case 3:
    $body_class = "al_body_template_three";
    $left_sidebar = 'layouts.store/left-sidebar-template-three';
    $footer_content = 'layouts.store/footer-content-template-three';
      break;
    case 4:
    $body_class = "al_body_template_four";
    $left_sidebar = 'layouts.store/left-sidebar-template-four';
    $footer_content = 'layouts.store/footer-content-template-four';
      break;
    case 5:
    $body_class = "al_body_template_five";
    $left_sidebar = 'layouts.store/left-sidebar-template-five';
    $footer_content = 'layouts.store/footer-content-template-five';
      break;
    case 6:
    $body_class = "al_body_template_six";
      if(Route::currentRouteName() == "customer.login" || Route::currentRouteName() == "customer.register"){
        $body_class =  $body_class. " login";
      }
      $left_sidebar = 'layouts.store/left-sidebar-template-six';
      $footer_content = 'layouts.store/footer-content-template-six';
      break;
    case 7:

      break;
    case 8:
    $body_class = "al_body_template_eight p2p-module";
    $left_sidebar = 'layouts.store/left-sidebar-template-eight';
    $footer_content = 'layouts.store/footer-content-template-eight';
      break;
    case 9:
    $body_class = "al_body_template_nine p2p-module";
    $left_sidebar = 'layouts.store/left-sidebar-template-one';
    $footer_content = 'layouts.store/footer-content-template-one';
      break;

    default:
      $body_class = "al_body_template_one";
      $left_sidebar = 'layouts.store/left-sidebar-template-nine';
      $footer_content = 'layouts.store/footer-content-template-one';
  }

}

$p2pClass = '';
$type = session()->get('vendorType');
if($type == 'p2p'){
  $p2pClass = "p2p_module_enable";
}
@endphp
@include('layouts.shared.variables-constant-js')
@include('layouts.language')
@yield('headerJs')
<script>
	var featured_products_length = '';
</script>

<body  class="{{$dark_mode}}{{ Request::is('category/cabservice') ? 'cab-booking-body' : '' }} {{$body_class}} {{$p2pClass}}" dir="{{session()->get('locale') == 'ar' ? 'rtl' : ''}}">
<article id="page-container">
  <article id="content-wrap">
  @if(isset($set_template)  && ($set_template->template_id == 3 || $set_template->template_id == 6 || $set_template->template_id == 1 ))
    <article class="al_new_wrapper_design">
  @endif
    <header>
     <div class="custom_loader d-none">
      <div class='uil-ring-css' style='transform:scale(0.79);'>
        <div></div>
      </div>
    </div>

      <div class="mobile-fix-option_al"></div>
      @include($left_sidebar)
      {{-- @if(isset($set_template)  && $set_template->template_id == 1)
      @include('layouts.store/left-sidebar-template-one')
      @elseif(isset($set_template)  && $set_template->template_id == 2)
      @include('layouts.store/left-sidebar-template-two')
      @elseif(isset($set_template)  && $set_template->template_id == 3)
      @include('layouts.store/left-sidebar-template-three')
      @elseif(isset($set_template)  && $set_template->template_id == 4)
      @include('layouts.store/left-sidebar-template-four')
      @elseif(isset($set_template)  && $set_template->template_id == 5)
      @include('layouts.store/left-sidebar-template-five')
      @elseif(isset($set_template)  && $set_template->template_id == 6)
      @include('layouts.store/left-sidebar-template-six')
      @elseif(isset($set_template)  && $set_template->template_id == 8)
      @include('layouts.store/left-sidebar-template-eight')
      @elseif(isset($set_template)  && $set_template->template_id == 9)
      @include('layouts.store/left-sidebar-template-nine')
      @else
      @include('layouts.store/left-sidebar-template-one')
      @endif --}}
    </header>

    @if(isset($set_template)  && $set_template->template_id == 4)
    @include('frontend.template_four.layouts.vendor_type')
    @endif

    @yield('content')
    @include($footer_content)
    {{-- @if(isset($set_template)  && $set_template->template_id == 1)
    @include('layouts.store/footer-content-template-one')
    @elseif(isset($set_template)  && $set_template->template_id == 2)
    @include('layouts.store/footer-content-template-two')
    @elseif(isset($set_template)  && $set_template->template_id == 3)
    @include('layouts.store/footer-content-template-three')
    @elseif(isset($set_template)  && $set_template->template_id == 4)
    @include('layouts.store/footer-content-template-four')
    @elseif(isset($set_template)  && $set_template->template_id == 5)
    @include('layouts.store/footer-content-template-five')
    @elseif(isset($set_template)  && $set_template->template_id == 6)
    @include('layouts.store/footer-content-template-six')
    @elseif(isset($set_template)  && $set_template->template_id == 8)
    @include('layouts.store/footer-content-template-eight')
    @elseif(isset($set_template)  && $set_template->template_id == 9)
    @include('layouts.store/footer-content-template-nine')
    @else
    @include('layouts.store/footer-content-template-one')
    @endif --}}

    @include('layouts.store/footer')
    @if(@getAdditionalPreference(['enable_pwa'])['enable_pwa'] == 1)

    <script src="{{ asset('/sw.js') }}"></script>
<script>

    // login error print issue (service worker)
  @if (Route::current()->getName() == 'customer.login')
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.getRegistrations().then(function(registrations) {
            for(let registration of registrations) {
                registration.unregister();
            }
        }).then(function() {
            // console.log('Service worker was stopped.');
        });
        if (navigator.serviceWorker.controller) {
            location.reload();
        }
    }
  @else
    if ("serviceWorker" in navigator) {
        // Register a service worker hosted at the root of the
        // site using the default scope.
        navigator.serviceWorker.register("/sw.js").then(
        (registration) => {
            console.log("Service worker registration succeeded:", registration);
        },
        (error) => {
            console.error(`Service worker registration failed: ${error}`);
        },
        );
    } else {
        console.error("Service workers are not supported.");
    }
  @endif
</script>
@endif
<style>
  

  *.hidden {
  display: none !important;
}

div.custom_loader{
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(16, 16, 16, 0.5);
}

@-webkit-keyframes uil-ring-anim {
  0% {
    -ms-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -webkit-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -ms-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -webkit-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-webkit-keyframes uil-ring-anim {
  0% {
    -ms-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -webkit-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -ms-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -webkit-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-moz-keyframes uil-ring-anim {
  0% {
    -ms-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -webkit-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -ms-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -webkit-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-ms-keyframes uil-ring-anim {
  0% {
    -ms-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -webkit-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -ms-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -webkit-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-moz-keyframes uil-ring-anim {
  0% {
    -ms-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -webkit-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -ms-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -webkit-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-webkit-keyframes uil-ring-anim {
  0% {
    -ms-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -webkit-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -ms-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -webkit-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-o-keyframes uil-ring-anim {
  0% {
    -ms-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -webkit-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -ms-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -webkit-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes uil-ring-anim {
  0% {
    -ms-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -webkit-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -ms-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -webkit-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
.uil-ring-css {
  margin: auto;
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  width: 200px;
  height: 200px;
}
.uil-ring-css > div {
  position: absolute;
  display: block;
  width: 160px;
  height: 160px;
  top: 20px;
  left: 20px;
  border-radius: 80px;
  box-shadow: 0 6px 0 0 #ffffff;
  -ms-animation: uil-ring-anim 1s linear infinite;
  -moz-animation: uil-ring-anim 1s linear infinite;
  -webkit-animation: uil-ring-anim 1s linear infinite;
  -o-animation: uil-ring-anim 1s linear infinite;
  animation: uil-ring-anim 1s linear infinite;
}


</style>
</body>

</html>
