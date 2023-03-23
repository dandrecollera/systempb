<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Settings</title>

    <script src="{{ asset('js/jquery-3.6.4.min.js') }}"></script>
</head>
<body>
    <h1>Camera Settings</h1>
    <select id="camera-select">
    </select>
    <button id="save-button">Save Settings</button>



    <script>
        $(document).ready(function() {
			// Get available camera devices
			navigator.mediaDevices.enumerateDevices()
				.then(function(devices) {
					// Filter video devices
					var videoDevices = devices.filter(function(device) {
						return device.kind === 'videoinput';
					});

					// Populate dropdown with video devices
					$.each(videoDevices, function(index, device) {
						$('#camera-select').append('<option value="' + device.deviceId + '">' + device.label + '</option>');
					});
				});

			// Save selected camera to local storage
			$('#save-button').click(function() {
				var selectedCamera = $('#camera-select').val();
				if(selectedCamera) {
					localStorage.setItem('camera', selectedCamera);
					alert('Camera settings saved!');
				}
			});
		});
    </script>
</body>
</html>