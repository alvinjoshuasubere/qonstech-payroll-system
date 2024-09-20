<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biometric Capture</title>
    <script>
        async function captureBiometric() {
            // Simulate capturing biometric from Digital Persona SDK (replace with actual integration)
            const biometricData = "sample_fingerprint_data";  // Replace this with real captured data
            const attendanceCode = document.getElementById('attendance_code').value;

            if (!attendanceCode) {
                alert('Please enter an attendance code.');
                return;
            }

            // Send the data to the backend (Laravel API)
            const response = await fetch('http://your-laravel-url/api/attendance/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    attendance_code: attendanceCode,
                    biometric_data: biometricData,
                }),
            });

            const result = await response.json();
            alert(result.message);
        }
    </script>
</head>
<body>
    <div>
        <h2>Capture Biometric</h2>
        <label for="attendance_code">Attendance Code:</label>
        <input type="text" id="attendance_code" placeholder="Enter Attendance Code" required>
        <button onclick="captureBiometric()">Capture Biometric</button>
    </div>
</body>
</html>
