<?php 
session_start();
include "../Utils/Util.php";
include "../Utils/Validation.php";
if (isset($_SESSION['username']) &&
    isset($_SESSION['admin_id'])) {

  $title = "EduPulse - Add Instructor";
  include "inc/Header.php";

    $fname = $uname = $email = $bd = $lname = "";
    if (isset($_GET["fname"])) {
        $fname = Validation::clean($_GET["fname"]);
    }
    if (isset($_GET["uname"])) {
        $uname = Validation::clean($_GET["uname"]);
    }
    if (isset($_GET["email"])) {
        $email = Validation::clean($_GET["email"]);
    }
    if (isset($_GET["bd"])) {
        $bd = Validation::clean($_GET["bd"]);
    }
    if (isset($_GET["lname"])) {
        $lname = Validation::clean($_GET["lname"]);
    }
?>

<div class="container">
  <!-- NavBar -->
  <?php include "inc/NavBar.php"; ?>
  
  <div class="d-flex justify-content-center mt-5">
    <form class="form-card shadow-lg p-4 rounded-3" 
          style="max-width: 650px; background: linear-gradient(135deg, #ffffff 0%, #f8f8f8 100%); border-left: 5px solid #e3b500;"
          action="Action/instructor-add.php"
          method="POST">
          
      <h4 class="py-3 mb-4 border-bottom" style="color: #2c3e50; border-color: #e3b500 !important;">
        Add Instructor Profile
      </h4>
      
      <?php if (isset($_GET['error'])) { ?>
        <div class="alert alert-danger shadow-sm fade-in" role="alert">
          <?=Validation::clean($_GET['error'])?>
        </div>
      <?php } ?>
      
      <?php if (isset($_GET['success'])) { ?>
        <div class="alert alert-success shadow-sm fade-in" role="alert">
          </i><?=Validation::clean($_GET['success'])?>
        </div>
      <?php } ?>

      <div class="row g-3">
        <div class="col-md-6">
          <div class="form-floating mb-3">
                <input type="text" class="form-control hover-gold" id="instructorFirstName" 
                   placeholder="First Name" name="fname" value="<?=$fname?>" required>
            <label for="instructorFirstName">First Name</label>
          </div>
        </div>
        
        <div class="col-md-6">
          <div class="form-floating mb-3">
            <input type="text" class="form-control hover-gold" id="instructorLastName" 
                   placeholder="Last Name" name="lname" value="<?=$lname?>" required>
            <label for="instructorLastName">Last Name</label>
          </div>
        </div>
      </div>

      <div class="form-floating mb-3">
        <input type="date" class="form-control hover-gold" id="instructorDOB" 
               value="<?=$bd?>" name="date_of_birth" required>
        <label for="instructorDOB">Date of Birth</label>
      </div>

      <div class="form-floating mb-3">
        <input type="email" class="form-control hover-gold" id="instructorEmail" 
               placeholder="Email" name="email" value="<?=$email?>" required>
        <label for="instructorEmail">Email</label>
      </div>

      <div class="mb-3">
        <label for="instructorUsername" class="form-label fw-medium">Username</label>
        <div class="input-group">
          <input type="text" class="form-control hover-gold" id="instructorUsername" 
                 placeholder="Username" name="username" value="<?=$uname?>" required>
          <button class="btn btn-gold" type="button" id="generateUsernameButton" onclick="generateUsername()">
             Generate
          </button>
        </div>
      </div>

      <div class="mb-4">
        <label for="instructorPassword" class="form-label fw-medium">Password</label>
        <div class="input-group">
          <input type="password" class="form-control hover-gold" id="instructorPassword" 
                 name="password" placeholder="Password" required>
          <button class="btn btn-gold" type="button" id="generatePasswordButton" onclick="generatePassword()">
             Generate
          </button>
        </div>
        <div class="form-text">Password must be at least 6 characters</div>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-dark btn-lg py-2 shadow-sm">
          Save Instructor
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  function generatePassword() {
    const randomString = Math.random().toString(36).slice(-8);
    const passwordField = document.getElementById('instructorPassword');
    passwordField.value = randomString;
    passwordField.type = "text";
    
    // Add visual feedback
    passwordField.style.backgroundColor = 'rgba(227, 181, 0, 0.2)';
    setTimeout(() => {
      passwordField.style.backgroundColor = '';
    }, 1000);
  }

  function generateUsername() {
    const randomString = Math.random().toString(36).slice(-3);
    const firstName = document.getElementById('instructorFirstName').value;
    const usernameField = document.getElementById('instructorUsername');
    
    if(firstName) {
      usernameField.value = firstName.toLowerCase() + randomString;
    } else {
      usernameField.value = "instructor" + randomString;
    }
    
    // Add visual feedback
    usernameField.style.backgroundColor = 'rgba(227, 181, 0, 0.2)';
    setTimeout(() => {
      usernameField.style.backgroundColor = '';
    }, 1000);
  }
</script>

<style>
  /* Custom styles to match the admin theme */
  .form-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  
  .form-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
  }
  
  .hover-gold {
    transition: all 0.3s ease;
    border: 1px solid #dee2e6;
  }
  
  .hover-gold:focus {
    border-color: #e3b500;
    box-shadow: 0 0 0 0.25rem rgba(227, 181, 0, 0.25);
  }
  
  .hover-gold:hover {
    border-color: #e3b500;
  }
  
  .text-gold {
    color: #e3b500 !important;
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
  
  .fade-in {
    animation: fadeIn 0.5s ease-out;
  }
  
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
  }
  
  .form-floating label {
    color: #6c757d;
  }
  
  .form-floating>.form-control:focus~label,
  .form-floating>.form-control:not(:placeholder-shown)~label {
    color: #e3b500;
  }
</style>

<!-- Footer -->
<?php include "inc/Footer.php"; ?>

<?php } else { 
  $em = "First login ";
  Util::redirect("../login.php", "error", $em);
} ?>