<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Karyawan;
use App\Helpers\CaptchaHelper;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        \Log::info('Register payload', $request->only([
            'name','email','nik','provinsi_id','kabupaten_id','kecamatan_id','kelurahan_id','ruangan_id','profesi_id','jenis_kelamin'
        ]));
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            // Password: min 6, at least one uppercase and one number
            'password' => ['required', 'confirmed', 'min:6', 'regex:/^(?=.*[A-Z])(?=.*\d).+$/'],
            'nik' => ['required', 'string', 'max:16', 'unique:karyawan,nik'],
            'alamat' => ['required', 'string'],
            'provinsi_id' => ['required', 'exists:provinsi,id'],
            'kabupaten_id' => ['required', 'exists:kabupaten,id'],
            'kecamatan_id' => ['required', 'exists:kecamatan,id'],
            'kelurahan_id' => ['required', 'exists:kelurahan,id'],
            'alamat_detail' => ['required', 'string', 'max:500'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'ruangan_id' => ['required', 'exists:ruangan,id'],
            'profesi_id' => ['required', 'exists:profesi,id'],
            'captcha' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    $captchaHelper = app(CaptchaHelper::class);
                    if (!$captchaHelper->validate($value, session('captcha_answer'))) {
                        $fail('Jawaban CAPTCHA tidak benar.');
                    }
                },
            ],
        ]);

        // Clear CAPTCHA session after successful validation
        session()->forget('captcha_answer');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'karyawan',
        ]);

        // Create complete karyawan record
        Karyawan::create([
            'user_id' => $user->id,
            'nik' => $request->nik,
            'alamat' => $request->alamat,
            'provinsi_id' => $request->provinsi_id,
            'kabupaten_id' => $request->kabupaten_id,
            'kecamatan_id' => $request->kecamatan_id,
            'kelurahan_id' => $request->kelurahan_id,
            'alamat_detail' => $request->alamat_detail,
            'jenis_kelamin' => $request->jenis_kelamin,
            'ruangan_id' => $request->ruangan_id,
            'profesi_id' => $request->profesi_id,
            'status_kelengkapan' => 'tahap1', // Tahap 1 completed
        ]);

        event(new Registered($user));

        // Don't auto-login, redirect to success page for admin activation
        return redirect()->route('registration.success')->with('success', 'Pendaftaran berhasil! Silakan tunggu aktivasi dari administrator.');
    }
}
