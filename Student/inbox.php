<?php
session_start();

// Example: student is logged in and we have their full name stored in session
// You should have this set during login, e.g. $_SESSION['student_full_name'] = $first_name . ' ' . $last_name;
$studentName = $_SESSION['student_full_name'] ?? '';

// Protect page if not logged in
if (!$studentName) {
    die("Please log in to view your messages.");
}

// Connect to database
$pdo = new PDO("mysql:host=localhost;dbname=edupulsedb", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fetch messages sent TO the student (e.g. instructor replies)
$stmt = $pdo->prepare("SELECT * FROM messages WHERE receiver = ? ORDER BY created_at DESC");
$stmt->execute([$studentName]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Inbox</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; }
    .message-box {
      border: 1px solid #ccc;
      padding: 15px;
      margin-bottom: 15px;
      border-radius: 8px;
      background-color: #f9f9f9;
    }
    .empty { font-style: italic; color: gray; }
  </style>
</head>
<body>

<h1>Your Inbox</h1>

<?php if (empty($messages)): ?>
  <p class="empty">You haven't received any messages yet.</p>
<?php else: ?>
  <?php foreach ($messages as $msg): ?>
    <div class="message-box">
      <strong>From:</strong> <?= htmlspecialchars($msg['sender']) ?><br>
      <strong>Sent at:</strong> <?= htmlspecialchars($msg['created_at']) ?><br><br>
      <p><?= nl2br(htmlspecialchars($msg['message'])) ?></p>
    </div>
  <?php endforeach; ?>
<?php endif; ?>

</body>
</html>
