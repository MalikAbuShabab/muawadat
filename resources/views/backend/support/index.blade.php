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
    
    .dataTables_filter input {
    margin-right: 20px; /* Space from the right */
    padding: 5px 10px; /* Optional: Adjust padding */
    border-radius: 5px; /* Optional: Rounded edges */
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
                    $newvendors = ($vendors === "vendors") ? __('Customer Support') : $vendors ;
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
    </div>
    <div class="row">
        <div class="col-12">
        <!-- P2P BID -->
        <table id="SupportList" class="display">
        <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Created At</th> 
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
         
        </tbody>
        </table>
        <!--  P2P BID OVER -->
    </div>
</div>
</div>

<!-- MODAL FORM TO VIEW SUPPORT TICKET -->
<div class="modal fade" id="supportTicketModal" tabindex="-1" aria-labelledby="supportTicketModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="supportTicketModalLabel">Support Ticket Details</h5>
                <button type="button" class="btn-close1" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <p><strong>Ticket ID:</strong> <span id="ticket_id"></span></p>
                <p><strong>Subject:</strong> <span id="ticket_subject"></span></p>
                <p><strong>Message:</strong> <span id="ticket_message"></span></p>
                <p><strong>Status:</strong> <span id="ticket_status"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- OVER -->
 
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
<script>
$(document).ready(function () {
    $(document).on('click', '.view-support-ticket', function (e) {  
        e.preventDefault();
         
        let ticketId = $(this).data('id'); // Get Ticket ID from button
        $.ajax({
            url: "{{ route('p2p.support_tickets.detail') }}", // Laravel route
            type: "GET",
            data: { id: ticketId },
            success: function (response) {
                if (response.success) {
                    $('#ticket_id').text('#0000'+response.ticket.id);
                    $('#ticket_subject').text(response.ticket.subject);
                    $('#ticket_message').text(response.ticket.message);
                    $('#ticket_status').text(response.ticket.status);

                    $('#supportTicketModal').modal('show'); // Show modal
                } else {
                    alert("Ticket not found!");
                }
            },
            error: function () {
                alert("Error fetching ticket details!");
            }
        });
    });
    // Destroy Suctomer Support Ticket
    $(document).on('click', '.delete-ticket', function (e) {
        e.preventDefault();

        let ticketId = $(this).data('id');
        let url = "{{ route('p2p.support.ticket.delete', ':id') }}".replace(':id', ticketId);
        
        Swal.fire({
            title: "Are you sure?",
            text: "Are you sure to delete this ticket ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}" // Ensure CSRF token is included
                    },
                    success: function (response) {
                        Swal.fire(
                            "Deleted!",
                            "The ticket has been deleted.",
                            "success"
                        );
                        $('#SupportList').DataTable().ajax.reload(null, false);
                    },
                    error: function (xhr) {
                        Swal.fire(
                            "Error!",
                            "Something went wrong. Please try again.",
                            "error"
                        );
                    }
                });
            }
        });
    });

});
</script>


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
        $('#SupportList').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('p2p.support.datatable') }}", // Your Laravel route to fetch data
            columns: [
                { data: 'id', name: 'id' },
                { data: 'user', name: 'user.name' },
                { data: 'subject', name: 'subject' },
                { data: 'message', name: 'message' },
                { data: 'created_at', name: 'created_at' },
                { data: 'status', name: 'status', orderable: false, searchable: false },
                { data: 'action', name: 'status', orderable: false, searchable: false },
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
            url: "{{ route('p2p.support.ticket-update') }}",
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
