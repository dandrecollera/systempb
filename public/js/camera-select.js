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

navigator.mediaDevices
    .getUserMedia(constraints)
    .then(function (stream) {
        video.srcObject = stream;
        video.play();
    })
    .catch(function (error) {
        console.error("Error getting video stream: " + error);
    });

// Get the canvas element and set its dimensions to match the video element
var canvas = document.getElementById("canvas");
var context = canvas.getContext("2d");

video.addEventListener("loadedmetadata", function () {
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
});

// Add event listener to the capture button
var captureBtn = document.getElementById("capture-btn");
captureBtn.addEventListener("click", function () {
    // Draw the current video frame onto the canvas
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    // Save the captured image as a data URL to local storage
    var dataURL = canvas.toDataURL();
    localStorage.setItem("capturedImage", dataURL);
});
