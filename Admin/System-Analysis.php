<?php 
session_start();
include "../Utils/Util.php";
include "../Utils/Validation.php";
if (isset($_SESSION['username']) &&
    isset($_SESSION['admin_id'])) {
    
    include "../Controller/Admin/System.php";  
    // get Certificates
    $student_count = getstudentsCount();
    $Instructor_count = getInstructorCount();
    $Course_count = getCourseCount();
    
    # Header 
    $title = "EduPulse - System Analysis";
    include "inc/Header.php";
?>
<style>
    .container {
        padding: 20px;
        background-color: #f5f5f5;
        min-height: 100vh;
    }
    .system-activities, .enrollment-statistics {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 20px;
        border-left: 4px solid #e3b500;
    }
    h4 {
        color: #2c3e50;
        border-bottom: 2px solid #e3b500;
        padding-bottom: 8px;
    }
    ul {
        list-style-type: none;
        padding: 0;
    }
    ul li {
        padding: 8px 0;
        border-bottom: 1px solid #eee;
    }
    ul li span {
        color: #e3b500;
        font-weight: bold;
        margin-right: 10px;
    }
    .d-flex {
        display: flex;
        gap: 20px;
    }
    .mb-4, .mb-5 {
        margin-bottom: 20px;
    }
</style>
<div class="container">
  <!-- NavBar -->
  <?php include "inc/NavBar.php"; ?>

    <!-- Display Recent Activities -->
    <div class="mb-4 system-activities">
        <h4>Recent Activities</h4>
        <ul>
            <li>10 new students joined this week.</li>
            <li>5 new courses were created.</li>
            <li>Quiz completion rates have increased by 15%.</li>
        </ul>
    </div>

    <!-- Display Course Enrollment Statistics -->
    <div class="mb-5 enrollment-statistics">
        <h4>Course Enrollment Statistics</h4>
        <p>Top 3 Courses with Highest Enrollment</p>
        <ul class="d-flex">
            <li><span>150 students</span>Course A</li>
            <li><span>100 students</span>Course B</li>
            <li><span>120 students</span>Course C</li>
        </ul>
    </div>
    
    <h4>Expected vs Actual Student Registration This Week</h4>
    <div class="mb-5" style="max-width: 350px">
        <canvas id="registrationPieChart" width="400" height="400"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Pie Chart
    var registrationPieChart = {
        labels: ['Actual', 'Expected'],
        datasets: [{
            data: [300, 500],
            backgroundColor: ['#e3b500', '#1a1a1a'],
        }]
    };

    new Chart(document.getElementById('registrationPieChart'), {
        type: 'pie',
        data: registrationPieChart
    });
</script>

<!-- Footer -->
<?php include "inc/Footer.php"; ?>

<?php
 }else { 
$em = "First login ";
Util::redirect("../login.php", "error", $em);
} ?>