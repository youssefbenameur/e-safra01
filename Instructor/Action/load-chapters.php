<?php
// Turn on full error reporting for development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// 1. Includes
require_once __DIR__ . '/../../Utils/Util.php';
require_once __DIR__ . '/../../Utils/Validation.php';
require_once __DIR__ . '/../../Database.php';
require_once __DIR__ . '/../../Models/Course.php';

// 2. Authorization check
if (! isset($_SESSION['username'], $_SESSION['instructor_id'])) {
    Util::redirect(__DIR__ . '/../../login.php', 'error', 'First login');
    exit;
}

// 3. Only accept POST with course_id
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || ! isset($_POST['course_id'])) {
    // Bad request
    http_response_code(400);
    echo '0';
    exit;
}

// 4. Sanitize input
$course_id = Validation::clean($_POST['course_id']);

// 5. Instantiate DB + Model
$db     = new Database();
$conn   = $db->connect();
$course = new Course($conn);

// 6. Fetch chapters
try {
    $chapters = $course->getChapters($course_id);
    echo 
    if (! $chapters || ! is_array($chapters)) {
        // No chapters found
        echo '0';
        exit;
    }

    // 7. Output <option> elements
    foreach ($chapters as $chapter) {
        $id    = htmlspecialchars($chapter['chapter_id'], ENT_QUOTES, 'UTF-8');
        $title = htmlspecialchars($chapter['title'],      ENT_QUOTES, 'UTF-8');
        echo "<option value=\"{$id}\">{$title}</option>\n";
    }

} catch (Exception $e) {
    // Log the actual DB error for your debugging
    error_log("Error fetching chapters for course_id={$course_id}: " . $e->getMessage());
    // Return generic failure to client
    echo '0';
    exit;
}
