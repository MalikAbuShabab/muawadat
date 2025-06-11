@extends('layouts.store', ['title' => __('Change Password')])
@section('css-links')
@endsection
@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
<style type="text/css">
    .main-menu .brand-logo {
        display: inline-block;
        padding-top: 20px;
        padding-bottom: 20px;
    }
    .productVariants .firstChild{
        min-width: 150px;
        text-align: left !important;
        border-radius: 0% !important;
        margin-right: 10px;
        cursor: default;
        border: none !important;
    }
    .product-right .color-variant li, .productVariants .otherChild{
        height: 35px;
        width: 35px;
        border-radius: 50%;
        margin-right: 10px;
        cursor: pointer;
        border: 1px solid #f7f7f7;
        text-align: center;
    }
    .productVariants .otherSize{
        height: auto !important;
        width: auto !important;
        border: none !important;
        border-radius: 0%;
    }
    .product-right .size-box ul li.active {
        background-color: inherit;
    }
    .iti__flag-container li, .flag-container li{
        display: block;
    }
    .iti.iti--allow-dropdown, .allow-dropdown {
        position: relative;
        display: inline-block;
        width: 100%;
    }
    .iti.iti--allow-dropdown .phone, .flag-container .phone {
        padding: 17px 0 17px 100px !important;
    }
    .social-logins{
        text-align: center;
    }
    .social-logins img{
        width: 100px;
        height: 100px;
        border-radius: 100%;
        margin-right: 20px;
    }
    .register-page .theme-card .theme-form input {
        margin-bottom: 5px;
    }
    .invalid-feedback{
        display: block;
    }
    .errors {
        color: #F00;
        background-color: #FFF;
    }
</style>
@endsection
@section('content')
<section class="section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="text-sm-left">
                    {{-- @if (\Session::has('success'))
                        <div class="alert alert-success">
                            <span>{!! \Session::get('success') !!}</span>
                        </div>
                    @endif
                    @if (\Session::has('error'))
                        <div class="alert alert-danger">
                            <span>{!! \Session::get('error') !!}</span>
                        </div>
                    @endif --}}
               
                </div>
            </div>
        </div>
        <div class="row my-md-3 mt-5 pt-4">
            <div class="col-lg-3">
                <div class="account-sidebar"><a class="popup-btn">{{ __('My Account') }}</a></div>
                <div class="dashboard-left mb-3">
                    <div class="collection-mobile-back">
                        <span class="filter-back d-lg-none d-inline-block">
                            <i class="fa fa-angle-left" aria-hidden="true"></i>{{ __('Back') }}
                        </span>
                    </div>
                    @include('layouts.store/profile-sidebar')
                </div>
            </div>
            <div class="col-lg-9">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="dashboard-right">
                    <div class="dashboard">
                        <div class="page-title">
                            <h2>{{__('Your Support Tickets')}}</h2>
                        </div>
                        <div class="outer-box">
                            <div class="container">
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                            
                                <table class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Message</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Admin Response</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($tickets as $ticket)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $ticket->title }}</td>
                                                <td>{{ Str::limit($ticket->message, 50) }}</td>
                                                <td>
                                                    @if($ticket->status == 'open')
                                                        <span class="badge badge-warning">Open</span>
                                                    @elseif($ticket->status == 'pending')
                                                        <span class="badge badge-primary">Pending</span>
                                                    @elseif($ticket->status == 'resolved')
                                                        <span class="badge badge-success">Resolved</span>
                                                    @endif
                                                </td>
                                                <td>{{ $ticket->created_at->format('F j, Y') }}</td>
                                                <td>
                                                    @if($ticket->admin_response)
                                                        {{ Str::limit($ticket->admin_response, 50) }}
                                                    @else
                                                        <span class="text-muted">No response yet</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No support tickets found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            
                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

@endsection