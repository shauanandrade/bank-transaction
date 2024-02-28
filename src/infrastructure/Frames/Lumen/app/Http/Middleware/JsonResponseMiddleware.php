<?php

namespace App\Http\Middleware;

use Closure;

class JsonResponseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $responseData = $response->original;

        $formatResponse = [
            'statusCode' => $response->status(),
            'result' => $responseData
        ];

        return response()->json($formatResponse, $response->status());
    }
}
