<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.required' => 'Nama lengkap harus diisi.',
            'name.max' => 'Nama lengkap maksimal 255 karakter.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar. Gunakan email lain.',
            'password.required' => 'Password harus diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        try {
            $user = User::create([
                'nik' => 'USER' . time(), // Generate NIK otomatis
                'fullname' => $request->name,
                'tempat_tanggal_lahir' => now()->subYears(20)->format('Y-m-d'), // Default 20 tahun lalu
                'alamat_tinggal' => 'Belum diisi', // Default
                'pendidikan_terakhir' => 'Belum diisi', // Default
                'jenis_kelamin' => 'Laki-laki', // Default
                'pekerjaan' => 'Belum diisi', // Default
                'usia' => 20, // Default
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'user',
            ]);

            event(new Registered($user));

            Auth::login($user);

            return redirect(route('dashboard', absolute: false))
                ->with('success', 'Selamat datang! Akun Anda berhasil dibuat. Silakan lengkapi profil Anda.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat akun: ' . $e->getMessage());
        }
    }
}
