<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class DatabaseFailover
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $defaultConnection = config('database.default');
        $fallbackConnection = env('FALLBACK_DB_CONNECTION');

        // Jika fallback tidak di-set, lanjutkan seperti biasa
        if (! $fallbackConnection) {
            return $next($request);
        }

        try {
            // Coba ping database utama
            DB::connection($defaultConnection)->getPdo();
        } catch (\Exception $e) {
            // Jika gagal (biasanya karena connection refused / down), switch koneksi
            Log::warning("Database utama ({$defaultConnection}) mati. Melakukan failover ke {$fallbackConnection}. Error: " . $e->getMessage());
            
            // Ubah konfigurasi secara dinamis untuk request ini
            Config::set('database.default', $fallbackConnection);
            
            // Re-purge connection cache agar laravel mem-build ulang PDO dengan koneksi baru
            DB::purge($defaultConnection);
        }

        return $next($request);
    }
}
