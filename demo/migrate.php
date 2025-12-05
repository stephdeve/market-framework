<?php
require_once __DIR__ . '/../autoload.php';

use Framework\Core\Database;
use Framework\Database\MigrationRunner;
use Framework\Config\Config;

echo "Running Migrations...\n";

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

// Run migrations
$migrationRunner = new MigrationRunner($db, __DIR__ . '/migrations');

if (isset($argv[1]) && $argv[1] === 'rollback') {
    $migrationRunner->rollback();
} else {
    $migrationRunner->migrate();
}

echo "Done.\n";
