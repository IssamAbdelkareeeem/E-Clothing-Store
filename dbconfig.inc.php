<?php
define('DBHOST', 'localhost');
define('DBNAME', 'web1211821_db');
define('DBUSER', 'web1211821_dbuser');
define('DBPASS', 'x_@QHHg4@r');
define('DBCONNSTRING', "mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8mb4");

try {
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
