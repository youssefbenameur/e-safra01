<?php
class Event {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getEvents($student_id) {
        $sql = "SELECT 
                    event_id AS id,
                    title,
                    start_date AS start,
                    end_date AS end,
                    description
                FROM student_events 
                WHERE student_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$student_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addEvent($student_id, $title, $start, $end, $description) {
        $sql = "INSERT INTO student_events 
                (student_id, title, start_date, end_date, description)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$student_id, $title, $start, $end, $description]);
    }

    public function updateEvent($event_id, $student_id, $title, $start, $end, $description) {
        $sql = "UPDATE student_events SET
                title = ?, 
                start_date = ?, 
                end_date = ?, 
                description = ?
                WHERE event_id = ? AND student_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$title, $start, $end, $description, $event_id, $student_id]);
    }

    public function deleteEvent($event_id, $student_id) {
        $sql = "DELETE FROM student_events 
                WHERE event_id = ? AND student_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$event_id, $student_id]);
    }
}