<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/1907491983:AAGY5f9Cm-JNc2g1TswjHrpWSmU2_YZJWYA/webhook',
        '/admin/test-bot',
        '/*',
        '/webhook',
      //   'https://asus-service-center.online/admin/test-bot',
    ];
}
