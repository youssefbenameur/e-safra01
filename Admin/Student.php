<?php 
session_start();
include "../Utils/Util.php";
include "../Utils/Validation.php";
if (isset($_SESSION['username']) &&
    isset($_SESSION['admin_id'])) {
    
  if (isset($_GET['student_id'])) {
    include "../Controller/Admin/Student.php";
    $_id = Validation::clean($_GET['student_id']);
    $student = getById($_id);
   if (empty($student['student_id'])) {
     $em = "Invalid Student id";
     Util::redirect("index.php", "error", $em);
   }
   // get Certificates
   $certificates = getCertificate($_id);
    # Header 
    $title = "EduPulse - Student Profile";
    include "inc/Header.php";
?>

<div class="container">
  <!-- NavBar -->
  <?php include "inc/NavBar.php"; ?>
  
  <div class="d-flex justify-content-center mt-4">
    <div class="profile-card shadow-lg p-4 rounded-3" style="
        max-width: 600px;
        width: 100%;
        background: linear-gradient(135deg, #ffffff 0%, #f8f8f8 100%);
        border-left: 5px solid #e3b500;
    ">
      <!-- Profile Header -->
      <div class="profile-header text-center mb-4">
        <img class="rounded-circle shadow border border-4 border-gold mb-3" 
             src="../Upload/profile/<?=$student['profile_img']?>" 
             alt="PROFILE IMG" 
             width="150"
             style="object-fit: cover; aspect-ratio: 1/1;">
        <h4 class="fw-bold text-dark"><?=$student['first_name']?> <?=$student['last_name']?></h4>
        <span class="badge bg-dark text-gold">Student</span>
      </div>
      
      <!-- Profile Details -->
      <div class="profile-details">
        <ul class="list-group list-group-flush mb-4">
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span class="fw-medium text-muted">First Name</span>
            <span class="fw-bold"><?=$student['first_name']?></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span class="fw-medium text-muted">Last Name</span>
            <span class="fw-bold"><?=$student['last_name']?></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span class="fw-medium text-muted">Email</span>
            <span class="fw-bold"><?=$student['email']?></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span class="fw-medium text-muted">Date of Birth</span>
            <span class="fw-bold"><?=$student['date_of_birth']?></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span class="fw-medium text-muted">Joined Date</span>
            <span class="fw-bold"><?=$student['date_of_joined']?></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span class="fw-medium text-muted">Student ID</span>
            <span class="fw-bold"><?=$student['student_id']?></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span class="fw-medium text-muted">Username</span>
            <span class="fw-bold"><?=$student['username']?></span>
          </li>
        </ul>
        
        <div class="text-center mb-4">
          <a href="Reset-Password.php?for=Student&student_id=<?=$student['student_id']?>" 
             class="btn btn-gold shadow-sm px-4 py-2 fw-medium">
            Reset Password
          </a>
        </div>
      </div>
      
      <!-- Certificates Section -->
      <?php if (!empty($certificates[0]["certificate_id"])) { ?>
      <div class="certificates-section mt-4 pt-3 border-top" style="border-color: #e3b500 !important;">
        <h4 class="fw-bold mb-3">Certificates</h4>
        <ul class="list-group list-group-flush">
          <?php foreach ($certificates as $certificate) { ?>
          <li class="list-group-item hover-gold py-2">
            <a href="../Certificate.php?certificate_id=<?=$certificate['certificate_id']?>" 
               class="text-decoration-none text-dark d-flex justify-content-between align-items-center">
              <span class="fw-medium"><?=$certificate['course_title']?></span>
              <span class="badge bg-dark">View</span>
            </a>
          </li>
          <?php } ?>
        </ul>
      </div>
      <?php } ?>
    </div>
  </div>
</div>

<style>
  /* Custom styles to match the admin theme */
  .border-gold {
    border-color: #e3b500 !important;
  }
  
  .text-gold {
    color: #e3b500 !important;
  }
  
  .bg-gold {
    background-color: #e3b500 !important;
  }
  
  .btn-gold {
    background-color: #e3b500;
    color: #1a1a1a;
    font-weight: 600;
    transition: all 0.3s ease;
  }
  
  .btn-gold:hover {
    background-color: #d4aa00;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  }
  
  .hover-gold:hover {
    background-color: rgba(227, 181, 0, 0.1);
    transform: translateX(5px);
    transition: all 0.3s ease;
  }
  
  .profile-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  
  .profile-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
  }
  
  .rounded-circle {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  
  .rounded-circle:hover {
    transform: scale(1.05);
    box-shadow: 0 0 15px rgba(227, 181, 0, 0.3);
  }
  
  .list-group-item {
    transition: all 0.3s ease;
  }
</style>

<!-- Footer -->
<?php include "inc/Footer.php"; ?>

<?php
 }else { 
  $em = "Invalid Student id";
  Util::redirect("index.php", "error", $em);
  }
} else { 
  $em = "First login ";
  Util::redirect("../login.php", "error", $em);
} ?>