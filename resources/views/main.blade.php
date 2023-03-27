@extends('template.layout')


@section('styles')
    <style>

        body{
            background-image: url("/img/bg1.png");
            background-size: cover;
        }

        .camera-container, .image-container {
            
            position: relative;
            overflow: hidden;
            padding-top: 56.25%; /* 16:9 aspect ratio */
            height: 0;
            
        }   

        .image-container{
            margin-bottom: 20px;
        }

        .camera-container{}
        
        .camera-container video, .image-container img {
            
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-hidden{
            display: none;
            position: relative;
            overflow: hidden;
            padding-top: 56.25%; /* 16:9 aspect ratio */
            height: 0;
        }

        .image-hidden img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .image-placeholder{
            background-image: url("/img/strip.png");
            background-size: cover;
        }
    </style>
@endsection

@section('content')
    {{-- Container for Camera --}}
    <div class="container">

        <div class="row">

            <div class="col-md-9">
                <div class="camera-container align-middle">
                    <video id="camera-view" class="camera-view-placeholder"></video>
                    <canvas id="canvas"></canvas>
                </div>
            </div>

            <div class="col-md-3 align-items-center">
                <div class="row">
                    <div class="col-md-12">
                        <div class="image-container">
                            <img id="image-1" class="image-placeholder">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="image-container">
                            <img id="image-2" class="image-placeholder">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="image-container">
                            <img id="image-3" class="image-placeholder">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="image-container">
                            <img id="image-4" class="image-placeholder">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9 align-items-center">
        <div class="row">
            <div class="col-md-12">
                <div class="image-hidden">
                    <img id="image-h1" class="image-placeholder">
                </div>
            </div>
            <div class="col-md-12">
                <div class="image-hidden">
                    <img id="image-h2" class="image-placeholder">
                </div>
            </div>
            <div class="col-md-12">
                <div class="image-hidden">
                    <img id="image-h3" class="image-placeholder">
                </div>
            </div>
            <div class="col-md-12">
                <div class="image-hidden">
                    <img id="image-h4" class="image-placeholder">
                </div>
            </div>
        </div>
    </div>
    <script>
        // Get the saved camera setting from local storage
        var savedCameraSetting = localStorage.getItem("camera");
        

        // Set the selected camera as the video source
        if (savedCameraSetting) {
            var constraints = { video: { deviceId: savedCameraSetting } };
        } else {
            var constraints = { video: true };
        }

        // Get the video element and start the stream
        var video = document.getElementById("camera-view");
        var canvas = document.getElementById("canvas");
        var context = canvas.getContext("2d");
        var count = 0;
        var imageContainers = [
            document.getElementById('image-1'),
            document.getElementById('image-2'),
            document.getElementById('image-3'),
            document.getElementById('image-4')
        ]

        navigator.mediaDevices
        .getUserMedia(constraints)
        .then(function (stream) {
            video.srcObject = stream;
            video.play();
        })
        .catch(function (error) {
            console.error("Error getting video stream: " + error);
        });

        video.addEventListener('loadedmetadata', function() {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
        });

        document.addEventListener('keydown', function(event) {
            if (event.code === 'Space') {
                // perform some action here
                console.log('The spacebar was pressed!');
                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                const imageDataUrl = canvas.toDataURL();

                if (count == 0){
                    document.getElementById('image-1').src = imageDataUrl;
                    document.getElementById('image-h1').src = imageDataUrl;
                } else if (count == 1){
                    document.getElementById('image-2').src = imageDataUrl;
                    document.getElementById('image-h2').src = imageDataUrl;
                } else if (count == 2){
                    document.getElementById('image-3').src = imageDataUrl;
                    document.getElementById('image-h3').src = imageDataUrl;
                } else if (count == 3){
                    document.getElementById('image-4').src = imageDataUrl;
                    document.getElementById('image-h4').src = imageDataUrl;
                    setTimeout(function() {
                        saveImagesToStorage();
                        stripsGenerator();
                    }, 1000);
                    setTimeout(function() {
                        location.reload();
                    }, 5000);
                }
                count++;
            }
        });

        function stripsGenerator() {
            const images = document.querySelectorAll('.image-hidden img');
            const cv2 = document.createElement('canvas');

            cv2.width = images[0].width;
            cv2.height = images[0].height * images.length;

            let x = 0;
            for (let i = 0; i < images.length; i++) {
                const img = images[i];
                cv2.getContext('2d').drawImage(img, 0, x, img.width, img.height);
                x += img.height;
            }

            cv2.toBlob(function(blob) {
                var savedNumber = parseInt(localStorage.getItem("savedNumber"));
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                var newnums = parseInt(savedNumber + 1);
                a.download = 'S4M-'+ newnums +'.png';
                localStorage.setItem('savedNumber', newnums);
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            }, 'image/png');
        }


        function saveImagesToStorage(){
            imageContainers.forEach(function(imageContainer, index) {
                var savedNumber = parseInt(localStorage.getItem("savedNumber"));
                var a = document.createElement('a');
                a.href = imageContainer.src;
                var newnums = parseInt(savedNumber + 1);
                console.log(savedNumber);
                a.download = 'S4M-' + newnums + '.png';
                localStorage.setItem('savedNumber', newnums);
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            })
        }

        
    </script>
@endsection
