<?php

/**
 * Post-process Swagger JSON to remove relative server URLs
 * This ensures Swagger UI uses the Production server URL
 */

$swaggerJsonPath = __DIR__ . '/../storage/api-docs/api-docs.json';

if (!file_exists($swaggerJsonPath)) {
    echo "Swagger JSON file not found: {$swaggerJsonPath}\n";
    exit(1);
}

$json = json_decode(file_get_contents($swaggerJsonPath), true);

if (!$json) {
    echo "Failed to parse Swagger JSON\n";
    exit(1);
}

// Remove relative server URLs (like "/")
if (isset($json['servers']) && is_array($json['servers'])) {
    $json['servers'] = array_filter($json['servers'], function($server) {
        $url = $server['url'] ?? '';
        // Keep only absolute URLs (starting with http:// or https://)
        return strpos($url, 'http://') === 0 || strpos($url, 'https://') === 0;
    });
    // Re-index array
    $json['servers'] = array_values($json['servers']);
}

// Ensure Production server is first
if (isset($json['servers']) && is_array($json['servers'])) {
    usort($json['servers'], function($a, $b) {
        $aUrl = $a['url'] ?? '';
        $bUrl = $b['url'] ?? '';
        // Production server first
        if (strpos($aUrl, 'tinderphp-production.up.railway.app') !== false) {
            return -1;
        }
        if (strpos($bUrl, 'tinderphp-production.up.railway.app') !== false) {
            return 1;
        }
        return 0;
    });
}

file_put_contents($swaggerJsonPath, json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

echo "Swagger JSON fixed successfully\n";

