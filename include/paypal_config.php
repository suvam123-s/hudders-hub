<?php

// ── Mode: 'sandbox' or 'live' ──
define('PAYPAL_MODE', 'sandbox');

// ── Sandbox credentials ──
define('PAYPAL_SANDBOX_CLIENT_ID',  'AaimcNs3VVM-Q1tfQsZpNw9ZcndvNCBra9OIFx24JNMQ7HnTs3HIA17mSxsI02T7oKf0Al1Zn8iXocbk');
define('PAYPAL_SANDBOX_SECRET',     'EL6WnwQ6su-Ub4-KvLoXHODHLzsIQ3KBan_-ztEZ0VLhC42hv1KNSKlNdhs_eaiM89GLyQossV77mt7h');

// ── Live credentials (fill in before production) ──
define('PAYPAL_LIVE_CLIENT_ID',     'YOUR_LIVE_CLIENT_ID');
define('PAYPAL_LIVE_SECRET',        'YOUR_LIVE_SECRET');

// ── Currency ──
define('PAYPAL_CURRENCY', 'GBP');

// ── Helper functions ──

/**
 * Returns the active Client ID based on PAYPAL_MODE.
 */
function paypal_client_id(): string {
    return PAYPAL_MODE === 'live' ? PAYPAL_LIVE_CLIENT_ID : PAYPAL_SANDBOX_CLIENT_ID;
}

/**
 * Returns the active Secret based on PAYPAL_MODE.
 */
function paypal_secret(): string {
    return PAYPAL_MODE === 'live' ? PAYPAL_LIVE_SECRET : PAYPAL_SANDBOX_SECRET;
}

/**
 * Returns the PayPal API base URL.
 */
function paypal_api_base(): string {
    return PAYPAL_MODE === 'live'
        ? 'https://api-m.paypal.com'
        : 'https://api-m.sandbox.paypal.com';
}

/**
 * Gets an OAuth2 access token from PayPal.
 * Tokens are cached in the session for 30 minutes.
 */
function paypal_get_access_token(): string {
    // Check session cache
    if (!empty($_SESSION['paypal_token']) && ($_SESSION['paypal_token_expires'] ?? 0) > time()) {
        return $_SESSION['paypal_token'];
    }

    $ch = curl_init(paypal_api_base() . '/v1/oauth2/token');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => 'grant_type=client_credentials',
        CURLOPT_USERPWD        => paypal_client_id() . ':' . paypal_secret(),
        CURLOPT_HTTPHEADER     => ['Accept: application/json', 'Accept-Language: en_US'],
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_TIMEOUT        => 30,
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200) {
        error_log('PayPal OAuth Error: HTTP ' . $httpCode . ' — ' . $response);
        throw new \RuntimeException('Failed to obtain PayPal access token.');
    }

    $data = json_decode($response, true);
    $_SESSION['paypal_token']         = $data['access_token'];
    $_SESSION['paypal_token_expires'] = time() + ($data['expires_in'] ?? 1800) - 60; // 1-min buffer

    return $data['access_token'];
}

/**
 * Makes an authenticated request to the PayPal REST API.
 */
function paypal_request(string $method, string $endpoint, ?array $body = null): array {
    $token = paypal_get_access_token();
    $url   = paypal_api_base() . $endpoint;

    $ch = curl_init($url);
    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $token,
        'Prefer: return=representation',
    ];

    $opts = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER     => $headers,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_TIMEOUT        => 30,
    ];

    if ($method === 'POST') {
        $opts[CURLOPT_POST]       = true;
        $opts[CURLOPT_POSTFIELDS] = $body ? json_encode($body) : '';
    }

    curl_setopt_array($ch, $opts);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $decoded = json_decode($response, true) ?? [];
    $decoded['_http_code'] = $httpCode;

    return $decoded;
}
