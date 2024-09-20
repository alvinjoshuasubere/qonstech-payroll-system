<?php

use App\Models\Biometrics;
use Illuminate\Http\Request;

class BiometricController extends Controller
{
    public function captureFingerprint(Request $request)
    {
        // Load SDK and start the fingerprint capture process
        $digitalPersonaSDK = new \DigitalPersona\FingerprintCapture();

        // Start capturing the fingerprint
        $fingerprintData = $digitalPersonaSDK->capture();
        
        // Handle the fingerprint data and store it in the database
        if ($fingerprintData) {
            $encodedFingerprint = base64_encode($fingerprintData);
            Biometrics::create([
                'attendance_code' => $request->user()->id,
                'fingerprint_data' => $encodedFingerprint,
            ]);
        
            return response()->json(['message' => 'Fingerprint captured and stored successfully.']);
        } else {
            return response()->json(['message' => 'Fingerprint capture failed.'], 500);
        }
    }
}
