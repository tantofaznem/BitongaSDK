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
    $requestIdentifier = getClientIdentifier();

    // Set a time window (e.g., 1 minute) for the rate limit
    $timeWindow = 60; // 60 seconds

    // Define the rate limit allowed within the time window
    $rateLimit = RATE_LIMIT; // Get the rate limit from config.php

    // Connect to a database
    $conn = connectToDatabase(); 

    // Check if the request count for the client identifier exceeds the rate limit
    $requestCount = getRequestCountFromDataStore($conn, $requestIdentifier);
    
    if ($requestCount >= $rateLimit) {
        return false; // The request should be rate-limited
    } else {
        // Increment the request count for the client identifier
        incrementRequestCountInDataStore($conn, $requestIdentifier); // 
        // Set an expiration time for the request count data in the data store (e.g., 1 minute)
        setRequestCountExpiration($conn, $requestIdentifier, $timeWindow); 
        return false; // The request is not rate-limited
    }
}

// Function to get the client identifier (e.g., API key or token)
function getClientIdentifier() {
    // Check if the client identifier is provided in the Authorization header
    if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $authorizationHeader = $_SERVER['HTTP_AUTHORIZATION'];
        
        // Bearer token
        if (strpos($authorizationHeader, 'Bearer ') === 0) {
            // Extract the token from the header
            $token = substr($authorizationHeader, 7);
            // Validate and verify the token here
            $decoded = validateJWT($token); 
            if ($decoded) {
                return $decoded->user_id; // Return the user ID or client identifier
            }
        }

        // Basic authentication (API key)
        if (strpos($authorizationHeader, 'Basic ') === 0) {
            // Extract and decode the API key
            $base64Credentials = substr($authorizationHeader, 6);
            $decodedCredentials = base64_decode($base64Credentials);
            if ($decodedCredentials) {
                list($apiKey, $apiSecret) = explode(':', $decodedCredentials, 2);
                // Validate the API key here
                if (validateApiKey($apiKey)) { 
                    return $apiKey; // Return the API key
                }
            }
        }
    }

    // If the client identifier is not found or valid, return an error or handle it based on your requirements.
    // Return a 401 Unauthorized response.
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

// Function to set an expiration time for the request count data in the MySQL table
function setRequestCountExpiration($conn, $requestIdentifier, $timeWindow) {
    $expirationTime = time() + $timeWindow;

    $query = "INSERT INTO request_rate_limit (request_identifier, request_count, expiration_time)
              VALUES (?, 1, ?)
              ON DUPLICATE KEY UPDATE request_count = request_count + 1, expiration_time = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('sii', $requestIdentifier, $expirationTime, $expirationTime);
    $stmt->execute();
}

// Function to increment the request count for the client identifier in the MySQL table
function incrementRequestCountInDatabase($conn, $requestIdentifier) {
    $query = "INSERT INTO request_rate_limit (request_identifier, request_count, expiration_time)
              VALUES (?, 1, ?)
              ON DUPLICATE KEY UPDATE request_count = request_count + 1";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $requestIdentifier, time());
    $stmt->execute();
}

// Function to retrieve the request count from the MySQL table
function getRequestCountFromDatabase($conn, $requestIdentifier) {
    $query = "SELECT request_count FROM request_rate_limit WHERE request_identifier = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $requestIdentifier);
    $stmt->execute();
    $stmt->bind_result($requestCount);
    $stmt->fetch();

    return $requestCount;
}

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
