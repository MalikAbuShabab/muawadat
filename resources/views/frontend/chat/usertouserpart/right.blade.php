<div class="col-lg-7 col-xl-8 px-0 flex-column bg-white rounded-lg" id="rightChat" style="display: none;">
	{{-- <div class="px-4 py-4" style="border-bottom: 1px solid rgb(238, 238, 238);">
		<h2 id="roomName" class="font-size-15 mb-0"></h2>
	</div> --}}
	<div class="conversation-head row py-3 px-3 mx-0 mb-2">
		<div class="col-4 alOrderDetailsBox pr-0">
			<p class="alOrderDetails m-0">Product <span id="order_num"></span></p>
			<p class="alVendorDetails m-0">Vendor <span id="vendor_name"></span></p>
			<p class="alAmountDetails m-0">Product Amount <span id="order_vendor_price"></span></p>
		</div>
		<div class="col-8 pl-0">
			<div class="d-flex align-items-center justify-content-between user_data">
				{{-- <div class="alPhoneNumberDetails">
					<ul class="p-0 m-0 d-lg-flex align-items-center text-lg-left text-center">
						<li class="mr-xl-2"><img class="rounded-circle userImg" src="images/avatar-5.jpg"></li>
						<li><span class="alUserName"> Admin </span><p class="m-0 alPhoneNumber">+1 225252525</p></li>
					</ul>
				</div>
				<div class="alPhoneNumberDetails">
					<ul class="p-0 m-0 d-lg-flex align-items-center text-lg-left text-center">
						<li class="mr-xl-2"><img class="rounded-circle userImg" src="images/avatar-5.jpg"></li>
						<li><span class="alUserName">John </span><p class="m-0 alPhoneNumber">+1 225252525</p></li>
					</ul>
				</div>
				<div class="alPhoneNumberDetails">
					<ul class="p-0 m-0 d-lg-flex align-items-center text-lg-left text-center">
						<li class="mr-xl-2"><img class="rounded-circle userImg" src="images/avatar-5.jpg"></li>
						<li><span class="alUserName">Meo </span><p class="m-0 alPhoneNumber">+1 225252525</p></li>
					</ul>
				</div> --}}
			</div>
		</div>


	</div>
	<div class="chat-box-wrapper position-relative d-flex chatitem">
		<div id="chatHistory" class="px-4 pt-3 chat-box col-12 ">
			{{-- <div class="d-flex justify-content-between">
				<div style="flex: 1 1 0%;"></div>
				<div class="text-right mb-4">
					<div class="conversation-list d-inline-block bg-light px-3 py-2" style="border-radius: 12px;">
						<div class="ctext-wrap">
							<div class="conversation-name text-left text-primary mb-1" style="font-weight: 600;">Pablo</div>
							<p class="text-left">Hello!</p>
							<p class="chat-time mb-0">
								<svg width="12" height="12" class="prefix__MuiSvgIcon-root prefix__jss80 prefix__MuiSvgIcon-fontSizeLarge" viewBox="0 0 24 24" aria-hidden="true">
									<path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"></path>
									<path d="M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z"></path>
								</svg> 3:30 PM </p>
						</div>
					</div>
				</div>
			</div>
			<div class="d-flex justify-content-between">
				<div class="text-left mb-4" style="width: 50%;">
					<div class="conversation-list d-inline-block px-3 py-2" style="border-radius: 12px; background-color: rgba(85, 110, 230, 0.1);">
						<div class="ctext-wrap">
							<div class="conversation-name text-primary d-flex align-items-center mb-1">
								<div class="mr-2" style="font-weight: 600; cursor: pointer;">Mary</div>
								<div class="rounded-circle bg-gray" style="width: 7px; height: 7px; opacity: 1;"></div>
							</div>
							<p class="text-left">Hi, How are you? What about our next meeting?</p>
							<p class="chat-time mb-0">
								<svg width="12" height="12" class="prefix__MuiSvgIcon-root prefix__jss80 prefix__MuiSvgIcon-fontSizeLarge" viewBox="0 0 24 24" aria-hidden="true">
									<path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"></path>
									<path d="M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z"></path>
								</svg> 3:34 PM </p>
						</div>
					</div>
				</div>
				<div style="flex: 1 1 0%;"></div>
			</div> --}}
			{{-- <div class="d-flex justify-content-between">
				<div class="text-left mb-4" style="width: 50%;">
					<div class="conversation-list d-inline-block px-3 py-2" style="border-radius: 12px; background-color: rgba(85, 110, 230, 0.1);">
						<div class="ctext-wrap">
							<div class="conversation-name text-primary d-flex align-items-center mb-1">
								<div class="mr-2" style="font-weight: 600; cursor: pointer;">Mary</div>
								<div class="rounded-circle bg-gray" style="width: 7px; height: 7px; opacity: 1;"></div>
							</div>
							<p class="text-left">Yeah everything is fine</p>
							<p class="chat-time mb-0">
								<svg width="12" height="12" class="prefix__MuiSvgIcon-root prefix__jss80 prefix__MuiSvgIcon-fontSizeLarge" viewBox="0 0 24 24" aria-hidden="true">
									<path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"></path>
									<path d="M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z"></path>
								</svg> 3:37 PM </p>
						</div>
					</div>
				</div>
				<div style="flex: 1 1 0%;"></div>
			</div> --}}
			{{-- <div class="d-flex">
				<div class="text-left mb-4" style="width: 50%;">
					<div class="conversation-list d-inline-block px-3 py-2" style="border-radius: 12px; background-color: rgba(85, 110, 230, 0.1);">
						<div class="ctext-wrap">
							<div class="conversation-name text-primary d-flex align-items-center mb-1">
								<div class="mr-2" style="font-weight: 600; cursor: pointer;">Alex</div>
								<div class="rounded-circle bg-gray" style="width: 7px; height: 7px; opacity: 1;"></div>
							</div>
							<p class="text-left">Next meeting tomorrow 10.00AM</p>
							<p class="chat-time mb-0">
								<svg width="12" height="12" class="prefix__MuiSvgIcon-root prefix__jss80 prefix__MuiSvgIcon-fontSizeLarge" viewBox="0 0 24 24" aria-hidden="true">
									<path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"></path>
									<path d="M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z"></path>
								</svg> 3:40 PM </p>
						</div>
					</div>
				</div>
				<div style="flex: 1 1 0%;"></div>
			</div> --}}
			{{-- <div class="d-flex">
				<div class="text-left mb-4" style="width: 50%;">
					<div class="conversation-list d-inline-block px-3 py-2" style="border-radius: 12px; background-color: rgba(85, 110, 230, 0.1);">
						<div class="ctext-wrap">
							<div class="conversation-name text-primary d-flex align-items-center mb-1">
								<div class="mr-2" style="font-weight: 600; cursor: pointer;">Alex</div>
								<div class="rounded-circle bg-gray" style="width: 7px; height: 7px; opacity: 1;"></div>
							</div>
							<p class="text-left">Wow that's great</p>
							<p class="chat-time mb-0">
								<svg width="12" height="12" class="prefix__MuiSvgIcon-root prefix__jss80 prefix__MuiSvgIcon-fontSizeLarge" viewBox="0 0 24 24" aria-hidden="true">
									<path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"></path>
									<path d="M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z"></path>
								</svg> 3:44 PM </p>
						</div>
					</div>
				</div>
				<div style="flex: 1 1 0%;"></div>
			</div> --}}
		</div>
	</div>
	<div class="p-3 chat-input-section">
		<form class="row">
			<div class="col">
				<div class="position-relative">
					<input id="message_box" type="text" placeholder="Enter Message..." class="form-control chat-input" value="" autocomplete="off">
					<!-- Send button inside input -->
					<a href="javascript:void(0)" data-id="" class="send_message input-send-icon" style="display:none;">
						<div class="send-icon-wrapper" style="background:#015158; width:34px; height:34px; border-radius:50%; display:flex; align-items:center; justify-content:center;">
							<svg width="24" height="24" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M22 2L11 13" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M22 2L15 22L11 13L2 9L22 2Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</div>
					</a>
				</div>
			</div>
			<div class="col-auto d-flex align-items-center">
				<!-- Join button -->
				<a href="javascript:void(0)" class="btn btn-primary btn-rounded chat-send w-md join_room me-2" data-id="">
					<span class="d-none d-sm-inline-block mr-2">Join</span>
					<svg width="13" height="13" viewBox="0 0 24 24" tabindex="-1">
						<path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" fill="white"></path>
					</svg>
				</a>

				<!-- Attachment button -->
				<a href="javascript:void(0)" class="me-3" style="font-size:24px;color:#015158;" onclick="openMediaNav()">
					<i class="fa fa-paperclip" aria-hidden="true"></i>
				</a>
			</div>
		</form>
	</div>
</div>
<script>
	document.addEventListener("DOMContentLoaded", function () {
		 
    let messageInput = document.getElementById("message_box");
    let sendButton = document.querySelector(".send_message");

    messageInput.addEventListener("input", function () {
        if (this.value.trim() !== "") {
            sendButton.style.display = "inline-block"; // Show button
        } else {
            sendButton.style.display = "none"; // Hide button
        }
    });

	messageInput.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Stop page reload
            // sendMessage(); // Call send message function
        }
    });

});

// function sendMessage() {
//     let messageInput = document.getElementById("messageInput");
//     let sendButton = document.querySelector(".send_message");

//     let message = messageInput.value.trim();
//     if (message === "") return;

//     // Example: Send message via WebSocket
//     console.log("Sending message:", message);
    
//     // Clear input after sending
//     messageInput.value = "";
//     sendButton.classList.add("disabled"); // Disable button again
// }
</script>
