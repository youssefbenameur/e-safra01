<?php
session_start();
include "../Utils/Util.php";
include "../Database.php";
include "../Models/Student.php";

if (isset($_SESSION['student_id'])) {
    $db = new Database();
    $db_conn = $db->connect();
    
    // Example events - replace with your actual event fetching logic
    $events = [
        [
            'title' => 'Midterm Exams',
            'start' => date('Y-m-d', strtotime('+1 week')),
            'color' => '#dc3545'
        ],
        [
            'title' => 'Project Deadline',
            'start' => date('Y-m-d', strtotime('+2 weeks')),
            'color' => '#007bff'
        ]
    ];

    header('Content-Type: application/json');
    echo json_encode($events);
} else {
    http_response_code(401);
    echo json_encode([]);
}