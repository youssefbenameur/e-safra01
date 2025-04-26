<?php
session_start();
include "../Utils/Util.php";
if (!isset($_SESSION['username']) || !isset($_SESSION['student_id'])) {
    Util::redirect("../login.php", "error", "Please login first");
}

include "../Controller/Student/Student.php";
$pdo = new PDO("mysql:host=localhost;dbname=edupulsedb", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fetch instructors
$instructors = $pdo->query("SELECT i.instructor_id, i.first_name, i.last_name, c.title AS course_title 
                            FROM instructor i 
                            JOIN course c ON i.instructor_id = c.instructor_id")->fetchAll(PDO::FETCH_ASSOC);

// Fetch messages
$stmt = $pdo->prepare("SELECT * FROM messages WHERE sender = ? OR receiver = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['username'], $_SESSION['username']]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

$title = "E-Safra - Messages";
include "inc/Header.php";
?>



    <?php include "inc/NavBar.php"; ?>

    <style>
        :root {
            --primary: #e3b500;
            --secondary: #b58f00;
            --accent: #ffd95e;
            --light: #fffcf2;
            --dark: #2a2a2a;
            --text-dark: #333333;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background: var(--light);
            color: var(--text-dark);
        }

        .container {
            max-width: 800px;
            margin: 90px auto 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            padding: 2rem;
        }

        h1 {
            color: var(--dark);
            font-weight: 700;
            margin-bottom: 2rem;
            font-size: 2rem;
        }

        form {
            background: rgba(227, 181, 0, 0.03);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        select, textarea {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid rgba(0,0,0,0.1);
            border-radius: 8px;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        button {
            background: var(--primary);
            color: white;
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .message-box {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border-left: 4px solid var(--primary);
        }

        @media (max-width: 768px) {
            .container {
                margin: 70px 15px 30px;
                padding: 1.5rem;
            }
        }
    </style>

    <div class="container">
        <h1><i class="fas fa-comments me-2"></i>Student Messaging</h1>
        
        <form action="../Controller/send.php" method="post">
            <input type="hidden" name="sender" value="<?= htmlspecialchars($_SESSION['username']) ?>">
            
            <div class="mb-4">
                <label class="form-label">Course Subject:</label>
                <select class="form-select" name="subject" required>
                    <option value="">Select Course</option>
                    <?php foreach ($instructors as $inst): ?>
                    <option value="<?= htmlspecialchars($inst['course_title']) ?>">
                        <?= htmlspecialchars($inst['course_title']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label">Instructor:</label>
                <select class="form-select" name="receiver" required>
                    <option value="">Choose Instructor</option>
                    <?php foreach ($instructors as $inst): ?>
                    <option value="<?= htmlspecialchars($inst['first_name'].' '.$inst['last_name']) ?>">
                        <?= htmlspecialchars($inst['course_title'] . " - " . $inst['first_name'].' '.$inst['last_name']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label">Message:</label>
                <textarea class="form-control" name="message" rows="5" required></textarea>
            </div>

            <button type="submit" class="w-100">
                <i class="fas fa-paper-plane me-2"></i>Send Message
            </button>
        </form>

        <h2 class="mt-5"><i class="fas fa-inbox me-2"></i>Message History</h2>
        
        <?php if (empty($messages)): ?>
            <div class="alert alert-info">
                <i class="fas fa-comment-slash me-2"></i>
                No messages found. Start a conversation!
            </div>
        <?php else: ?>
            <?php foreach ($messages as $msg): ?>
            <div class="message-box">
                <div class="d-flex justify-content-between mb-2">
                    <div>
                        <strong><i class="fas fa-user me-1"></i><?= htmlspecialchars($msg['sender']) ?></strong>
                        <span class="text-muted ms-3"><?= date('M j, Y g:i A', strtotime($msg['created_at'])) ?></span>
                    </div>
                    <span class="badge bg-primary"><?= htmlspecialchars($msg['subject']) ?></span>
                </div>
                <p class="mb-0"><?= nl2br(htmlspecialchars($msg['message'])) ?></p>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


