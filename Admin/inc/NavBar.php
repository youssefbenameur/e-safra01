<?php
// Determine the current page name without extension
$activePage = basename($_SERVER['SCRIPT_FILENAME'], '.php');
?>
<nav class="admin-header">
  <div class="container-fluid">
    <!-- Logo -->
    <a class="navbar-brand" href="#">
      <div class="logo">
        <img src="../assets/img/icon.png" alt="E-SAFRA Logo" width="50" height="40">
        <span>
          <span>E-</span>
          <span>SAFRA</span>
        </span>
      </div>
    </a>
    <!-- Navigation List -->
    <ul class="nav-list">
      <li>
        <a href="dashboard.php" class="nav-link <?= ($activePage=="dashboard")?"active":""; ?>">
          <i class="fa fa-home"></i> Dashboard
        </a>
      </li>
      <li>
      <a href="index.php" class="nav-link <?= ($activePage=="index")?"active":""; ?>">
  <i class="fa fa-user"></i> Students
</a>  
      </li>
      <li>
        <a href="Instructors.php" class="nav-link <?= ($activePage=="Instructors")?"active":""; ?>">
          <i class="fa fa-user-md"></i> Instructors
        </a>
      </li>
      <li>
        <a href="Courses.php" class="nav-link <?= ($activePage=="Courses")?"active":""; ?>">
          <i class="fa fa-graduation-cap"></i> Courses
        </a>
      </li>
      <li>
        <a href="System-Analysis.php" class="nav-link <?= ($activePage=="System-Analysis")?"active":""; ?>">
          <i class="fa fa-line-chart"></i> System Analysis
        </a>
      </li>
      <li>
        <a href="../Logout.php" class="nav-link">
          <i class="fa fa-sign-out"></i> Logout
        </a>
      </li>
    </ul>
  </div>
</nav>
