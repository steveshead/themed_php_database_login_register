<?php
session_start();

// Load environment variables from .env file
function loadEnv($filePath) {
    if (!file_exists($filePath)) {
        return;
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && $line[0] !== '#') {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

// Load the .env file
loadEnv(__DIR__ . '/.env');

// Get database credentials from environment variables
$db_host = $_ENV['DB_HOST'] ?? 'localhost';
$db_user = $_ENV['DB_USER'] ?? 'root';
$db_pass = $_ENV['DB_PASS'] ?? '';
$db_name = $_ENV['DB_NAME'] ?? 'database';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// Simple login check
if (!isset($_SESSION['account_loggedin'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

header('Content-Type: application/json');

// Rest of your search code...
if (isset($_POST['search']) && !empty(trim($_POST['search']))) {
    $searchTerm = '%' . trim($_POST['search']) . '%';

    try {
        $stmt = $pdo->prepare('SELECT username, email FROM accounts WHERE username LIKE ? OR email LIKE ? ORDER BY username LIMIT 20');
        $stmt->execute([$searchTerm, $searchTerm]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($results);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Search failed']);
    }
} else {
    echo json_encode([]);
}
?>