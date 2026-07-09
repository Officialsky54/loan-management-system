<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Middleware\TrustProxies as Middleware;

class TrustProxies extends Middleware
{
    protected $proxies = '*';
    protected $headers =
        'HEADER_CLIENT_IP|HTTP_CLIENT_IP|' .
        'HEADER_X_FORWARDED_FOR|HTTP_X_FORWARDED_FOR|' .
        'HEADER_X_FORWARDED_HOST|HTTP_X_FORWARDED_HOST|' .
        'HEADER_X_FORWARDED_PROTO|HTTP_X_FORWARDED_PROTO|' .
        'HEADER_X_FORWARDED_PORT|HTTP_X_FORWARDED_PORT';
}
