<?php

namespace App\Core;

class SupabaseClient
{
    private string $url;
    private string $anonKey;
    private string $serviceRoleKey;

    public function __construct(array $config)
    {
        $this->url = rtrim($config['url'], '/');
        $this->anonKey = $config['anon_key'];
        $this->serviceRoleKey = $config['service_role_key'];
    }

    public function signInWithPassword(string $email, string $password): array
    {
        return $this->request(
            'POST',
            '/auth/v1/token?grant_type=password',
            [
                'email' => $email,
                'password' => $password,
            ],
            false
        );
    }

    public function refreshSession(string $refreshToken): array
    {
        return $this->request(
            'POST',
            '/auth/v1/token?grant_type=refresh_token',
            [
                'refresh_token' => $refreshToken,
            ],
            false
        );
    }

    public function getUser(string $accessToken): array
    {
        return $this->request(
            'GET',
            '/auth/v1/user',
            null,
            false,
            $accessToken
        );
    }

    public function signOut(string $accessToken): array
    {
        return $this->request(
            'POST',
            '/auth/v1/logout',
            new \stdClass(),
            false,
            $accessToken
        );
    }

    public function from(string $table, string $method = 'GET', ?array $body = null, ?string $query = '', bool $useServiceRole = true, ?string $accessToken = null): array
    {
        $path = '/rest/v1/' . $table;
        if ($query) {
            $path .= '?' . ltrim($query, '?');
        }

        return $this->request($method, $path, $body, $useServiceRole, $accessToken);
    }

    private function request(string $method, string $path, $body = null, bool $useServiceRole = false, ?string $accessToken = null): array
    {
        $ch = curl_init();

        $headers = [
            'Content-Type: application/json',
            'apikey: ' . ($useServiceRole ? $this->serviceRoleKey : $this->anonKey),
        ];

        if ($accessToken) {
            $headers[] = 'Authorization: Bearer ' . $accessToken;
        } elseif ($useServiceRole) {
            $headers[] = 'Authorization: Bearer ' . $this->serviceRoleKey;
        }
        curl_setopt_array($ch, [
            CURLOPT_URL => $this->url . $path,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ]);

        if ($body !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);

        if ($error) {
            return [
                'success' => false,
                'status' => 500,
                'error' => $error,
                'data' => null,
            ];
        }

        $decoded = json_decode($response, true);

        return [
            'success' => $httpCode >= 200 && $httpCode < 300,
            'status' => $httpCode,
            'error' => $httpCode >= 400 ? ($decoded['msg'] ?? $decoded['message'] ?? 'Request failed') : null,
            'data' => $decoded,
        ];
    }
}