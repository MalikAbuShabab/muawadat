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
        .progress-circle {
            position: relative;
            width: 35px;
            /* Adjusted size */
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            /* Pointer cursor for better UX */
        }

        .circular-chart {
            display: block;
            width: 100%;
            height: 100%;
            transform: rotate(-90deg);
        }

        .circle-bg {
            fill: none;
            stroke: #eee;
            stroke-width: 2.8;
        }

        .circle {
            fill: none;
            stroke: #015158fc;
            stroke-width: 2.8;
            stroke-linecap: round;
            transition: stroke-dasharray 0.6s ease;
        }

        #progress-percentage {
            position: absolute;
            font-weight: bold;
            font-size: 9px;
            color: #015158fc;
        }

        /* Tooltip styles */
        .tooltip-text {
            visibility: hidden;
            background-color: #333;
            color: #fff;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            position: absolute;
            bottom: 110%;
            /* Position above the circle */
            left: 50%;
            transform: translateX(-50%);
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.3s;
            z-index: 1;
        }

        .progress-circle:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
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

        .no_cancel {
            background: #015158;
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
        <div class="my_bits pt-0 pt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="bid-heading">{{__('My Bids')}}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="container bid_request_section">
            <div class="row gx-2">

                <div class="col-md-4 px-1">
                    <div class="bg-light rounded p-2">
                    <h5>{{__('Active')}}</h5>
                    @forelse($openBids as $key => $bid)
                        {{-- <a href="{{ url($bid->product->vendor->slug . '/product/' . $bid->product->url_slug) }}"> --}}
                            <div class="active_bits mb-1">
                                <div
                                    class="inner_bits bg-white shadow rounded p-2 d-flex align-items-center justify-content-between">
                                    <img
                                        src="{{@$bid->product->media[0]->image['path']['image_fit'] . '100/100' . $bid->product->media[0]->image['path']['image_path']}}" />
                                    <span class="hasan_ahmed ml-2 w-75">
                                        <label class="d-flex justify-content-between mb-0">
                                            <h6 class="display-6 mt-0 mb-0"
                                                style="color: #01383d;font-weight:700;font-size:16px">{{ $bid->product->title }}
                                            </h6>
                                            <h6 class="display-6 mt-0 mb-0" style="color: #858585">#0000{{$bid->id ?? '0.00'}}
                                            </h6>
                                        </label>
                                        <label class="d-flex justify-content-between mb-0">
                                            <h6 class="display-6 mt-0 mb-0" style="color: #858585">
                                                By {{ $bid->seller->name ?? 'N/A' }}
                                            </h6>
                                            <h6 class="display-6 mt-0 mb-0"
                                                style="color: #015158;font-weight:700;font-size:16px">{{__('Bid offer')}}:</h6>
                                        </label>
                                        <label class="d-flex justify-content-between mb-0">
                                            <h6 class="display-6 mt-0 mb-0" style="color: #858585">
                                                Placed on {{ $bid->created_at->format('D d M, h:i A') }}
                                            </h6>
                                            <h6 class="display-6 mt-0" style="color: #015158">{{$currencysymbol}}
                                                {{ $bid->bid_amount ?? '0.00' }}</h6>
                                        </label>
                                        <label class="d-flex justify-content-between mb-0" style="gap: 10px">
                                            {{-- <p
                                                style="background: {{ $bid->bid_status == 'open' ? '#e8ae10' : ($bid->bid_status == 'rejected' ? 'red' : '') }}"
                                                class="p-1 w-50 text-center text-white rounded" href="#">
                                                @if ($bid->bid_status == 'open') Pending @elseif ($bid->bid_status ==
                                                'rejected') Rejected @else open @endif
                                            </p>
                                            <p style="background: #015158"
                                                class="p-1 w-50 text-center text-white rounded  {{ $bid->bid_status == 'rejected' ? '': 'bid_amount_update' }} "
                                                data-bs-toggle="modal" data-bs-target="#updateBidModal"
                                                data-bid-id="{{ $bid->id }}" data-product-id="{{ $bid->product_id }}"
                                                data-seller-id="{{ $bid->seller_id }}" data-buyer-id="{{ $bid->buyer_id }}">
                                                Raise Bid </p>
                                        </label> --}}

                                        <p style="background: #e8ae10" class="p-1 w-50 text-center text-white rounded" href="#">
                                            {{__('Pending')}}
                                        </p>
                                        <p style="background: #015158"
                                            class="p-1 w-50 text-center text-white rounded  {{ $bid->bid_status == 'rejected' ? '' : 'bid_amount_update' }} "
                                            data-bs-toggle="modal" data-bs-target="#updateBidModal" data-bid-id="{{ $bid->id }}"
                                            data-product-id="{{ $bid->product_id }}" data-seller-id="{{ $bid->seller_id }}"
                                            data-buyer-id="{{ $bid->buyer_id }}"> {{__('Raise Bid')}} </p>
                                        {{-- <p style="background: #015158" class="p-1 w-50 text-center text-white rounded">
                                            Raised Bid </p> --}}
                                        </label>

                                    </span>
                                </div>
                                {{-- @if($bid->bid_status == 'rejected')
                                <strong style="display: inline">Bid Reject -:</strong>
                                <span style="color: #e23434; font-weight: bold;">Bid Rejected by Seller</span>
                                @endif
                                <h6 class="display-6 my-0" style="color: #e23434">{{ $bid->seller_reason ? 'Reason By Seller':
                                    '' }} -: {{ $bid->seller_reason ?? '' }}</h6>
                                --}}
                            </div>
                        </a>
                    @empty
                        <p class="no_data_found">{{__('No Open Bid Available')}} !</p>
                    @endforelse
                    </div>
                </div>

                <!-- Modal for update bid amount -->
                <div class="modal fade" id="updateBidModal" tabindex="-1" aria-labelledby="updateBidModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="updateBidModalLabel">{{__('Raise Bid Amount')}}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            {{-- <form id="updateBidForm"> --}}
                                <div class="modal-body">
                                    <input type="hidden" id="bid_id">
                                    <input type="hidden" id="product_id">
                                    <input type="hidden" id="seller_id">
                                    <input type="hidden" id="buyer_id">
                                    <div class="mb-3">
                                        <label for="bidAmount" class="form-label">{{__('Raise Bid Amount')}}</label>
                                        <input type="number" class="form-control" id="raised_bid_amount" name="bid_amount"
                                            min="1" required>
                                    </div>

                                    <div class="modal-footer " style="flex-wrap: inherit;">
                                        <button type="button" id="closeButton"
                                            class="no_cancel btn darkgreen w-50 mb-2 text-white rounded"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="button"
                                            class="withdraw_contract  btn darkgreen w-50 mb-2 text-white rounded"
                                            id="submitRaiseAmount">Update Bid</button>
                                    </div>
                                </div>

                                {{--
                            </form> --}}
                        </div>
                    </div>
                </div>
                <!-- OVER -->



                <div class="col-md-4 px-1">
                    <div class="bg-light rounded p-2">
                    <h5>{{__('Ongoing')}}</h5>
                    @forelse($matchedbids as $key => $bid)
                        <a
                            href="{{ url($bid->product->vendor->slug . '/product-page/' . $bid->product->url_slug . '?url_bid_id=' . $bid->id) }}">
                            <div class="active_bits mb-1">
                                <div
                                    class="inner_bits bg-white shadow rounded p-2 d-flex align-items-center justify-content-between">
                                    <img
                                        src="{{@$bid->product->media[0]->image['path']['image_fit'] . '100/100' . $bid->product->media[0]->image['path']['image_path']}}" />
                                    <span class="hasan_ahmed ml-2 w-75">
                                        <label class="d-flex justify-content-between mb-0">
                                            <h6 class="display-6 mt-0 mb-0"
                                                style="color: #01383d;color: #015158;font-weight:700;font-size:16px">
                                                {{ $bid->product->title }}</h6>
                                            <h6 class="display-6 mt-0 mb-0" style="color: #858585">#0000{{$bid->id ?? '0.00'}}
                                            </h6>
                                        </label>
                                        <label class="d-flex justify-content-between mb-0">
                                            <h6 class="display-6 mt-0 mb-0" style="color: #858585">
                                                By {{ $bid->seller->name ?? 'N/A' }}
                                            </h6>
                                            <h6 class="display-6 mt-0 mb-0"
                                                style="color: #015158;font-weight:700;font-size:16px">{{__('Bid offer')}}:</h6>
                                        </label>
                                        <label class="d-flex justify-content-between mb-0">
                                            <h6 class="display-6 mt-0 mb-0" style="color: #858585">
                                                Placed on {{ $bid->created_at->format('D d M, h:i A') }}
                                            </h6>
                                            <h6 class="display-6 mt-0" style="color: #015158">{{$currencysymbol}}
                                                {{ $bid->bid_amount ?? '0.00' }}</h6>
                                        </label>
                                        <label class="d-flex justify-content-end1 mb-0" style="gap: 10px">
                                            <span style="background: #E8AE10" class="p-1 w-50 text-center text-white rounded"
                                                href="#">{{__('Tasks Pending')}}</span>
                                        </label>
                                    </span>
                                    <div class="ongoing-bid" style="margin-top: 89px;">
                                        <div class="progress-circle">
                                            <div id="progress-percentage">{{$bid->progress}}%</div>
                                            <svg viewBox="0 0 36 36" class="circular-chart">
                                                <path class="circle-bg" d="M18 2.0845
                                                a 15.9155 15.9155 0 0 1 0 31.831
                                                a 15.9155 15.9155 0 0 1 0 -31.831" />
                                                <path class="circle" stroke-dasharray="{{$bid->progress}}, 100" d="M18 2.0845
                                                a 15.9155 15.9155 0 0 1 0 31.831
                                                a 15.9155 15.9155 0 0 1 0 -31.831" />
                                            </svg>
                                            <div class="tooltip-text">
                                                Bid GoingOn: {{$bid->matched_progress ?? 0}} %<br>
                                                Seller Sign: {{$bid->seller_signed_progress ?? 0}} %<br>
                                                Buyer Sign: {{$bid->buyer_signed_progress ?? 0}} %<br>
                                                Milestone: {{$bid->milestone_progress ?? 0}} %<br>
                                                Milestone Approve: {{$bid->milestone_approve_progress ?? 0}} %<br>
                                                Milestone Payment: {{$bid->milestone_payment_progress ?? 0}} %<br>
                                                Milestone Payment Approved: {{$bid->milestone_payment_approved_progress ?? 0}}
                                                %<br>
                                                Owner Transfer: {{$bid->owner_transfer_progress ?? 0}} %
                                            </div>
                                        </div>
                                    </div>
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
                    @forelse($completedBids as $key => $bid)
                        <a
                            href="{{ url($bid->product->vendor->slug . '/product-page/' . $bid->product->url_slug . '?url_bid_id=' . $bid->id) }}">
                            <div
                                class="active_bits mb-1   {{ $bid->bid_status === 'closed' && empty($bid->withdraw_reason) ? 'bid_close_success' : 'bid_close_fail' }}">
                                <div
                                    class="inner_bits bg-white shadow rounded p-2 d-flex align-items-center justify-content-between">
                                    <img
                                        src="{{@$bid->product->media[0]->image['path']['image_fit'] . '100/100' . $bid->product->media[0]->image['path']['image_path']}}" />
                                    <span class="hasan_ahmed ml-2 w-75">
                                        <label class="d-flex justify-content-between mb-0">
                                            <h6 class="display-6 mt-0 mb-0"
                                                style="color: #01383d;font-weight:700;font-size:16px">{{ $bid->product->title }}
                                            </h6>
                                            <h6 class="display-6 mt-0 mb-0" style="color: #858585">#0000{{$bid->id ?? '0.00'}}
                                            </h6>
                                        </label>
                                        <label class="d-flex justify-content-between mb-0">
                                            <h6 class="display-6 mt-0 mb-0" style="color: #858585">
                                                By {{ $bid->seller->name ?? 'N/A' }}
                                            </h6>
                                            <h6 class="display-6 mt-0 mb-0"
                                                style="color: #015158;font-weight:700;font-size:16px">{{__('Bid offer')}}:</h6>
                                        </label>
                                        <label class="d-flex justify-content-between mb-0">
                                            <h6 class="display-6 mt-0 mb-0" style="color: #858585">
                                                Placed on {{ $bid->created_at->format('D d M, h:i A') }}
                                            </h6>
                                            <h6 class="display-6 mt-0" style="color: #015158">{{ $currencysymbol }}
                                                {{ $bid->bid_amount ?? '0.00' }}</h6>
                                        </label>
                                        <label class="d-flex justify-content-end mb-0" style="gap: 10px">
                                            @if($bid->bid_status == 'rejected')
                                                <strong style="display: inline">{{__('Bid Status')}} -:</strong>
                                                <span style="color: #e23434; font-weight: bold;">{{__('Bid Rejected By Seller')}}</span>
                                            @endif
                                            @if($bid->bid_status == 'closed' && $bid->withdraw_reason == '')
                                                <span style="background: #015158" class="p-1 text-center text-white rounded"
                                                    href="#">Milestone Completed</span>
                                                <div class="ongoing-bid">
                                                    <div class="progress-circle">
                                                        <div id="progress-percentage">100%</div>
                                                        <svg viewBox="0 0 36 36" class="circular-chart">
                                                            <path class="circle-bg" d="M18 2.0845
                                                            a 15.9155 15.9155 0 0 1 0 31.831
                                                            a 15.9155 15.9155 0 0 1 0 -31.831" />
                                                            <path class="circle" stroke-dasharray="100, 100" d="M18 2.0845
                                                            a 15.9155 15.9155 0 0 1 0 31.831
                                                            a 15.9155 15.9155 0 0 1 0 -31.831" />
                                                        </svg>
                                                        <span class="tooltip-text">Progress: 100%</span>
                                                    </div>
                                                </div>
                                            @endif

                                            @if($bid->bid_status == 'closed' && $bid->withdraw_reason != '')
                                                <strong style="display: inline">{{__('Bid Status')}} -:</strong>
                                                <span style="color: #e23434; font-weight: bold;">Bid Withdraw</span>
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

@endsection
@section('script')

    <script src="{{asset('assets/libs/dropzone/dropzone.min.js')}}"></script>
    <script src="{{asset('assets/libs/dropify/dropify.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/form-fileuploads.init.js')}}"></script>
    <script src="{{asset('assets/js/intlTelInput.js')}}"></script>
    <script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>

    <script>

        document.getElementById('closeButton').addEventListener('click', function () {
            $('#updateBidModal').modal('hide');
        });
        $('.bid_amount_update').click(function (event) {
            event.preventDefault(); // Prevent the default action (navigation)

            // Get the bid ID and status from data attributes
            var bidId = $(this).data('bid-id');
            var productId = $(this).data('product-id');
            var sellerId = $(this).data('seller-id');
            var buyerId = $(this).data('buyer-id');


            $('#bid_id').val(bidId);
            $('#product_id').val(productId);
            $('#seller_id').val(sellerId);
            $('#buyer_id').val(buyerId);

            // Show the modal
            $('#updateBidModal').modal('show');
        });

        $('#submitRaiseAmount').click(function (event) {
            event.preventDefault();
            var bidId = $('#bid_id').val();
            var raisedBidAmount = $('#raised_bid_amount').val();
            var sellerId = $('#seller_id').val();
            var buyerId = $('#buyer_id').val();
            var productId = $('#product_id').val();
            if (!raisedBidAmount) {
                alert("Please enter Amount.");
                return;
            }

            var uri = "{{route('p2p.raisebid.store')}}";
            $.ajax({
                url: uri,
                method: 'POST',
                data: {
                    bid_amount: raisedBidAmount,
                    buyer_id: buyerId,
                    seller_id: sellerId,
                    product_id: productId,
                    _token: $('meta[name="csrf-token"]').attr('content')  // CSRF token
                },
                success: function (response) {
                    $('#updateBidModal').modal('hide');
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
                    alert('Error submitting the action.');
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