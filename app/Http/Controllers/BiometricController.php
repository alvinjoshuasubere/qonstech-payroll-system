<?php

use App\Models\Biometrics;
use Illuminate\Http\Request;

class BiometricController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'attendance_code' => 'required|string',
            'fingerprint_data' => 'required|string',
        ]);

        // Store attendance data
        Biometrics::create([
            'attendance_code' => $request->attendance_code,
            'fingerprint_data' => $request->biometric_data,
        ]);

        return response()->json(['message' => 'Biometric data stored successfully!'], 200);
    }
}
