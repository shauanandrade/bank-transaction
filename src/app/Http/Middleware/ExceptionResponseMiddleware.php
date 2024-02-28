<?php

namespace App\Http\Middleware;

use Closure;

class ExceptionResponseMiddleware
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
        $response = $next($request);
        if($response->exception) {
            return response()->json([
                'status_code' => 500,
                'error_message' => $response->exception->getMessage(),
            ],500);
        }
        return $next($request);
    }
}
