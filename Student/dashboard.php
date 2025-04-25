







<?php 
session_start();
include "../Utils/Util.php";
if (isset($_SESSION['username']) && isset($_SESSION['student_id'])) {

    include "../Controller/Student/Student.php";

    $_id =  $_SESSION['student_id'];
    $student = getById($_id);

    if (empty($student['student_id'])) {
        $em = "Invalid Student id";
        Util::redirect("../logout.php", "error", $em);
    }
    
    $notes = [];
    try {
        $notes = getNotes($_id);
    } catch(Exception $e) {
        $em = "Error loading notes: " . $e->getMessage();
    }  
    
    $title = "E-Safra - Students ";
    include "inc/Header.php";
?>

<!-- Add these in header -->
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    :root {
        --primary: #000000;
        --secondary: #836f0a;
        --accent: #5c5951;
        --light: #fffcf2;
        --dark: #2a2a2a;
        --text-dark: #333333;
    }

    body {
        font-family: 'Nunito', sans-serif;
        background: var(--light);
        color: var(--text-dark);
    }

    .welcome-card {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 20px;
        padding: 2rem;
        margin: 2rem 0;
        color: white;
        box-shadow: 0 10px 20px rgba(227, 181, 0, 0.2);
        position: relative;
        overflow: hidden;
    }

    .dashboard-card {
        background: rgba(175, 175, 175, 0.16);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        height: 100%;
        border: 2px solid black;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 25px rgba(227, 181, 0, 0.1);
    }

    .dashboard-card h5 {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 700;
        color: var(--dark);
    }

    .dashboard-card h5 i {
        width: 40px;
        height: 40px;
        background: rgba(227, 181, 0, 0.1);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
    }

    .dashboard-btn {
        background: var(--primary);
        color: white !important;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        text-decoration: none !important;
        border: 2px solid transparent;
    }

    .dashboard-btn:hover {
        background: var(--secondary);
        transform: translateY(-2px);
        color: white !important;
    }

    .announcement-item {
        padding: 1rem;
        border-radius: 10px;
        background: #e2e2e2;
        margin-bottom: 1rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        border: 1px solid black;
    }

    .quick-links {
        display: grid;
        gap: 0.75rem;
    }

    .quick-links a {
        padding: 1rem;
        border-radius: 10px;
        background: #e2e2e2;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.3s ease;
        text-decoration: none !important;
        color: var(--text-dark);
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .quick-links a i {
        width: 30px;
        height: 30px;
        background: var(--primary);
        color: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .quick-links a:hover {
        background: var(--primary);
        color: white !important;
        transform: translateX(5px);
    }
    .dashboard-container {
        padding: 1em;
    }
    .note-item {
        background: white;
        padding: 1rem;
        border-radius: 10px;
        margin-bottom: 1rem;
        position: relative;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .note-actions {
        position: absolute;
        bottom: 0.5rem;
        right: 0.5rem;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .note-item:hover .note-actions {
        opacity: 1;
    }

    .fab-container {
        position: fixed;
        bottom: 2rem;
        left: 2rem;
        z-index: 1000;
    }

    .fab-main {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 6px 12px rgba(227, 181, 0, 0.3);
        transition: all 0.3s ease;
    }

    .fab-main:hover {
        transform: scale(1.1);
    }

    .fc {
        background: white;
        border-radius: 15px;
        padding: 1rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .dashboard-container {
            padding: 15px;
        }

        .welcome-card {
            padding: 1.5rem;
            margin: 1rem 0;
        }

        .welcome-card h1 {
            font-size: 1.8rem;
        }

        .dashboard-card {
            margin-bottom: 1rem;
        }

        .fab-main {
            width: 48px;
            height: 48px;
            bottom: 1.5rem;
            right: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .welcome-card h1 {
            font-size: 1.5rem;
        }

        .welcome-card p {
            font-size: 0.95rem;
        }

        .dashboard-card h5 {
            font-size: 1.1rem;
        }

        .dashboard-btn {
            width: 100%;
            justify-content: center;
        }

        .col-md-6, .col-md-4, .col-md-8 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        #calendar {
            min-height: 300px;
        }
    }

    @media (max-width: 576px) {
        .dashboard-container {
            padding: 10px;
        }

        .welcome-card {
            padding: 1rem;
        }

        .note-actions {
            opacity: 1;
            position: relative;
            top: auto;
            right: auto;
            margin-top: 0.5rem;
            justify-content: flex-end;
        }

        .note-item:hover .note-actions {
            opacity: 1;
        }

        .modal-dialog {
            margin: 0.5rem;
        }
    }
</style>

<header>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</header>

<?php include "inc/NavBar.php"; ?>
<?php include 'chatbot.php'; ?>
<div class="dashboard-container">
    <!-- Floating Action Button -->
    <div class="fab-container">
        <div class="fab-main" data-bs-toggle="modal" data-bs-target="#noteModal">
            <i class="fas fa-plus"></i>
        </div>
    </div>

    <div class="row" style="margin-top: 50px;">
        <div class="col-md-12">
            <div class="welcome-card">
                <h1>Welcome <?=$student['first_name']?></h1>
                <p>This is your student dashboard. Manage courses, view schedules, and access academic resources.</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="dashboard-card">
                <h5><i class="fas fa-book-open"></i>My Courses</h5>
                <p>Manage your enrolled courses and access materials</p>
                <a href="courses.php" class="dashboard-btn">
                    <i class="fas fa-arrow-right"></i>View Courses
                </a>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="dashboard-card">
                <h5><i class="fas fa-comments"></i>My Messages</h5>
                <p>Communicate with instructors and peers</p>
                <a href="student_messages.php" class="dashboard-btn">
                    <i class="fas fa-inbox"></i>View Messages
                </a>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="dashboard-card">
                <h5><i class="fas fa-user-edit"></i>My Profile</h5>
                <p>Update your personal information</p>
                <a href="Profile-View.php" class="dashboard-btn">
                    <i class="fas fa-cog"></i>Edit Profile
                </a>
            </div>
        </div>
    </div>

    <div class="row mt-4 g-4">
        <div class="col-md-6">
            <div class="dashboard-card">
                <h5><i class="fas fa-bullhorn"></i>Announcements</h5>
                <div class="announcements-list">
                    <div class="announcement-item">
                        <h6>Midterm Schedule Posted</h6>
                        <p class="text-muted small"><i class="fas fa-clock"></i> April 15, 2025</p>
                        <p>The midterm examination schedule has been posted.</p>
                    </div>
                    <div class="announcement-item">
                        <h6>Campus Event: Career Fair</h6>
                        <p class="text-muted small"><i class="fas fa-clock"></i> April 10, 2025</p>
                        <p>Don't miss the annual career fair happening next week.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="dashboard-card">
                <h5><i class="fas fa-rocket"></i>Quick Access</h5>
                <div class="quick-links">
                    <a href="library.php">
                        <i class="fas fa-book"></i>
                        Library Resources
                    </a>
                    <a href="grades.php">
                        <i class="fas fa-chart-line"></i>
                        View Grades
                    </a>
                    <a href="calendar.php">
                        <i class="fas fa-calendar-alt"></i>
                        Academic Calendar
                    </a>
                    <a href="support.php">
                        <i class="fas fa-life-ring"></i>
                        Student Support
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4 g-4">
        <div class="col-md-8">
            <div class="dashboard-card">
                <h5><i class="fas fa-calendar-alt"></i>Academic Calendar</h5>
                <div id="calendar" style="min-height: 400px;"></div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="dashboard-card">
                <h5><i class="fas fa-sticky-note"></i>My Notes</h5>
                <div class="notes-list mt-3">
                    <?php if(count($notes) > 0): ?>
                        <?php foreach($notes as $note): ?>
                            <div class="note-item">
                                <div class="note-content">
                                    <?= htmlspecialchars($note['content']) ?>
                                    <div class="note-actions d-flex">
                                        <button class="btn btn-link text-primary edit-note"
                                                data-id="<?= $note['note_id'] ?>"
                                                data-content="<?= htmlspecialchars($note['content']) ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form method="post" action="../Controller/Student/NoteAction.php">
                                            <input type="hidden" name="note_id" value="<?= $note['note_id'] ?>">
                                            <button type="submit" name="delete" class="btn btn-link text-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-clock"></i>
                                    <?= date('M d, Y h:i A', strtotime($note['created_at'])) ?>
                                </small>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state text-center py-4">
                            <i class="fas fa-comment-slash fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No notes found. Tap the + button to create one!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Note Modal -->
    <div class="modal fade" id="noteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Manage Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="post" action="/e-safra01/Controller/Student/NoteAction.php">
                    <input type="hidden" name="note_id" id="editNoteId">
                    <div class="modal-body">
                        <div class="form-group">
                            <textarea class="form-control note-editor" 
                                    name="content" 
                                    id="noteContent"
                                    placeholder="Start typing your note here..."
                                    rows="5"
                                    style="border-radius: 10px; padding: 1rem;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="update" class="btn btn-primary" id="updateBtn">
                            <i class="fas fa-save me-2"></i>Update
                        </button>
                        <button type="submit" class="btn btn-success" id="saveBtn">
                            <i class="fas fa-plus-circle me-2"></i>Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
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
    initialView: 'dayGridMonth',
    themeSystem: 'bootstrap5',
    eventColor: 'var(--primary)',
    eventTextColor: 'var(--dark)',
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
        info.el.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
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

<?php include "inc/Footer.php"; ?>

<?php } else { 
    $em = "First login ";
    Util::redirect("../login.php", "error", $em);
} ?>
