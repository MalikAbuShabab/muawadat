var uppy = new Uppy.Uppy()
.use(Uppy.Dashboard, {
  inline: true,
  target: '#uppy-progress',
  hidePoweredBy: true, // Remove "Powered by Uppy" message
  

})
.use(Uppy.Webcam, { target: Uppy.Dashboard })
.use(Uppy.ImageEditor, { target: Uppy.Dashboard })
.use(Uppy.ScreenCapture, { target: Uppy.Dashboard })
.use(Uppy.AwsS3, {
    // Configure your AWS S3 settings
    companionUrl: '/', // Set companionUrl to '/' since we are not using a companion server
    getUploadParameters(file) {
        return new Promise((resolve, reject) => {
            var room_id = $('.send_message').attr('data-id');
            var roomIdText = $(`#room_${room_id}`).attr('data-roomid');
            const formData = new FormData();
            formData.append('file', file.data);
    
            let progress = 0;
            const progressInterval = setInterval(() => {
                progress += 5;
                if (progress < 105) {
                    $('.uppy-StatusBar-statusPrimary').html(`Uploading... ${progress}%`);
                }
            }, 40);
    
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    
            $.ajax({
                url: '/common/chat/uploadChatMedia',
                type: 'POST',
                data: formData,
                contentType: false, 
                processData: false,
                success: function(response) {
                    clearInterval(progressInterval);
                    
                    // ✅ Force final progress to 100%
                    $('.uppy-StatusBar-statusPrimary').html(`Upload complete 100%`);
    
                    var media = {
                        is_media : true,
                        mediaUrl: response.url,
                        thumbnailUrl: response.url,
                        mediaType: 1,
                    };
    
                    sendMessage('', room_id, roomIdText, media);
                    
                    // Close dashboard
                    $('.uppy-DashboardContent-back').trigger('click');
                    $('body').toggleClass('push_to_side');
                },
                error: function(xhr, status, error) {
                    clearInterval(progressInterval);
                    console.error('File upload failed:', error);
                    $('.uppy-StatusBar-statusPrimary').html('Upload failed');
                }
            });
        });
    }
    
})
uppy.on('complete', (result) => {
    console.log('my result');
    console.log(result);
    var room_id = $('.send_message').attr('data-id');
    var roomIdText = $(`#room_${room_id}`).attr('data-roomid');

    if(! room_id ){
        return;
        
    }
        if(result.successful){
            var media = {
                is_media :true,
                mediaUrl:data.response.uploadURL,
                thumbnailUrl:data.preview,
                mediaType:data.type,
            }

            console.log(media, 'finding media');
            //media.is_media = true;
             sendMessage('',room_id,roomIdText,media)
            
            // $.each( result.successful, function( key, data ) {

            //     //if(status)
                
            //         var media = {
            //             is_media :true,
            //             mediaUrl:data.response.uploadURL,
            //             thumbnailUrl:data.preview,
            //             mediaType:data.type,
            //         }

            //         console.log(media, 'finding media');
            //         //media.is_media = true;
            //          sendMessage('',room_id,roomIdText,media)
            // })
        }
    

    //console.log('Upload complete! We’ve uploaded these files:', result.successful)
  })


function openMediaNav() {
    $('body').toggleClass('push_to_side');
}