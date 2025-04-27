<?php 
session_start();
include "../Utils/Util.php";
include "../Utils/Validation.php";
if (isset($_SESSION['username']) &&
    isset($_SESSION['admin_id'])) {
    
  if (isset($_GET['course_id'])) {
     include "../Controller/Admin/Course.php";
     $_id = Validation::clean($_GET['course_id']);
     $_chapter_id = 1;
     $_topic_id = 1;
     if(isset($_GET['chapter'])) {
      $_chapter_id = Validation::clean($_GET['chapter']);
     }
     if(isset($_GET['topic'])) {
      $_topic_id = Validation::clean($_GET['topic']);
     }
     $psag_exes = pageExes($_id, $_chapter_id);
     if($psag_exes == 0){
         Util::redirect("../404.php", "error", "404");
     }
     
     $course = getById($_id, $_chapter_id, $_topic_id);

     if (empty($course['course']['course_id'])) {
       $em = "Invalid course id";
       Util::redirect("courses.php", "error", $em);
     }
      $num_topic = 0;

    # Header
    $title = "EduPulse - ". $course['course']["title"];
    include "inc/Header.php";
    
?>
<div class="container">
  <!-- NavBar -->
  <?php include "inc/NavBar.php"; ?>
  
  <div class="d-flex mt-4">
    <!-- Left Sidebar - Chapters & Topics -->
    <div class="l-side shadow p-3 rounded-3" style="
        min-width: 300px; 
        background: linear-gradient(135deg, #ffffff 0%, #f8f8f8 100%);
        border-left: 5px solid #1a1a1a;
        margin-right: 20px;
        height: fit-content;
    ">
      <h5 class="border-bottom pb-2 mb-3" style="border-color: #e3b500 !important;">Course Content</h5>
      <ul class="list-group list-group-flush">
        <?php foreach ($course['chapters'] as $chapter) { ?>
          <li class="list-group-item p-0 mb-2">
            <div class="accordion-item border-0">
              <h2 class="accordion-header" id="heading<?=$chapter['chapter_id']?>">
                <button class="accordion-button collapsed bg-light text-dark fw-medium hover-gold" 
                        type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#collapse<?=$chapter['chapter_id']?>" 
                        aria-expanded="false" 
                        aria-controls="collapse<?=$chapter['chapter_id']?>"
                        style="border-left: 3px solid #e3b500;">
                  <?=$chapter['title'] ?>
                </button>
              </h2>
              <div id="collapse<?=$chapter['chapter_id']?>" 
                   class="accordion-collapse collapse" 
                   aria-labelledby="heading<?=$chapter['chapter_id']?>">
                <div class="accordion-body p-0">
                  <ul class="list-group list-group-flush">
                    <?php foreach ($course['topics'] as $topic) {
                      if ($chapter['chapter_id'] == $_chapter_id && $topic['chapter_id'] == $_topic_id) $num_topic++;
                      if ($chapter['chapter_id'] != $topic['chapter_id']) continue;
                      
                      if ($chapter['chapter_id'] == $_chapter_id) $chapter_title = $chapter['title'];
                      if ($topic['topic_id'] == $_topic_id) $topic_title = $topic['title'];
                    ?>
                    <li class="list-group-item ps-4 hover-gold <?=($topic['topic_id'] == $_topic_id) ? 'active-topic' : ''?>">
                      <a href="Course.php?course_id=<?=$_id?>&chapter=<?=$chapter['chapter_id']?>&topic=<?=$topic['topic_id']?>" 
                         class="text-decoration-none d-block py-2 text-dark">
                        <?=$topic["title"]?>
                      </a>
                    </li>
                    <?php } ?>
                  </ul>
                </div>
              </div>
            </div>
          </li>
        <?php } ?>
      </ul>
    </div>

    <!-- Right Side - Content -->
    <div class="r-side shadow p-4 rounded-3 flex-grow-1" style="
        background: linear-gradient(135deg, #ffffff 0%, #f8f8f8 100%);
        border-left: 5px solid #e3b500;
    ">
      <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2" style="border-color: #e3b500 !important;">
        <div>
          <h4 class="m-0 text-dark"><?=$course['course']["title"]?></h4>
          <h6 class="m-0 text-muted"><?=$chapter_title?> - <?=$topic_title?></h6>
        </div>
        <div class="badge bg-dark text-gold">Topic <?=$num_topic?></div>
      </div>
      
      <div class="course-content p-3 rounded-2" style="background-color: rgba(227, 181, 0, 0.05);">
        <?php if (!empty($course['content']["data"])) { ?>
          <?= $course['content']["data"] ?>
        <?php } else { ?>
          <div class="alert alert-info shadow-sm">
            No content available for this topic
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<style>
  /* Custom styles to match the admin theme */
  .hover-gold:hover {
    color: #e3b500 !important;
  }
  
  .text-gold {
    color: #e3b500 !important;
  }
  
  .bg-gold {
    background-color: #e3b500 !important;
  }
  
  .active-topic {
    background-color: rgba(227, 181, 0, 0.1) !important;
    border-left: 3px solid #e3b500 !important;
  }
  
  .accordion-button:not(.collapsed) {
    background-color: rgba(227, 181, 0, 0.1);
    color: #1a1a1a;
  }
  
  .accordion-button:focus {
    box-shadow: 0 0 0 0.25rem rgba(227, 181, 0, 0.25);
    border-color: #e3b500;
  }
  
  .course-content {
    transition: all 0.3s ease;
  }
  
  .course-content:hover {
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  }
  
  .badge-primary {
    background-color: #1a1a1a;
    color: #e3b500;
  }
</style>

<!-- Footer -->
<?php include "inc/Footer.php"; ?>

<?php
  } else { 
    $em = "Invalid course id";
    Util::redirect("courses.php", "error", $em);
  }
} else { 
  $em = "First login ";
  Util::redirect("../login.php", "error", $em);
} ?>