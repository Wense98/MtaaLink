<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PhoneVerificationController extends Controller
{
    public function send(Request $request)
    {
        $request->validate(['phone' => ['required']]);

        // For now: create a stub OTP '1234' and log it. In production, integrate SMS provider.
        $otp = '1234';
        Log::info('OTP for '.$request->phone.': '.$otp);

        // You could store the OTP in cache or DB. Here we return a success response for dev.
        return response()->json(['status' => 'otp_sent', 'otp' => $otp]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'phone' => ['required'],
            'code' => ['required'],
        ]);

        // In dev we accept '1234' as the correct code
        if ($request->code !== '1234') {
            return response()->json(['status' => 'invalid_code'], 422);
        }

        $user = User::where('phone', $request->phone)->first();
        if (! $user) {
            return response()->json(['status' => 'user_not_found'], 404);
        }

        $user->phone_verified_at = now();
        $user->save();

        return response()->json(['status' => 'verified']);
    }
}
