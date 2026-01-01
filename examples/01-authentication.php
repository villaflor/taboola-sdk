<?php

declare(strict_types=1);

/**
 * Example 1: Authentication
 *
 * This example demonstrates how to authenticate with the Taboola API
 * and obtain an access token.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Villaflor\Connection\Auth\None;
use Villaflor\TaboolaSDK\Configurations\AuthenticationConfiguration;
use Villaflor\TaboolaSDK\Endpoints\Authentication;
use Villaflor\TaboolaSDK\TaboolaClient;

// Your Taboola API credentials
// Note: Request these from your Taboola Account Manager
$clientId = 'your-client-id';
$clientSecret = 'your-client-secret';

try {
    // Step 1: Create a client with no authentication (for the auth endpoint)
    $unauthenticatedClient = new TaboolaClient(new None());

    // Step 2: Create the authentication endpoint
    $authEndpoint = new Authentication($unauthenticatedClient);

    // Step 3: Configure authentication request
    $authConfig = new AuthenticationConfiguration(
        clientId: $clientId,
        clientSecret: $clientSecret
    );

    // Step 4: Get access token
    echo "Authenticating with Taboola API...\n";
    $response = $authEndpoint->getAccessToken($authConfig);

    // Step 5: Access the token details
    echo "✅ Authentication successful!\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "Access Token: " . substr($response->accessToken, 0, 20) . "...\n";
    echo "Token Type: {$response->tokenType}\n";
    echo "Expires In: {$response->expiresIn} seconds\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

    // Step 6: Save the token for use in other requests
    // In a real application, you would store this securely
    file_put_contents(__DIR__ . '/token.txt', $response->accessToken);
    echo "💾 Token saved to examples/token.txt\n";
    echo "   Use this token in other examples.\n\n";

    // Optional: Calculate token expiration time
    $expiresAt = new DateTime();
    $expiresAt->modify("+{$response->expiresIn} seconds");
    echo "⏰ Token expires at: " . $expiresAt->format('Y-m-d H:i:s') . "\n";
} catch (\Villaflor\TaboolaSDK\Exceptions\TaboolaException $e) {
    echo "❌ Authentication failed: {$e->getMessage()}\n";
    exit(1);
} catch (\Exception $e) {
    echo "❌ Unexpected error: {$e->getMessage()}\n";
    exit(1);
}

echo "\n";
echo "📚 Next Steps:\n";
echo "   1. Use the token in other examples\n";
echo "   2. Implement token refresh before expiration\n";
echo "   3. Store tokens securely in production\n";
