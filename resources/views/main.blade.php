@extends('template.layout')


@section('styles')
    <style>

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

        /* .camera-view-placeholder, .image-placeholder{
            background-color: black;
        } */
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

                <div>
                    <button id="test-button">test</button>
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

        document.getElementById('test-button').addEventListener('click', () => {
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            let imageDataUrl = canvas.toDataURL();
            if (count == 0){
                document.getElementById('image-1').src = imageDataUrl;
            } else if (count == 1){
                document.getElementById('image-2').src = imageDataUrl;
            } else if (count == 2){
                document.getElementById('image-3').src = imageDataUrl;
            } else if (count == 3){
                document.getElementById('image-4').src = imageDataUrl;
                ajControl(imageDataUrl);
            }

            count++;

        });

        function saveImagesToStorage(){
            imageContainers.forEach(function(imageContainer, index) {
                console.log('downloading');
                var a = document.createElement('a');
                a.href = imageContainer.src;
                a.download = 'image-' + (index + 1) + '.png';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            })
        }
    </script>
@endsection