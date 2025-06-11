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
    </style>
    <link rel="stylesheet" href="{{asset('assets/css/intlTelInput.css')}}">
@endsection
@section('content')

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f8f9fa;
        }

        .milestones-container {
            margin: 0px auto;
            max-width: 100%;
        }

        .status-group {
            margin-bottom: 30px;
        }

        .status-group h2 {
            margin-bottom: 10px;
            font-size: 20px;
            color: #333;
        }

        .milestone {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            border-left: 5px solid #ddd;
            border-radius: 0;
            background-color: #fff;
            margin-bottom: 0px;
            box-shadow: 0 0 5px 0 #d9d9d9;
        }

        .milestone.complete {
            border-color: #28a745;
        }

        .milestone.complete .status {
            color: #28a745;
        }

        .milestone.pending {
            border-color: #ffc107;
        }

        .milestone.pending .status {
            color: #ffc107;
        }

        .status {
            font-weight: bold;
        }

        .milestone-card {
            border-radius: 10px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            width: 100%;
        }

        /* .milestone-card:hover {
            transform: scale(1.02);
            background:rgb(242, 243, 247);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        } */

        /* .milestone-card.complete {
            border-left: 5px solid #28a745; 
        }

        .milestone-card.pending {
            border-left: 5px solid #ffc107;
        } */

        .milestone-status {
            font-size: 14px;
            font-weight: bold;
        }

        .milestone-status.complete {
            color: #28a745;
        }

        .milestone-status.pending {
            color: #ffc107;
        }

        /*Open hide on plus button */

        .toggle-content {
            display: none;
            padding: 10px 20px;
            /* background-color: #f1f1f1; */
            /* border: 1px solid #ccc; */
            margin-top: 10px;
            box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.1);
        }

        .plus-button {
            cursor: pointer;
            padding: 5px 10px;
            background-color: #fff;
            color: white;
            border: none;
            border-radius: 5px;
        }

        .plus-button:hover {
            background-color: #015158;
        }

        /* .card-title {
        padding: 0px 0px 0px 47px;
    } */

        .milestone_title {
            display: flex;
            margin-right: 10px;
            background: #17676e;
            width: 100%;
            padding: 10px;
            align-items: center;
            justify-content: space-between;
        }


        .plus-button,
        .card-title {
            display: inline-block;
            vertical-align: middle;
            /* Aligns elements in the middle */
            margin: 0 5px;
            /* Optional: Space between button and text */
        }

        #approval-status {
            float: right;
        }

        #confirmModal-17 input {
            height: unset;
        }

        .star {
            font-size: 40px;
            line-height: 20px;
        }

        .feedback-options .form-check {
            border-radius: 15px;
            margin: 5px;
            position: relative;
            padding-left: 0;
            text-align: center;
            justify-content: space-evenly;
            background: #c7c7c7;
            color: #000;
        }

        .feedback-options .form-check input {
            position: absolute;
            right: 0;
            width: 100%;
            left: 50%;
            transform: translate(-50%, -50%);
            top: 50%;
            opacity: 0;
        }

        .highlighted {
            transition: background-color 0.3s ease-in-out, border 0.3s ease-in-out;
            background: #015158 !important;
            color: #fff !important;
        }

        .btn-primary,
        .btn-primary:hover {
            background-color: #015158;
            border-color: #015158 !important;
        }
    </style>
    @php 
            $multiply = session()->get('currencyMultiplier') ?? 1;
        $currencysymbol = session()->get('currencySymbol') . ' '; 
    @endphp

    <section class="section-b-space">
        <div class="my_bits py-3">
            <div class="container mt-5">
                <div class="milestones-container">
                    <h2 style="font-size: 20px !important; margin-bottom: 15px;">Seller Milestone List</h2>
                    @if($milestone->count() > 0)
                        @foreach($milestone as $key => $row)
                            @if($row->bidMilestones->isNotEmpty())
                                <div class="milestone_title rounded mb-2">
                                    <div class="d-flex align-items-center gap-2 mb-1 mb-md-0">
                                        <button class="plus-button" onclick="toggleDiv({{ $key }})">+</button>
                                        <p class="card-title text-white">Bid Product: {{$row->product->title}}</p>
                                    </div>

                                    <p class="card-title text-white">Bid No: #000{{$row->id}}</p>
                                    <p class="card-title text-white">Amount: {{ $currencysymbol ?? 'AED'}}
                                        {{$row->bid_amount ?? '0.00'}}</p>
                                    <p class="card-title text-white">Bid On: {{$row->created_at->format('j F, Y')}}</p>
                                    <p class="card-title text-white">Bid Status: {{ strtoupper($row->bid_status)}}</p>
                                    <span id="approval-status" class="text-white d-flex align-items-center" style="gap:10px;">
                                        Buyer Approval
                                        <p style="background: {{ @$row->bidMilestones[0]['is_approved'] == 1 ? '#28a745' : '#ffc107' }};
                                                          padding: 5px; 
                                                          margin-bottom: 0; 
                                                          border-radius: 5px; 
                                                          color: #fff;
                                                          display: flex;
                                                          align-items: center;
                                                          gap: 5px;">
                                            @if(@$row->bidMilestones[0]['is_approved'] == 1)
                                                <i class="fa fa-check-circle"></i> Approved
                                            @else
                                                <i class="fa fa-clock"></i> Pending
                                            @endif
                                        </p>
                                    </span>
                                </div>

                                <div class="toggle-content mb-2" id="content-{{ $key }}">
                                    {{-- @if($row->bidMilestones->isNotEmpty()) --}}
                                    @php
                                        $allCompleted = 1;  
                                    @endphp
                                    <div class="row">
                                        @foreach($row->bidMilestones as $k => $mile_stone) <!--- foreach loop child -->
                                            <div class="col-md-6">
                                                @if(!empty($mile_stone))
                                                    @if($mile_stone->is_paid != 'completed' || $mile_stone->status != 'completed')

                                                        @php $allCompleted = 0;  @endphp
                                                    @endif
                                                    <div class="status-group" id="pending-milestones-{{$k}}">
                                                        <h2> {{ ($mile_stone->is_paid == 'completed' && $mile_stone->status == 'completed') ? 'Completed' : 'Pending' }}
                                                        </h2>
                                                        <div
                                                            class="milestone {{ ($mile_stone->is_paid == 'completed' && $mile_stone->status == 'completed') ? 'complete' : 'pending' }}">

                                                            <div class="card milestone-card pending py-1 px-2">
                                                                <h5 class="card-title1">Milestone {{ $k + 1 }} - Payment Due</h5>
                                                                <p class="card-text mb-0">Amount : {{ $currencysymbol ?? 'AED'}}
                                                                    {{ ucfirst($mile_stone->amount)}}</p>
                                                                <p class="card-text mb-0">Buyer : {{ ucfirst($row->buyer->name)}}</p>
                                                                <p class="card-text mb-0">Bid No: #000{{$mile_stone->bid_id}}</p>
                                                                <p class="card-text mb-0">Due Date: {{$mile_stone->due_date}}</p>
                                                                <span class="card-text">Buyer Milestone Approval: <span
                                                                        style="color: {{ $mile_stone->is_approved == 1 ? '#28a745' : 'red' }}">{{$mile_stone->is_approved == 1 ? 'Approved' : 'Not Approve'}}</span></span><br>
                                                                {{-- <span class="card-text"
                                                                    style="color: {{ $mile_stone->status == 'completed' ? 'green' : 'red' }}">Mark
                                                                    Completed: {{$mile_stone->status=='completed' ? 'Marked' : 'Not
                                                                    Mark'}}</span><br> --}}
                                                                <span class="card-text">
                                                                    Mark Completed:
                                                                    <span
                                                                        style="color: {{ $mile_stone->status == 'completed' ? '#28a745' : 'red' }}">
                                                                        {{ $mile_stone->status == 'completed' ? 'Marked' : 'Not Marked' }}
                                                                    </span>
                                                                </span><br>
                                                                <strong>Payment Status:</strong>

                                                                <span
                                                                    class=" {{ $mile_stone->is_paid == 'completed' ? 'milestone-status complete' : 'milestone-status pending' }}">{{$mile_stone->is_paid == 'completed' ? 'Completed' : 'Pending'}}</span>

                                                                <button class="btn btn-primary open-modal text-white" data-bs-toggle="modal"
                                                                    data-bs-target="#milestoneModal-{{$mile_stone->id}}" style=" float: right;">
                                                                    View Details
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                <!-- Modal for Each Milestone -->
                                                <div class="modal fade" id="milestoneModal-{{$mile_stone->id}}" tabindex="-1"
                                                    aria-labelledby="milestoneModalLabel-{{$mile_stone->id}}" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="milestoneModalLabel-{{$mile_stone->id}}">
                                                                    Milestone Details - {{$mile_stone->id}}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p class="mb-0 d-flex justify-content-between"><strong>Bid No:</strong>
                                                                    #000{{$mile_stone->bid_id}}</p>
                                                                <p class="mb-0 d-flex justify-content-between"><strong>Due Date:</strong>
                                                                    {{$mile_stone->due_date}}</p>
                                                                <p class="mb-0 d-flex justify-content-between"><strong>Buyer
                                                                        Approve:</strong> {{$mile_stone->is_approved ? 'Yes' : 'Not'}}</p>
                                                                <p class="mb-0 d-flex justify-content-between"><strong>Buyer Milestone
                                                                        Approve:
                                                                    </strong>{{$mile_stone->is_approved ? 'Approved' : 'Not Approve'}}</p>
                                                                <p class="mb-0 d-flex justify-content-between"><strong>Mark Completed:
                                                                    </strong>{{$mile_stone->status == 'completed' ? 'Marked' : 'Not Mark'}}
                                                                </p>
                                                                <p class="mb-0 d-flex justify-content-between"><strong>Payment
                                                                        Status:</strong>
                                                                    {{$mile_stone->is_paid == 'completed' ? 'Completed' : 'Pending'}}</p>
                                                            </div>

                                                            <div class="modal-footer">
                                                                @if($mile_stone->is_paid == 'completed')
                                                                    <button type="button"
                                                                        class="p-1 w-100 text-center offer_submit text-white rounded mark-complete"
                                                                        data-bs-dismiss="modal" style="background: #015158"
                                                                        data-milestone-id="{{ $mile_stone->id }}" {{ $mile_stone->status == 'completed' ? 'disabled' : '' }}>
                                                                        {{ $mile_stone->status == 'completed' ? 'Milestone Marked' : 'Mark As Complete' }}
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                        <div class="row">
                                        <div class="col-md-4 mx-auto">
                                            <button type="button" name="transfer_ownership"
                                                class="btn darkgreen w-100 mb-5 text-white rounded" data-toggle="modal"
                                                data-target="#confirmModal-{{ $row->id }}" {{ ($allCompleted == 1 && $row->bid_status == 'closed') ? "disabled" : "" }} {{ (($allCompleted == 1 && $row->bid_status == 'closed') || ($allCompleted == 0)) ? 'disabled' : '' }}>
                                                {{ ($allCompleted == 1 && $row->bid_status == 'closed') ? "OwnerShip Has Been Transferred" : "Transfer Owner ship" }}
                                            </button>
                                        </div>
                                    {{-- @endif --}}
                                    <!-- Modal for Each Milestone -->
                                    <div class="modal fade milestoneModal" id="milestoneModal-{{$mile_stone->id}}" tabindex="-1" aria-labelledby="milestoneModalLabel-{{$mile_stone->id}}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header pb-0">
                                                    <h5 class="modal-title" id="confirmModalLabel">Confirmation Required</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body mt-0">
                                                    <h5> By Confirming you acknowledge and agree to the following: </h5>

                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="terms-{{$row->id}}"
                                                            required>
                                                        <label class="form-check-label" for="terms-{{$row->id}}">You have read and
                                                            accepted the terms and conditions.</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="payment-authorized-{{$row->id}}" required>
                                                        <label class="form-check-label" for="payment_authorized">Payment in the amount
                                                            of {{$row->bid_amount}} will be authorized and processed.</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="ownership-right-{{$row->id}}" required>
                                                        <label class="form-check-label" for="ownership_rights">Ownership rights will be
                                                            transferred upon successful completion of this transaction.</label>
                                                    </div>
                                                </div>
                                                <div class="modal-footer d-flex" style="gap: 10px;flex-wrap: unset;">
                                                    <button type="button" class="btn bg-light w-50 m-0 rounded"
                                                        data-dismiss="modal">Cancel</button>
                                                    <button type="button" id="confirmButton-{{ $row->id }}" data-id="{{ $row->id }}"
                                                        class="btn darkgreen w-50 text-white m-0 rounded confirm-transfer-ownership">Confirm</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--  Pop comfirm  Transfer Ownership Over -->
                                    <!-- Customer rating modal -->
                                    <div class="modal fade" id="ratingModal-{{ $row->id }}" tabindex="-1" role="dialog"
                                        aria-labelledby="ratingModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">How Was Your Seller Experience?</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- 5 Star Rating -->
                                                    <div id="stars-{{ $row->id }}" class="d-flex justify-content-center mb-3">
                                                        <span class="star" data-value="1">&#9733;</span>
                                                        <span class="star" data-value="2">&#9733;</span>
                                                        <span class="star" data-value="3">&#9733;</span>
                                                        <span class="star" data-value="4">&#9733;</span>
                                                        <span class="star" data-value="5">&#9733;</span>
                                                    </div>
                                                    <input type="hidden" id="ratingValue-{{ $row->id }}" value="0">

                                                    <!-- Feedback Checkboxes -->
                                                    <div id="suggestion-box-{{$row->id}}" class="suggestion-box mt-3">
                                                        <label for="suggestion"> Suggestions:</label>
                                                        <textarea id="suggestion-{{$row->id}}"
                                                            style=" border-radius: 10px;resize: none;margin-bottom: 20px;"
                                                            name="suggestion" class="form-control" rows="3"
                                                            placeholder="Write your feedback here..."></textarea>
                                                    </div>
                                                    <div class="feedback-options ">
                                                        <ul>
                                                            <li>
                                                                <div class="form-check">
                                                                    <input type="checkbox"
                                                                        class="form-check-input feedback-checkbox highlight-checkbox"
                                                                        value="Best Service" id="bestService-{{ $row->id }}">
                                                                    <label class="form-check-label p-1"
                                                                        for="bestService-{{ $row->id }}">Best Service</label>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="form-check">
                                                                    <input type="checkbox"
                                                                        class="form-check-input feedback-checkbox highlight-checkbox"
                                                                        value="Best Property" id="bestProperty-{{ $row->id }}">
                                                                    <label class="form-check-label p-1"
                                                                        for="bestProperty-{{ $row->id }}">Best Property</label>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="form-check">
                                                                    <input type="checkbox"
                                                                        class="form-check-input feedback-checkbox highlight-checkbox"
                                                                        value="Conversation" id="conversation-{{ $row->id }}">
                                                                    <label class="form-check-label p-1"
                                                                        for="conversation-{{ $row->id }}">Conversation</label>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="form-check">
                                                                    <input type="checkbox"
                                                                        class="form-check-input feedback-checkbox highlight-checkbox"
                                                                        value="Disrespectful" id="disrespectful-{{ $row->id }}">
                                                                    <label class="form-check-label p-1"
                                                                        for="disrespectful-{{ $row->id }}">Disrespectful</label>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="form-check">
                                                                    <input type="checkbox"
                                                                        class="form-check-input feedback-checkbox highlight-checkbox"
                                                                        value="Customer Care" id="customerCare-{{ $row->id }}">
                                                                    <label class="form-check-label p-1"
                                                                        for="customerCare-{{ $row->id }}">Customer Care</label>
                                                                </div>
                                                            </li>
                                                        </ul>


                                                    </div>
                                                </div>
                                                <div class="modal-footer d-flex" style="gap: 10px;flex-wrap: unset;">
                                                    <button type="button" class="btn bg-light w-50 m-0 rounded"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="button" id="submitRating-{{ $row->id }}"
                                                        class="btn darkgreen w-50 text-white m-0 rounded submit-rating"
                                                        data-id="{{ $row->id }}">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- over -->
                                    {{-- @else
                                    <p>No milestones found.</p>
                                    @endif --}}
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="card-box al_inner_card" style="background-color: #edeaea; !important;">
                            <div class="row">
                                <div class="offset-md-3 col-md-6">
                                    <div class="col-md-12 text-center">
                                        <div class="card-box earn-points p-2">
                                            <div class="points-title1" style="color:red;">
                                                <div class="text-center"><strong>Seller Milestone Not Found ! </strong></div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </section>

@endsection
@section('script')
    <script>

    </script>
    <script src="{{asset('assets/libs/dropzone/dropzone.min.js')}}"></script>
    <script src="{{asset('assets/libs/dropify/dropify.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/form-fileuploads.init.js')}}"></script>
    <script src="{{asset('assets/js/intlTelInput.js')}}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
     
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script> --}}
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}
<script>
    $('.close').click(function(){
        $('.milestoneModal').modal('hide');
        $('.modal-backdrop').remove(); // Ensures backdrop is removed
        $('body').removeClass('modal-open'); // Fix body overflow issue
    });
    //Seller Rating 
    $(document).ready(function () {
        $(".highlight-checkbox").change(function () {
            if ($(this).is(":checked")) {
                $(this).closest(".form-check").addClass("highlighted");
            } else {
                $(this).closest(".form-check").removeClass("highlighted").fadeOut(200).fadeIn(400);
            }
        });
        //Seller Rating 
        $(document).ready(function () {
            $(".highlight-checkbox").change(function () {
                if ($(this).is(":checked")) {
                    $(this).closest(".form-check").addClass("highlighted");
                } else {
                    $(this).closest(".form-check").removeClass("highlighted").fadeOut(200).fadeIn(400);
                }
            });
        });
    });
       
    $(document).ready(function () {
            $(".star").click(function () {
                var rating = $(this).data("value");
                var starsContainer = $(this).parent();
                var modalId = starsContainer.attr("id").split("-")[1]; // Extract dynamic ID

                $("#ratingValue-" + modalId).val(rating); // Set hidden input value

                // Highlight stars up to the clicked one
                starsContainer.children(".star").each(function () {
                    $(this).css("color", $(this).data("value") <= rating ? "#f8d64e" : "#ccc");
                });
            });

            $(".submit-rating").click(function () {
                var bidId = $(this).data("id");
                var rating = $("#ratingValue-" + bidId).val();
                var suggestion = $("#suggestion-" + bidId).val();
                var feedbacks = [];

                $("#ratingModal-" + bidId + " .feedback-checkbox:checked").each(function () {
                    feedbacks.push($(this).val());
                });

                if (rating == 0) {
                    alert("Please select a star rating.");
                    return;
                }

                if (feedbacks.length == 0) {
                    alert("Please select at least one feedback option.");
                    return;
                }

                if (suggestion == '') {
                    alert("Please write suggestion.");
                    return;
                }

                $.ajax({
                    url: "{{ route('marketpalce.rating.save')}}",
                    type: "POST",
                    data: {
                        bid_id: bidId,
                        rating: rating,
                        feedback: feedbacks,
                        suggestion: suggestion,
                        _token: $('meta[name="csrf-token"]').attr("content"),
                    },
                    success: function (response) {
                        $("#ratingModal-" + bidId).modal("hide");
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.value) {
                                setTimeout(function () {
                                    location.reload();
                                }, 1000);
                                // $('#ratingModal-' + rowId).modal('show');

                            }
                        });
                    },
                    error: function (xhr) {
                        alert("An error occurred. Please try again.");
                    },
                });
            });
    });


    // Seller rating module stop
    $(document).ready(function () {
        $('#ratingModal').modal('hide');
        $(".mark-complete").click(function () {
            $('#ratingModal').modal('show');
        });
    });


    function toggleDiv(key) {
        const contentDiv = document.getElementById(`content-${key}`);

        // Toggle display property
        if (contentDiv.style.display === "none" || contentDiv.style.display === "") {
            contentDiv.style.display = "block";
        } else {
            contentDiv.style.display = "none";
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".mark-complete").forEach(button => {
            button.addEventListener("click", function () {
                let milestoneId = this.getAttribute("data-milestone-id");
                if (!confirm("Are you sure you want to mark this milestone as complete?")) {
                    return;
                }
                fetch("{{ route('marketplace.payment.mark-complete') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        milestone_id: milestoneId,
                    }),
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.value) {
                                    location.reload();
                                }
                            });
                        } else {
                            alert("Failed to update milestone.");
                        }
                    })
                    .catch(error => console.error("Error:", error));
            });
        });
    });

    // OwnerShip Confirmation save //
    $(document).ready(function () {
        $(".confirm-transfer-ownership").click(function () {
            var rowId = $(this).data('id');
            if ($("#terms-" + rowId).prop("checked") &&
                $("#payment-authorized-" + rowId).prop("checked") &&
                $("#ownership-right-" + rowId).prop("checked")) {
                var url = "{{ route('marketpalce.ownership-confirm') }}";
                $.ajax({
                    url: url, // The route that handles the update
                    type: 'POST',
                    data: {
                        bid_id: rowId, // The dynamic row ID
                        _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token for security
                    },
                    success: function (response) {
                        if (response.success) {
                            // Close the modal
                            $('#confirmModal-' + rowId).hide();
                            document.querySelector('.modal-backdrop').remove();
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.value) {

                                    $('#ratingModal-' + rowId).modal('show');
                                }
                            });
                        } else {
                            alert('Something went wrong. Please try again.');
                        }
                    },
                    error: function (xhr, status, error) {
                        alert('Error: ' + error);
                    }
                });


            } else {
                // If any checkbox is unchecked, show an alert and prevent form submission
                alert("Please read and agree to all items.");
            }
        });
    });

    </script>
@endsection