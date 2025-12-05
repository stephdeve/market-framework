<?php

// Test bootstrap file
require_once __DIR__ . '/../autoload.php';

// Set timezone
date_default_timezone_set('UTC');

// Start session for testing
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
