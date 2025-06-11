@extends('layouts.vertical', ['demo' => 'creative', 'title' => getNomenclatureName('vendors', true)])
@section('css')
<link href="{{asset('assets/libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/dropify/dropify.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css" rel="stylesheet" />

<link rel="stylesheet" href="{{asset('assets/css/intlTelInput.css')}}">
<style type="text/css">
@media(min-width: 1440px){.content{min-height: calc(100vh - 100px);}.dataTables_scrollBody {height: calc(100vh - 500px);}}
.dd-list .dd3-item {list-style: none;}
div.dataTables_wrapper div.dataTables_filter input {width: 180px;}
</style>
<style type="text/css">
    .pac-container,.pac-container .pac-item{z-index:99999!important}.fc-v-event{border-color:#43bee1;background-color:#43bee1}.dd-list .dd3-content{position:relative}span.inner-div{top:50%;-webkit-transform:translateY(-50%);-moz-transform:translateY(-50%);transform:translateY(-50%)}.button{position:relative;padding:8px 16px;background:#009579;border:none;outline:0;border-radius:50px;cursor:pointer}.button:active{background:#007a63}.button__text{font:bold 20px Quicksand,san-serif;color:#fff;transition:all .2s}.button--loading .button__text{visibility:hidden;opacity:0}.button--loading::after{content:"";position:absolute;width:16px;height:16px;top:0;left:0;right:0;bottom:0;margin:auto;border:4px solid transparent;border-top-color:#fff;border-radius:50%;animation:button-loading-spinner 1s ease infinite}@keyframes button-loading-spinner{from{transform:rotate(0turn)}to{transform:rotate(1turn)}}
</style>

<style>
    /* Dark Green Background for Success Toastr */
    .toast-success {
        background-color: #0B6623 !important; /* Dark Green */
        color: white !important;
    }

    /* Customize Toastr Text */
    .toast-message {
        font-size: 16px;
        font-weight: bold;
    }

    /* Toastr Close Button Color */
    .toast-success .toast-close-button {
        color: white !important;
    }

    select.status-dropdown {
        background: #015158;
        border-radius: 5px;
        padding: 5px;
        color: #fff;
    }
   
    div#bidList_filter {
        margin-right: 20px !important;
    }

    div.dt-buttons {
        float: right !important;
    }

    .sidebar {
    position: fixed;
    top: 0;
    right: -400px;
    width: 400px;
    height: 100%;
    background: #fff;
    box-shadow: -2px 0 5px rgba(0, 0, 0, 0.2);
    overflow-y: auto;
    z-index: 1050;
    transition: right 0.3s ease-in-out;
    padding: 20px;
}

.sidebar.open {
    right: 0;
}

.close-btn {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 24px;
    background: none;
    border: none;
    cursor: pointer;
}

.sidebar {
    position: fixed;
    top: 0;
    right: -400px;
    width: 400px;
    height: 100%;
    background: #fff;
    box-shadow: -2px 0 5px rgba(0, 0, 0, 0.2);
    overflow-y: auto;
    z-index: 1050;
    transition: right 0.3s ease-in-out;
    padding: 20px;
}

.sidebar.show {
    right: 0;
}

.close-btn {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 24px;
    background: none;
    border: none;
    cursor: pointer;
}
    
</style>


@endsection
@section('content')

<div class="container-fluid vendor-page">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="page-title-box">
                @php
                    $vendors = getNomenclatureName('vendors', true);
                    $newvendors = ($vendors === "vendors") ? __('Bid List') : $vendors ;
                    $ordersNom = getNomenclatureName('Orders', true);
                    $ordersNom = ($ordersNom=="Orders")?__('Orders'):__($ordersNom);
                    $productsNom = getNomenclatureName('Products', true);
                    $productsNom = ($productsNom=="Products")?__('Companies'):__($productsNom);
                    $OpenNom = getNomenclatureName('Open', true);
                    $OpenNom = ($OpenNom=="Open")?__('Open'):__($OpenNom);
                @endphp
                @php
                    $getAdditionalPreference = getAdditionalPreference(['is_gst_required_for_vendor_registration', 'is_baking_details_required_for_vendor_registration', 'is_advance_details_required_for_vendor_registration', 'is_vendor_category_required_for_vendor_registration', 'is_seller_module', 'gofrugal_enable_status']);
                @endphp

                <h4 class="page-title">{{ $newvendors }}</h4>
            </div>
        </div>


        {{-- @if(isset($client_preference_detail) && $client_preference_detail->single_vendor == 1)
            @if($total_vendor_count == 0)
            <div class="col-sm-6 text-sm-right">
                <button class="btn btn-info waves-effect waves-light text-sm-right openAddModal" userId="0"><i class="mdi mdi-plus-circle mr-1"></i> {{ __('Add') }}
                </button>
            </div>
            @endif
        @else
            @if(auth()->user()->can('vendor-add') || auth()->user()->is_superadmin)
            <div class="col-sm-6 text-sm-right">
                <button class="btn btn-info waves-effect waves-light text-sm-right openImportModal" userId="0"><i class="mdi mdi-plus-circle mr-1"></i> {{ __('Import') }}
                </button>
                <button class="btn btn-info waves-effect waves-light text-sm-right openAddModal" userId="0"><i class="mdi mdi-plus-circle mr-1"></i> {{ __('Add') }}
                </button>
            </div>
            @endif
        @endif --}}

    </div>
    <div class="row">
        <div class="col-12">

            <div class="card widget-inline">
                <div class="card-body p-2">
                    <div class="row">
                        <div class="col-6 col-md-3 mb-3 mb-md-0">
                            <div class="text-center">
                                <h3>
                                    <i class="mdi mdi-storefront text-primary mdi-24px"></i>
                                    <span data-plugin="counterup" id="total_earnings_by_vendors">6</span>
                                    {{-- <span data-plugin="counterup" id="total_earnings_by_vendors">{{$active_vendor_count}}</span> --}}
                                </h3>
                                {{-- <p class="text-muted font-15 mb-0">{{ __('Total') }} {{ $newvendors }}</p> --}}
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-3 mb-md-0">
                            <div class="text-center">
                                <h3>
                                    <i class="fas fa-money-check-alt text-primary"></i>
                                    <span data-plugin="counterup" id="total_cash_to_collected">5</span>
                                    {{-- <span data-plugin="counterup" id="total_cash_to_collected">{{$vendors_product_count}}</span> --}}
                                     
                                </h3>
                                {{-- <p class="text-muted font-15 mb-0">{{ __('Total Active Bids'.$productsNom) }}</p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
        <!-- P2P BID -->
        <table id="bidList" class="display">
        <thead>
        <tr>
            <th>ID</th>
            <th>Seller</th>
            <th>Buyer</th>
            <th>Company</th>
            <th>Bid Amount</th>
            <th>Bid Status</th>
            <th>Match Date</th>
            <th>Documents</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <!-- Dynamic data will be loaded here -->
        </tbody>
        </table>
        <!--  P2P BID OVER -->
    </div>
</div>
</div>
<div id="sidebar" class="sidebar">
    {{-- <button onclick="closeSidebar()" class="close-btn">&times;</button> --}}
    <div id="sidebar-content">
        <!-- Dynamic content will be loaded here -->
    </div>
</div>

<!-- start product action popup -->
<div id="action-vendor-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h4 class="modal-title">{{ __('Vendor Action') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">

                        <div class="card-box">
                            <form id="save_product_action_modal" method="post" enctype="multipart/form-data"
                            action="#">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-md-6 mb-2">
                                    {!! Form::label('title', __('Action For '), ['class' => 'control-label']) !!}
                                    <select class="form-control" id="action_for" name="action_for" required>
                                        <option value="">{{__('Select')}}</option>
                                        <option value="delete">{{__('Delete')}}</option>
                                    </select>
                                </div>



                            </div>
                            <div class="modal-footer">
                                <button type="button"
                                    class="btn btn-info waves-effect waves-light submitVendorAction">{{ __('Submit') }}</button>
                            </div>

                            </form>


                        </div>

                </div>

            </div>
        </div>
    </div>

    

{{-- @include('backend.vendor.modals') --}}
<script type="text/template" id="user_id_section">
    <li class="d-flex justify-content-start align-items-center position-relative" id ="user_selected_<%= id %>" data-section_number="<%= id %>">
        <p class="al_checkbox m-0 py-2 ">
            <input type="hidden" class="user_hidden_ids" name="userIDs[]" value="<%= user_id %>" class="mt-2 mr-1">
            <img class="user_img mr-2" src="<%= image %>" alt="">
        </p>
        <p class="al_username m-0 py-2">
            <span> <%= name %> </span>
            <small><%= email %></small>
        </p>
        <sup class="">&#128473;</sup>
    </li>
</script>
@endsection
@section('script')
<script src="{{asset('assets/js/intlTelInput.js')}}"></script>
<script src="{{asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

<!-- jQuery and DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

<script type="text/javascript">
  

    toastr.options = {
        "closeButton": true, // Show close (X) button
        "debug": false,
        "newestOnTop": true, // Show latest alert on top
        "progressBar": true, // Show running line
        "positionClass": "toast-top-right", // Change position
        "preventDuplicates": true,
        "showDuration": "400",
        "hideDuration": "1000",
        "timeOut": "3000", // Auto-hide after 3 seconds
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    $(document).ready(function() {
   
        $('#bidList').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('p2p.admin.bid.fetchList') }}", // Your Laravel route to fetch data
            columns: [
                { data: 'id', name: 'id' },
                { data: 'seller_name', name: 'seller.name' },
                { data: 'buyer_name', name: 'buyer.name' },
                { data: 'company_name', name: 'products.title' },
                { data: 'bid_amount', name: 'bid_amount' },
                { data: 'bid_status', name: 'bid_status' },
                { data: 'match_date', name: 'match_date' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
                { data: 'status', name: 'status', orderable: false, searchable: false },
            ],
            dom: 'lBfrtip', // Enables filter, search, and export buttons
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });



    $(document).on('change', '.status-dropdown', function() {
        var bidId = $(this).data('id');
        var status = $(this).val();
        
        $.ajax({
            url: "{{ route('p2p.bids.status-update') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                bid_id: bidId,
                status: status
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.success);
                    table.ajax.reload(); // Refresh DataTable
                } else {
                    toastr.error("Something went wrong!");
                }
                
            },
            error: function(error) {
                toastr.error('Error updating status');
            }
        });
    });
    
 
 


    var mobile_number = '';
    var updateVendorAll = '{{route("vendor.updateall")}}';
    $('#add-agent-modal .xyz').change(function() {
        var phonevalue = $('.xyz').val();
        $("#countryCode").val(mobile_number.getSelectedCountryData().dialCode);
    });

    function phoneInput() {
        console.log('phone working');
        var input = document.querySelector(".xyz");

        var mobile_number_input = document.querySelector(".xyz");
        mobile_number = window.intlTelInput(mobile_number_input, {
            separateDialCode: true,
            hiddenInput: "full_number",
            utilsScript: "{{ asset('telinput/js/utils.js') }}",
        });
    }
    var input = document.querySelector("#new_user_phone_number");
    if(input){
        window.intlTelInput(input, {
        separateDialCode: true,
        hiddenInput: "contact",
        utilsScript: "{{asset('assets/js/utils.js')}}",
        initialCountry: "{{ Session::get('default_country_code','US') }}",
    });
    }
    var input = document.querySelector("#vendor_phone_number");
    if(input){
        window.intlTelInput(input, {
        separateDialCode: true,
        hiddenInput: "contact",
        utilsScript: "{{asset('assets/js/utils.js')}}",
        initialCountry: "{{ Session::get('default_country_code','US') }}",
    });
    }

    $(document).ready(function() {
        $("#new_user_phone_number").keypress(function(e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
            return true;
        });
        $("#vendor_phone_number").keypress(function(e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
            return true;
        });
        @if($client_preference_detail->business_type != 'taxi')
            vendorOrderTime();
        @endif
    });
    $('#phone_numberInput .iti__country').click(function() {
        var code = $(this).attr('data-country-code');
        $('#countryData').val(code);
        var dial_code = $(this).attr('data-dial-code');
        $('#dialCode').val(dial_code);
    });
    $(document).on('click', '#phone_noInput .iti__country', function() {
        var code = $(this).attr('data-country-code');
        $('#vendorCountryCode').val(code);
        var dial_code = $(this).attr('data-dial-code');
        $("input[name='vendor_dial_code']").val(dial_code);
    });
    $(document).on('change', '#Vendor_order_pre_time', function(){
        vendorOrderTime();
    });
    function vendorOrderTime(){
       var min = $('#Vendor_order_pre_time').val();
        
       if(min >=60){
            var hours = Math.floor(min / 60);
            var minutes = min % 60;

            if( minutes <= 9)
            minutes ='0'+minutes;

            var txt = '~ '+hours+':'+minutes+" {{__('Hours')}}";
            $('#Vendor_order_pre_time_show').text(txt);
       }else{
            var txt = min+" {{__('Min')}}";
            $('#Vendor_order_pre_time_show').text(txt);
       }
    }
    var gofrugalEnableStatus = "{{ @$getAdditionalPreference['gofrugal_enable_status'] }}";
    var toggleGroFrugalBtn = gofrugalEnableStatus != 1 ? 'd-none' : '';
    var goFrugalUrl = '{{route("gofrugal.home")}}';
</script>
@include('backend.vendor.pagescript')
<script src="{{asset('js/admin_vendor.js')}}"></script>
@include('backend.export_pdf')

<script type="text/javascript">
    var search_text = "{{__('Search By '). getNomenclatureName('vendors', false) . __(' Name')}}";
    var table_info = '{{__("Showing _START_ to _END_  of _TOTAL_ entries")}}';
</script>

<script>
    $(document).on('click', '.view-btn', function () {
        
         const id = $(this).data('id');
        $('#sidebar-content').html(); // Load response into sidebar
        // $('#sidebar').addClass('show');
    //    $('#sidebar').show(); 
         
        // Optional: Fetch data using AJAX
        $.ajax({
            url: "/client/p2p/admin/product/document/" + id, // Your route to fetch bid detail view
            method: 'GET',
            success: function (response) {
                $('#sidebar-content').html(response.html); // Load response into sidebar
                $('#sidebar').addClass('show'); // Show the sidebar
            }
        });
    });
    
    function closeSidebar() {
        $('#sidebar').removeClass('show');
        //   $('#sidebar').hide();
    }
    </script>
@endsection
