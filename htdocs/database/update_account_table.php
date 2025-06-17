<?php
// Include database connection
require_once 'connection.php';

try {
    // Check if account table exists
    $tableExists = $conn->query("SHOW TABLES LIKE 'account'")->rowCount() > 0;
    
    if (!$tableExists) {
        // Create account table if it doesn't exist
        $conn->exec("CREATE TABLE account (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            profile_image VARCHAR(255) NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        echo "Account table created successfully!";
    } else {
        // Check if profile_image column exists
        $columnExists = $conn->query("SHOW COLUMNS FROM account LIKE 'profile_image'")->rowCount() > 0;
        
        if (!$columnExists) {
            // Add profile_image column if it doesn't exist
            $conn->exec("ALTER TABLE account ADD COLUMN profile_image VARCHAR(255) NULL");
            echo "Added profile_image column to account table!";
        } else {
            echo "Profile image column already exists in account table.<br>";
        }

        // Check if is_admin column exists
        $isAdminColumnExists = $conn->query("SHOW COLUMNS FROM account LIKE 'is_admin'")->rowCount() > 0;
        if (!$isAdminColumnExists) {
            // Add is_admin column if it doesn't exist
            $conn->exec("ALTER TABLE account ADD COLUMN is_admin TINYINT(1) NOT NULL DEFAULT 0 COMMENT '0 = user, 1 = admin'");
            echo "Added is_admin column to account table!<br>";
        } else {
            echo "is_admin column already exists in account table.<br>";
        }
    }
    
    echo "<br><a href='/'>Return to Home</a>";
    
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    echo "<br><a href='/'>Return to Home</a>";
}
?>
