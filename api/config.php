<?php

define('API_URL', 'http://127.0.0.3');


// JWT Secret Key
define('JWT_SECRET', 'MTM1MzcyYjk3MDRlYzd');  // Replace with a strong, unique secret key
define('API_KEY', 'Fbj71YBGbSKn3vfaUVgctzySoDMyquEM');

// Rate Limiting Configuration
define('RATE_LIMIT', 100);    // The maximum number of requests allowed per minute

// CORS (Cross-Origin Resource Sharing) Configuration
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Authorization, Content-Type');
