@extends('layouts.store', ['title' => 'My Profile'])
@section('css')
  <link href="{{asset('assets/libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('assets/libs/dropify/dropify.min.css')}}" rel="stylesheet" type="text/css" />
  <script src="https://code.jquery.com/jquery-3.6.3.min.js"
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
  <style type="text/css">
    .main-menu .brand-logo {
    display: inline-block;
    padding-top: 20px;
    padding-bottom: 20px;
    }

    /* .no_data_found{
      text-align: center;
      color: red;
      margin-top: 61px;
    } */
    .swal2-cancel {
    background: #015158 !important;
    color: #fff !important;
    }
  </style>
  <link rel="stylesheet" href="{{asset('assets/css/intlTelInput.css')}}">
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

    .errors {
    color: #F00;
    background-color: #FFF;
    }

    .invalid-feedback {
    display: block;
    }

    .inner_bits img {
    height: 120px;
    width: 120px;
    object-fit: cover;
    }

    .bid_close_success {
    border: 2px solid rgba(129, 235, 58, 0.829);
    }

    .bid_close_fail {
    border: 2px solid red;
    }
  </style>
  @php 
    $multiply = session()->get('currencyMultiplier') ?? 1;
    $currencysymbol = session()->get('currencySymbol') . ' '; 
  @endphp
  <section class="section-b-space">
    <div class="my_bits pt-5 pb-5">
    <div class="container bid_request_section">
      <div class="row">
      <div class="col-md-12">
       <h4 class="bid-heading">{{__('Marketplace')}}</h4>
      </div>
      </div>
      <div class="row">

      <div class="col-md-4 px-1">
        <div class="bg-light rounded p-2">
        <h5>{{__('Requests')}}</h5>
        @forelse($openMarketPlace as $key => $bid)

      {{-- <a
      href="@if($bid->bid_status != 'rejected') {{ url($bid->product->vendor->slug . '/product-page/' . $bid->product->url_slug .'/'.$bid_type) }} @else # @endif">
      --}}
      <div class="active_bits mb-1">
        <div class="inner_bits bg-white shadow rounded p-2 d-flex align-items-center justify-content-between">
        <img
        src="{{@$bid->product->media[0]->image['path']['image_fit'] . '100/100' . $bid->product->media[0]->image['path']['image_path']}}" />
        <span class="hasan_ahmed ml-2 w-75">
        <label class="d-flex justify-content-between mb-0">
        <h6 class="display-6 mt-0 mb-0" style="color: #01383d;font-weight:700;font-size:16px">
          {{ $bid->product->title }}</h6>
        <h6 class="display-6 mt-0 mb-0" style="color: #858585">#0000{{$bid->id ?? '0.00'}}</h6>
        </label>
        <label class="d-flex justify-content-between mb-0">
        <h6 class="display-6 mt-0 mb-0" style="color: #858585">
          By {{ $bid->buyer->name ?? 'N/A' }}
        </h6>
        <h6 class="display-6 mt-0 mb-0" style="color: #015158;font-weight:700;font-size:16px">{{__('Bid offer')}}:
        </h6>
        </label>
        <label class="d-flex justify-content-between mb-0">
        <h6 class="display-6 mt-0 mb-0" style="color: #858585">
          Placed on {{ $bid->created_at->format('D d M, h:i A') }}
        </h6>
        <h6 class="display-6 mt-0" style="color: #015158">{{ $currencysymbol ?? 'AED' }}
          {{ $bid->bid_amount ?? '0.00' }}</h6>
        </label>
        <label class="d-flex justify-content-between mb-0" style="gap: 10px">
        {{-- <span
          style="background:{{ $bid->bid_status == 'open' ? '#e8ae10' : ($bid->bid_status == 'rejected' ? 'red' : '') }}"
          class="p-1 w-50 text-center text-white rounded  {{ $bid->bid_status == 'rejected' ? '': 'bid_reject_update' }} "
          href="#" data-bid-id="{{ $bid->id }}" data-bid-status="reject"> @if ($bid->bid_status == 'open')
          Reject @elseif ($bid->bid_status == 'rejected') Rejected @else open @endif </span> --}}
        <span
          style="background:{{ $bid->bid_status == 'open' ? '#e8ae10' : ($bid->bid_status == 'rejected' ? 'red' : '') }}"
          class="p-1 w-50 text-center text-white rounded  bid_reject_update" href="#"
          data-bid-id="{{ $bid->id }}" data-bid-status="reject"> @if ($bid->bid_status == 'open') Reject
      @elseif ($bid->bid_status == 'rejected') Rejected @else open @endif </span>
        <span style="background: #015158"
          class="p-1 w-50 text-center text-white rounded  {{ $bid->bid_status != 'rejected' ? 'bid_status_update' : ''}}"
          href="#" data-bid-id="{{ $bid->id }}" data-bid-status="accept">Accept</span>
        </label>
        </span>
        </div>
        @if($bid->bid_status == 'rejected')
      <strong style="display: inline">{{__('Bid Status')}} -:</strong>
      <span style="color: #e23434; font-weight: bold;">Rejected</span>
    @endif
      </div>
      {{--
      </a> --}}
    @empty
    <p class="no_data_found">{{__('No Request Available')}} !</p>
  @endforelse
        </div>
      </div>

      <div class="col-md-4 px-1">
      <div class="bg-light rounded p-2">
       <h5>{{__('Ongoing')}}</h5>
        @forelse($matchedMarketPlace as $key => $bid)
      <a
      href="{{ url($bid->product->vendor->slug . '/product-page/' . $bid->product->url_slug . '/' . $bid_type . '?url_bid_id=' . $bid->id) }}">
      <div class="active_bits mb-1">
        <div class="inner_bits bg-white shadow rounded p-2 d-flex align-items-center justify-content-between">
        <img
        src="{{@$bid->product->media[0]->image['path']['image_fit'] . '100/100' . $bid->product->media[0]->image['path']['image_path']}}" />
        <span class="hasan_ahmed ml-2 w-75">
        <label class="d-flex justify-content-between mb-0">
        <h6 class="display-6 mt-0 mb-0" style="color: #01383d;font-weight:700;font-size:16px">
          {{ $bid->product->title }}</h6>
        <h6 class="display-6 mt-0 mb-0" style="color: #858585">#0000{{$bid->id ?? '0.00'}}</h6>
        </label>
        <label class="d-flex justify-content-between mb-0">
        <h6 class="display-6 mt-0 mb-0" style="color: #858585">
          By {{ $bid->buyer->name ?? 'N/A' }}
        </h6>
        <h6 class="display-6 mt-0 mb-0" style="color: #015158;font-weight:700;font-size:16px">{{__('Bid offer')}}:
        </h6>
        </label>
        <label class="d-flex justify-content-between mb-0">
        <h6 class="display-6 mt-0 mb-0" style="color: #858585">
          Placed on {{ $bid->created_at->format('D d M, h:i A') }}
        </h6>
        <h6 class="display-6 mt-0" style="color: #015158">{{ $currencysymbol ?? 'AED' }}
          {{ $bid->bid_amount ?? '0.00' }}</h6>
        </label>
        <label class="d-flex justify-content-end mb-0" style="gap: 10px">
        <span style="background: #E8AE10" class="p-1 w-50 text-center text-white rounded" href="#"
          data-bid-id="{{ $bid->id }}" data-bid-status="reject">{{__('Tasks Pending')}}</span>
        </label>
        </span>
        </div>
      </div>
      </a>
    @empty
    <p class="no_data_found">{{__('No Ongoing Bid Available')}} !</p>
  @endforelse
       </div>
      </div>

      <div class="col-md-4 px-1">
      <div class="bg-light rounded p-2">
       <h5>{{__('Completed')}}</h5>
        @forelse($closedMarketPlace as $key => $bid)
      <a
      href="{{ url($bid->product->vendor->slug . '/product-page/' . $bid->product->url_slug . '/' . $bid_type . '?url_bid_id=' . $bid->id) }}">
      <div
        class="active_bits mb-1 {{ $bid->bid_status === 'closed' && empty($bid->withdraw_reason) ? 'bid_close_success' : 'bid_close_fail' }}">
        <div class="inner_bits bg-white shadow rounded p-2 d-flex align-items-center justify-content-between">
        <img
        src="{{@$bid->product->media[0]->image['path']['image_fit'] . '100/100' . $bid->product->media[0]->image['path']['image_path']}}" />
        <span class="hasan_ahmed ml-2 w-75">
        <label class="d-flex justify-content-between mb-0">
        <h6 class="display-6 mt-0 mb-0" style="color: #01383d;font-weight:700;font-size:16px">
          {{ $bid->product->title }}</h6>
        <h6 class="display-6 mt-0 mb-0" style="color: #858585">#0000{{$bid->id ?? '0.00'}}</h6>
        </label>
        <label class="d-flex justify-content-between mb-0">
        <h6 class="display-6 mt-0 mb-0" style="color: #858585">
          By {{ $bid->buyer->name ?? 'N/A' }}
        </h6>
        <h6 class="display-6 mt-0 mb-0" style="color: #015158;font-weight:700;font-size:16px">{{__('Bid offer')}}:
        </h6>
        </label>
        <label class="d-flex justify-content-between mb-0">
        <h6 class="display-6 mt-0 mb-0" style="color: #858585">
          Placed on {{ $bid->created_at->format('D d M, h:i A') }}
        </h6>
        <h6 class="display-6 mt-0" style="color: #015158">{{ $currencysymbol ?? 'AED' }}
          {{ $bid->bid_amount ?? '0.00' }}</h6>
        </label>
        <label class="d-flex justify-content-end mb-0">

        @if($bid->bid_status == 'closed' && $bid->withdraw_reason != '')
      <strong style="display: inline">{{__('Bid Status')}} -:</strong>
      <span style="color: #e23434; font-weight: bold;">Bid Withdraw</span>
    @endif
        @if($bid->bid_status == 'closed' && $bid->withdraw_reason == '')
      <span style="background: #015158" class="p-1 w-50 text-center text-white rounded" href="#"
        data-bid-id="{{ $bid->id }}" data-bid-status="reject">{{__('Completed')}}</span>
    @endif
        @if($bid->bid_status == 'rejected')
      <strong style="display: inline">{{__('Bid Status')}} -:</strong>
      <span style="color: #e23434; font-weight: bold;">Bid Rejected By You</span>
    @endif
        </label>
        </span>
        </div>
      </div>
      </a>
    @empty
    <p class="no_data_found">{{__('No Completed Bid Available')}} !</p>
  @endforelse
       </div>
      </div>

      </div>
    </div>
    </div>
  </section>

  <!-- Raise and reject bid by seller Modal -->
  <div class="modal fade" id="bidModal" tabindex="-1" aria-labelledby="bidModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header py-0 pt-2">
      <h5 class="modal-title pl-0" id="bidModalLabel">Reject Reason</h5>
      <span id="hideRejectModal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </div>
      <div class="modal-body">
      {{-- <p>Please select an option and provide a reason for the action:</p>
      <div class="d-flex align-items-center" style="gap: 10px;">
        <span class="d-flex align-items-center bg-light pl-2 pr-2 rounded mb-2 w-50" style="gap:10px;">
        <input type="radio" name="action_status" value="1" id="actionAccept">
        Accept
        </span>
        <span class="d-flex align-items-center bg-light pl-2 pr-2 rounded mb-2 w-50" style="gap:10px;">
        <input type="radio" name="action_status" value="2" id="actionReject">
        Reject
        </span>
      </div> --}}

      <div class="mt-3">
        <textarea id="reason" class="form-control" rows="4" placeholder="Enter reason here..."></textarea>
      </div>
      </div>
      <div class="modal-footer" style="flex-wrap: inherit;">
      <button style="background: #e61216" id="closeButton" type="button"
        class="btn darkgreen w-50 mb-2 text-white rounded" data-bs-dismiss="modal">Close</button>
      <button type="button" class="btn darkgreen w-50 mb-2 text-white rounded" id="submitAction">Submit</button>
      </div>
    </div>
    </div>
  </div>
  <!-- Raise and reject bid by seller Modal stop -->


@endsection
@section('script')

  <script src="{{asset('assets/libs/dropzone/dropzone.min.js')}}"></script>
  <script src="{{asset('assets/libs/dropify/dropify.min.js')}}"></script>
  <script src="{{asset('assets/js/pages/form-fileuploads.init.js')}}"></script>
  <script src="{{asset('assets/js/intlTelInput.js')}}"></script>
  <script type="text/javascript"
    src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>


  <script>
    $(document).ready(function () {
    // Hide Rejet Reason Modal 
    document.getElementById('hideRejectModal').addEventListener('click', function () {
      $('#bidModal').modal('hide');
    });
    document.getElementById('closeButton').addEventListener('click', function () {
      $('#bidModal').modal('hide');
    });

    // When the "Reject" or "Accept" link is clicked
    $('.bid_reject_update').click(function (event) {
      event.preventDefault();
      var bidId = $(this).data('bid-id');
      var bidStatus = $(this).data('bid-status');

      Swal.fire({
      title: "Are you sure?",
      text: "Do you really want to reject this bid?",
      icon: "warning",
      showCancelButton: true,
      cancelButtonColor: "#3085d6",
      confirmButtonColor: "#d33",
      confirmButtonText: "Yes, Reject it!"
      }).then((result) => {
      if (result.value) {
        $('#submitAction').attr('data-bid-id', bidId);
        $('#submitAction').attr('data-bid-status', bidStatus);
        // $('#bidModal').modal('show');
        var uri = "{{route('marketpalce.reject-raised-bid')}}";
        $.ajax({
        url: uri,
        method: 'POST',
        data: {
          bid_id: bidId,
          bid_status: bidStatus,
          action_status: 2,
          reason: 'Seller Rejected The Bid Request',
          _token: $('meta[name="csrf-token"]').attr('content')  // CSRF token
        },
        success: function (response) {
          // $('#bidModal').modal('hide');
          Swal.fire({
          title: 'Success!',
          text: response.message,
          icon: 'success',
          confirmButtonText: 'OK'
          }).then(() => {
          location.reload(); // Reload page after clicking OK
          });
        },
        error: function (xhr, status, error) {
          alert('Error submitting the action.');
        }
        });
      }
      });

      // $('#submitAction').data('bid-id', bidId);
      // $('#submitAction').data('bid-status', bidStatus);
      // $('#bidModal').modal('show');
    });


    $('#submitAction').click(function () {

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
      url: uri,
      method: 'POST',
      data: {
        bid_id: bidId,
        bid_status: bidStatus,
        action_status: actionStatus,
        reason: reason,
        _token: $('meta[name="csrf-token"]').attr('content')  // CSRF token
      },
      success: function (response) {
        $('#bidModal').modal('hide');
        Swal.fire({
        title: 'Success!',
        text: response.message,
        icon: 'success',
        confirmButtonText: 'OK'
        });
      },
      error: function (xhr, status, error) {
        alert('Error submitting the action.');
      }
      });
    });
    });
  </script>

  <script>
    $(".bid_status_update").click(function (e) {
    e.preventDefault();
    const bidId = this.getAttribute('data-bid-id');
    const bidStatus = this.getAttribute('data-bid-status');
    var uri = "{{route('marketpalce.update-bid-status')}}";
    $.ajax({
      type: "get",
      url: uri,
      data: {
      _token: "{{ csrf_token() }}", bid_id: bidId, bid_status: bidStatus,
      },
      dataType: 'json',
      success: function (response) {
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
      error: function (xhr, status, error) {
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

  <script type="text/javascript">
    var ajaxCall = 'ToCancelPrevReq';
    $('.verifyEmail').click(function () {
    verifyUser('email');
    });
    $('.verifyPhone').click(function () {
    verifyUser('phone');
    });
    function verifyUser($type = 'email') {
    ajaxCall = $.ajax({
      type: "post",
      dataType: "json",
      url: "{{ route('verifyInformation', Auth::user()->id) }}",
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
      },
      error: function (data) { },
    });
    }

    $(document).ready(function () {
    jQuery.validator.addMethod("alphanumeric", function (value, element) {
      return this.optional(element) || /^[a-zA-Z0-9 ]+$/i.test(value);
    }, "Name should contains alphanumeric data.");
    $("#editProfileForm").validate({
      errorClass: 'errors',
      rules: {
      name: {
        required: true,
        minlength: 3,
        alphanumeric: true
      },
      phone_number: {
        required: true,
        number: true,
        minlength: 7,
        maxlength: 15,
        regex: /^[1-9][0-9]*$/
      },
      email: {
        required: true,
        email: true
      }
      },
      onfocusout: function (element) {
      this.element(element); // triggers validation
      },
      onkeyup: function (element, event) {
      this.element(element); // triggers validation
      },
      messages: {
      name: {
        required: "{{ __('Please enter your name')}}",
        minlength: "{{__('The name must be at least 3 characters.')}}",
        alphanumeric: "{{ __('Name should contains alphanumeric data')}}"
      },
      phone_number: {
        required: "{{ __('Please enter your phone')}}",
        number: "{{ __('Please enter a numerical value')}}",
        minlength: "{{ __('minimum 7 digits allowed')}}",
        maxlength: "{{ __('maximum 15 digits required')}}"
      },
      email: "{{ __('The email should be in the format:')}} abc@domain.tld",
      }
    });

    $("#editProfileForm").submit(function () {
      if ($("#phone").hasClass("is-invalid")) {
      $("#phone").focus();
      return false;
      }
    });
    });


    $(".openProfileModal").click(function (e) {
    e.preventDefault();
    var uri = "{{route('user.editAccount')}}";
    $.ajax({
      type: "get",
      url: uri,
      data: '',
      dataType: 'json',
      success: function (data) {
      $('#editProfileForm #editProfileBox').html(data.html);
      $('#profile-modal').modal('show');
      var input = document.querySelector("#phone");
      window.intlTelInput(input, {
        separateDialCode: true,
        hiddenInput: "full_number",
        utilsScript: "{{asset('assets/js/utils.js')}}",
        initialCountry: "{{ Session::get('default_country_code', 'US') }}",
      });
      // Initialize Dropify
      var drEvent = $('.dropify').dropify();

      drEvent.on('dropify.beforeClear', function (event, element) {
        return confirm("Are you sure you want to remove this image?");
      });

      // Set up the event listener for afterClear
      drEvent.on('dropify.afterClear', function (event, element) {
        var removeUri = "{{route('user.removeProfileImage')}}"; // Define the route for removing the image
        $.ajax({
        type: "POST",
        url: removeUri,
        data: {
          _token: "{{ csrf_token() }}", // Include CSRF token for security
          user_id: "{{ $user->id }}" // Pass any necessary data
        },
        success: function (response) {
          console.log("Profile image removed successfully.");
        },
        error: function (response) {
          alert("An error occurred while removing the profile image.");
        }
        });
      });
      },
      error: function (data) {
      }
    });
    });

    $("#timezone").change(function () {
    $("#user_timezone_form").submit();
    });
    $("#copy_icon").click(function () {
    var temp = $("<input>");
    var url = $(this).data('url');
    $("body").append(temp);
    temp.val(url).select();
    document.execCommand("copy");
    temp.remove();
    $("#copy_message").text("{{ __('URL Copied!') }}").show();
    setTimeout(function () {
      $("#copy_message").text('').hide();
    }, 3000);
    });
  </script>
  <script>
    var loadFile = function (event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    };
  </script>
  <script>
    $(document).ready(function () {
    $("#phone").keypress(function (e) {
      if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      return false;
      }
      return true;
    });
    });
    $(document).delegate('.iti__country', 'click', function () {
    var code = $(this).attr('data-country-code');
    $('#countryData').val(code);
    var dial_code = $(this).attr('data-dial-code');
    $('#dialCode').val(dial_code);
    });
  </script>
@endsection