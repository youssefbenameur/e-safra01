<?php
session_start();
include "../../Utils/Util.php";
include "../../Database.php";
include "../../Models/Event.php";

if (isset($_SESSION['student_id'])) {
    $student_id = $_SESSION['student_id'];
    $db = new Database();
    $db_conn = $db->connect();
    $event_model = new Event($db_conn);

    header('Content-Type: application/json');

    try {
        $operation = $_POST['operation'] ?? 'read';
        
        switch($operation) {
            case 'create':
                $result = $event_model->addEvent(
                    $student_id,
                    $_POST['title'],
                    $_POST['start'],
                    $_POST['end'] ?? null,
                    $_POST['description'] ?? ''
                );
                echo json_encode(['success' => $result]);
                break;

            case 'update':
                $result = $event_model->updateEvent(
                    $_POST['event_id'],
                    $student_id,
                    $_POST['title'],
                    $_POST['start'],
                    $_POST['end'] ?? null,
                    $_POST['description'] ?? ''
                );
                echo json_encode(['success' => $result]);
                break;

            case 'delete':
                $result = $event_model->deleteEvent(
                    $_POST['event_id'],
                    $student_id
                );
                echo json_encode(['success' => $result]);
                break;

            default: // read
                $events = $event_model->getEvents($student_id);
                echo json_encode($events);
        }
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    } catch(Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
}