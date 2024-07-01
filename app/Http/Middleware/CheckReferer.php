<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckReferer
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
        $allowedReferers = ['127.0.0.1', '10.252.1.25']; // Daftar referer yang diizinkan

        $referer = $request->headers->get('referer');

        Log::info('Referer:', ['referer' => $referer]);

        // Pastikan referer ada
        if ($referer) {
            $refererHost = parse_url($referer, PHP_URL_HOST);
            Log::info('Referer Host:', ['refererHost' => $refererHost]);

            // Periksa apakah referer ada di dalam daftar yang diizinkan
            if (!in_array($refererHost, $allowedReferers)) {
                return response()->json(['message' => 'Anda tidak memiliki akses!'], 403);
            }
        } else {
            // Jika tidak ada referer, Anda bisa memutuskan untuk menolak akses atau mengizinkannya
            return response()->json(['message' => 'Anda tidak memiliki akses!'], 403);
        }

        return $next($request);
    }
}
