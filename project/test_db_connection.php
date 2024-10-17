<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config/Database.php';

try {
    $db = new Database(); // Attempt to connect to the database

    // Test connection with a simple query
    $db->query('SELECT 1'); // Simple test query
    echo "Database connection successful!";
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage(); // Output the error message
}
