<?php
try {
    // Base URL (IMPORTANT)
    define("APP_URL", "http://localhost/homeland");

    // Database configuration
    define("HOSTNAME", "localhost");
    define("DBNAME", "homeland");
    define("USER", "root");
    define("PASS", "");

    $conn = new PDO(
        "mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . ";",
        USER,
        PASS
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

