<?php 
session_start();
include "../Utils/Util.php";
include "../Utils/Validation.php";

// Check admin session
if (!isset($_SESSION['username']) || !isset($_SESSION['admin_id'])) {
    $em = "First login";
    Util::redirect("../login.php", "error", $em);
}

$title = "EduPulse - Change Password";
include "inc/Header.php";
?>

<div class="container">
  <!-- NavBar -->
  <?php include "inc/NavBar.php"; ?>

  <div class="d-flex justify-content-center mt-4">
    <div class="password-card shadow-lg p-4 rounded-3" style="
        max-width: 600px;
        width: 100%;
        background: linear-gradient(135deg, #ffffff 0%, #f8f8f8 100%);
        border-left: 5px solid #e3b500;
    ">
      <h4 class="mb-4 border-bottom pb-2" style="border-color: #e3b500 !important;">
        Change Admin Password
      </h4>
      
      <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger shadow-sm mb-4">
          <?=Validation::clean($_GET['error'])?>
        </div>
      <?php endif; ?>
      
      <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success shadow-sm mb-4">
          <?=Validation::clean($_GET['success'])?>
        </div>
      <?php endif; ?>

      <form id="ChangePassword" method="post" action="Action/change-admin-password.php">
        <div class="mb-3">
          <label class="form-label fw-medium">Old Password</label>
          <input type="password" 
                 class="form-control hover-gold"
                 name="old_password"
                 placeholder="Enter current password"
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
                   minlength="8"
                   required>
            <button class="btn btn-gold" 
                    type="button" 
                    id="generatePasswordButton" 
                    onclick="generatePassword()">
              Auto Generate
            </button>
          </div>
          <div class="form-text">Minimum 8 characters</div>
        </div>
        
        <div class="mb-4">
          <label for="confirmPassword" class="form-label fw-medium">Confirm New Password</label>
          <input type="password" 
                 class="form-control hover-gold"
                 id="confirmPassword"
                 name="confirm_password"
                 placeholder="Confirm new password"
                 minlength="8"
                 required>
        </div>
        
        <div class="d-grid">
          <button type="submit" class="btn btn-dark btn-lg py-2 shadow-sm">
            Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
  /* Custom styles to match the admin theme */
  .password-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  
  .password-card:hover {
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
    // Generate stronger password (12 characters with mixed case)
    const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let password = '';
    for (let i = 0; i < 12; i++) {
      password += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    
    const newPassField = document.getElementById('newPassword');
    const confirmPassField = document.getElementById('confirmPassword');
    
    newPassField.value = password;
    newPassField.type = "text";
    confirmPassField.value = password;
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
    
    if (newPass.length < 8) {
      e.preventDefault();
      alert('Password must be at least 8 characters!');
      return false;
    }
  });
</script>

<!-- Footer -->
<?php include "inc/Footer.php"; ?>