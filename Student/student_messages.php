<?php
session_start();
// Example session usage
$student_username = $_SESSION['username'] ?? "student1";

// Database connection
$pdo = new PDO("mysql:host=localhost;dbname=edupulsedb", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fetch instructors
$instructors = $pdo->query("SELECT i.instructor_id, i.first_name, i.last_name, c.title AS course_title 
                            FROM instructor i 
                            JOIN course c ON i.instructor_id = c.instructor_id")->fetchAll(PDO::FETCH_ASSOC);

// Fetch messages for this student
$stmt = $pdo->prepare("SELECT * FROM messages WHERE sender = ? OR receiver = ? ORDER BY created_at DESC");
$stmt->execute([$student_username, $student_username]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Messaging</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f3f6fa;
      margin: 0;
      padding: 20px;
    }

    h1, h2 {
      color: #333;
    }

    .container {
      max-width: 800px;
      margin: auto;
      background-color: #fff;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    form {
      margin-bottom: 30px;
    }

    label {
      font-weight: bold;
    }

    select, textarea {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    textarea {
      height: 100px;
      resize: vertical;
    }

    button {
      background-color:rgb(4, 12, 26);
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color:rgb(212, 180, 49);
    }

    .message-box {
      border: 1px solid #ddd;
      padding: 15px;
      margin-bottom: 15px;
      border-radius: 8px;
      background-color: #fafafa;
    }

    .message-box strong {
      color: #555;
    }

    .no-messages {
      font-style: italic;
      color: #777;
    }

    .top-btn {
      text-align: right;
    }

    .top-btn a {
      text-decoration: none;
    }

    .top-btn button {
      background-color: #444;
    }

    .top-btn button:hover {
      background-color: #222;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Send a Message</h1>
    <form action="../Controller/send.php" method="post">
      <input type="hidden" name="sender" value="<?= htmlspecialchars($student_username) ?>">

      <label for="subject">Subject (Course):</label>
      <select name="subject" id="subject" required>
        <option value="">-- Choose Course --</option>
        <?php foreach ($instructors as $inst): ?>
          <option value="<?= htmlspecialchars($inst['course_title']) ?>">
            <?= htmlspecialchars($inst['course_title']) ?>
          </option>
        <?php endforeach; ?>
      </select>

      <label for="receiver">Instructor:</label>
      <select name="receiver" id="receiver" required>
        <option value="">-- Choose Instructor --</option>
        <?php foreach ($instructors as $inst): ?>
          <option value="<?= htmlspecialchars($inst['first_name'].' '.$inst['last_name']) ?>">
            <?= htmlspecialchars($inst['course_title'] . " - " . $inst['first_name'].' '.$inst['last_name']) ?>
          </option>
        <?php endforeach; ?>
      </select>

      <label for="message">Message:</label>
      <textarea name="message" id="message" placeholder="Type your message..." required></textarea>

      <button type="submit">Send</button>
    </form>

    <hr>

    <h2>Your Inbox</h2>
    <?php if (empty($messages)): ?>
      <p class="no-messages">No messages yet. Start the conversation!</p>
    <?php else: ?>
      <?php foreach ($messages as $msg): ?>
        <div class="message-box">
          <strong>From:</strong>   <?= htmlspecialchars($msg['sender'])  ?><br>
          <strong>To:</strong>     <?= htmlspecialchars($msg['receiver'])?><br>
          <strong>Subject:</strong><?= htmlspecialchars($msg['subject']) ?><br>
          <strong>At:</strong>     <?= htmlspecialchars($msg['created_at'])?><br><br>
          <?= nl2br(htmlspecialchars($msg['message'])) ?>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</body>
</html>