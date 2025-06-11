<?php 
use App\Models\PaymentOption;


?>

@php
$urlImg = URL::to('/').'/assets/images/users/user-1.jpg';
$clientData = \App\Models\Client::select('id', 'logo','socket_url')->first();
$azulExist =  PaymentOption::where('code', 'azul')->where('status', 1)->first();
$getAdditionalPreference = getAdditionalPreference(['is_gift_card','is_token_currency_enable', 'is_rental_weekly_monthly_price','product_measurment']);
@endphp
@switch($client_preference_detail->business_type)
    @case('taxi')
        <?php $ordertitle = 'Rides'; ?>
        <?php $hidereturn = 1; ?>
        @break
    @default
    <?php $ordertitle = 'Orders';  ?>
@endswitch
<div class="dashboard-left">
    <div class="collection-mobile-back">
        <span class="filter-back d-lg-none d-inline-block">
            <i class="fa fa-angle-left" aria-hidden="true"></i> back
        </span>
    </div>
    <div class="block-content">
        <ul>
            <li class="{{ (request()->is('user/profile')) ? 'active' : '' }}"><a href="{{route('user.profile')}}">{{ __('Profile') }}</a></li>
            <li class="{{ (request()->is('user/wallet')) ? 'active' : '' }}"><a href="{{route('user.wallet')}}">{{ $getAdditionalPreference['is_token_currency_enable'] ? __('My Wallet/Token') : __('Transaction Report') }}</a></li>
            <li class="{{ (request()->is('user/two-factor-auth')) ? 'active' : '' }}"><a href="{{route('user.two-factor-auth')}}">{{ __('Two-factor authentication') }}</a></li>
            <li class="{{ (request()->is('user/identity-proof')) ? 'active' : '' }}"><a href="{{route('user.identity-proof')}}">{{ __('Identity Verfication') }}</a></li>
            <li class="{{ (request()->is('user/money-verification')) ? 'active' : '' }}"><a href="{{route('user.money-verification')}}">{{ __('Money Verfication') }}</a></li>
            <li class="{{ (request()->is('/user/social-login-links')) ? 'active' : '' }}"><a href="{{route('user.social-login-links')}}">{{ __('Social Media') }}</a></li>
            <li class="{{ (request()->is('user/addressBook')) ? 'active' : '' }}"><a href="{{route('user.addressBook')}}">
                {{ __('Address') }}
            </a></li>
            <li class="last {{ (request()->is('page/terms-conditions')) ? 'active' : '' }}"><a href="{{ url('page/terms-conditions') }}">{{ __('Terms & Conditions') }}</a></li>
            <li class="last {{ (request()->is('page/privacy-policy')) ? 'active' : '' }}"><a href="{{ url('page/privacy-policy') }}">{{ __('Privacy Policy') }}</a></li>
            <li class="last {{ (request()->is('page/about-us')) ? 'active' : '' }}"><a href="{{ url('page/about-us') }}">{{ __('about.us') }}</a></li>
            <li class="last {{ (request()->is('contact-us')) ? 'active' : '' }}"><a href="{{route('contact-us')}}">{{ __('Contact Us') }}</a></li>
            
            {{-- <li class="last {{ (request()->is('user/logout')) ? 'active' : '' }}"><a href="{{route('user.logout')}}">{{ __('Log Out') }}</a></li> --}}
            @if($clientData->socket_url)
                {{-- <li  class="{{ (request()->is('user/chat/userVendor') || request()->is('user/chat/userAgent') ) ? 'active' : '' }}" >
                    <a href="#chat" data-toggle="collapse">
                    <span class="mdi-message"></span>
                        <span> {{ __('Chat') }} </span>
                    </a>
                    <div class="collapse" id="chat">
                        <ul class="nav-second-level">
                            <li  class="{{ (request()->is('user/chat/userVendor')) ? 'active' : '' }}">
                                <a href="{{route('userChat.UservendorChat')}}">{{ __('Vendor Chat') }}</a>
                            </li>
                            @if(p2p_module_status())
                            
                            <li  class="{{ (request()->is('user/chat/userToUser')) ? 'active' : '' }}">
                                <a href="{{route('userChat.UserToUserChat')}}">{{ __('User Chat') }}</a>
                            </li>
                            @endif
                            <li  class="{{ (request()->is('user/chat/userAgent')) ? 'active' : '' }}">
                                <a href="{{route('userChat.UserAgentChat')}}">{{ __('Driver Chat') }}</a>
                            </li>
 
                            <li>
                                <a href="{{route('report.productperformance')}}">{{ __("Product Performance Report") }}</a>
                            </li>
                        </ul>
                    </div>
                </li> --}}
            @endif
            {{-- <li class="{{ (request()->is('user/addressBook')) ? 'active' : '' }}"><a href="{{route('user.addressBook')}}">
                {{ __('Address Book') }}
            </a></li> --}}
            @if(!empty($azulExist))
            
            {{-- <li class="{{ (request()->is('payment/get-user-cards')) ? 'active' : '' }}"><a href="{{route('payment.user.cards')}}">
                {{ __('Saved Cards') }}
            </a></li> --}}
            @endif
            
            {{-- <li class="{{ (request()->is('user/orders*')) ? 'active' : '' }}"><a href="{{route('user.orders')}}">{{ __('My '.getNomenclatureName($ordertitle, true) )}}</a></li>
            @if(@$getAdditionalPreference['product_measurment'] == 1)
                <li class="active"><a href="{{route('get.measurementKeys')}}">
                    {{ __('My Measurement') }}
                </a></li>
            @endif
            @if(@$getAdditionalPreference['is_rental_weekly_monthly_price'] == 1)
                <li class="{{ (request()->is('user/lander-orders*')) ? 'active' : '' }}"><a href="{{route('user.lander-orders')}}">{{ __('My Order As Lender')}}</a></li>
                <li class="{{ (request()->is('user/borrower-orders*')) ? 'active' : '' }}"><a href="{{route('user.borrower-orders')}}">{{ __('My Order As Borrower')}}</a></li>
            @endif --}}

            <li class="{{ (request()->is('user/wishlists')) ? 'active' : '' }}"><a href="{{route('user.wishlists')}}">{{ __(getNomenclatureName('Wishlist', true) )}}</a></li>
            {{-- <li class="{{ (request()->is('user/loyalty')) ? 'active' : '' }}"><a href="{{route('user.loyalty')}}">{{ __('My Loyalty') }}</a></li> --}}
            
            {{-- <li class="{{ (request()->is('user/wallet')) ? 'active' : '' }}"><a href="{{route('user.wallet')}}">{{ $getAdditionalPreference['is_token_currency_enable'] ? __('My Wallet/Token') : __('My Wallet') }}</a></li> --}}

            @if (@getAdditionalPreference(['is_bid_enable'])['is_bid_enable'] && getAdditionalPreference(['is_bid_enable'])['is_bid_enable']==1)
                <li class="{{ (request()->is('user/bidRequest') || request()->is('bid/Details') ) ? 'active' : '' }}"><a href="{{route('user.bidRequest')}}">{{ __('Bid Request') }}</a></li>
            @endif
          
            @if( (isset($client_preference_detail->subscription_mode)) && ($client_preference_detail->subscription_mode == 1) )
                <li class="{{ (request()->is('user/subscription*')) ? 'active' : '' }}"><a href="{{route('user.subscription.plans')}}">{{ __('My Subscriptions') }}</a></li>
            @endif
            {{-- <li class="last {{ (request()->is('user/notification')) ? 'active' : '' }}"><a href="{{route('user.notification')}}">{{ __('Notification') }}</a></li> --}}
            @if(p2p_module_status())
                <li class="last {{ (request()->is('user/my-ads')) ? 'active' : '' }}"><a href="{{route('user.productList')}}">{{__('My Ads')}}</a></li>
            @endif
            @if(@getAdditionalPreference(['is_enable_allergic_items'])['is_enable_allergic_items'])
                <li class="last {{ (request()->is('user/allergic-items')) ? 'active' : '' }}"><a href="{{route('list.allergicItems')}}">{{__('Allergic Items')}}</a></li>
            @endif
            @if(is_p2p_vendor())
            <li>
                <a href="#milestone" data-toggle="collapse">
                   <span class="mdi-message"></span>
                   <span> {{ __('Milestones') }} </span>
                </a>
                <div class="collapse" id="milestone">
                    <ul class="nav-second-level">
                        <li  class="{{ (request()->is('p2p/buyer-milestone-list')) ? 'active' : '' }}">
                            <a href="{{route('buyer.list-milestone')}}">{{ __('As Buyer') }}</a>
                        </li>
                          <li  class="{{ (request()->is('marketplace/milestone-list')) ? 'active' : '' }}">
                            <a href="{{route('marketplace.list-milestone')}}">{{ __('As Seller') }}</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="#contracts" data-toggle="collapse">
                   <span class="mdi-message"></span>
                   <span> {{ __('My Contracts') }} </span>
                </a>
                <div class="collapse" id="contracts">
                    <ul class="nav-second-level">
                        <li  class="{{ (request()->is('p2p/view-buyer-contracts')) ? 'active' : '' }}">
                            <a href="{{route('p2p.view-buyer-contracts')}}">{{ __('As Buyer') }}</a>
                        </li>
                          <li  class="{{ (request()->is('marketplace/view-contracts')) ? 'active' : '' }}">
                            <a href="{{route('marketpalce.view-contracts')}}">{{ __('As Seller') }}</a>
                        </li>
                    </ul>
                </div>
            </li>
            
            @endif
            @if(is_p2p_vendor())
            {{-- <li class=""><a href="{{route('posts.index', ['fullPage'=>1])}}">{{ __('Add Post') }}</a></li> --}}
            <li class=""><a href="#" onclick="checkDocumentStatus(event)" 
                data-verified-front="@if(auth()->check()){{auth()->user()->front_identity_doc_verified}}@endif"
                data-verified-back="@if(auth()->check()){{auth()->user()->back_identity_doc_verified}}@endif"
                data-is-superadmin="@if(auth()->check()){{auth()->user()->is_superadmin}}@endif"
                data-redirect="{{ route('posts.index', ['fullPage' => 1]) }}"
                >{{ __('Add Post') }}</a></li>
            
            <li>
                <a href="#support" data-toggle="collapse">
                   <span class="mdi-message"></span>
                   <span> {{ __('Support') }} </span>
                </a>
                <div class="collapse" id="support">
                    <ul class="nav-second-level">
                        <li  class="{{ (request()->is('customer/support/form')) ? 'active' : '' }}">
                            <a href="{{route('customer.support.form')}}">{{ __('Raise Ticket') }}</a>
                        </li>
                          <li  class="{{ (request()->is('customer/support/tickes')) ? 'active' : '' }}">
                            <a href="{{route('customer.support.tickets')}}">{{ __('Support Tickets') }}</a>
                        </li>
                    </ul>
                </div>
            </li>

            @endif
            @if(@getAdditionalPreference(['is_gift_card'])['is_gift_card']==1)
                <li class="{{ (request()->is('user/giftCard')) ? 'active' : '' }}"><a href="{{route('giftCard.index')}}">{{ __('Gift Card') }}</a></li>
            @endif
            <li class="{{ (request()->is('user/changePassword')) ? 'active' : '' }}"><a href="{{route('user.changePassword')}}">{{ __('Change Password') }}</a></li>
            <li class="last {{ (request()->is('user/logout')) ? 'active' : '' }}"><a href="{{route('user.logout')}}">{{ __('Log Out') }}</a></li>
            {{-- <li class="last {{ (request()->is('user/address')) ? 'active' : '' }}"><a href="#">{{ __('Address') }}</a></li> --}}
             
            {{-- <li class="last {{ (request()->is('user/refer-earn')) ? 'active' : '' }}"><a href="{{route('refer-earn.index')}}">{{ __('Refer & Earn') }}</a></li> --}}
        </ul>
    </div>
</div>
<script>
    function checkDocumentStatus(e) {
        e.preventDefault();
        const link = e.currentTarget;
        const isVerifiedFrontDoc = link.getAttribute('data-verified-front') === '1';
        const isVerifiedBackDoc  = link.getAttribute('data-verified-back') === '1';
        const isNotSuperAdmin    = link.getAttribute('data-is-superadmin') === '0'; 
        const isSuperAdmin    = link.getAttribute('data-is-superadmin') === '1'; // clearer name
 
        const redirectUrl = link.getAttribute('data-redirect');
        if (isSuperAdmin) {
            window.location.href = redirectUrl;
            return false;
        }
        if (isVerifiedFrontDoc && isVerifiedBackDoc && isNotSuperAdmin) {
            window.location.href = redirectUrl;
        } else {
            Swal.fire({
                title: 'Identity Verification Required',
                text: 'Please upload your documents before adding a listing.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Go to Verification',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#3085d6',
            }).then((result) => {
                if (result.value) {
                    window.location.href = '{{ route("user.identity-proof") }}'; // adjust this route
                }
            });
        }
    }
</script>
