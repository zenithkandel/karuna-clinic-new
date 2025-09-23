<?php
/**
 * Database Setup Script
 * Run this script to create the database and tables for Karuna Clinic
 */

require_once __DIR__ . '/config.php';

// Define database constants for setup (before database.php includes them)
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'karuna_clinic');

// Database connection without selecting a specific database
function getBaseConnection() {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";charset=utf8mb4", 
                      DB_USERNAME, 
                      DB_PASSWORD, 
                      [
                          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                          PDO::ATTR_EMULATE_PREPARES => false
                      ]);
        return $pdo;
    } catch(PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}

// Read and execute SQL file
function executeSQLFile($pdo, $filename) {
    $sql = file_get_contents($filename);
    if ($sql === false) {
        throw new Exception("Could not read SQL file: " . $filename);
    }
    
    // Split SQL into individual statements
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    
    $executedCount = 0;
    foreach ($statements as $statement) {
        if (!empty($statement)) {
            try {
                $pdo->exec($statement);
                $executedCount++;
            } catch (PDOException $e) {
                // Continue with other statements if one fails
                echo "Warning: Failed to execute statement: " . substr($statement, 0, 100) . "...\n";
                echo "Error: " . $e->getMessage() . "\n";
            }
        }
    }
    
    return $executedCount;
}

// Main setup function
function setupDatabase() {
    try {
        echo "Starting database setup...\n";
        
        // Connect to MySQL server
        $pdo = getBaseConnection();
        echo "✓ Connected to MySQL server\n";
        
        // Execute schema file
        $sqlFile = __DIR__ . '/database_schema.sql';
        if (!file_exists($sqlFile)) {
            throw new Exception("SQL schema file not found: " . $sqlFile);
        }
        
        $count = executeSQLFile($pdo, $sqlFile);
        echo "✓ Executed {$count} SQL statements\n";
        
        // Test the connection to the new database
        require_once __DIR__ . '/database.php';
        $testPdo = getDBConnection();
        echo "✓ Successfully connected to karuna_clinic database\n";
        
        // Verify tables were created
        $tables = $testPdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        echo "✓ Created " . count($tables) . " tables: " . implode(', ', $tables) . "\n";
        
        echo "\n🎉 Database setup completed successfully!\n";
        echo "You can now access the website at: " . SITE_URL . "\n";
        
        return true;
        
    } catch (Exception $e) {
        echo "❌ Error during setup: " . $e->getMessage() . "\n";
        return false;
    }
}

// Run setup if this file is executed directly
if (php_sapi_name() === 'cli' || basename($_SERVER['PHP_SELF']) === 'setup_database.php') {
    setupDatabase();
}
?>