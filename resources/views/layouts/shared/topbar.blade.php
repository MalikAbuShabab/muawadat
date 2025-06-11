@php
$languageList = \App\Models\ClientLanguage::with('language')->where('is_active', 1)->orderBy('is_primary', 'desc')->get();
$currencyList = \App\Models\ClientCurrency::with('currency')->orderBy('is_primary', 'desc')->get();

$urlImg = URL::to('/').'/assets/images/users/user-1.jpg';
$clientData = \App\Models\Client::select('id', 'logo','custom_domain','code')->with('getPreference')->where('id', '>', 0)->first();
if($clientData){
$urlImg = $clientData->logo['image_fit'].'200/80'.$clientData->logo['image_path'];
}

$is_map_search_perticular_country = getMapConfigrationPreference();
@endphp
<script>
    let is_map_search_perticular_country = '';
     is_map_search_perticular_country = '{{ $is_map_search_perticular_country }}';
</script>
<!-- Topbar Start -->
<audio id="orderAudio">
    <source src="{{ asset('assets/sounds/notification.ogg')}}" type="audio/ogg">
    <source src="{{ asset('assets/sounds/notification.mp3')}}" type="audio/mpeg">
    Your browser does not support the audio element.
</audio>
<style>
 .notification {
  text-decoration: none;
  padding: 1px 2px;
  position: relative;
  display: inline-block;
  border-radius: 2px;
}

.notification .badge {
  position: absolute;
  top: -10px;
  right: -10px;
  padding: 5px 10px;
  border-radius: 50%;
  background: rgb(189, 188, 188);
  color: white;
}

.darkgreen {
    background: #015158;
    color: #fff;
}

.darkgreen:hover {
    color: #fff;
}
</style>
<div class="navbar-custom {{(is_p2p_vendor()) ? '' : ''}}">
    <div class="d-flex align-items-center justify-content-between">
        {{-- <div class="col">
            <div class="menu_cta">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div> --}}
        <div class="col d-flex align-items-center justify-content-between justify-content-lg-end">
            <ul class="top-site-links d-flex align-items-center p-0 mb-0 mr-lg-2 mr-auto">
                <li class="AlSpinnerCustom">
                    <!-- spinner Start -->
                    <div class="nb-spinner-main">
                        <div class="nb-spinner"></div>
                    </div>
                    <!-- spinner End -->
                </li>
                <li class="mobile-toggle">
                    <button id="shortclick" class="button-menu-mobile waves-effect waves-light">
                        <i class="fe-menu"></i>
                    </button>
                </li>
                <li class="d_none">
                    <div class="logo-box">
                        <a href="{{route('client.dashboard')}}" class="logo logo-dark text-center">
                            <span class="logo-sm">
                                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="50">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="50">
                            </span>
                        </a>

                        <a href="{{route('client.dashboard')}}" class="logo logo-light text-center">
                            <span class="logo-sm">
                                <img src="{{$urlImg}}" alt="" height="30" style="padding-top: 4px;">
                            </span>
                            <span class="logo-lg">
                                <img src="{{$urlImg}}" alt="" height="50" style="padding-top: 4px;">
                            </span>
                        </a>
                    </div>
                </li>
                <!--Admin Web notifiation section -->
                @if(Auth::user()->is_superadmin )
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-toggle="dropdown">
                        <i class="fa fa-bell"></i>
                        <span class="badge badge-danger" id="notificationCount" style="display: none;" >0</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown">
                        <ul id="notificationList" class="list-group pl-0" style="width:400px !important">
                            <li class="list-group-item py-2">No new notifications</li>
                        </ul>
                    </div>
                </li>
                 <!-- END  -->
                @endif
                <!-- User Web Notification Sestion --> 
                    @if(Auth::user()->is_superadmin==0)   
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="notificationDropdownUser" role="button" data-toggle="dropdown">
                                <i class="fa fa-bell"></i>
                                <span class="badge badge-danger" id="notificationCountUser" style="display: none;" >0</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdownUser">
                                <ul id="notificationListUser" class="list-group pl-0" style="width:400px !important">
                                    <li class="list-group-item py-2">No new notifications</li>
                                </ul>
                            </div>
                        </li>
                    @endif
                <!-- Over -->
                 
                
                @if(Auth::user()->is_superadmin )
                    <li class="alToggleSwitch">
                        <label class="altoggle">
                            <input type="checkbox" class="admin_panel_theme" {{@$clientData->getPreference->theme_admin == "dark" ? 'checked' : ''}}>
                            <div class="toggle__bg">
                                <div class="toggle__sphere">
                                    <div class="toggle__sphere-bg">
                                    </div>
                                    <div class="toggle__sphere-overlay"></div>
                                </div>
                            </div>
                        </label>
                    </li>
                @endif



                <li class="m-hide"><label class="site-name m-0">{{ucFirst($clientData->custom_domain)}}</label></li>
                <li class="m-hide"><a href="{{route('userHome')}}" target="_blank"><i class="fa fa-globe" aria-hidden="true"></i><span class="align-middle">{{ __("View Website") }}</span></a></li>
            @if(App\Services\InventoryService::checkIfInventoryOn())
                <li class="m-hide" ><a href="javascript:;"id="inventoryModalShow" ><i class="fa fa-globe" aria-hidden="true"></i><span class="align-middle">{{ __("View Inventory") }}</span></a></li>
                @endif
                <!-- <li class="m-hide"><a href="#" target="_blank"><i class="fab fa-apple" aria-hidden="true"></i><span class="align-middle">iOS App</span></a></li>
                <li class="m-hide"><a href="#" target="_blank"><i class="fab fa-android" aria-hidden="true"></i><span class="align-middle">Android App</span></a></li> -->

                @if(Auth::user()->is_superadmin == 1)
                {{-- <!-- @if($clientData->getPreference->need_delivery_service  == 1 && isset($clientData->getPreference->delivery_service_key_url))
                    <li class="m-hide"><a href="{{ $clientData->getPreference->delivery_service_key_url }}" target="_blank"><i class="fa fa-globe" aria-hidden="true"></i><span class="align-middle">{{ __('Last Mile Delivery Dashboard')}}</span></a></li>
                @endif --> --}}
                @if(isset($clientData->getPreference->need_dispacher_ride) && $clientData->getPreference->need_dispacher_ride == 1 && isset($clientData->getPreference->pickup_delivery_service_key_url))
                <li class="m-hide"><a href="{{ $clientData->getPreference->pickup_delivery_service_key_url }}" target="_blank"><i class="fa fa-globe" aria-hidden="true"></i><span class="align-middle">{{ __('Pickup & Delivery Dashboard')}}</span></a></li>
                @endif
                @endif
            </ul>


            <!-- LOGO -->
            <!-- <div class="logo-box d-inline-block d-lg-none">
                @php
                    $urlImg = URL::to('/').'/assets/images/users/user-1.jpg';
                    $clientData = \App\Models\Client::select('id', 'logo','dark_logo')->where('id', '>', 0)->first();
                    $client_preference = \App\Models\ClientPreference::where(['id' => 1])->first();
                    if($clientData){
                        if($client_preference->theme_admin == 'dark'){
                            $urlImg = $clientData ? $clientData->dark_logo['image_fit'].'200/80'.$clientData->dark_logo['image_path'] : ' ';
                        }else{
                            $urlImg = $clientData ? $clientData->logo['image_fit'].'200/80'.$clientData->logo['image_path'] : ' ';
                        }
                         
                    }
                @endphp
                <a href="{{route('client.dashboard')}}" class="logo logo-dark text-center">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="50">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="20">
                    </span>
                </a>

                <a href="{{route('client.dashboard')}}" class="logo logo-light text-center">
                    <span class="logo-sm">
                        <img src="{{$urlImg}}"
                            alt="" height="30" style="padding-top: 4px;">
                    </span>
                    <span class="logo-lg">
                        <img src="{{$urlImg}}"
                            alt="" height="50" style="padding-top: 4px;">
                    </span>
                </a>
            </div> -->


            {{-- ADMIN LANGUAGE SWITCH START --}}

            @php
            $applocale_admin = 'en';
            if(session()->has('applocale_admin')){
            $applocale_admin = session()->get('applocale_admin');
            }
            @endphp

            <ul class="list-unstyled topnav-menu float-right mb-0">
                <li class="dropdown alLanguageTop">
                    <a class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        {{__('Language')}}
                        {{ $applocale_admin }}
                        <i class="mdi mdi-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        {{-- <a href="/switch/admin/language?lang=en" class="dropdown-item" langid="1">English</a>
                        <a href="/switch/admin/language?lang=es" class="dropdown-item" langid="1">Spanish</a>
                        <a href="/switch/admin/language?lang=ar" class="dropdown-item" langid="1">Arabic</a>
                        <a href="/switch/admin/language?lang=fr" class="dropdown-item" langid="1">French</a>
                        <a href="/switch/admin/language?lang=de" class="dropdown-item" langid="1">German</a> --}}

                        @foreach($languageList as $key => $listl)
                            <li>
                                <a href="/switch/admin/language?lang={{$listl->language->sort_code}}&langid={{$listl->language_id}}" class="customerLang dropdown-item {{$applocale_admin ==  $listl->language->sort_code ?  'active' : ''}}" langid="{{$listl->language_id}}">{{$listl->language->name}}</a>
                            </li>
                        @endforeach

                        <div class="dropdown-divider"></div>
                    </ul>
                </li>


                {{-- ADMIN LANGUAGE SWITCH END --}}


                <li class="dropdown d-inline-block d-lg-none">
                    <!-- <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="fe-search noti-icon"></i>
                    </a> -->

                    <div class="dropdown-menu dropdown-lg dropdown-menu-right p-0">
                        <form class="p-3">
                            <input type="text" class="form-control" placeholder="{{ __("Search") }} ..." aria-label="Recipient's username">
                        </form>
                    </div>
                </li>
                {{-- <li class="dropdown d-none d-lg-inline-block">
                    <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="fullscreen"
                        href="#">
                        <i class="fe-bell noti-icon"></i>
                    </a>
                </li>
                <li class="dropdown d-lg-inline-block">
                    <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="fullscreen"
                        href="#">
                        <i class="fe-maximize noti-icon"></i>
                    </a>
                </li>--}}

                <li class="dropdown notification-list topbar-dropdown">
                    <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">

                        <span class="pro-user-name ml-1">
                            <img style="height: 32px; width:86.48px" src="{{$urlImg}}" alt="">
                            <!-- <b class="text-capitalize">{{ auth()->user()->name }} <i class="mdi mdi-chevron-down"></i></b> -->
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown p-0">

                        <!-- <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome !</h6>
                        </div> -->

                        {{--<a href="{{route('userHome')}}" class="dropdown-item notify-item">
                            <i class="fe-globe"></i>
                            <span>{{ __("Website") }}</span>
                        </a> --}}
                        @if(Auth::user()->is_superadmin == 1)
                        <a href="{{route('client.profile')}}" class="dropdown-item notify-item">
                            <i class="fe-user"></i>
                            <span>{{ __("My Account") }}</span>
                        </a>
                        @endif
                        {{-- @can('role-add') --}}
                        {{-- @if(Auth::user()->is_superadmin )
                            <a href="{{route('roles')}}" class="dropdown-item notify-item">
                                <i class="fe-user"></i>
                                <span>{{ __("Manage Roles") }}</span>
                            </a>
                        @endif --}}
                        {{-- <a href="{{route('permissions')}}" class="dropdown-item notify-item">
                            <i class="fe-user"></i>
                            <span>{{ __("All Permissions") }}</span>
                        </a> --}}
                        {{-- @endcan --}}
                        <a href="javascript:void(0)" class="dropdown-item notify-item" data-toggle="modal" data-target="#change_password">
                            <i class="fe-user"></i>
                            <span>{{ __("Change Password") }}</span>
                        </a>

                        <a class="dropdown-item notify-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <i class="fe-log-out"></i> <span>{{ __("Logout") }}</span>
                        </a>

                        <form id="logout-form" action="{{route('client.logout')}}" method="POST">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="change_password" tabindex="-1" aria-labelledby="change_passwordLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <form id="change_password_form" method="post" action="{{route('cl.password.update')}}">
                    @csrf

                    <h4 class="header-title">{{ __("Change Password") }}</h4>
                    <p class="sub-header">
                        {{-- <code>Organization details</code>/Change Password. --}}
                    </p>
                    <div class="pwd-msg"></div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group mb-2">
                                <label for="old_password">{{ __("Old Password") }}</label>
                                <div class="input-group input-group-merge ">
                                    <input class="form-control " name="old_password" type="password" required="" id="old_password" placeholder={{ __("Enter your old password") }}>
                                    <div class="input-group-append" data-password="false">
                                        <div class="input-group-text">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($errors->has('old_password'))
                            <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('old_password') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group mb-2">
                                <label for="password">{{ __("New Password") }}</label>
                                <div class="input-group input-group-merge ">
                                    <input class="form-control " name="password" type="password" required="" id="password" placeholder={{__("Enter your password")}}>
                                    <div class="input-group-append" data-password="false">
                                        <div class="input-group-text">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($errors->has('password'))
                            <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>

                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group mb-2">
                                <label for="confirm_password">{{ __("Confirm Password") }}</label>
                                <div class="input-group input-group-merge ">
                                    <input class="form-control " name="password_confirmation" type="password" required="" id="confirm_password" placeholder={{ __("Enter your confirm password") }}>
                                    <div class="input-group-append" data-password="false">
                                        <div class="input-group-text">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($errors->has('password_confirmation'))
                            <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-group mb-0 text-cente2">
                                <button class="btn btn-info btn-block w-100" type="submit"> {{ __("Update") }} </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>

    function fetchNotifications() {
        fetch('/client/admin/notifications/unread')
            .then(response => response.json())
            .then(data => {
                let notificationList = $("#notificationList");
              
                let notificationCount = document.getElementById("notificationCount");

                if (data.length > 0) {

                notificationList.empty();
                notificationCount.textContent = data.length > 0 ? data.length : "0";
               
                if (notificationList) {
                    if (data.length === 0) {
                        notificationList.append('<li class="list-group-item text-center py-2">No new notifications</li>');
                    } else {
                        data.forEach(notification => {
                            let timeAgo = timeSince(new Date(notification.created_at)); // Convert to "5 minutes ago"
                            let dummy_image = "{{ asset('assets/images/dummy_user.png') }}";
                            let userImage = notification.data.user_image ? notification.data.user_image: dummy_image;
                            let redirectUrl = "#";
                            let notificationMessage = "";
                            // Check notification type
                            if (notification.data.notification_type === "new_post") {
                                redirectUrl = notification.data.post_url; // Redirect to the post
                                notificationMessage = `📝 New Post: <strong>${notification.data.post_title}</strong>`;
                            } 
                            else if (notification.data.notification_type === "new_user") {
                                redirectUrl = "{{ url('/client/customer/edit') }}/" + notification.data.user_id; // Redirect to user profile
                                notificationMessage = `👤 New User: <strong>${notification.data.message}</strong>`;
                            }
                            let notificationItem = `
                        <li class="list-group-item d-flex align-items-center p-2">
                            <img src="${userImage}" class="rounded-circle" width="40" height="40" alt="User">
                            <div class="ml-3">
                                <a href="${redirectUrl}" class="notification-link">
                                    <p class="mb-0">${notificationMessage}</p>
                                </a>
                                <small class="text-muted"><i class="far fa-clock mr-1" style="font-size: 18px; color: #6c757d;"></i>${timeAgo}</small>
                            </div>
                            <button class="btn darkgreen rounded ml-auto" onclick="markAsRead('${notification.id}')">
                                Mark As Read
                            </button>
                        </li>
                    `;
                    notificationList.append(notificationItem);
                        });
                    }
                } else {
                    console.error("Element #notificationList not found!");
                }
        });
    }

    function fetchNotificationsUser() {
       fetch('/client/user/notifications/unread')
           .then(response => response.json())
           .then(data => {
               let notificationListUser = $("#notificationListUser");
             
               let notificationCountUser = document.getElementById("notificationCountUser");
                

               if (data.length > 0) {
                    notificationCountUser.style.display = "flex"; // Show badge
                    notificationCountUser.textContent = data.length;
                } else {
                    notificationCountUser.style.display = "none"; // Hide badge
                    notificationCountUser.textContent = "0";
                }
               notificationListUser.empty();
               notificationCountUser.textContent = data.length > 0 ? data.length : "0";
              
               if (notificationListUser) {
                   if (data.length === 0) {
                    notificationListUser.append('<li class="list-group-item text-center py-2">No new notifications</li>');
                   } else {
                       data.forEach(notification => {
                           let timeAgo = timeSince(new Date(notification.created_at)); // Convert to "5 minutes ago"
                           let dummy_image = "{{ asset('assets/images/dummy_user.png') }}";
                           
                        //    let userImage = notification.data.user_image ? notification.data.user_image: dummy_image;
                           var redirectUrl = "#";
                           var notificationMessage = "";
                           // Check notification type
                           if (notification.data.notification_type === "bid_status") {
                                 
                                //  redirectUrl = notification.data.post_url; // Redirect to the post
                                var redirectUrl = "{{ route('p2p.bid.list') }}";
                                let bidStatus = notification.data.bid_status.toLowerCase(); // Convert to lowercase for consistency
                                let notificationColor = bidStatus === 'rejected' ? 'red' : 'green';
                                
                            //    notificationMessage = `📝 Bid ${notification.data.bid_status}: <strong>${notification.data.product_name}</strong>`;
                                    var notificationMessage = `
                                    <div style="color: ${notificationColor}; font-weight: bold;">
                                        📝 Bid ${notification.data.bid_status}: <strong>${notification.data.product_name}</strong>
                                    </div>`;
                                     
                            } 
                           
                            //    else if (notification.data.notification_type === "new_user") {
                            //        redirectUrl = "{{ url('/client/customer/edit') }}/" + notification.data.user_id; // Redirect to user profile
                            //        notificationMessage = `👤 New User: <strong>${notification.data.message}</strong>`;
                            //    }
                           let notificationItemUser = `
                       <li class="list-group-item d-flex align-items-center p-2">
                            
                           <div class="ml-3">
                               <a href="${redirectUrl}" class="notification-link">
                                   <p class="mb-0">${notificationMessage}</p>
                               </a>
                               <small class="text-muted"><i class="far fa-clock mr-1" style="font-size: 18px; color: #6c757d;"></i>${timeAgo}</small>
                           </div>
                           <button class="btn darkgreen rounded ml-auto" onclick="markAsRead('${notification.id}')">
                               Mark As Read
                           </button>
                       </li>
                   `;
                   notificationListUser.append(notificationItemUser);
                       });
                   }
               } else {
                   console.error("Element #notificationList not found!");
               }
       });
   }

    

    fetchNotifications();
    setInterval(fetchNotifications, 10000); // Refresh every 10 seconds

    fetchNotificationsUser();
    setInterval(fetchNotificationsUser, 10000); // Refresh every 10 seconds

    function timeSince(date) {
        let seconds = Math.floor((new Date() - date) / 1000);
        let intervals = [
            { label: "year", seconds: 31536000 },
            { label: "month", seconds: 2592000 },
            { label: "week", seconds: 604800 },
            { label: "day", seconds: 86400 },
            { label: "hour", seconds: 3600 },
            { label: "minute", seconds: 60 }
        ];

        for (let i = 0; i < intervals.length; i++) {
            let interval = Math.floor(seconds / intervals[i].seconds);
            if (interval >= 1) {
                return `${interval} ${intervals[i].label}${interval > 1 ? "s" : ""} ago`;
            }
        }
        return "Just now";
    }


    function markAsRead(id) {
        fetch(`/client/admin/notifications/read/${id}`, {
            method: "POST",
            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
        }).then(() => fetchNotifications());
    }

    function toggleNotifications() {
        let dropdown = document.getElementById("notificationList");
        dropdown.style.display = dropdown.style.display === "none" ? "block" : "none";
    }

     
</script>


