<?php

namespace App\Services;

use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    /**
     * The list of accepted SSO clients
     *
     * @var array
     */
    private $acceptedSsoClients = ['paymoney'];

    /**
     * Checks if the current session needs auto authentication
     */
    public function needsAutoAuthentication(): bool
    {
        // Get the intended URL from the session
        $intendedUrl = session('url')['intended'] ?? null;

        // Ensure the intended URL is present
        if (! $intendedUrl) {
            return false;
        }

        // Parse the URL and extract its components
        $urlParts = parse_url($intendedUrl);

        // Ensure the query part of the URL exists
        if (! isset($urlParts['query'])) {
            return false;
        }

        // Parse the query string into an array of parameters
        parse_str($urlParts['query'], $params);

        // Check if the 'sso' parameter exists and is accepted
        if (isset($params['sso_client']) && in_array($params['sso_client'], $this->acceptedSsoClients)) {
            return true;
        }

        return false;
    }

    /**
     * Auto authenticate the user if the session needs it
     */
    public function autoAuthenticate(): void
    {
        $sessionData = $this->getSessionData();

        $user = User::where('email', $sessionData['email'])->first();

        if (! $user) {
            $user = $this->createUser($sessionData);
        }

        Auth::login($user);
    }

    /**
     * Get the session data
     */
    private function getSessionData(): array
    {
        $intendedUrl = session('url')['intended'];

        $urlParts = parse_url($intendedUrl);

        parse_str($urlParts['query'], $params);

        return $params;
    }

    /**
     * Create a new user
     */
    private function createUser(array $sessionData): User
    {
        $user = User::create([
            'name' => $sessionData['name'],
            'email' => $sessionData['email'],
            'password' => $sessionData['password'],
            'phone' => '',
            'status' => 'Active',
        ]);

        $role = Role::where('slug', 'customer')->first();

        RoleUser::insert([
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);

        return $user;
    }
}
