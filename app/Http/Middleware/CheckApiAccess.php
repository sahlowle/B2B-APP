<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApiAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $data = [
            'status' => ['code' => 403, 'text' => __('Forbidden')],
        ];

        // Check if API access is enabled
        if (! preference('enable_api', 1)) {
            $data['message'] = __('API is disabled');

            return response()->json(['response' => $data], 403);
        }

        // Check if access token is required
        if (preference('access_token_required', 0)) {
            $apiKey = $request->header('API-KEY');

            // Validate the access token
            if (! $this->isValidApiKey($apiKey)) {
                $data['message'] = __('Invalid API Key');

                return response()->json(['response' => $data], 403);
            }
        }

        return $next($request);
    }

    /**
     * Check if the access token is valid
     *
     * @return bool
     */
    private function isValidApiKey(string $apiKey)
    {
        return $apiKey && ApiKey::where(['access_token' => $apiKey, 'status' => 'Active'])->exists();
    }
}
