
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fingerprint Capture</title>
</head>

<body>
    <h1>Capture Fingerprint</h1>

    <form action="/biometric/capture" method="POST">
        @csrf
        <button type="submit">Start Fingerprint Capture</button>
    </form>
</body>

</html>