<?php
require_once __DIR__ . '/../autoload.php';

use Framework\Core\Database;
use Framework\Database\SeederRunner;
use Framework\Config\Config;

echo "Running Seeders...\n";

// Load configuration
Config::load(__DIR__ . '/config');

// Database configuration
$dbConfig = Config::get('database');
$db = new Database(
    $dbConfig['dbname'],
    $dbConfig['host'],
    $dbConfig['username'],
    $dbConfig['password']
);

// Run seeders
$seederRunner = new SeederRunner($db, __DIR__ . '/seeders');

if (isset($argv[1])) {
    // Run specific seeder
    $seederClass = $argv[1];
    require_once __DIR__ . '/seeders/' . $seederClass . '.php';
    $seederRunner->seed($seederClass);
} else {
    // Run all seeders
    $seederRunner->seedAll();
}

echo "Done.\n";
