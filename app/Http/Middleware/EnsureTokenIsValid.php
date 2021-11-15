<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     * 
     * Verifica se usuário proprietário do token está ativo
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        $user = \App\Models\User::where([['api_token', $token],['active',1]])->first();
        if ($user) {
            return $next($request);
        }
        return response([
            'message' => 'Token inativo'
        ], 401);
    }
}
