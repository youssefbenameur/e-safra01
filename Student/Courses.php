<?php 
session_start();
include "../Utils/Util.php";
if (isset($_SESSION['username']) &&
    isset($_SESSION['student_id'])) {

    include "../Controller/Student/Course.php";
    
    // Handle search functionality
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $row_count = getCount($search);
    
    // Pagination logic
    $page = isset($_GET['page']) ? max(1, min((int)$_GET['page'], ceil($row_count / 6))) : 1;
    $row_num = 6;
    $offset = ($page - 1) * $row_num;
    $courses = getSomeCourses($offset, $row_num, $search);
    $last_page = ceil($row_count / $row_num);

    // Handle AJAX suggestions request
    if(isset($_GET['ajax'])) {
        header('Content-Type: application/json');
        echo json_encode($courses);
        exit();
    }

    # Header
    $title = "EduPulse - Courses";
    include "inc/Header.php";

?>
<style>
    :root {
        --primary: #2563eb;
        --secondary: #1d4ed8;
        --accent: #ffd95e;
        --light: #f8fafc;
        --dark: #1e293b;
        --text-dark: #334155;
    }

    .container {
        margin-top: 50px;
        max-width: 1200px;
        padding: 20px;
    }

    .search-container {
        margin: 2rem 0 3rem;
    }

    .search-wrapper {
        position: relative;
        max-width: 800px;
        margin: 0 auto;
    }

    .search-input {
        width: 100%;
        padding: 1.25rem 2rem;
        border: none;
        border-radius: 50px;
        font-size: 1.1rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        background: white;
    }

    .search-input:focus {
        outline: none;
        box-shadow: 0 6px 12px rgba(37, 99, 235, 0.15);
    }

    .search-icon {
        position: absolute;
        right: 25px;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
        font-size: 1.2rem;
    }

    .suggestions-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        margin-top: 5px;
        max-height: 300px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
    }

    .suggestion-item {
        padding: 1rem 2rem;
        cursor: pointer;
        transition: all 0.2s ease;
        color: var(--text-dark);
    }

    .suggestion-item:hover {
        background: #f1f5f9;
    }

    .course-list-title {
        color: var(--dark);
        margin: 2rem 0;
        font-size: 2rem;
        font-weight: 700;
        text-align: center;
    }

    .course-list {
        display: grid;
        gap: 2rem;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    }

    .course-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px rgba(0,0,0,0.1);
    }

    .course-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-bottom: 3px solid var(--accent);
    }

    .course-content {
        padding: 1.5rem;
    }

    .course-title {
        font-size: 1.3rem;
        margin: 0 0 1rem;
        color: var(--dark);
        font-weight: 600;
    }

    .course-description {
        color: #64748b;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.5;
    }

    .course-date {
        color: #94a3b8;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .btn-accent {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        background: var(--accent);
        color: var(--dark) !important;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-accent:hover {
        background: #ffd33b;
        transform: translateY(-2px);
    }

    .pagination {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        margin: 3rem 0 2rem;
        flex-wrap: wrap;
    }

    .page-btn {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        background: white;
        color: var(--primary);
        border: 2px solid var(--primary);
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .page-btn:hover {
        background: var(--primary);
        color: white !important;
    }

    .page-btn.disabled {
        opacity: 0.5;
        pointer-events: none;
    }

    .alert {
        padding: 2rem;
        text-align: center;
        background: #f1f5f9;
        border-radius: 15px;
        color: var(--text-dark);
    }

    @media (max-width: 768px) {
        .container {
            padding: 15px;
            margin-top: 30px;
        }
        
        .search-input {
            padding: 1rem 1.5rem;
            font-size: 1rem;
        }
        
        .course-list-title {
            font-size: 1.5rem;
        }
    }
</style>

<div class="container">
  <?php include "inc/NavBar.php"; ?>
  
  <!-- Search Section -->
  <div class="search-container">
    <div class="search-wrapper">
      <form id="searchForm" method="GET" action="Courses.php">
        <input type="text" 
               name="search" 
               id="searchInput" 
               class="search-input" 
               placeholder="Search courses by title or description..." 
               autocomplete="off"
               value="<?= htmlspecialchars($search) ?>">
        <i class="fas fa-search search-icon"></i>
        <div id="suggestions" class="suggestions-dropdown"></div>
      </form>
    </div>
  </div>

  <!-- Course List -->
  <?php if ($courses) { ?>
  <h2 class="course-list-title">
    <?= empty($search) ? 'All Courses' : 'Search Results' ?> 
    <span>(<?= $row_count ?>)</span>
  </h2>
  <div class="course-list">
    <?php foreach ($courses as $course) { ?>
    <div class="course-card">
        <img src="../Upload/thumbnail/<?= $course["cover"] ?>" 
             class="course-image" 
             alt="<?= htmlspecialchars($course["title"]) ?>">
        <div class="course-content">
            <h3 class="course-title"><?= htmlspecialchars($course["title"]) ?></h3>
            <p class="course-description"><?= htmlspecialchars($course["description"]) ?></p>
            <p class="course-date">Created: <?= date('M d, Y', strtotime($course["created_at"])) ?></p>
            <a href="Course.php?course_id=<?= $course["course_id"] ?>" class="btn-accent">View Course</a>
        </div>
    </div>
    <?php } ?>
  </div>
  <?php } else { ?>
    <div class="alert">No courses found<?= empty($search) ? '' : ' matching your search' ?></div>
  <?php } ?>

  <!-- Pagination -->
  <?php if ($last_page > 1) { ?>
  <div class="pagination">
      <?php
      $prev = max(1, $page - 1);
      $next = min($last_page, $page + 1);
      
      // Previous button
      if ($page > 1) {
          echo '<a href="Courses.php?page='.$prev.'&search='.urlencode($search).'" class="page-btn">Prev</a>';
      } else {
          echo '<span class="page-btn disabled">Prev</span>';
      }

      // Page numbers
      for ($i = max(1, $page - 2); $i <= min($page + 2, $last_page); $i++) {
          $active = $i == $page ? ' style="background: var(--primary); color: white;"' : '';
          echo '<a href="Courses.php?page='.$i.'&search='.urlencode($search).'" class="page-btn"'.$active.'>'.$i.'</a>';
      }

      // Next button
      if ($page < $last_page) {
          echo '<a href="Courses.php?page='.$next.'&search='.urlencode($search).'" class="page-btn">Next</a>';
      } else {
          echo '<span class="page-btn disabled">Next</span>';
      }
      ?>
  </div>
  <?php } ?>
</div>

<script>
    document.getElementById('searchInput').addEventListener('input', function(e) {
    const query = e.target.value;
    const suggestions = document.getElementById('suggestions');
    
    if (query.length < 2) {
        suggestions.style.display = 'none';
        return;
    }

    fetch(`Courses.php?search=${encodeURIComponent(query)}&ajax=1`)
        .then(response => response.json())
        .then(data => {
            suggestions.innerHTML = '';
            if(data.length > 0) {
                data.forEach(course => {
                    // Only show suggestions that match the query
                    if (course.title.toLowerCase().includes(query.toLowerCase()) || 
                        course.description.toLowerCase().includes(query.toLowerCase())) {
                        const suggestion = document.createElement('div');
                        suggestion.className = 'suggestion-item';
                        suggestion.innerHTML = `
                            <div class="suggestion-title">${course.title}</div>
                            <div class="suggestion-description">${course.description.substring(0, 50)}...</div>
                        `;
                        suggestion.addEventListener('click', () => {
                            window.location.href = `Course.php?course_id=${course.course_id}`;
                        });
                        suggestions.appendChild(suggestion);
                    }
                });
                suggestions.style.display = suggestions.children.length > 0 ? 'block' : 'none';
            } else {
                suggestions.style.display = 'none';
            }
        })
        .catch(error => {
            suggestions.style.display = 'none';
        });
});
document.addEventListener('click', function(e) {
    if (!e.target.closest('.search-wrapper')) {
        document.getElementById('suggestions').style.display = 'none';
    }
});
</script>

<?php include "inc/Footer.php"; ?>
<?php 
} else { 
    Util::redirect("../login.php", "error", "Please login first");
} ?>