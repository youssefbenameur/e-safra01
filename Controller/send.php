
<?php
session_start();
$pdo = new PDO("mysql:host=localhost;dbname=edupulsedb", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sender   = $_POST['sender'];
$receiver = $_POST['receiver'];
$subject  = $_POST['subject'];
$message  = $_POST['message'];

$stmt = $pdo->prepare("
  INSERT INTO messages (sender, receiver, subject, message, created_at)
  VALUES (?, ?, ?, ?, NOW())
");
$stmt->execute([$sender, $receiver, $subject, $message]);

header("Location: ../Student/student_messages.php");
exit();
?>