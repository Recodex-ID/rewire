<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class RejectSpamSubmissions
{
    /**
     * Name of the hidden field rendered by <x-honeypot />. Real visitors never see
     * or fill it; form-filling bots usually fill every input they find.
     */
    public const HONEYPOT_FIELD = 'company_url';

    /**
     * Public forms that create records or send email without being signed in.
     *
     * @var list<string>
     */
    private const PROTECTED_ROUTES = ['register.store', 'password.email'];

    private const MAX_ATTEMPTS_PER_MINUTE = 5;

    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->isMethod('POST') || ! $request->routeIs(...self::PROTECTED_ROUTES)) {
            return $next($request);
        }

        // Answer as if the submission worked so the bot has nothing to learn from.
        if (filled($request->input(self::HONEYPOT_FIELD))) {
            return redirect()->route('home');
        }

        $key = 'spam-guard:'.$request->route()->getName().'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($key, self::MAX_ATTEMPTS_PER_MINUTE)) {
            throw new ThrottleRequestsException(
                headers: ['Retry-After' => RateLimiter::availableIn($key)],
            );
        }

        RateLimiter::hit($key, 60);

        return $next($request);
    }
}
