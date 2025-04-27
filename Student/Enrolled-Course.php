
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
      --secondary: #836f0a;
  }

  .courses-container {
      margin-top: 60px;
      padding: 2rem 1.5rem;
      background: var(--surface);
  }

  .course-header {
      display: flex;
      align-items: center;
      gap: 1.5rem;
      margin-bottom: 3rem;
      padding: 1.5rem;
      background-image: var(--gradient);
      border-radius: 12px;
      border: 2px solid var(--border);
      background: linear-gradient(135deg, var(--primary), var(--secondary));
  }

  .course-header h1 {
      font-weight: 700;
      color: var(--accent);
      margin: 0;
      font-size: 2rem;
  }

  .course-count {
      background: var(--accent);
      color: var(--primary);
      padding: 0.5rem 1.5rem;
      border-radius: 20px;
      font-weight: 700;
      border: 2px solid var(--primary);
  }

  .course-card {
      background: var(--background);
      border-radius: 15px;
      border: 2px solid var(--border);
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      margin-bottom: 2rem;
      position: relative;
  }

  .course-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
      border-color: var(--primary);
  }

  .course-image {
      height: 250px;
      object-fit: cover;
      border-bottom: 2px solid var(--border);
  }

  .course-body {
      padding: 2rem;
      background: var(--background);
  }

  .course-title {
      color: var(--accent);
      font-weight: 800;
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
      gap: 1rem;
      font-size: 1.4rem;
  }

  .course-title i {
      color: var(--primary);
      font-size: 1.8rem;
  }

  .course-description {
      color: var(--text-secondary);
      line-height: 1.7;
      margin-bottom: 1.5rem;
      font-size: 1.1rem;
  }

  .course-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-top: 1.5rem;
      border-top: 2px solid var(--border);
  }

  .course-date {
      color: var(--text-secondary);
      font-weight: 500;
      font-size: 0.95rem;
  }

  .btn-view {
      background: var(--accent);
      color: var(--primary);
      padding: 0.8rem 2rem;
      border-radius: 8px;
      font-weight: 700;
      transition: all 0.3s ease;
      border: 2px solid var(--primary);
      display: inline-flex;
      align-items: center;
      gap: 0.8rem;
  }

  .btn-view:hover {
      background: var(--primary);
      color: var(--accent);
      transform: translateY(-2px);
  }

  .empty-state {
      text-align: center;
      padding: 4rem 2rem;
      background: var(--surface);
      border-radius: 15px;
      border: 2px dashed var(--border);
      margin: 2rem 0;
  }

  .empty-state i {
      font-size: 3.5rem;
      color: var(--primary);
      margin-bottom: 1.5rem;
  }

  @media (max-width: 768px) {
      .courses-container {
          margin-top: 70px;
          padding: 1rem;
      }
      
      .course-header {
          flex-direction: column;
          text-align: center;
      }
      
      .course-image {
          height: 200px;
      }
      
      .course-body {
          padding: 1.5rem;
      }
  }
</style>

<?php 
session_start();
include "../Utils/Util.php";
if (isset($_SESSION['username']) && isset($_SESSION['student_id'])) {

    include "../Controller/Student/Course.php";
    include "../Controller/Student/EnrolledStudent.php";
    
    $student_id = $_SESSION['student_id'];
    $courses_data = getEnrolledCourses($student_id);
    $row_count = $courses_data[0]['count'] ?? 0;
    $courses = array_slice($courses_data, 1); // Remove the count element

    $title = "EduPulse - Enrolled Courses";
    include "inc/Header.php";
?>


<div class="courses-container">
    <?php include "inc/NavBar.php"; ?>
    
    <div class="container">
        <div class="course-header">
            <h1><i class="fas fa-book-open"></i> My Enrollments</h1>
            <?php if($row_count > 0): ?>
                <span class="course-count"><?= $row_count ?> Courses</span>
            <?php endif; ?>
        </div>

        <?php if ($row_count > 0): ?>
            <div class="row g-4">
                <?php foreach ($courses as $course): 
                    // Set default values for missing keys
                    $cover = $course['cover'] ?? 'default-cover.jpg';
                    $title = $course['title'] ?? 'Untitled Course';
                    $description = $course['description'] ?? 'No description available';
                    $created_at = $course['created_at'] ?? date('Y-m-d H:i:s');
                    $course_id = $course['course_id'] ?? 0;
                ?>
                <div class="col-lg-6">
                    <div class="course-card">
                        <img src="../Upload/thumbnail/<?= htmlspecialchars($cover) ?>" 
                             class="course-image" 
                             alt="<?= htmlspecialchars($title) ?>">
                        <div class="course-body">
                            <h3 class="course-title">
                                <i class="fas fa-graduation-cap"></i>
                                <?= htmlspecialchars($title) ?>
                            </h3>
                            <p class="course-description">
                                <?= htmlspecialchars($description) ?>
                            </p>
                            <div class="course-footer">
                                <span class="course-date">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    <?= date('M d, Y', strtotime($created_at)) ?>
                                </span>
                                <a href="Courses-Enrolled.php?course_id=<?= $course_id ?>" 
                                   class="btn-view">
                                    <i class="fas fa-arrow-right"></i>
                                    View Course
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-book-open"></i>
                <h3>No Enrolled Courses Yet</h3>
                <p class="text-muted">Explore our courses and start your learning journey!</p>
                <a href="Courses.php" class="btn-view mt-3">
                    <i class="fas fa-search"></i>
                    Browse Courses
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include "inc/Footer.php"; ?>

<?php } else { 
    $em = "First login ";
    Util::redirect("../login.php", "error", $em);
} ?>