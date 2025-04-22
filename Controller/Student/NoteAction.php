<?php
session_start();
include "../../Utils/Util.php";
include "../../Database.php";
include "../../Models/Note.php"; // Include Note model

if (isset($_SESSION['student_id'])) {
    $student_id = $_SESSION['student_id'];
    $db = new Database();
    $db_conn = $db->connect();
    $note_model = new Note($db_conn);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        try {
            if (isset($_POST['delete'])) {
                $success = $note_model->deleteNote($_POST['note_id'], $student_id);
                $message = $success ? "Note deleted successfully" : "Error deleting note";
            } elseif (isset($_POST['update'])) {
                $success = $note_model->updateNote(
                    $_POST['note_id'],
                    $student_id,
                    $_POST['content']
                );
                $message = $success ? "Note updated successfully" : "Error updating note";
            } else {
                $success = $note_model->addNote(
                    $student_id,
                    $_POST['content']
                );
                $message = $success ? "Note saved successfully" : "Error saving note";
            }
        
            Util::redirect(
                "/e-safra01/student/dashboard.php",  // Absolute path from root
                ($success ? "success" : "error"),
                $message
            );
        } catch(PDOException $e) {
            Util::redirect(
                "../../../student/dashboard.php",
                "error",
                "Database error: " . $e->getMessage()
            );
        }
    }
} else {
    $em = "Unauthorized access";
    Util::redirect("../../login.php", "error", $em);
}