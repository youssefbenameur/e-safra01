<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - E-SAFRA</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #ffc107;
            --accent: #e74c3c;
            --light: #ecf0f1;
            --dark: #2c3e50;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--dark);
        }
        
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                        url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
            background-size: cover;
            background-position: center;
            min-height: 80vh;
            display: flex;
            flex-direction: column;
        }
        
        .navbar {
            transition: all 0.3s ease;
        }
        
        .navbar.scrolled {
            background-color: var(--primary) !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .logo-img {
            height: 40px;
            margin-right: 10px;
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: var(--secondary);
            margin-bottom: 1rem;
        }
        
        .mission-card {
            border-left: 5px solid var(--secondary);
            transition: transform 0.3s ease;
        }
        
        .mission-card:hover {
            transform: translateY(-5px);
        }
        
        .btn-primary {
            background-color: var(--secondary);
            border-color: var(--secondary);
        }
        
        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }
        
        .testimonial-card {
            background-color: var(--light);
            border-radius: 10px;
        }
        
        footer {
            background-color: var(--primary);
            color: white;
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark py-3">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="./assets/img/icon.png" alt="E-SAFRA Logo" class="logo-img">
                    <span class="fw-bold fs-4">E-<span class="text-warning">SAFRA</span></span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php"><i class="fas fa-home me-1"></i> Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="about.php"><i class="fas fa-info-circle me-1"></i> About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="signup.php"><i class="fas fa-user-plus me-1"></i> Sign Up</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt me-1"></i> Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <!-- Hero Content -->
        <div class="container my-auto text-white">
            <div class="row">
                <div class="col-lg-8">
                    <h1 class="display-3 fw-bold mb-4">Empowering Education Through Technology</h1>
                    <p class="lead mb-5">E-SAFRA is revolutionizing learning at ESSTHS with our innovative online platform designed by students, for students.</p>
                    <a href="#about" class="btn btn-primary btn-lg px-4 me-2"><i class="fas fa-arrow-down me-2"></i>Learn More</a>
                    <a href="signup.php" class="btn btn-outline-light btn-lg px-4"><i class="fas fa-user-plus me-2"></i>Join Now</a>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-5 bg-light" id="about">
        <div class="container py-5">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="display-5 fw-bold mb-3">Welcome to E-SAFRA</h2>
                    <p class="lead">Your comprehensive learning platform built by the ESSTHS community for the ESSTHS community.</p>
                    <div class="divider mx-auto bg-primary" style="height: 3px; width: 80px;"></div>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="p-4 h-100">
                        <h3 class="fw-bold mb-4">Who We Are</h3>
                        <p class="fs-5 mb-4">
                            E-SAFRA was born at <strong class="text-primary">ESSTHS</strong> — an institution filled with bright, driven, and passionate students who recognized the need for a better way to learn and share knowledge.
                        </p>
                        <p class="fs-5 mb-4">
                            We're not just a platform — we're a movement dedicated to democratizing education and making learning accessible to everyone in our community.
                        </p>
                        <p class="mb-4">
                            Whether you're watching lectures in your PJs or dropping knowledge in a forum, E-SAFRA brings the classroom to you, wherever you are.
                        </p>
                        <div class="d-flex justify-content-center justify-content-lg-start">
                            <a href="#features" class="btn btn-primary px-4 py-2 rounded-pill fw-bold">
                                <i class="fas fa-rocket me-2"></i>Explore Features
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" 
                         alt="Students learning" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5" id="features">
        <div class="container py-5">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="display-5 fw-bold mb-3">Why Choose E-SAFRA?</h2>
                    <p class="lead">Experience learning reimagined with our powerful features</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="text-center p-4 h-100">
                        <div class="feature-icon">
                            <i class="fas fa-laptop-code"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Interactive Learning</h4>
                        <p>Engage with dynamic course materials, quizzes, and discussion forums that make learning active and social.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center p-4 h-100">
                        <div class="feature-icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Expert Instructors</h4>
                        <p>Learn from the best - our platform connects you with experienced educators and industry professionals.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center p-4 h-100">
                        <div class="feature-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Mobile Friendly</h4>
                        <p>Access your courses anytime, anywhere with our fully responsive design that works on all devices.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission Section -->
    <section class="py-5 bg-light">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="mission-card p-4 bg-white h-100 shadow-sm">
                        <h3 class="fw-bold mb-4">Our Mission</h3>
                        <p class="mb-4">
                            To break down barriers to education by providing an accessible, intuitive platform that empowers both learners and instructors to achieve their full potential.
                        </p>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Democratize access to quality education</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Foster collaborative learning communities</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Support lifelong learning journeys</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Bridge the gap between students and educators</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mission-card p-4 bg-white h-100 shadow-sm">
                        <h3 class="fw-bold mb-4">Our Vision</h3>
                        <p class="mb-4">
                            We envision a future where every ESSTHS student has equal opportunity to learn, grow, and succeed through technology-enabled education.
                        </p>
                        <div class="progress mb-3" style="height: 10px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 95%;" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <p class="small text-muted">Current platform adoption at ESSTHS</p>
                        
                        <div class="progress mb-3" style="height: 10px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 87%;" aria-valuenow="87" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <p class="small text-muted">Student satisfaction rate</p>
                        
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 78%;" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <p class="small text-muted">Instructor engagement</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-5">
        <div class="container py-5">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="display-5 fw-bold mb-3">What Our Community Says</h2>
                    <p class="lead">Hear from students and instructors who are using E-SAFRA</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="testimonial-card p-4 h-100">
                        <div class="d-flex mb-3">
                            <img src="https://randomuser.me/api/portraits/women/32.jpg" class="rounded-circle me-3" width="60" height="60" alt="Student">
                            <div>
                                <h5 class="mb-0">Sarah Johnson</h5>
                                <p class="text-muted mb-0">Computer Science Student</p>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <p>"E-SAFRA has completely transformed how I learn. The ability to revisit lectures and participate in forums has boosted my grades significantly."</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card p-4 h-100">
                        <div class="d-flex mb-3">
                            <img src="https://randomuser.me/api/portraits/men/45.jpg" class="rounded-circle me-3" width="60" height="60" alt="Instructor">
                            <div>
                                <h5 class="mb-0">Prof. Ahmed Ben Ali</h5>
                                <p class="text-muted mb-0">Mathematics Instructor</p>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                            </div>
                        </div>
                        <p>"Creating courses on E-SAFRA is incredibly intuitive. I can see exactly how students are progressing and where they need more help."</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card p-4 h-100">
                        <div class="d-flex mb-3">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" class="rounded-circle me-3" width="60" height="60" alt="Student">
                            <div>
                                <h5 class="mb-0">Leila Trabelsi</h5>
                                <p class="text-muted mb-0">Engineering Student</p>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <p>"As someone who commutes, being able to access course materials on my phone has been a game-changer. I haven't missed a single assignment!"</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-5 bg-primary text-white">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="display-5 fw-bold mb-4">Ready to Transform Your Learning Experience?</h2>
                    <p class="lead mb-5">Join thousands of ESSTHS students and instructors who are already benefiting from E-SAFRA</p>
                    <a href="signup.php" class="btn btn-light btn-lg px-4 me-3"><i class="fas fa-user-plus me-2"></i>Sign Up Now</a>
                    <a href="login.php" class="btn btn-outline-light btn-lg px-4"><i class="fas fa-sign-in-alt me-2"></i>Login</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-4 bg-dark text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <img src="./assets/img/icon.png" alt="E-SAFRA Logo" class="logo-img me-2">
                        <span class="fw-bold fs-5">E-<span class="text-warning">SAFRA</span></span>
                    </div>
                    <p class="mb-0 small mt-2">Empowering education through technology</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">&copy; 2025 E-SAFRA. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Custom JS -->
    <script>
        $(document).ready(function(){
            $(window).on('scroll', function(){
                if ($(window).scrollTop() > 50) {
                    $('.navbar').addClass('scrolled');
                } else {
                    $('.navbar').removeClass('scrolled');
                }
            });
        });
    </script>
</body>
</html>