<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Konfigurasi aksi Fortify standar
        |--------------------------------------------------------------------------
        */
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        /*
        |--------------------------------------------------------------------------
        | Rate limiter "login" dan "two-factor"
        |--------------------------------------------------------------------------
        | - login: max 5 percobaan per menit per kombinasi email + IP
        | - two-factor: contoh default (kalau kamu pakai 2FA Fortify)
        */
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->input(Fortify::username());

            // 5 percobaan per menit per email + IP
            return [
                Limit::perMinutes(1, 5)->by($email . $request->ip()),
            ];
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return [
                Limit::perMinutes(1, 5)->by((string) $request->session()->get('login.id')),
            ];
        });

        /*
        |--------------------------------------------------------------------------
        | Custom authenticateUsing
        |--------------------------------------------------------------------------
        | - cek user
        | - tolak kalau is_blocked = true
        | - hitung gagal login di kolom failed_logins
        | - kalau gagal >= 5 → is_blocked = true
        */
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();

            // kalau tidak ada user, biarkan Fortify kasih pesan standar
            if (! $user) {
                return null;
            }

            // kalau sudah diblokir → langsung tolak, meskipun password benar
            if ($user->is_blocked) {
                throw ValidationException::withMessages([
                    Fortify::username() => __('Akun Anda diblokir karena terlalu banyak percobaan login. Silakan hubungi Super Admin.'),
                ]);
            }

            // kalau password benar
            if (Hash::check($request->password, $user->password)) {
                // reset counter gagal jika sebelumnya pernah gagal
                if ($user->failed_logins > 0) {
                    $user->failed_logins = 0;
                    $user->save();
                }

                return $user;
            }

            // kalau password salah → tambah counter
            $user->failed_logins = ($user->failed_logins ?? 0) + 1;

            // kalau sudah 5x → blokir
            if ($user->failed_logins >= 5) {
                $user->is_blocked = true;
                $user->blocked_at = now();
                // $user->blocked_by bisa diisi nanti oleh super admin
            }

            $user->save();

            // return null → Fortify akan kirim pesan "These credentials do not match..."
            return null;
        });
    }
}
