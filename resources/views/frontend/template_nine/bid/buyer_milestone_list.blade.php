@extends('layouts.store', ['title' => 'My Profile'])
@section('css')
<link href="{{asset('assets/libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/dropify/dropify.min.css')}}" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
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
        border-radius: 0px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        width: 100%;
        border: none;
    }

    /* .milestone-card:hover {
        transform: scale(1.02);
        background:rgb(242, 243, 247);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
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
        padding: 10px;
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
        background-color: #fff;
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

    .plus-button, .card-title {
        display: inline-block;
        vertical-align: middle;
        margin: 0 5px;  
    }


/*  SWITCHERY MILESTONE APPROVED */

.switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 26px;
  margin-bottom: 0
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #c50202;
  transition: 0.4s;
  border-radius: 34px;
}

.slider:before {
  position: absolute;
  content: "";
  height: 20px;
  width: 20px;
  border-radius: 50%;
  left: 4px;
  bottom: 3px;
  background-color: white;
  transition: 0.4s;
}

input:checked + .slider {
  background-color: #4CAF50;
}

input:checked + .slider:before {
    transform: translateX(26px);
    left: 0;
}
#approveMilestoneForm {
    float: right;
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 4px;
}

</style>

@php 
 $multiply =  session()->get('currencyMultiplier') ?? 1;
 $currencysymbol = session()->get('currencySymbol').' '; 
@endphp

<section class="section-b-space">
    <div class="my_bits py-3">
        <div class="container px-0 mt-5">
            <div class="milestones-container">
                <h2 style="font-size: 20px !important;
    margin-bottom: 15px;" >Buyer Milestone List</h2>
                @if($milestone->count() > 0)
                    @foreach($milestone as $key => $row)
                        @if($row->bidMilestones->isNotEmpty()) 
                            <div class="milestone_title rounded mb-2">
                               <div class="d-flex align-items-center gap-2 mb-1 mb-md-0">
                               <button class="plus-button" onclick="toggleDiv({{ $key }})">+</button>
                               <p class="card-title text-white">Company: {{$row->product->title ?? 'N/A'}}</p>
                               </div>
                                {{-- <p class="card-title text-white">Seller: {{$row->seller->name ?? '0'}}</p> --}}
                                <p class="card-title text-white">Bid No: #000{{$row->id ?? '0'}}</p>
                                <p class="card-title text-white">Amount:{{$currencysymbol}} {{$row->bid_amount ?? '0.00'}}</p>
                                <p class="card-title text-white">Bid On: {{$row->created_at->format('j M, Y')}}</p>
                                <p class="card-title text-white">Bid Status: {{ strtoupper($row->bid_status)}}</p>
                                <form action="" method="PUT" id="approveMilestoneForm">
                                    @if($row->bidMilestones->isNotEmpty())
                                    @php $checkMileStoneApprove = 1;   @endphp
                                    @foreach($row->bidMilestones as $k => $mile_stone_row)
                                        @if(!empty($mile_stone_row) && $mile_stone_row->is_approved != 1)
                                            @php $checkMileStoneApprove = 0; @endphp
                                        @endif
                                    @endforeach
                                    
                                    <span id="approval-status" class="text-white">{{ $mile_stone_row->is_approved == 1 ? 'Approved' : 'Not Approved' }} </span>
                                    @csrf
                                    @method('PUT')
                                    
                                    <label class="switch">
                                        <input type="checkbox" class ="approve-toggle" id="approve-toggle" data-id="{{ $row->id }}" {{ $mile_stone_row->is_approved == 1  ? 'checked' : '' }}
                                    {{$row->bid_status =='closed' ? 'disabled':'' }} {{$mile_stone_row->is_approved ==1 ? 'disabled':'' }}
                                    >
                                        <span class="slider round"></span>
                                    </label>
                                    @endif
                                </form>
                            </div> 
                            <div class="toggle-content mb-2" id="content-{{ $key }}">
                               <div class="row">
                               @if($row->bidMilestones->isNotEmpty())
                                    @php
                                        $allCompleted = true;
                                    @endphp
                                    @foreach($row->bidMilestones as $k => $mile_stone)
                                        @if(!empty($mile_stone))
                                            @if($mile_stone->is_paid != 'completed' || $mile_stone->status != 'completed')
                                                @php $allCompleted = false; @endphp
                                            @endif
                                            <div class="status-group col-md-6" id="pending-milestones-{{$k}}">
                                                <h2> {{$mile_stone->is_paid=='completed' ? 'Completed' : 'Pending'}}</h2>
                                                <div class="milestone {{ $mile_stone->is_paid === 'completed' ? 'complete' : 'pending' }}">
                                                    <div class="card milestone-card pending py-1 px-2">
                                                        <h5 class="card-title1">Milestone {{$mile_stone->id}} - Payment Due</h5>
                                                        <p class="card-text mb-0">Amount : {{ $currencysymbol ?? 'AED'}} {{$mile_stone->amount ?? '0'}}</p>
                                                        <p class="card-text mb-0">Seller : {{$row->seller->name ?? '0'}}</p>
                                                        <p class="card-text mb-0">Bid No : #000{{$mile_stone->bid_id}}</p>
                                                        <p class="card-text mb-0">Due Date : {{$mile_stone->due_date}}</p>
                                                        <span class="card-text">Buyer Milestone Approval : <span style="color: {{ $mile_stone->is_approved == 1 ? '#28a745' : 'red' }}">{{$mile_stone->is_approved == 1 ? 'Approved' : 'Not Approve'}}</span></span><br>
                                                        <span class="card-text">
                                                            Mark Completed : 
                                                            <span style="color: {{ $mile_stone->status == 'completed' ? '#28a745' : 'red' }}">
                                                                {{ $mile_stone->status == 'completed' ? 'Marked' : 'Not Marked' }}
                                                            </span>
                                                        </span><br>
                                                            <strong>Payment Status:</strong> <span class=" {{ $mile_stone->is_paid == 'completed' ? 'milestone-status complete' : 'milestone-status pending' }}">{{$mile_stone->is_paid=='completed' ? 'Completed' : 'Pending'}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    @if($row->bid_status=="closed" && $allCompleted==1)
                                        <button type="button" name="transfer_ownership" class="btn darkgreen w-100 mb-5 text-white rounded"
                                            data-toggle="modal"{{ $allCompleted ? "" : 'disabled' }}  >  
                                            Ownership has been successfully  transferred to you. As the new owner!
                                        </button>
                                    @endif
                                    @else
                                    
                                    <p>No milestones found.</p>
                                @endif
                               </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="card-box al_inner_card" style="background-color: #edeaea; !important;" >
                        <div class="row">
                            <div class="offset-md-3 col-md-6">
                                <div class="col-md-12 text-center">
                                    <div class="card-box earn-points p-2">
                                        <div class="points-title1" style="color:red;">
                                            <div class="text-center"><strong>Buyer Milestone Not Found ! </strong></div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif    
        </div>
    </div>
</section>

@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
     function toggleDiv(key) {
        // Select the div using the dynamic ID
        const contentDiv = document.getElementById(`content-${key}`);

        // Toggle display property
        if (contentDiv.style.display === "none" || contentDiv.style.display === "") {
            contentDiv.style.display = "block";
        } else {
            contentDiv.style.display = "none";
        }
    }

    // function confirmApproval(checkbox) {
    // if (checkbox.checked) {
    //     if (confirm("Are you sure you want to approve this milestone?")) {
    //         checkbox.disabled = true; // Disable after confirmation
            
    //     } else {
    //         checkbox.checked = false; // Revert if canceled
    //     }
    // }
    // }

    $(document).ready(function() {
        $('.approve-toggle').change(function(e) {
            e.preventDefault();
            
            var checkbox = $(this);
            var milestoneId = checkbox.data('id');
            var isChecked = checkbox.prop('checked');
            
            // Immediately revert the checkbox state - will be updated based on confirmation
            checkbox.prop('checked', !isChecked);
            
            var confirmMessage = isChecked 
                ? "Are you sure you want to approve this milestone?" 
                : "Are you sure you want to unapprove this milestone?";

            if (confirm(confirmMessage)) {
                // Show loading state
                checkbox.prop('disabled', true);
                
                $.ajax({
                    url: '/p2p/' + milestoneId + '/toggle-approval',
                    method: 'PUT',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        is_approved: isChecked,
                        bid_id: milestoneId
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update checkbox state and disable it if approved
                            checkbox.prop('checked', isChecked);
                            if (isChecked) {
                                checkbox.prop('disabled', true);
                                $('#approval-status').text('Approved');
                            } else {
                                checkbox.prop('disabled', false);
                                $('#approval-status').text('Not Approved');
                            }
                            location.reload();
                        } else {
                            // Revert checkbox state on error
                            checkbox.prop('checked', !isChecked);
                            checkbox.prop('disabled', false);
                            alert('Error updating approval status');
                        }
                    },
                    error: function(xhr, status, error) {
                        // Revert checkbox state on error
                        checkbox.prop('checked', !isChecked);
                        checkbox.prop('disabled', false);
                        alert('An error occurred: ' + error);
                    }
                });
            } else {
                // Keep the original state if user cancels
                checkbox.prop('checked', !isChecked);
                checkbox.prop('disabled', false);
            }
        });
    });
</script>
    <script src="{{asset('assets/libs/dropzone/dropzone.min.js')}}"></script>
    <script src="{{asset('assets/libs/dropify/dropify.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/form-fileuploads.init.js')}}"></script>
    <script src="{{asset('assets/js/intlTelInput.js')}}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
 @endsection

 
