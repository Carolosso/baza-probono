<?php

namespace App\Http\Controllers;


use PragmaRX\Google2FA\Google2FA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
//use Illuminate\Support\Facades\Storage;
//use Illuminate\Support\Facades\Log; // Add logging
//use Carbon\Carbon; // Import the Carbon class


class TwoFactorController extends Controller
{
    public function setup()
    {
        $google2fa = new Google2FA();
        $user = backpack_user();
        $email = $user->email;
        $secret = $google2fa->generateSecretKey();
        // Generate OTP URL
        $otpAuthUrl = 'otpauth://totp/Adopcja_Serca_Baza:'.$email.'?secret=' . $secret;

        // Create the QR code
        $qrCode = new QrCode(
            data: $otpAuthUrl,
            size: 300
        );

        // Create a PNG writer
        $writer = new PngWriter();

        // Write the QR code to a string
        $qrCodeResult = $writer->write($qrCode);

        $dataUri = $qrCodeResult->getDataUri();


        return view('auth.2fa.setup', compact('dataUri', 'secret'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'secret' => 'required',
        ]);

        $user = backpack_user();
        $user->google2fa_secret = $request->input('secret');
        $user->two_factor_enabled = true;
        $user->save();

        return redirect()->route('admin.dashboard')->with('status', '2FA enabled successfully!');
    }
    public function verify()
    {
        return view('auth.2fa.verify');
    }

    public function check(Request $request)
    {

        // Sanitize the input to remove any non-numeric characters
        $otp = preg_replace('/\D/', '', $request->input('one_time_password'));

        // Validate the sanitized OTP
        $request->merge(['one_time_password' => $otp]);

        $request->validate([
            'one_time_password' => 'required|numeric',
        ]);

        $google2fa = new Google2FA();
        $user = backpack_user();


        // Log the user secret and OTP to debug
        //Log::info('Google2FA Secret: ' . $user->google2fa_secret);
        //Log::info('OTP Provided: ' . $request->one_time_password);
        /* $serverTime = now();
        Log::info('Server Time: ' . $serverTime); */

        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->one_time_password,3);
        
        if ($valid) {
            $user->two_factor_verified = true;
            $user->two_factor_confirmed_at = now();
            $user->save();


            // Mark session as authenticated
            $request->session()->put('authenticated_session', true);

            return redirect()->route('admin.dashboard')->with('status', '2FA verification successful!');
        }

        return back()->withErrors(['one_time_password' => 'Błędny kod. Spróbuj ponownie.']);
    }
}
