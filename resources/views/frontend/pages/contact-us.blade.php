@extends('layouts.store', ['title' => 'Product'])
<style type="text/css">
.inquiry_type {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.inquiry_type label {
    display: flex;
    align-items: center;
    font-size: 22px;
    margin-right: 15px;
}

.inquiry_type input[type="radio"] {
    height: 40px !important;
    margin-right: 25%;
}

input[type="radio"]:hover {
    cursor: pointer;
}

.form-control {
    border-radius: 0.25rem;
    padding: 0.375rem 0.75rem;
}

input[type="radio"] {
    appearance: radio;
    outline: none;
}

.contact-container {
            max-width: 600px;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin: 50px auto;
        }
        .contact-container h6 {
            font-size: 32px;
            font-weight: bold;
            color: #1b4144eb;
            text-align: center;
        }
        .contact-container p {
            text-align: center;
            color: #666;
        }
        .contact-container input, .contact-container textarea {
            width: 100%;
            padding: 12px;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
        }
        .contact-container input:focus, .contact-container textarea:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.2);
        }
        .contact-container button:hover {
            background: #0056b3;
        }
        .form-group {
            position: relative;
        }
        .form-group img {
            position: absolute;
            left: 10px;
            top: 38%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            opacity: 0.7;
        }
        .form-group input {
            padding-left: 40px;
        }

</style>
@section('content')
    
<section class="space emailtemplateBlock contactusBlock position-relative">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        
        <div class="breadcrumbsPages">
            <ul class="d-flex">
                {{-- <li><a href="javascript:void">Menu</a> <i class="fa  fa-angle-right"></i></li>                
                <li><a href="javascript:void">Contact Us </a></li>                          --}}
                {{-- <li>My Account Info</li> --}}
            </ul>
        </div>
        <div class="customHeading mt-4">
            <h2>Contact Us</h2>
            <!-- <div class="contact-icons">
                 <a href="https://wa.me/+971501002025?text=Hello!" class="icon chatbot" target="_blank">
                    <img src="https://s3.us-west-2.amazonaws.com/royoorders2.0-assets/prods/jnKcSRWr5vIItEYzANY3mNZhgMV0EiR5NKU251Yx.png" alt="WhatsApp" width="40px" class="green-icon">
                 </a>

                 <a href="javascript:void" class="icon" data-toggle="modal" data-target="#phoneModal" onclick="setPhoneNumber('+971 50 100 2025')">
                    <img src="https://s3.us-west-2.amazonaws.com/royoorders2.0-assets/prods/sVIcc43P5Nki7WfYPnHmuhcy11OzGR6HK6JyYlTD.png" alt="Phone" class="green-icon">
                 </a>
              
                 <a href="mailto:Shehab.hassani@areednow.com" class="icon">
                    <img src="https://s3.us-west-2.amazonaws.com/royoorders2.0-assets/prods/CaIH17dSkHPZCrJlkiY2f9Apvyzaa8Pacg1GDIql.png" alt="Email" width="40px" class="green-icon">
                 </a>
              
                 <a href="javascript:void" class="icon">
                    <img src="https://s3.us-west-2.amazonaws.com/royoorders2.0-assets/prods/2u3QlO5sjmnpqSr3jAXa6e3p2Sd3DsTFODHjkVD9.png" alt="Chatbot" width="40px" class="green-icon">
                 </a>
            </div> -->
        </div>
        {{-- <div class="contact_us">
            <h6>Talk to our contact sales</h6>
            <p>Have question about business? Fill out the form and send us your query. We will revert back to you shortly.</p>
            <form action="{{ route('contact.store') }}" method="POST">
                @csrf
                <label>
                    <img src="{{URL::asset('/assets/icons/user2.png')}}" alt="no image">
                    <input type="text" placeholder="Enter your name" id="name" name="name" required>
                    @error('name')
                    <span style="color: red;">{{ $message }}</span>
                    @enderror
                </label>
                <label>
                    <img src="{{URL::asset('/assets/icons/email1.png')}}" alt="no image">
                    <input type="email" placeholder="Enter your email" id="email" name="email" required>
                </label>
                <!-- <label>
                    <img src="{{URL::asset('/assets/areednow/call.png')}}" alt="no image">
                    <input type="number" placeholder="Enter your phone number" id="phone_number" name="phone_number">
                </label> -->
                <textarea id="description" placeholder="Description" name="description" rows="4" cols="50" required></textarea>
                <button type="submit" class="mt-3">Send Query</button>
            </form>
        </div> --}}
        <div class="contact-container">
            <h6>Talk to Our Contact Sales</h6>
            <p>Have questions about business? Fill out the form and send us your query. We will get back to you shortly.</p>
    
            <form action="{{ route('contact.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <img src="{{URL::asset('/assets/icons/user2.png')}}" alt="User">
                    <input type="text" placeholder="Enter your name" id="name" name="name" required>
                    @error('name')
                    <span style="color: red;">{{ $message }}</span>
                    @enderror
                </div>
    
                <div class="form-group">
                    <img src="{{URL::asset('/assets/icons/email1.png')}}" alt="Email">
                    <input type="email" placeholder="Enter your email" id="email" name="email" required>
                </div>
    
                <div class="form-group">
                    <textarea id="description" placeholder="Enter your message" name="description" rows="4" required></textarea>
                </div>
    
                <button type="submit" class="btn darkgreen w-100 mb-3 p-2 text-white rounded" >Send Query</button>
            </form>
        </div>
    
    </div>
    <div class="modal fade" id="phoneModal" tabindex="-1" role="dialog" aria-labelledby="phoneModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="phoneModalLabel" style="margin-left: 29%;font-size: x-large;">Contact Number</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="phone-number"  style="margin-left: 33%;font-size: larger;">Phone Number will be shown here</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script>
    function setPhoneNumber(phoneNumber) {
        document.getElementById("phone-number").innerText = phoneNumber;
    }
</script>
@endsection