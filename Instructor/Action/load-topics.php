<?php
session_start();

// 1. Utilities & Models
require_once __DIR__ . '/../../Utils/Util.php';
require_once __DIR__ . '/../../Utils/Validation.php';
require_once __DIR__ . '/../../Database.php';
require_once __DIR__ . '/../../Models/Course.php';

// 2. Authorization check
if (! isset($_SESSION['username'], $_SESSION['instructor_id'])) {
    Util::redirect(__DIR__ . '/../../login.php', 'error', 'First login');
    exit;
}

// 3. Only accept POST requests with a chapter_id
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || ! isset($_POST['chapter_id'])) {
    // You could also return a 400 status here
    echo '0';
    exit;
}

// 4. Clean input
$chapter_id = Validation::clean($_POST['chapter_id']);

// 5. Connect to database & load topics
$db   = new Database();
$conn = $db->connect();
$course = new Course($conn);

$topics = $course->getTopicsByChapterId($chapter_id);

// 6. Output
if ($topics && is_array($topics)) {
    foreach ($topics as $topic) {
        // Escape output for safety
        $id    = htmlspecialchars($topic['topic_id'],   ENT_QUOTES, 'UTF-8');
        $title = htmlspecialchars($topic['title'],      ENT_QUOTES, 'UTF-8');
        echo "<option value=\"{$id}\">{$title}</option>";
    }
} else {
    echo '0';
}
