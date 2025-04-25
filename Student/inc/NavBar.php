<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<nav class="admin-header">
  <style>
    /* =================== Redesigned Navbar =================== */
    .admin-header {
        background: black;
        padding: 0 2rem;
        display: flex;
        align-items: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        height: 70px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
  
    .admin-header .container-fluid {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: 0 15px;
    }
  
    .admin-header .logo {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        min-width: 180px;
    }
  
    .admin-header .logo img {
        width: 45px;
        height: 45px;
        object-fit: contain;
        transition: transform 0.3s ease;
    }
  
    .admin-header .logo:hover img {
        transform: rotate(-15deg);
    }
  
    .logo-text {
        font-family: 'Nunito', sans-serif;
        font-weight: 700;
        font-size: 1.8rem;
        color: #fff;
        display: flex;
        align-items: center;
    }
  
    .logo-text span:first-child {
        color: #e3b500;
        margin-right: 3px;
    }
  
    .logo-text span:last-child {
        color: #fff;
        position: relative;
    }
  
    .logo-text span:last-child::after {
        content: '';
        position: absolute;
        bottom: -3px;
        left: 0;
        width: 100%;
        height: 2px;
        background: #e3b500;
    }
  
    .nav-list {
        display: flex;
        gap: 1.5rem;
        margin: 0;
        align-items: center;
        padding-left: 0;
        list-style: none;
    }
  
    .nav-list li a {
        color: #fff;
        padding: 0.8rem 1.2rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        position: relative;
        font-weight: 600;
    }
  
    .nav-list li a:hover {
        background: rgba(227, 181, 0, 0.1);
        color: #e3b500;
    }
  
    .nav-list li a::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 2px;
        background: #e3b500;
        transition: all 0.3s ease;
    }
  
    .nav-list li a:hover::before {
        width: 100%;
        left: 0;
    }
  
    .nav-list li a.active {
        color: #e3b500;
        background: rgba(227, 181, 0, 0.1);
    }
  
    .nav-list li a i {
        font-size: 1.1rem;
        transition: transform 0.3s ease;
    }
  
    .nav-list li a:hover i {
        transform: translateY(-2px);
    }
  
    .menu-toggle {
        display: none;
        background: none;
        border: none;
        color: #fff;
        font-size: 1.5rem;
        padding: 1rem;
        order: 2;
    }
  
    @media (max-width: 992px) {
        .admin-header {
            padding: 0 1.5rem;
        }
  
        .nav-list {
            position: fixed;
            top: 70px;
            right: -100%;
            width: 280px;
            height: calc(100vh - 70px);
            background: #2a2a2a;
            flex-direction: column;
            gap: 0;
            padding: 2rem 0;
            transition: right 0.3s ease;
        }
  
        .nav-list.active {
            right: 0;
        }
  
        .nav-list li {
            width: 100%;
        }
  
        .nav-list li a {
            border-radius: 0;
            padding: 1.2rem 2rem;
            justify-content: flex-start;
        }
  
        .menu-toggle {
            display: block;
        }
  
        .logo-text {
            font-size: 1.5rem;
        }
  
        .admin-header .logo {
            min-width: auto;
        }
    }
  
    @media (max-width: 576px) {
        .admin-header {
            padding: 0 1rem;
        }
  
        .admin-header .logo img {
            width: 40px;
            height: 40px;
        }
  
        .logo-text {
            font-size: 1.3rem;
        }
  
        .logo-text span:last-child::after {
            bottom: -2px;
        }
    }
  </style>
  
  <div class="container-fluid">
      <a class="navbar-brand" href="#">
          <div class="logo">
              <img src="../assets/img/icon.png" alt="E-SAFRA Logo">
              <span class="logo-text">
                  <span>E-</span>
                  <span>SAFRA</span>
              </span>
          </div>
      </a>
      
      <button class="menu-toggle">
          <i class="fas fa-bars"></i>
      </button>
      
      <?php
      // Get current page name
      $current_page = basename($_SERVER['SCRIPT_NAME']);
      
      // Define navigation items
      $nav_items = [
          [
              'href' => 'dashboard.php',
              'icon' => 'fa-home',
              'text' => 'Dashboard'
          ],
          [
              'href' => 'Enrolled-Course.php',
              'icon' => 'fa-book-open',
              'text' => 'Enrolled Courses'
          ],
          [
              'href' => 'Courses.php',
              'icon' => 'fa-graduation-cap',
              'text' => 'Courses'
          ],
          [
              'href' => 'student_messages.php',
              'icon' => 'fa-comments',
              'text' => 'Messages'
          ],
          [
              'href' => 'Profile-View.php',
              'icon' => 'fa-user',
              'text' => 'Profile'
          ]
      ];
      ?>
      
      <ul class="nav-list">
          <?php foreach ($nav_items as $item): ?>
              <li>
                  <a href="<?= $item['href'] ?>" class="nav-link <?= ($current_page === $item['href']) ? 'active' : '' ?>">
                      <i class="fas <?= $item['icon'] ?>"></i><?= $item['text'] ?>
                  </a>
              </li>
          <?php endforeach; ?>
          <li>
              <a href="../Logout.php" class="nav-link">
                  <i class="fas fa-sign-out-alt"></i>Logout
              </a>
          </li>
      </ul>
  </div>
  </nav>
  
  <script>
      // Mobile Menu Toggle
      document.querySelector('.menu-toggle').addEventListener('click', function() {
          document.querySelector('.nav-list').classList.toggle('active');
      });
  
      // Close menu when clicking outside
      document.addEventListener('click', function(event) {
          const navList = document.querySelector('.nav-list');
          const menuToggle = document.querySelector('.menu-toggle');
          
          if (!navList.contains(event.target) && !menuToggle.contains(event.target)) {
              navList.classList.remove('active');
          }
      });
  
      // Remove the active link management from JavaScript
      // (Now handled server-side by PHP)
  </script>