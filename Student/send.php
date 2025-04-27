<?php
// Database connection
$pdo = new PDO("mysql:host=localhost;dbname=edupulsedb", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Ensure all data is set
if (isset($_POST['sender'], $_POST['receiver'], $_POST['message'])) {
    // Get form data
    $sender = $_POST['sender'];
    $receiver = $_POST['receiver'];
    $message = $_POST['message'];

    // Insert the message into the database
    $stmt = $pdo->prepare("INSERT INTO messages (sender, receiver, message, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$sender, $receiver, $message]);

    // Option 1: Redirect back to the messages page (can be a "refresh" or "home" page)
    header("Location: messages.php");
    exit;
} else {
    // Option 2: Show an error or redirect if fields are missing
    echo "All fields are required!";
}
?>
