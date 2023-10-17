<?php

// Include necessary files and libraries
require_once('api/config.php');
require_once('api/functions.php');
require_once('sdk/BitongaDictionarySDK.php');

$apiUrl = API_URL;
$apiKey = API_KEY;
// Handle CORS (Cross-Origin Resource Sharing) headers
handleCors();

// Check for rate limiting
if (isRateLimited()) {
    http_response_code(429); // Return 429 Too Many Requests status code
    echo json_encode(array('message' => 'Rate limit exceeded'));
    exit;
}

// Check the HTTP method of the request
$method = $_SERVER['REQUEST_METHOD'];

// Create an instance of the BitongaDictionarySDK
$bitongaSDK = new BitongaDictionarySDK($apiUrl, $apiKey);

// Define the API routes
switch ($method) {
    case 'GET':
        // Handle GET requests
        if ($_GET['route'] === 'bitonga-words') {
            $bitongaWords = $bitongaSDK->getBitongaWords();
            echo json_encode($bitongaWords);
        } elseif (preg_match('/^bitonga-words\/([0-9]+)$/', $_GET['route'], $matches)) {
            $wordId = $matches[1];
            $bitongaWord = $bitongaSDK->getBitongaWord($wordId);
            if ($bitongaWord) {
                echo json_encode($bitongaWord);
            } else {
                http_response_code(404);
                echo json_encode(array('message' => 'Word not found'));
            }
        }
        break;
    case 'POST':
        // Handle POST requests
        if ($_GET['route'] === 'bitonga-words') {
            $data = json_decode(file_get_contents('php://input'));
            $newBitongaWord = $bitongaSDK->addBitongaWord($data);
            echo json_encode($newBitongaWord);
        }
        break;
    case 'PUT':
        // Handle PUT requests
        if (preg_match('/^bitonga-words\/([0-9]+)$/', $_GET['route'], $matches)) {
            $wordId = $matches[1];
            $data = json_decode(file_get_contents('php://input'));
            $updatedBitongaWord = $bitongaSDK->updateBitongaWord($wordId, $data);
            if ($updatedBitongaWord) {
                echo json_encode($updatedBitongaWord);
            } else {
                http_response_code(404);
                echo json_encode(array('message' => 'Word not found'));
            }
        }
        break;
    case 'DELETE':
        // Handle DELETE requests
        if (preg_match('/^bitonga-words\/([0-9]+)$/', $_GET['route'], $matches)) {
            $wordId = $matches[1];
            $deleted = $bitongaSDK->deleteBitongaWord($wordId);
            if ($deleted) {
                echo json_encode(array('message' => 'Word deleted'));
            } else {
                http_response_code(404);
                echo json_encode(array('message' => 'Word not found'));
            }
        }
        break;
    default:
        http_response_code(405); // Return 405 Method Not Allowed status code
        echo json_encode(array('message' => 'Method not allowed'));
}

?>
