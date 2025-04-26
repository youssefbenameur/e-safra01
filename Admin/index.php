<?php 
session_start();
include "../Utils/Util.php";
if (isset($_SESSION['username']) &&
    isset($_SESSION['admin_id'])) {
    include "../Controller/Admin/Student.php";
    $row_count = getCount();

    $page = 1;
    $row_num = 5;
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
    $students = getSomeStudent($offset, $row_num);
    # Header
    $title = "EduPulse - Students ";
    include "inc/Header.php";

?>

<div class="container">
  <!-- NavBar -->
  <?php include "inc/NavBar.php"; ?>
  
  <div class="list-table pt-4">
  <?php if ($students) { ?>
  <h4 class="mb-4 border-bottom pb-2" style="color: #2c3e50; border-color: #e3b500 !important;">All Students <span class="badge bg-dark"><?=$row_count?></span></h4>

  <div class="table-responsive">
    <table class="table table-hover table-bordered shadow-sm">
      <thead class="bg-dark text-light">
        <tr>
          <th class="py-3">#Id</th>
          <th class="py-3">Full name</th>
          <th class="py-3">Status</th>
          <th class="py-3">Action</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($students as $student) {?>
      <tr class="align-middle" style="transition: all 0.3s ease;">
        <td class="fw-bold"><?=$student["student_id"]?></td>
        <td>
          <a href="Student.php?student_id=<?=$student["student_id"]?>" class="text-decoration-none text-dark fw-medium hover-gold">
            <?=$student["first_name"]?> <?=$student["last_name"]?>
          </a>
        </td>
        <td class="status">
          <span class="badge <?=$student['status'] == 'Active' ? 'bg-success' : 'bg-secondary'?>">
            <?=$student["status"]?>
          </span>
        </td>
        <td class="action_btn">
          <?php  
          $status = $student["status"];
          $student_id = $student["student_id"];
          $text_temp = $student["status"] == "Active" ? "Block" : "Unblock";
          $btn_class = $student["status"] == "Active" ? "btn-danger" : "btn-warning";
          ?>
          <a href="javascript:void()" onclick="ChangeStatus(this, <?=$student_id?>)" class="btn <?=$btn_class?> btn-sm shadow action-btn">
            <?=$text_temp?>
          </a>
        </td>
      </tr>
      <?php } ?>
      </tbody>
    </table>
  </div>

  <?php if ($last_page > 1 ) { ?>
  <div class="d-flex justify-content-center mt-4">
    <nav aria-label="Page navigation">
      <ul class="pagination shadow-sm">
        <?php
          $prev = 1;
          $next = 1;
          $next_btn = true;
          $prev_btn = true;
          if($page <= 1) $prev_btn = false; 
          if($last_page == $page) $next_btn = false; 
          if($page > 1) $prev = $page - 1;
          if($page < $last_page) $next = $page + 1;
          
          if ($prev_btn){
        ?>
        <li class="page-item">
          <a href="index.php?page=<?=$prev?>" class="page-link bg-dark text-light border-dark">«</a>
        </li>
        <?php }else { ?>
        <li class="page-item disabled">
          <span class="page-link bg-secondary text-light border-secondary">«</span>
        </li>
        <?php } 
        
        $push_mid = $page;
        if ($page >= 2) $push_mid = $page - 1;
        if ($page > 3) $push_mid = $page - 3;
        
        for($i = $push_mid; $i < 5 + $page; $i++){
          if($i == $page){ ?>
          <li class="page-item active">
            <span class="page-link bg-gold border-gold text-dark"><?=$i?></span>
          </li>
          <?php }else{ ?>
          <li class="page-item">
            <a href="index.php?page=<?=$i?>" class="page-link bg-dark text-light border-dark"><?=$i?></a>
          </li>
          <?php } 
          if($last_page <= $i) break;
        } 
        
        if($next_btn){
        ?>
        <li class="page-item">
          <a href="index.php?page=<?=$next?>" class="page-link bg-dark text-light border-dark">»</a>
        </li>
        <?php }else { ?>
        <li class="page-item disabled">
          <span class="page-link bg-secondary text-light border-secondary">»</span>
        </li>
        <?php } ?>
      </ul>
    </nav>
  </div>

  <?php }}else { ?>
    <div class="alert alert-info shadow-sm" role="alert">
      <i class="fas fa-info-circle me-2"></i> 0 student records found in the database
    </div>
  <?php } ?>
  </div>
</div>

<!-- Footer -->
<?php include "inc/Footer.php"; ?>
<script src="../assets/js/jquery-3.5.1.min.js"></script>
<style>
  /* Custom styles to match the admin theme */
  .hover-gold:hover {
    color: #e3b500 !important;
    text-decoration: underline !important;
  }
  
  .bg-gold {
    background-color: #e3b500 !important;
  }
  
  .border-gold {
    border-color: #e3b500 !important;
  }
  
  .action-btn {
    transition: all 0.3s ease;
    min-width: 90px;
  }
  
  .action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  }
  
  .table-hover tbody tr:hover {
    background-color: rgba(227, 181, 0, 0.05);
    transform: translateX(5px);
  }
  
  .badge {
    font-weight: 500;
    padding: 5px 10px;
  }
  
  .pagination .page-link {
    border-radius: 4px !important;
    margin: 0 3px;
    transition: all 0.3s ease;
  }
  
  .pagination .page-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  }
</style>
<script type="text/javascript">
  var valu= "";
  var btext= "";
  function ChangeStatus(current, stud_id){
    var cStatus = $(current).parent().parent().children(".status").text().toString().trim();
   
    if (cStatus == "Active") {
      valu = "Not Active";
      btext = "Unblock";
      btnClass = "btn-warning";
    }
    else {
      valu = "Active";
      btext = "Block";
      btnClass = "btn-danger";
    }

    $.post("Action/active-student.php",
    {
      student_id: stud_id,
      val: valu
    },
    function(data, status){
      if (status == "success") {
        var statusBadge = $(current).parent().parent().children(".status").find(".badge");
        statusBadge.text(valu);
        statusBadge.removeClass("bg-success bg-secondary").addClass(valu == "Active" ? "bg-success" : "bg-secondary");
        
        var actionBtn = $(current).parent().parent().children(".action_btn").children("a");
        actionBtn.text(btext);
        actionBtn.removeClass("btn-danger btn-warning").addClass(btnClass);
        
        // Add animation effect
        $(current).parent().parent().css({'background-color': 'rgba(227, 181, 0, 0.2)'})
                  .animate({'background-color': 'transparent'}, 1000);
      }
    });
  }
</script>
<?php
 }else { 
$em = "First login ";
Util::redirect("../login.php", "error", $em);
} ?>