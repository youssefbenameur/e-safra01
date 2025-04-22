<?php 
session_start();
include "../Utils/Util.php";
if (isset($_SESSION['username']) &&
    isset($_SESSION['student_id'])) {

        include "../Controller/Student/Student.php";

        $_id =  $_SESSION['student_id'];
        $student = getById($_id);
    
       if (empty($student['student_id'])) {
         $em = "Invalid Student id";
         Util::redirect("../logout.php", "error", $em);
       }
       $notes = [];
       try {
           $notes = getNotes($_id); // Make sure this function is properly defined
       } catch(Exception $e) {
           $em = "Error loading notes: " . $e->getMessage();
            // Add this to your Util class if needed
       }  
    # Header
    $title = "E-Safra - Students ";
    include "inc/Header.php";

?>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
        color: #333;
        background-color: #f5f7fa;
        margin: 0;
        padding: 0;
    }
    /* Dashboard Styles */
    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .welcome-card {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        border-left: 5px solid #007bff;
    }
    
    .welcome-card h1 {
        color: #2c3e50;
        margin-bottom: 15px;
        font-size: 28px;
    }
    
    .welcome-card p {
        color: #7f8c8d;
        font-size: 16px;
    }
    
    .dashboard-card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        padding: 20px;
        margin-bottom: 20px;
        transition: transform 0.3s ease;
        height: 100%;
    }
    
    .dashboard-card:hover {
        transform: translateY(-5px);
    }
    
    .dashboard-card h5 {
        color: #2c3e50;
        font-size: 18px;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }
    
    .dashboard-card p {
        color: #7f8c8d;
        margin-bottom: 20px;
    }
    
    .dashboard-btn {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.3s ease;
    }
    
    .dashboard-btn:hover {
        background-color: #0056b3;
        text-decoration: none;
        color: #fff;
    }
    
    .announcement-item {
        padding-bottom: 15px;
        margin-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    
    .announcement-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .announcement-item h6 {
        font-size: 16px;
        color: #2c3e50;
        margin-bottom: 5px;
    }
    
    .announcement-date {
        font-size: 12px;
        color: #95a5a6;
        margin-bottom: 8px;
    }
    
    .quick-links {
        list-style-type: none;
        padding: 0;
    }
    
    .quick-links li {
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }
    
    .quick-links li:last-child {
        border-bottom: none;
    }
    
    .quick-links a {
        color: #3498db;
        text-decoration: none;
        display: block;
        transition: color 0.3s ease;
    }
    
    .quick-links a:hover {
        color: #2980b9;
    }
    
    .row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -10px;
        margin-left: -10px;
    }
    
    .col-md-12 {
        flex: 0 0 100%;
        max-width: 100%;
        padding-right: 10px;
        padding-left: 10px;
    }
    
    .col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;
        padding-right: 10px;
        padding-left: 10px;
    }
    
    .col-md-4 {
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
        padding-right: 10px;
        padding-left: 10px;
    }
    
    /* Footer styling */
    .footer {
        background-color: #2c3e50;
        color: #ecf0f1;
        padding: 20px 0;
        text-align: center;
        margin-top: 40px;
    }
    
    .footer p {
        margin: 0;
    }
    
    @media (max-width: 768px) {
        .col-md-6, .col-md-4 {
            flex: 0 0 100%;
            max-width: 100%;
        }
        
        .navbar-container {
            flex-direction: column;
            text-align: center;
        }
        
        .navbar-menu {
            margin-top: 15px;
            justify-content: center;
        }
        
        .navbar-menu li {
            margin: 0 10px;
        }
    }
</style>
<header>
    <!-- In your header section -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- In your header -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</header>

<?php include "inc/NavBar.php"; ?>
<div class="dashboard-container">
    
    <div class="row" style="margin-top: 90px;">
        <div class="col-md-12">
            <div class="welcome-card">
                <h1>Welcome <?=$student['first_name']?></h1>
                <p>This is your student dashboard. Here you can manage your courses, view your schedule, and access your academic resources.</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="dashboard-card">
                <h5>My Courses</h5>
                <p>View and manage your enrolled courses.</p>
                <a href="courses.php" class="dashboard-btn">View Courses</a>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="dashboard-card">
                <h5>My Schedule</h5>
                <p>Check your class schedule and upcoming events.</p>
                <a href="schedule.php" class="dashboard-btn">View Schedule</a>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="dashboard-card">
                <h5>My Profile</h5>
                <p>Update your personal information and settings.</p>
                <a href="Profile-View.php" class="dashboard-btn">Edit Profile</a>
            </div>
        </div>
    </div>
    
    <div class="row" style="margin-top: 20px;">
        <div class="col-md-6">
            <div class="dashboard-card">
                <h5>Announcements</h5>
                <div class="announcements-list">
                    <div class="announcement-item">
                        <h6>Midterm Schedule Posted</h6>
                        <p class="announcement-date">Posted on: April 15, 2025</p>
                        <p>The midterm examination schedule has been posted. Please check your email for details.</p>
                    </div>
                    <div class="announcement-item">
                        <h6>Campus Event: Career Fair</h6>
                        <p class="announcement-date">Posted on: April 10, 2025</p>
                        <p>Don't miss the annual career fair happening next week in the main hall.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="dashboard-card">
                <h5>Quick Links</h5>
                <ul class="quick-links">
                    <li><a href="library.php">Library Resources</a></li>
                    <li><a href="grades.php">View Grades</a></li>
                    <li><a href="calendar.php">Academic Calendar</a></li>
                    <li><a href="support.php">Student Support</a></li>
                    <li><a href="documents.php">Document Center</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <!-- Calendar Section -->
        <div class="col-md-8">
            <div class="dashboard-card">
                <h5>Academic Calendar</h5>
                <div id="calendar" style="min-height: 400px;"></div>
            </div>
        </div>
    
        <!-- Notes Section -->
<div class="col-md-4">
    <div class="dashboard-card">
        <h5>My Notes <button class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#noteModal">Add New</button></h5>
        
        <!-- Notes List -->
        <div class="mt-4">
            <?php if(count($notes) > 0): ?>
                <?php foreach($notes as $note): ?>
                    <div class="announcement-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <p style="color: #2c3e50;"><?= htmlspecialchars($note['content']) ?></p>
                            <div>
                                <button class="btn btn-link text-primary p-0 edit-note" 
                                        data-id="<?= $note['note_id'] ?>"
                                        data-content="<?= htmlspecialchars($note['content']) ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form method="post" action="../Controller/Student/NoteAction.php" class="d-inline">
                                    <input type="hidden" name="note_id" value="<?= $note['note_id'] ?>">
                                    <button type="submit" name="delete" class="btn btn-link text-danger p-0">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <small class="announcement-date"><?= date('M d, Y h:i A', strtotime($note['created_at'])) ?></small>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-info">No notes found. Create your first note!</div>
            <?php endif; ?>
        </div>
    </div>
</div>
        
        <!-- Note Modal -->
        <div class="modal fade" id="noteModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Manage Note</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="post" action="/e-safra01/Controller/Student/NoteAction.php">
                        <input type="hidden" name="note_id" id="editNoteId">
                        <div class="modal-body">
                            <div class="form-group">
                                <textarea class="form-control" name="content" 
                                        id="noteContent"
                                        placeholder="Write your note here..." 
                                        rows="4" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="update" class="btn btn-primary" id="updateBtn">Update Note</button>
                            <button type="submit" class="btn btn-primary" id="saveBtn">Save Note</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <script>
        // Handle edit click
        document.querySelectorAll('.edit-note').forEach(button => {
            button.addEventListener('click', () => {
                document.getElementById('editNoteId').value = button.dataset.id;
                document.getElementById('noteContent').value = button.dataset.content;
                document.getElementById('updateBtn').style.display = 'inline-block';
                document.getElementById('saveBtn').style.display = 'none';
                new bootstrap.Modal(document.getElementById('noteModal')).show();
            });
        });
        
        // Reset modal for new notes
        document.getElementById('noteModal').addEventListener('hidden.bs.modal', () => {
            document.getElementById('editNoteId').value = '';
            document.getElementById('noteContent').value = '';
            document.getElementById('updateBtn').style.display = 'none';
            document.getElementById('saveBtn').style.display = 'inline-block';
        });
        </script>
    </div>
    <!-- Event Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Manage Event</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="eventForm">
                    <div class="modal-body">
                        <input type="hidden" id="eventId">
                        <div class="form-group">
                            <label>Event Title</label>
                            <input type="text" class="form-control" id="title" required>
                        </div>
                        <div class="form-group">
                            <label>Start Date/Time</label>
                            <input type="datetime-local" class="form-control" id="start" required>
                        </div>
                        <div class="form-group">
                            <label>End Date/Time</label>
                            <input type="datetime-local" class="form-control" id="end">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" id="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger mr-auto" id="deleteBtn">Delete</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Calendar Dependencies -->
     <!-- Add in your header section -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
     <!-- Add these in the <head> section or before your custom scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        // ... other config options ...
        dateClick: function(info) {
            document.querySelector('#start').value = info.dateStr + 'T00:00';
            new bootstrap.Modal(document.getElementById('eventModal')).show();
        },
        eventClick: function(info) {
            const event = info.event;
            document.querySelector('#eventId').value = event.id;
            document.querySelector('#title').value = event.title;
            document.querySelector('#start').value = event.start?.toISOString().slice(0, 16);
            document.querySelector('#end').value = event.end?.toISOString().slice(0, 16);
            document.querySelector('#description').value = event.extendedProps.description;
            new bootstrap.Modal(document.getElementById('eventModal')).show();
        }
    });
    calendar.render();
});
// Replace jQuery code with vanilla JS
document.getElementById('eventForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    formData.append('operation', document.getElementById('eventId').value ? 'update' : 'create');
    
    fetch('../Controller/Student/EventAction.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            calendar.refetchEvents();
            bootstrap.Modal.getInstance(document.getElementById('eventModal')).hide();
        }
    });
});

document.getElementById('deleteBtn').addEventListener('click', function() {
    if(confirm('Are you sure?')) {
        const formData = new FormData();
        formData.append('operation', 'delete');
        formData.append('event_id', document.getElementById('eventId').value);
        
        fetch('../Controller/Student/EventAction.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                calendar.refetchEvents();
                bootstrap.Modal.getInstance(document.getElementById('eventModal')).hide();
            }
        });
    }
});
        document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: '../Controller/Student/EventAction.php',
        editable: true,
        selectable: true,
        eventDidMount: function(info) {
            info.el.style.borderRadius = '8px';
            info.el.style.padding = '5px';
            info.el.style.backgroundColor = '#3788d8'; // Default color
        },
        dateClick: function(info) {
            $('#eventModal').modal('show');
            $('#start').val(info.dateStr + 'T00:00');
        },
        eventClick: function(info) {
            const event = info.event;
            $('#eventId').val(event.id);
            $('#title').val(event.title);
            $('#start').val(event.start?.toISOString().slice(0, 16));
            $('#end').val(event.end?.toISOString().slice(0, 16));
            $('#description').val(event.extendedProps.description);
            $('#eventModal').modal('show');
        }
    });
    calendar.render();

    // Handle form submission
    $('#eventForm').submit(function(e) {
        e.preventDefault();
        const formData = {
            operation: $('#eventId').val() ? 'update' : 'create',
            event_id: $('#eventId').val(),
            title: $('#title').val(),
            start: $('#start').val(),
            end: $('#end').val(),
            description: $('#description').val()
        };

        $.post('../Controller/Student/EventAction.php', formData)
            .done(function(response) {
                if(response.success) {
                    calendar.refetchEvents();
                    $('#eventModal').modal('hide');
                }
            })
            .fail(function(xhr) {
                console.error('Error:', xhr.responseText);
            });
    });

    // Handle delete
    $('#deleteBtn').click(function() {
        if(confirm('Are you sure you want to delete this event?')) {
            $.post('../Controller/Student/EventAction.php', {
                operation: 'delete',
                event_id: $('#eventId').val()
            }).done(function(response) {
                if(response.success) {
                    calendar.refetchEvents();
                    $('#eventModal').modal('hide');
                }
            });
        }
    });

    // Reset form on modal close
    $('#eventModal').on('hidden.bs.modal', function() {
        $('#eventForm')[0].reset();
        $('#eventId').val('');
    });
});
    </script>
</div>




<!-- Footer -->
<?php include "inc/Footer.php"; ?>

<?php
 }else { 
$em = "First login ";
Util::redirect("../login.php", "error", $em);
} ?>


