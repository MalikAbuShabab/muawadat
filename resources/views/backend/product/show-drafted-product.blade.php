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

    .action-btn {
        margin-top: 21px;
    }

    .filter-btn {
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.3s ease-in-out;
    }

    .drafted {
        background-color: #ff9800;
        color: white;
    }

    .published {
        background-color: #4CAF50;
        color: white;
    }

    .filter-btn:hover {
        opacity: 0.8;
    }

    .filter-btn.active {
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        transform: scale(1.05);
        border: 2px solid #0d7852a6;
    }

    /* Active Color Change */
    .drafted.active {
        background-color: #e68900; /* Darker Orange */
    }

    .published.active {
        background-color: #388E3C; /* Darker Green */
    }

    .action-btn button {
        opacity: 0.5; /* Default: Dimmed */
        pointer-events: none; /* Disable clicks when inactive */
        transition: opacity 0.3s ease;
    }

    .action-btn button.active {
        opacity: 1; /* Highlight when active */
        pointer-events: auto; /* Enable clicks */
    }
    
    /* Add these responsive table styles */
    @media screen and (max-width: 767px) {
        table#companyList {
            display: block;
            width: 100%;
            overflow-x: auto;
        }

        #companyList thead {
            display: none; /* Hide header on mobile */
        }

        #companyList tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            padding: 0.5rem;
            background: #fff;
        }

        #companyList tbody td {
            display: block;
            text-align: right;
            padding: 0.5rem;
            border: none;
            position: relative;
            padding-left: 50%;
        }

        #companyList tbody td:before {
            content: attr(data-label);
            position: absolute;
            left: 0;
            width: 45%;
            padding-left: 0.5rem;
            font-weight: bold;
            text-align: left;
        }

        /* Adjust action buttons layout */
        .action-btn {
            flex-direction: column;
            gap: 0.5rem;
        }

        .action-btn button {
            width: 100%;
            margin: 0 !important;
        }

        /* Adjust filter buttons */
        .filter-btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }
    }

    /* Ensure table visibility */
    #companyList {
        width: 100% !important;
        display: table !important;
    }
    
    /* Improve table wrapper visibility */
    .dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
        clear: both;
    }

    /* Ensure proper spacing */
    .dataTables_wrapper .row {
        margin: 10px 0;
    }
    
    /* Improve mobile responsiveness */
    @media screen and (max-width: 767px) {
        .dataTables_wrapper .row {
            margin: 5px 0;
        }
        
        .dataTables_filter,
        .dataTables_length {
            text-align: left !important;
            margin: 5px 0;
        }
    }

    /* Responsive Search Bar */
    .dataTables_filter {
        width: 100%;
        margin-bottom: 15px;
    }

    .dataTables_filter label {
        width: 100%;
        display: flex;
        align-items: center;
        margin: 0;
    }

    .dataTables_filter input {
        width: 100% !important;
        margin-left: 10px !important;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    /* Table Row Alignment */
    #companyList td {
        vertical-align: middle;
        padding: 12px 8px;
    }

    /* Responsive Table */
    @media screen and (max-width: 767px) {
        .dataTables_wrapper {
            padding: 0 15px;
        }

        .dataTables_filter {
            margin: 15px 0;
        }

        .dataTables_filter label {
            flex-direction: column;
            align-items: flex-start;
        }

        .dataTables_filter input {
            margin: 10px 0 0 0 !important;
        }

        #companyList td {
            min-height: 50px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 8px 15px;
            position: relative;
        }

        #companyList td:before {
            content: attr(data-label);
            position: absolute;
            left: 15px;
            font-weight: bold;
        }

        #companyList td:not(:last-child) {
            border-bottom: 1px solid #eee;
        }

        /* Improve checkbox alignment */
        #companyList td:first-child {
            justify-content: center;
        }

        /* Improve image alignment */
        #companyList td:nth-child(2) img {
            margin: 0 auto;
        }

        /* Action buttons alignment */
        #companyList td:last-child {
            justify-content: center;
        }

        .toggle-islive-status {
            width: 100%;
            max-width: 200px;
        }
    }

    /* Table Header Styling */
    #companyList thead th {
        background-color: #f8f9fa;
        font-weight: 600;
        padding: 12px 8px;
        border-bottom: 2px solid #dee2e6;
    }

    /* Even/Odd Row Styling */
    #companyList tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    /* Row Hover Effect */
    #companyList tbody tr:hover {
        background-color: #f2f2f2;
    }

    /* DataTable Length Control */
    .dataTables_length {
        margin-bottom: 15px;
    }

    .dataTables_length select {
        padding: 5px;
        border-radius: 4px;
        border: 1px solid #ddd;
    }

    /* Improve table layout */
    .table-responsive {
        margin: 0;
        padding: 0;
    }

    #companyList {
        margin: 0;
        width: 100% !important;
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
                    $newvendors = ($vendors === "vendors") ? __('Customer Listing Requests') : $vendors ;
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
                                    <span data-plugin="counterup" id="total_earnings_by_vendors">{{$draftCompanyCount}}</span>
                                    {{-- <span data-plugin="counterup" id="total_earnings_by_vendors">{{$active_vendor_count}}</span> --}}
                                </h3>
                                {{-- <p class="text-muted font-15 mb-0">{{ __('Total') }} {{ $newvendors }}</p> --}}
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-3 mb-md-0">
                            <div class="text-center">
                                <h3>
                                    <i class="fas fa-money-check-alt text-primary"></i>
                                    <span data-plugin="counterup" id="total_cash_to_collected">{{$publishCompanyCount}}</span>
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
        <!-- DREAFTED PRODUCT BID -->
        {{-- <button class="filter-btn" data-status="">All</button> --}}
        <button class="filter-btn active" data-status="inactive">Drafted</button>
        <button class="filter-btn" data-status="active">Published</button>
        <div class="d-flex mb-3 action-btn">
            <button id="activateSelected" class="btn btn-success mr-2 publish-btn" > Move to Publish</button>
            <button id="deactivateSelected" class="btn btn-danger draft-btn" > Move to Draft</button>
        </div>
        <table id="companyList" class="display">
        <thead>
        <tr>
            <th><input type="checkbox" class="rowCheckbox" id="selectAll"></th>
            <th>ID</th>
            <th>Image</th> 
            <th>Company</th>
            <th>Status</th>
            <th>Created On</th>
            <th>Action</th>
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

    $(document).ready(function () {
        $(".filter-btn").on("click", function () {
            $(".filter-btn").removeClass("active");
            $(this).addClass("active");
        });
    });
    var table;
    $(document).ready(function() {
        table = $('#companyList').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: '{{ route("p2p.admin.draft-product.list") }}',
                data: function (d) {
                    d.status = $('.filter-btn.active').data('status');
                }
            },
            columns: [
                {
                data: "id",
                name: "id",
                orderable: false,
                searchable: false,
                render: function (data) {
                    return '<input type="checkbox" class="rowCheckbox innerCheck" value="' + data + '">';
                    }
                },
                { data: 'id', name: 'id' },
                { data: 'image', name: 'image', orderable: false, searchable: false },
                { data: 'company_name', name: 'product.company_name' },
                { data: 'status', name: 'status', orderable: false, searchable: false,
                    render: function(data, type, row) {
                        if (data === 'Drafted') {
                            return '<span style="color: red;"><b>Drafted</b></span>';
                        } else if (data === 'Published') {
                            return '<span style="color: green;"><b>Published</b></span>';
                        }
                        return data; // Default return for other statuses
                    }
                },
                { data: 'created_at', name: 'created_at', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip',
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search...",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
            },
            drawCallback: function() {
                // Ensure proper alignment after data load
                $(this).find('td').css('vertical-align', 'middle');
            }
        }).on('order.dt', function() {
            $('.rowCheckbox, #selectAll').prop('checked', false);
        });

        $('.filter-btn').click(function () {
            $('.filter-btn').removeClass('active');
            $(this).addClass('active');
            table.ajax.reload();
        });
    

        $("#selectAll").on("click", function () {
            $(".rowCheckbox").prop("checked", this.checked);
        });

        $("#activateSelected").on("click", function () {
            updateStatus(1);
            $(".rowCheckbox, #selectAll").prop("checked", false);
        });

     
        $("#deactivateSelected").on("click", function () {
            updateStatus(0);
            $(".rowCheckbox, #selectAll").prop("checked", false);
        });

        function updateStatus(status) {
            let selectedIds = $(".innerCheck:checked").map(function () {
                return this.value;
            }).get();

            if (selectedIds.length === 0) {
                alert("Please select at least one product.");
                return;
            }
    
            $.ajax({
                url: "{{ route('p2p.product.bulkUpdateStatus') }}", // Define this route in Laravel
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    ids: selectedIds,
                    status: status
                },
                success: function (response) {
                    // alert(response.message);
                    table.ajax.reload(); // Refresh DataTable
                }
            });
        }

    });

        // Handle dropdown change (Publish/Draft)
        $(document).on('change', '.toggle-islive-status', function () {
        let productId = $(this).data('id');
        let newStatus = $(this).val() === 'publish' ? 1 : 0;
        $.ajax({
            url: '/client/p2p/products/' + productId + '/update-islive-status',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                is_live: newStatus
            },
            success: function (response) {
                let toastType = response.is_live == 1 ? 'success' : 'error'; 
                toastr[toastType](response.message);
                table.ajax.reload();
            },
            error: function (xhr, status, error) {
                alert('Something went wrong!');
            }
        });
    });


    $(document).ready(function () {
        function toggleActionButtons() {
            let checkedCount = $(".rowCheckbox:checked").length;
            let activeFilter = $(".filter-btn.active").data("status"); // Get active tab status
            if (checkedCount > 0) {
                if (activeFilter === "inactive") { // Trigger Drafted
                    $("#activateSelected").prop("disabled", false); // Enable Publish
                    $("#deactivateSelected").prop("disabled", true);  // Disable Draft
                    $(".publish-btn").addClass("active");
                } else if (activeFilter === "active") { // Trigger Published
                    $("#deactivateSelected").prop("disabled", false); // Enable Draft
                    $("#activateSelected").prop("disabled", true);  // Disable Publish
                    $(".draft-btn").addClass("active");
                }
            } else {
                $("#activateSelected, #deactivateSelected").prop("disabled", true);
            }
        }

        // ✅ Detect checkbox change & toggle buttons
        $(document).on("change", ".rowCheckbox", function () {
            toggleActionButtons();
        });

        // ✅ "Select All" checkbox functionality
        $("#selectAll").on("change", function () {
            $(".rowCheckbox").prop("checked", this.checked).trigger("change");
        });

        // ✅ Change active tab & update buttons
        $(".filter-btn").on("click", function () {
            $(".filter-btn").removeClass("active");
            $(this).addClass("active");
 
            toggleActionButtons(); // Update button states
        });

        // ✅ Initially disable both buttons
        $("#activateSelected, #deactivateSelected").prop("disabled", true);
    });


    // $(document).ready(function () {
         
    //     function toggleActionButtons() {
    //         if ($(".rowCheckbox:checked").length > 0) {
    //             $(".action-btn button").addClass("active"); // Highlight buttons
    //         } else {
    //             $(".action-btn button").removeClass("active"); // Remove highlight
    //         }
    //     }

    //     // Handle individual checkbox click
    //     $(document).on("change", ".rowCheckbox", function () {
    //         toggleActionButtons();
    //     });

    //     // Handle "Select All" checkbox
    //     $("#select-all").on("change", function () {
    //         $(".row-checkbox").prop("checked", this.checked).trigger("change");
    //     });
    // });


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
@endsection
