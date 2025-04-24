<?php
session_start();

// Suppose your session array is:
// Array ( [username] => manar [instructor_id] => 4 )
$instructor_id       = $_SESSION['instructor_id'];
$instructor_username = $_SESSION['username'];

// Database connection
$pdo = new PDO("mysql:host=localhost;dbname=edupulsedb", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 1) Lookup the instructor's first and last name
$stmt = $pdo->prepare("
    SELECT first_name, last_name 
      FROM instructor 
     WHERE instructor_id = ?
    ");
$stmt->execute([$instructor_id]);
$inst = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$inst) {
    die("Instructor not found.");
}

// Build the full name
$instructor_fullname = $inst['first_name'] . ' ' . $inst['last_name'];

// 2) Fetch messages where the receiver equals that full name
$stmt = $pdo->prepare("
    SELECT * 
      FROM messages 
     WHERE receiver = ? 
  ORDER BY created_at DESC
");
$stmt->execute([$instructor_fullname]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Instructor Messaging</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f4f6f9;
      padding: 20px;
    }

    h1 {
      text-align: center;
      color: #333;
    }

    .message-card {
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      padding: 15px;
      margin: 20px auto;
      max-width: 700px;
    }

    .message-card p {
      margin-top: 10px;
      color: #555;
      white-space: pre-line;
    }

    .reply-form {
      margin-top: 10px;
    }

    textarea {
      width: 100%;
      height: 100px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
      resize: vertical;
    }

    button {
      margin-top: 10px;
      background-color: #007BFF;
      color: white;
      padding: 10px 20px;
      font-size: 15px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    button:hover {
      background-color:rgb(222, 195, 59);
    }
  </style>
</head>
<body>

  <h1> Instructor's Inbox</h1>

  <?php if (empty($messages)): ?>
    <p style="text-align:center;"><em>No messages yet. Check back later!</em></p>
  <?php else: ?>
    <?php foreach ($messages as $msg): ?>
      <div class="message-card">
        <strong>From:</strong> <?= htmlspecialchars($msg['sender']) ?><br>
        <strong>To:</strong> <?= htmlspecialchars($msg['receiver']) ?><br>
        <strong>Subject:</strong> <?= htmlspecialchars($msg['subject']) ?><br>
        <strong>At:</strong> <?= htmlspecialchars($msg['created_at']) ?><br>
        <p><?= nl2br(htmlspecialchars($msg['message'])) ?></p>

        <form class="reply-form" action="Controller/reply.php" method="post">
          <input type="hidden" name="sender" value="<?= htmlspecialchars($instructor_username) ?>">
          <input type="hidden" name="receiver" value="<?= htmlspecialchars($msg['sender']) ?>">
          <textarea name="message" placeholder="Your reply..." required></textarea><br>
          <button type="submit">Reply</button>
        </form>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>

</body>
</html>
