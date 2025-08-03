<?php
// Don't include any files that might output HTML
session_start();

// Just include the bare minimum for database connection
$db_host = 'localhost';  // or use your env variables
$db_user = 'root';
$db_pass = 'root';
$db_name = 'loginregistration-themed';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// Simple login check without including main.php
if (!isset($_SESSION['account_loggedin'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

header('Content-Type: application/json');

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