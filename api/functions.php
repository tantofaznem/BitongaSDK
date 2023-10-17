<?php
require_once('config.php');
require_once('vendor/autoload.php'); // Include the PHP-JWT library

use \Firebase\JWT\JWT;
// Database Connection Function
function connectToDatabase() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Rate Limiting Function
function isRateLimited() {
    // Define a unique identifier for the current request, such as the client's IP address or API key
    $requestIdentifier = getClientIdentifier(); // Implement getClientIdentifier() to retrieve the client identifier

    // Set a time window (e.g., 1 minute) for the rate limit
    $timeWindow = 60; // 60 seconds

    // Define the rate limit allowed within the time window
    $rateLimit = RATE_LIMIT; // Get the rate limit from config.php

    // Connect to a data store (e.g., Redis, database, or in-memory cache) where request counts are stored
    $conn = connectToDatabase(); // Implement connectToDataStore() to establish a connection

    // Check if the request count for the client identifier exceeds the rate limit
    $requestCount = getRequestCountFromDataStore($conn, $requestIdentifier); // Implement getRequestCountFromDataStore()
    
    if ($requestCount >= $rateLimit) {
        return false; // The request should be rate-limited
    } else {
        // Increment the request count for the client identifier
        incrementRequestCountInDataStore($conn, $requestIdentifier); // Implement incrementRequestCountInDataStore()
        // Set an expiration time for the request count data in the data store (e.g., 1 minute)
        setRequestCountExpiration($conn, $requestIdentifier, $timeWindow); // Implement setRequestCountExpiration()
        return false; // The request is not rate-limited
    }
}

// Function to get the client identifier (e.g., API key or token)
function getClientIdentifier() {
    // Check if the client identifier is provided in the Authorization header
    if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $authorizationHeader = $_SERVER['HTTP_AUTHORIZATION'];
        
        // Example: Bearer token
        if (strpos($authorizationHeader, 'Bearer ') === 0) {
            // Extract the token from the header
            $token = substr($authorizationHeader, 7);
            // Validate and verify the token here
            $decoded = validateJWT($token); // Implement the validateJWT function
            if ($decoded) {
                return $decoded->user_id; // Return the user ID or client identifier
            }
        }

        // Example: Basic authentication (API key)
        if (strpos($authorizationHeader, 'Basic ') === 0) {
            // Extract and decode the API key
            $base64Credentials = substr($authorizationHeader, 6);
            $decodedCredentials = base64_decode($base64Credentials);
            if ($decodedCredentials) {
                list($apiKey, $apiSecret) = explode(':', $decodedCredentials, 2);
                // Validate the API key here
                if (validateApiKey($apiKey)) { // Implement validateApiKey function
                    return $apiKey; // Return the API key
                }
            }
        }
    }

    // If the client identifier is not found or valid, return an error or handle it based on your requirements.
    // For example, return a 401 Unauthorized response.
    http_response_code(401);
    die("Unauthorized");
}


//$user_id = '123';

// JWT Authentication Functions
function generateJWT($user_id) {
    $payload = array(
        "user_id" => $user_id,
        "exp" => time() + 3600 // Token expiration time (1 hour)
    );
    $jwt = JWT::encode($payload, $key, 'HS256'); // Specify the algorithm as 'HS256'
    return $jwt;
}



function validateJWT($jwt) {
    $key = $apiKey;
    try {
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        return $decoded;
    } catch (Exception $e) {
        return null; // Token is invalid or expired
    }
}


// Other Helper Functions


// Function to handle CORS headers
function handleCors() {
    // Replace these headers with the appropriate values for your application
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization");

    // Check if it's a preflight request (OPTIONS method) and respond accordingly
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        header("HTTP/1.1 200 OK");
        exit();
    }
}
?>
