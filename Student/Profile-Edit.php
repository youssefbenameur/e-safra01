<?php 
session_start();
include "../Utils/Util.php";
include "../Utils/Validation.php";
if (isset($_SESSION['username']) &&
    isset($_SESSION['student_id'])) {
    include "../Controller/Student/Student.php";

    $_id =  $_SESSION['student_id'];
    $student = getById($_id);

   if (empty($student['student_id'])) {
     $em = "Invalid Student id";
     Util::redirect("../logout.php", "error", $em);
   }
   // get Certificates
    # Header
    $title = "EduPulse - Students ";
    include "inc/Header.php";

?>
<style>
  :root {
    --primary: #e3b500;
    --primary-hover: #c79d00;
    --accent: #000000;
    --background: #ffffff;
    --surface: #f8f8f8;
    --text-primary: #000000;
    --text-secondary: #444444;
    --border: #000000;
    --border-light: rgba(0, 0, 0, 0.15);
    --gradient: linear-gradient(135deg, var(--primary) 0%, #f8d347 100%);
}

/* CRITICAL FIX: Override Bootstrap container */
.container {
    width: 100% !important;
    max-width: 100% !important;
    margin: 0 !important;
    padding: 0 !important;
    display: block !important;
}

/* CRITICAL FIX: Override r-side margins and make full width */
.r-side {
    width: 100% !important;
    max-width: 100% !important;
    margin: 0 !important;
    padding: 2rem !important;
    border-radius: 0 !important;
    box-shadow: none !important;
    background-color: var(--background);
}

/* CRITICAL FIX: Override form max-width */
form {
    max-width: 100% !important;
    width: 100% !important;
}

/* CRITICAL FIX: Override Bootstrap row and col classes if present */
.row {
    margin: 0 !important;
    width: 100% !important;
}

.col, .col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12,
.col-sm, .col-md, .col-lg, .col-xl {
    padding: 0 !important;
    width: 100% !important;
    max-width: 100% !important;
    flex: 0 0 100% !important;
}

/* Basic styling */
body {
    margin: 0;
    padding: 0;
    background: #f9f9f9;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.r-side h4 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--accent);
    margin-bottom: 1.5rem;
    position: relative;
    padding-left: 1rem;
    border-bottom: 2px solid var(--primary);
    padding-bottom: 0.5rem;
}

.form-label {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    display: block;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    border: 1px solid var(--border-light);
    background-color: var(--surface);
    transition: all 0.2s ease;
    margin-bottom: 1rem;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(227, 181, 0, 0.25);
}

.input-group {
    display: flex;
    width: 100%;
}

.input-group .form-control {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    flex: 1;
}

.input-group .btn {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

/* Button styling */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.2s ease;
    border: 1px solid transparent;
    cursor: pointer;
}

.btn-primary {
    background: var(--primary);
    color: var(--accent);
    border: 1px solid var(--border);
}

.btn-primary:hover {
    background: var(--primary-hover);
    transform: translateY(-2px);
}

.btn-outline-secondary {
    background: var(--surface);
    color: var(--text-primary);
    border: 1px solid var(--border-light);
}

.btn-outline-secondary:hover {
    background: #eeeeee;
}

/* Alert styling */
.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    border: 1px solid transparent;
    width: 100%;
}

.alert-danger {
    background-color: #fff5f5;
    color: #e53e3e;
    border-color: #feb2b2;
}

.alert-success {
    background-color: #f0fff4;
    color: #38a169;
    border-color: #9ae6b4;
}

/* Password section styling */
#ChangePassword {
    margin-top: 2rem;
    border-top: 1px solid var(--border-light);
    padding-top: 1.5rem;
}

/* CRITICAL FIX: Override any navbar or profile styles */
.navbar, .profile {
    width: 100% !important;
    max-width: 100% !important;
    margin: 0 !important;
    padding: 1rem !important;
    background-color: var(--background);
    border-bottom: 1px solid var(--border-light);
}

/* CRITICAL FIX: Make sure shadow class doesn't add unwanted effects */
.shadow {
    box-shadow: none !important;
}

/* CRITICAL FIX: Override mx-2 class that adds horizontal margin */
.mx-2 {
    margin-left: 0 !important;
    margin-right: 0 !important;
}

/* CRITICAL FIX: Override p-5 class that adds padding */
.p-5 {
    padding: 2rem !important;
}

/* CRITICAL FIX: Make sure all form elements take full width */
.mb-3 {
    width: 100% !important;
    max-width: 100% !important;
}

/* Media queries for responsive design */
@media (max-width: 768px) {
    .r-side {
        padding: 1rem !important;
    }
    
    .form-control, .btn {
        padding: 0.75rem 1rem;
    }
}
</style>

<div class="container">
  <!-- NavBar & Profile-->
  <?php include "inc/NavBar.php"; 
        include "inc/Profile.php"; ?>


    <div class="r-side p-5  mx-2 shadow">
    <?php 
      if (isset($_GET['error'])) { ?>
        <p class="alert alert-danger"><?=Validation::clean($_GET['error'])?></p>
    <?php } ?>
    <?php 
      if (isset($_GET['success'])) { ?>
        <p class="alert alert-success"><?=Validation::clean($_GET['success'])?></p>
    <?php } ?>
      <h4>Edit Account Information</h4>
        <form style="max-width: 600px;"
              action="Action/upload-profile-details.php"
              method="POST">
          <div class="mb-3">
            <label class="form-label">First name</label>
            <input type="text" 
                   class="form-control"
                   name="first_name"
                   value="<?=$student['first_name']?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Last name</label>
            <input type="text" 
                   class="form-control"
                   value="<?=$student['last_name']?>"
                   name="last_name">
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="text" 
                   class="form-control"
                   value="<?=$student['email']?>"
                   name="email">
          </div>
          <div class="mb-3">
            <label class="form-label">Date of birth</label>
            <input type="date" 
                   class="form-control"
                   value="<?=$student['date_of_birth']?>"
                   name="date_of_birth">
          </div>
          <button type="submit" class="btn btn-primary">Save</button>
        </form>
        
        <h4 class="mt-5">Change Password</h4>
        <form id="ChangePassword"
              method="post"
              action="Action/change-password.php"
              style="max-width: 600px;">
          <div class="mb-3">
            <label class="form-label">Current password</label>
            <input type="password" 
                   placeholder="Current password" 
                   class="form-control"
                   name="password">
          </div>
          <div class="mb-3">
              <label for="instructorPassword" class="form-label">New Password</label>
              <div class="input-group">
                  <input type="password" class="form-control" id="instructorPassword" name="new_password" placeholder="Enter new password" aria-describedby="generatePasswordButton" >
                  <button class="btn btn-outline-secondary" type="button" id="generatePasswordButton" onclick="generatePassword()">Auto Generate</button>
              </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Confirm password</label>
            <input type="password" 
                   placeholder="Current password" 
                   class="form-control"
                   id="confirmPassword"
                   name="confirm_password">
          </div>

          
          <button type="submit" class="btn btn-primary">Change Password</button>
        </form>
    </div>
  </div>
</div>

 <!-- Footer -->
<?php include "inc/Footer.php"; ?>
 <script>
    function generatePassword() {
        const randomString = Math.random().toString(36).slice(-6);
        document.getElementById('instructorPassword').value = randomString;
        document.getElementById('confirmPassword').value = randomString;
        document.getElementById('instructorPassword').type = "text";
        document.getElementById('confirmPassword').type = "text";
    }
</script>
<?php
 }else { 
$em = "First login ";
Util::redirect("../login.php", "error", $em);
} ?>
