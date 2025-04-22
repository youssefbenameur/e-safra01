<?php 
  session_start();
  include "../Controller/Admin/System.php";  
  $student_count    = getstudentsCount();
  $Instructor_count = getInstructorCount();
  $Course_count     = getCourseCount();
  $title = "Admin Dashboard - E-SAFRA";
  include "inc/Header.php"; 
  include "inc/NavBar.php";
?>

<div class="container dashboard-wrapper">
  <div class="dashboard-layout">
    <!-- Left Panel: Overall Statistics Cards -->
    <div class="left-panel">
      <h2>Overview</h2>
      <div class="dashboard-cards">
        <div class="card">
          <h3>Total Students</h3>
          <p><?php echo $student_count; ?></p>
        </div>
        <div class="card">
          <h3>Total Instructors</h3>
          <p><?php echo $Instructor_count; ?></p>
        </div>
        <div class="card">
          <h3>Total Courses</h3>
          <p><?php echo $Course_count; ?></p>
        </div>
      </div>
    </div>
    
    <!-- Right Panel: Analysis & Charts -->
    <div class="right-panel">
      <h2>Analysis & Trends</h2>
      <div class="analysis-section">
        <div class="chart-box">
          <h4>Student Growth (Last 4 Weeks)</h4>
          <canvas id="studentGrowthChart" width="400" height="200"></canvas>
        
                  
        </div>
      </div>
    </div>
  </div>
</div>

<?php include "inc/Footer.php"; ?>

<script>
// Sample Data for Student Growth Chart
var studentGrowthData = {
  labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
  datasets: [{
    label: 'New Students',
    data: [10, 25, 15, 20],
    backgroundColor: 'rgba(75, 192, 192, 0.2)',
    borderColor: 'rgba(75, 192, 192, 1)',
    borderWidth: 1
  }]
};

var ctx1 = document.getElementById('studentGrowthChart').getContext('2d');
new Chart(ctx1, {
  type: 'bar',
  data: studentGrowthData,
  options: {
      scales: {
          y: { beginAtZero: true }
      }
  }
});


</script>