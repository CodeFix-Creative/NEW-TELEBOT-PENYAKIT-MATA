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
        '/test-bot',
        '/*',
        'https://api.telegram.org/bot1907491983:AAGY5f9Cm-JNc2g1TswjHrpWSmU2_YZJWYA/*',
        '/api/1907491983:AAGY5f9Cm-JNc2g1TswjHrpWSmU2_YZJWYA',
        '/api',
    ];
}
