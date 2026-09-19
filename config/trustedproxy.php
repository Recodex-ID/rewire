<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Trusted Proxies
    |--------------------------------------------------------------------------
    |
    | Only forwarded headers (X-Forwarded-Proto, X-Forwarded-For, ...) from these
    | proxies are believed. Use a comma separated list of IP addresses, or "*" when
    | a load balancer you control terminates TLS in front of the app. Leave it empty
    | when the app is reached directly.
    |
    */

    'proxies' => env('TRUSTED_PROXIES'),

];
