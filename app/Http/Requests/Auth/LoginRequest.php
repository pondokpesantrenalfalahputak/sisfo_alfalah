<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\Santri; // Pastikan model Santri di-import

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Input login (bisa email atau NISN)
            'login_id' => ['required', 'string'], 
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $loginId = $this->input('login_id');
        $password = $this->input('password');
        $attemptSuccessful = false;

        // 1. Cek apakah input adalah EMAIL
        if (filter_var($loginId, FILTER_VALIDATE_EMAIL)) {
            $credentials = [
                'email' => $loginId,
                'password' => $password,
            ];
            $attemptSuccessful = Auth::attempt($credentials, $this->boolean('remember'));

        } 
        // 2. Jika input BUKAN email, asumsikan itu adalah NISN Santri
        else {
            // Lakukan lookup ID Wali Santri (User ID) berdasarkan NISN di tabel Santri
            $santri = Santri::where('nisn', $loginId)->first();

            // Jika santri ditemukan dan memiliki wali
            if ($santri && $santri->wali_santri_id) {
                
                // Coba login menggunakan ID Wali Santri (user ID) dan Password
                $credentials = [
                    'id' => $santri->wali_santri_id,
                    'password' => $password,
                ];
                
                // Menggunakan Auth::attempt untuk memverifikasi password terhadap user ID
                $attemptSuccessful = Auth::attempt($credentials, $this->boolean('remember'));
                
            } else {
                // Santri dengan NISN ini tidak ditemukan atau belum memiliki wali
                $attemptSuccessful = false;
            }
        }
        
        // 3. Penanganan Kegagalan
        if (! $attemptSuccessful) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                // Pesan error diarahkan ke field input utama 'login_id'
                'login_id' => trans('Email/NIS dan Password salah.'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login_id' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        // Gunakan 'login_id' untuk throttle key
        return Str::transliterate(Str::lower($this->string('login_id')).'|'.$this->ip());
    }
}