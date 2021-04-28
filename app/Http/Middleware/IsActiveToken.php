<?php

namespace App\Http\Middleware;

use Closure;

use App\Configuration;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class IsActiveToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = Auth::user()->token();

        $now = Carbon::now();

        if ($now > $token->expires_at) {
            $token->revoke();
            return response()->json(['message' => "Acceso denegado"], 401);
        }

        $conf_expiration_time = Configuration::whereName('expiration_tokens')->first()->value ?? 5;
        
        $token->update([
            "expires_at" => now()->addMinutes($conf_expiration_time)
        ]);

        return $next($request);
    }
}