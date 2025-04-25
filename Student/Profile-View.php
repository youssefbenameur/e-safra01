<?php 
session_start();
include "../Utils/Util.php";
include "../Utils/Validation.php";

if (isset($_SESSION['username']) && isset($_SESSION['student_id'])) {
    include "../Controller/Student/Student.php";

    $_id = $_SESSION['student_id'] ?? null;
    
    // Get student data with error handling
    $student = getById($_id) ?? [];
    
    // Verify student exists
    if (empty($student['student_id'])) {
        $em = "Invalid Student ID";
        Util::redirect("../logout.php", "error", $em);
    }

    // Get certificates with fallback to empty array
    $certificates = getCertificate($_id) ?? [];
    
    # Header
    $title = "EduPulse - Student Profile";
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
      --gradient: linear-gradient(135deg, var(--primary) 0%, #f8d347 100%);
  }

  body {
      background: #f9f9f9;
  }

  .dashboard-container {
      max-width: 1440px;
      margin: 2rem auto;
      padding: 0 1.5rem;
      display: grid;
      grid-template-columns: 280px 1fr;
      gap: 2rem;
  }

  .profile-sidebar {
      background: var(--surface);
      border-radius: 15px;
      padding: 2rem;
      border: 2px solid var(--border);
      box-shadow: 0 8px 24px rgba(0,0,0,0.05);
      height: fit-content;
      background-image: var(--gradient);
  }

  .profile-avatar {
      width: 120px;
      height: 120px;
      background: var(--accent);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2.5rem;
      font-weight: 700;
      margin: 0 auto 1.5rem;
      color: var(--primary);
      border: 2px solid var(--border);
  }

  .profile-meta {
      text-align: center;
      margin-bottom: 2rem;
      color: var(--accent);
  }

  .profile-name {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--accent);
      margin-bottom: 0.25rem;
  }

  .profile-id {
      color: var(--text-secondary);
      font-size: 0.9rem;
      font-weight: 500;
  }

  .stats-grid {
      display: grid;
      gap: 1rem;
      margin-bottom: 2rem;
  }

  .stat-card {
      background: rgba(255,255,255,0.9);
      padding: 1.25rem;
      border-radius: 12px;
      text-align: center;
      border: 1px solid var(--border);
      backdrop-filter: blur(4px);
  }

  .stat-value {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--accent);
      margin-bottom: 0.25rem;
  }

  .stat-label {
      color: var(--text-secondary);
      font-size: 0.9rem;
      font-weight: 500;
  }

  .profile-nav {
      display: grid;
      gap: 0.5rem;
  }

  .nav-item {
      padding: 0.75rem 1rem;
      border-radius: 8px;
      color: var(--accent);
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 0.75rem;
      transition: all 0.2s ease;
      background: rgba(255,255,255,0.9);
      border: 1px solid var(--border);
  }

  .nav-item:hover {
      background: var(--primary);
      color: var(--accent);
      transform: translateY(-2px);
  }

  .nav-item.active {
      background: var(--primary);
      color: var(--accent);
      font-weight: 600;
  }

  .profile-main {
      background: var(--background);
      border-radius: 15px;
      padding: 2rem;
      border: 2px solid var(--border);
      box-shadow: 0 8px 24px rgba(0,0,0,0.05);
  }

  .section-title {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--accent);
      margin-bottom: 1.5rem;
      position: relative;
      padding-left: 1rem;
  }

  .section-title::before {
      content: '';
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
      width: 4px;
      height: 70%;
      background: var(--primary);
  }

  .info-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 1.5rem;
      margin-bottom: 3rem;
  }

  .info-card {
      background: var(--surface);
      padding: 1.5rem;
      border-radius: 12px;
      border: 1px solid var(--border);
      transition: transform 0.2s ease;
  }

  .info-card:hover {
      transform: translateY(-5px);
  }

  .info-header {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin-bottom: 1rem;
  }

  .info-icon {
      width: 40px;
      height: 40px;
      background: var(--primary);
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--accent);
  }

  .certificate-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      gap: 1.5rem;
  }

  .certificate-card {
      background: var(--surface);
      border-radius: 12px;
      padding: 1.5rem;
      position: relative;
      overflow: hidden;
      transition: transform 0.2s ease;
      border: 1px solid var(--border);
  }

  .certificate-card:hover {
      transform: translateY(-5px);
  }

  .certificate-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 4px;
      height: 100%;
      background: var(--primary);
  }

  .certificate-badge {
      position: absolute;
      top: 1rem;
      right: 1rem;
      background: var(--primary);
      color: var(--accent);
      padding: 0.25rem 0.75rem;
      border-radius: 2rem;
      font-size: 0.8rem;
      font-weight: 600;
  }

  .btn-certificate {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.75rem 1.5rem;
      background: var(--primary);
      color: var(--accent);
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.2s ease;
      border: 1px solid var(--border);
  }

  .btn-certificate:hover {
      background: var(--primary-hover);
      transform: translateY(-2px);
  }

  .empty-state {
      text-align: center;
      padding: 3rem;
      color: var(--text-secondary);
      border: 2px dashed var(--border);
      border-radius: 12px;
  }

  @media (max-width: 1024px) {
      .dashboard-container {
          grid-template-columns: 1fr;
      }
  }

  @media (max-width: 768px) {
      .dashboard-container {
          padding: 0 1rem;
      }
      
      .profile-name {
          font-size: 1.25rem;
      }
  }
</style>

<div class="dashboard-container" style="margin-top: 80px;">
  <?php include "inc/NavBar.php"; ?>
  
  <!-- Sidebar -->
  <aside class="profile-sidebar">
    <div class="profile-avatar">
      <?= isset($student['first_name'], $student['last_name']) ? 
          strtoupper(substr($student['first_name'], 0, 1)) . 
          strtoupper(substr($student['last_name'], 0, 1)) : 'US' ?>
    </div>
    <div class="profile-meta">
      <h2 class="profile-name">
        <?= htmlspecialchars($student['first_name'] ?? 'Unknown') ?> 
        <?= htmlspecialchars($student['last_name'] ?? 'User') ?>
      </h2>
      <p class="profile-id">ID: <?= htmlspecialchars($student['student_id'] ?? 'N/A') ?></p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-value"><?= is_countable($certificates) ? count($certificates) : 0 ?></div>
            <div class="stat-label">Certificates</div>
        </div>
        <div class="stat-card">
            <div class="stat-value"><?= $student['course_count'] ?? 0 ?></div>
            <div class="stat-label">Courses Taken</div>
        </div>
    </div>

    <nav class="profile-nav">
        <a href="#" class="nav-item active">
            <i class="fas fa-user-circle"></i> Profile
        </a>
        <a href="courses.php" class="nav-item">
            <i class="fas fa-book-open"></i> My Courses
        </a>
        <a href="certificates.php" class="nav-item">
            <i class="fas fa-award"></i> Certificates
        </a>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="profile-main">
    <section class="personal-info">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-user-graduate"></i>
                Personal Information
            </h2>
        </div>

        <div class="info-grid">
            <div class="info-card">
                <div class="info-header">
                    <div class="info-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="info-content">
                        <h3>Email Address</h3>
                        <p><?= htmlspecialchars($student['email'] ?? 'Not provided') ?></p>
                    </div>
                </div>
            </div>
            <div class="info-card">
                <div class="info-header">
                    <div class="info-icon">
                        <i class="fas fa-birthday-cake"></i>
                    </div>
                    <div class="info-content">
                        <h3>Date of Birth</h3>
                        <p><?= !empty($student['date_of_birth']) ? 
                            date('M d, Y', strtotime($student['date_of_birth'])) : 'N/A' ?></p>
                    </div>
                </div>
            </div>
            <div class="info-card">
                <div class="info-header">
                    <div class="info-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="info-content">
                        <h3>Joined Date</h3>
                        <p><?= !empty($student['date_of_joined']) ? 
                            date('M d, Y', strtotime($student['date_of_joined'])) : 'N/A' ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="certificates-section">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-certificate"></i>
                Achieved Certificates
            </h2>
        </div>

        <?php if (!empty($certificates) && is_array($certificates)) : ?>
        <div class="certificate-grid">
            <?php foreach ($certificates as $certificate) : ?>
                <?php if (!empty($certificate['certificate_id'])) : ?>
                <div class="certificate-card">
                    <span class="certificate-badge">Achieved</span>
                    <h3 class="certificate-title">
                        <?= htmlspecialchars($certificate['course_title'] ?? 'Untitled Course') ?>
                    </h3>
                    <?php if (!empty($certificate['issue_date'])) : ?>
                    <div class="certificate-meta">
                        <i class="fas fa-calendar-alt"></i>
                        <?= date('M d, Y', strtotime($certificate['issue_date'])) ?>
                    </div>
                    <?php endif; ?>
                    <a href="../Certificate.php?certificate_id=<?= $certificate['certificate_id'] ?>" 
                       class="btn-certificate">
                        View Credential
                    </a>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <?php else : ?>
        <div class="empty-state">
            <i class="fas fa-certificate fa-3x"></i>
            <p>No certificates earned yet</p>
        </div>
        <?php endif; ?>
    </section>
  </main>
</div>

<?php include "inc/Footer.php"; ?>
<?php } else { 
    Util::redirect("../login.php", "error", "Please login first");
} ?>