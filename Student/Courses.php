<?php 
session_start();
include "../Utils/Util.php";
if (isset($_SESSION['username']) &&
    isset($_SESSION['student_id'])) {

    include "../Controller/Student/Course.php";
    $row_count = getCount();
    
    $page = 1;
    $row_num = 6;
    $offset = 0;
    $last_page = ceil($row_count / $row_num);
    if(isset($_GET['page'])){
    if($_GET['page'] > $last_page){
        $page = $last_page;
    }else if($_GET['page'] <= 0){
        $page = 1; 
    }else $page = $_GET['page'];
    }
    if($page != 1) $offset = ($page-1) * $row_num;
    $courses = getSomeCourses($offset, $row_num);

    # Header
    $title = "EduPulse - Students ";
    include "inc/Header.php";

?>
<style>
    :root {
        --primary: #6366f1;
        --primary-dark: #4f46e5;
        --background: #f8fafc;
        --text: #1e293b;
    }

    body {
        font-family: system-ui, -apple-system, sans-serif;
        background: var(--background);
        color: var(--text);
        margin: 0;
        line-height: 1.6;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .course-list-title {
        color: var(--primary-dark);
        margin: 2rem 0;
        font-size: 1.8rem;
        font-weight: 700;
    }

    .course-list {
        display: grid;
        gap: 2rem;
    }

    .course-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        overflow: hidden;
        display: flex;
        transition: transform 0.2s;
    }

    .course-card:hover {
        transform: translateY(-2px);
    }

    .course-image {
        flex: 0 0 300px;
        height: 200px;
        object-fit: cover;
    }

    .course-content {
        padding: 1.5rem;
        flex: 1;
    }

    .course-title {
        font-size: 1.4rem;
        margin: 0 0 1rem;
        color: var(--primary-dark);
    }

    .course-description {
        color: #64748b;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .course-date {
        color: #94a3b8;
        font-size: 0.9rem;
    }

    .btn {
        padding: 0.6rem 1.2rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
        display: inline-block;
    }

    .btn-primary {
        background: var(--primary);
        color: white !important;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
    }

    .pagination {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        margin: 2rem 0;
        flex-wrap: wrap;
    }

    .page-btn {
        background: white;
        color: var(--primary);
        border: 1px solid #e2e8f0;
        padding: 0.5rem 1rem;
    }

    .page-btn:hover {
        background: var(--primary);
        color: white;
    }

    .page-btn.disabled {
        opacity: 0.5;
        pointer-events: none;
    }

    .alert {
        padding: 1rem;
        border-radius: 8px;
        background: #e0f2fe;
        color: #0369a1;
        margin: 2rem 0;
    }

    @media (max-width: 768px) {
        .course-card {
            flex-direction: column;
        }
        
        .course-image {
            flex: none;
            width: 100%;
            height: 200px;
        }
        
        .container {
            padding: 15px;
        }
        
        .pagination {
            gap: 0.3rem;
        }
    }
</style>

<div class="container">
  <?php include "inc/NavBar.php"; ?>
<?php if ($courses) { ?>  <h4 class="course-list-title">All Courses (<?=$row_count?>)</h4>
  <div class="course-list">
    <?php foreach ($courses as $course) {?>
    <div class="course-card">
        <img src="../Upload/thumbnail/<?=$course["cover"]?>" 
             class="course-image" 
             alt="course cover">
        <div class="course-content">
            <h3 class="course-title"><?=$course["title"]?></h3>
            <p class="course-description"><?=$course["description"]?></p>
            <p class="course-date"><?=$course["created_at"]?></p>
            <a href="Course.php?course_id=<?=$course["course_id"]?>" class="btn btn-primary">View Course</a>
        </div>
    </div>
    <?php } ?>
  </div>
  <?php }else{ ?>
    <div class="alert">No courses found in the database</div>
  <?php } ?>

  <?php if ($last_page > 1 ) { ?>
  <div class="pagination">
      <?php
            $prev = 1;
            $next = 1;
            $next_btn = true;
            $prev_btn = true;
            if($page <= 1) $prev_btn = false; 
            if($last_page ==  $page) $next_btn = false; 
            if($page > 1) $prev = $page - 1;
            if($page < $last_page) $next = $page + 1;
            
            if ($prev_btn){
            ?>
            <a href="Courses.php?page=<?=$prev?>" class="btn page-btn">Prev</a>
           <?php }else { ?>
            <a href="#" class="btn page-btn disabled">Prev</a>
           <?php } 
           
           for($i = max(1, $page - 2); $i <= min($page + 2, $last_page); $i++){
            if($i == $page){ ?>
             <a href="Courses.php?page=<?=$i?>" class="btn page-btn" style="background: var(--primary); color: white;"><?=$i?></a>
           <?php }else{ ?>
             <a href="Courses.php?page=<?=$i?>" class="btn page-btn"><?=$i?></a>
           <?php }
            } 
            
            if($next_btn){
            ?>
            <a href="Courses.php?page=<?=$next?>" class="btn page-btn">Next</a>
        <?php }else { ?>
           <a href="#" class="btn page-btn disabled">Next</a>
        <?php } ?>
  </div>
  <?php } ?>
</div>

<!-- Footer -->
<?php include "inc/Footer.php"; ?>

<?php
 }else { 
$em = "First login ";
Util::redirect("../login.php", "error", $em);
} ?>