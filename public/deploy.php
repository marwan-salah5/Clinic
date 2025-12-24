<?php
/**
 * GitHub Webhook Handler for CyberPanel
 * 
 * This file receives webhook notifications from GitHub
 * and triggers automatic deployment when code is pushed.
 * 
 * Setup:
 * 1. Place this file in your public directory
 * 2. Set a strong webhook secret below
 * 3. Add webhook in GitHub: Settings → Webhooks → Add webhook
 *    - Payload URL: https://yourdomain.com/deploy.php
 *    - Content type: application/json
 *    - Secret: (same as below)
 *    - Events: Just the push event
 */

// Configuration
define('WEBHOOK_SECRET', 'CHANGE_THIS_TO_A_STRONG_SECRET');
define('DEPLOY_SCRIPT', '/home/yourdomain.com/deploy.sh');
define('LOG_FILE', '/home/yourdomain.com/deployment.log');

// Verify GitHub signature for security
function verifyGitHubSignature($payload, $signature)
{
    if (empty($signature)) {
        return false;
    }

    $expectedSignature = 'sha256=' . hash_hmac('sha256', $payload, WEBHOOK_SECRET);
    return hash_equals($expectedSignature, $signature);
}

// Log deployment
function logDeployment($message)
{
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] $message\n";
    file_put_contents(LOG_FILE, $logMessage, FILE_APPEND);
}

// Main execution
try {
    // Get payload
    $payload = file_get_contents('php://input');
    $signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';

    // Verify signature
    if (!verifyGitHubSignature($payload, $signature)) {
        http_response_code(403);
        logDeployment('ERROR: Invalid webhook signature');
        die('Invalid signature');
    }

    // Parse payload
    $data = json_decode($payload, true);

    // Check if it's a push to main branch
    if (isset($data['ref']) && $data['ref'] === 'refs/heads/main') {
        logDeployment('Webhook received - Starting deployment');

        // Execute deployment script
        $output = shell_exec(DEPLOY_SCRIPT . ' 2>&1');

        // Log output
        logDeployment("Deployment output:\n" . $output);

        // Return success
        http_response_code(200);
        echo json_encode([
            'status' => 'success',
            'message' => 'Deployment triggered successfully',
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    } else {
        logDeployment('Webhook received but not for main branch - Skipped');
        echo json_encode([
            'status' => 'skipped',
            'message' => 'Not a push to main branch'
        ]);
    }

} catch (Exception $e) {
    http_response_code(500);
    logDeployment('ERROR: ' . $e->getMessage());
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
