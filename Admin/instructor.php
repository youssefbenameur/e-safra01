<?php 
session_start();
include "../Utils/Util.php";
include "../Utils/Validation.php";
if (isset($_SESSION['username']) &&
    isset($_SESSION['admin_id'])) {
    
  if (isset($_GET['instructor_id'])) {
    include "../Controller/Admin/Instructor.php";
    $_id = Validation::clean($_GET['instructor_id']);
    $instructor = getById($_id);
   if (empty($instructor['instructor_id'])) {
     $em = "Invalid Instructor id";
     Util::redirect("index.php", "error", $em);
   }
   $courses = getCourseById($_id);
    # Header 
    $title = "EduPulse - Instructor ";
    include "inc/Header.php";
?>

<div class="container">
  <!-- NavBar -->
  <?php include "inc/NavBar.php"; ?>
  
  <div class="list-table pt-4">
    <div class="row">
      <div class="col-md-6">
        <div class="profile-card p-4 shadow-lg rounded-3" style="background: linear-gradient(135deg, #ffffff 0%, #f8f8f8 100%); border-left: 5px solid #e3b500;">
          <div class="profile-header text-center mb-4">
            <img class="rounded-circle shadow border border-4 border-gold mb-3" 
                 src="../assets/Upload/profile/<?=$instructor['profile_img']?>" 
                 alt="PROFILE IMG" 
                 width="150"
                 style="object-fit: cover; aspect-ratio: 1/1;">
            <h4 class="fw-bold text-dark"><?=$instructor['first_name']?> <?=$instructor['last_name']?></h4>
            <span class="badge bg-dark text-gold">Instructor</span>
          </div>
          
          <div class="profile-details">
            <ul class="list-group list-group-flush">
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span class="fw-medium text-muted">First Name</span>
                <span class="fw-bold"><?=$instructor['first_name']?></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span class="fw-medium text-muted">Last Name</span>
                <span class="fw-bold"><?=$instructor['last_name']?></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span class="fw-medium text-muted">Email</span>
                <span class="fw-bold"><?=$instructor['email']?></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span class="fw-medium text-muted">Date of Birth</span>
                <span class="fw-bold"><?=$instructor['date_of_birth']?></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span class="fw-medium text-muted">Joined Date</span>
                <span class="fw-bold"><?=$instructor['date_of_joined']?></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span class="fw-medium text-muted">Instructor ID</span>
                <span class="fw-bold"><?=$instructor['instructor_id']?></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span class="fw-medium text-muted">Username</span>
                <span class="fw-bold"><?=$instructor['username']?></span>
              </li>
            </ul>
            
            <div class="mt-4 text-center">
              <a href="Reset-Password.php?for=instructor&instructor_id=<?=$instructor['instructor_id']?>" 
                 class="btn btn-gold btn-lg shadow-sm px-4 py-2 fw-medium">
                <i class="fas fa-key me-2"></i>Reset Password
              </a>
            </div>
          </div>
        </div>
      </div>
      
      <?php if (!empty($courses)) { ?>
      <div class="col-md-6 mt-4 mt-md-0">
        <div class="courses-card p-4 shadow-lg rounded-3 h-100" style="background: linear-gradient(135deg, #ffffff 0%, #f8f8f8 100%); border-left: 5px solid #1a1a1a;">
          <h4 class="fw-bold mb-4 pb-2 border-bottom" style="border-color: #e3b500 !important;">
            <i class="fas fa-book me-2 text-gold"></i>Courses Taught
          </h4>
          
          <div class="courses-list">
            <ul class="list-group list-group-flush">
              <?php foreach ($courses as $course) { ?>
              <li class="list-group-item d-flex align-items-center hover-gold py-3">
                <div class="me-3">
                  <i class="fas fa-book-open text-gold"></i>
                </div>
                <div>
                  <a href="Course.php?course_id=<?=$course['course_id']?>" 
                     class="text-decoration-none text-dark fw-medium stretched-link">
                    <?=$course['title']?>
                  </a>
                  <small class="d-block text-muted">Course ID: <?=$course['course_id']?></small>
                </div>
              </li>
              <?php } ?>
            </ul>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
</div>

<!-- Footer -->
<?php include "inc/Footer.php"; ?>

<style>
  /* Custom styles to match the admin theme */
  :root {
    --gold: #e3b500;
    --dark: #1a1a1a;
    --gray: #f5f5f5;
  }
  
  .border-gold {
    border-color: var(--gold) !important;
  }
  
  .text-gold {
    color: var(--gold) !important;
  }
  
  .bg-gold {
    background-color: var(--gold) !important;
  }
  
  .btn-gold {
    background-color: var(--gold);
    color: var(--dark);
    font-weight: 600;
    border: none;
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
  
  .profile-card, .courses-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  
  .profile-card:hover, .courses-card:hover {
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
  
  .stretched-link::after {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1;
    content: "";
  }
</style>

<?php
 }else { 
  $em = "Invalid instructor id";
  Util::redirect("index.php", "error", $em);
  }

}else { 
$em = "First login ";
Util::redirect("../login.php", "error", $em);
} ?>