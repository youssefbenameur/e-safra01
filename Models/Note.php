<?php
class Note {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addNote($student_id, $content) {
        $sql = "INSERT INTO student_notes (student_id, content) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$student_id, $content]);
    }

    public function getNotes($student_id) {
        $sql = "SELECT * FROM student_notes WHERE student_id = ? ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$student_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteNote($note_id, $student_id) {
        $sql = "DELETE FROM student_notes WHERE note_id = ? AND student_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$note_id, $student_id]);
    }
    public function updateNote($note_id, $student_id, $content) {
        $sql = "UPDATE student_notes SET content = ? WHERE note_id = ? AND student_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$content, $note_id, $student_id]);
    }
}