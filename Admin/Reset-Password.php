<?php 
session_start();
include "../Utils/Util.php";
include "../Utils/Validation.php";

# Header
$title = "EduPulse - Reset Password";
include "inc/Header.php";

$type = isset($_GET['for']) ? Validation::clean($_GET['for']) : '';
$student_id = isset($_GET['student_id']) ? Validation::clean($_GET['student_id']) : '';
?>

<div class="container">
  <!-- NavBar -->
  <?php include "inc/NavBar.php"; ?>

  <div class="d-flex justify-content-center mt-4">
    <div class="password-reset-card shadow-lg p-4 rounded-3" style="
        max-width: 600px;
        width: 100%;
        background: linear-gradient(135deg, #ffffff 0%, #f8f8f8 100%);
        border-left: 5px solid #e3b500;
    ">
      <h4 class="mb-4 border-bottom pb-2" style="border-color: #e3b500 !important;">
        Reset <?=htmlspecialchars($type)?> Password
      </h4>
      
      <form id="ChangePassword" method="post" action="">
        <div class="mb-3">
          <label class="form-label fw-medium">ID</label>
          <input type="text" 
                 class="form-control hover-gold"
                 value="<?=htmlspecialchars($student_id)?>"
                 readonly>
        </div>

        <div class="mb-3">
          <label class="form-label fw-medium">Admin Password</label>
          <input type="password" 
                 class="form-control hover-gold"
                 name="admin_password"
                 required>
        </div>
        
        <div class="mb-3">
          <label for="newPassword" class="form-label fw-medium">New Password</label>
          <div class="input-group">
            <input type="password" 
                   class="form-control hover-gold" 
                   id="newPassword" 
                   name="new_password"
                   placeholder="Enter new password" 
                   required>
            <button class="btn btn-gold" 
                    type="button" 
                    id="generatePasswordButton" 
                    onclick="generatePassword()">
              Auto Generate
            </button>
          </div>
        </div>
        
        <div class="mb-4">
          <label for="confirmPassword" class="form-label fw-medium">Confirm New Password</label>
          <input type="password" 
                 class="form-control hover-gold"
                 id="confirmPassword"
                 name="confirm_password"
                 placeholder="Confirm new password"
                 required>
        </div>
        
        <div class="d-grid">
          <button type="submit" class="btn btn-dark btn-lg py-2 shadow-sm">
            Reset Password
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
  /* Custom styles to match the admin theme */
  .password-reset-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  
  .password-reset-card:hover {
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
  
  .form-label {
    color: #2c3e50;
  }
</style>

<script>
  function generatePassword() {
    const randomString = Math.random().toString(36).slice(-8);
    const newPassField = document.getElementById('newPassword');
    const confirmPassField = document.getElementById('confirmPassword');
    
    newPassField.value = randomString;
    newPassField.type = "text";
    confirmPassField.value = randomString;
    confirmPassField.type = "text";
    
    // Add visual feedback
    newPassField.style.backgroundColor = 'rgba(227, 181, 0, 0.2)';
    confirmPassField.style.backgroundColor = 'rgba(227, 181, 0, 0.2)';
    setTimeout(() => {
      newPassField.style.backgroundColor = '';
      confirmPassField.style.backgroundColor = '';
    }, 1000);
  }
  
  // Form validation
  document.getElementById('ChangePassword').addEventListener('submit', function(e) {
    const newPass = document.getElementById('newPassword').value;
    const confirmPass = document.getElementById('confirmPassword').value;
    
    if (newPass !== confirmPass) {
      e.preventDefault();
      alert('Passwords do not match!');
      return false;
    }
    
    if (newPass.length < 6) {
      e.preventDefault();
      alert('Password must be at least 6 characters!');
      return false;
    }
  });
</script>

<!-- Footer -->
<?php include "inc/Footer.php"; ?>