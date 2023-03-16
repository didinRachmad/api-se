<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $addHttpCookie = true;

    protected $except = [
        // '/getDataByKodeCustomer', // tambahkan route yang ingin dikecualikan di sini
        // '/getDataByRuteId', // tambahkan route yang ingin dikecualikan di sini
        // '/RuteId/getOrder', // tambahkan route yang ingin dikecualikan di sini
    ];
}
