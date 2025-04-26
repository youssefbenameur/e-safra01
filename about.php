<!DOCTYPE html>
<html>
<head>
	<title>about - e-safra</title>
	<link rel="stylesheet" type="text/css" href="assets/css/welcome.css">
	<link rel="icon" type="image/x-icon" href="favicon.ico">
</head>
<body>
    <section class="section-1" style="background-image: url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-position: center; background-repeat: no-repeat; width: 100%; height: 80vh;">

    	<header>
				<h2 class="logo">
	         <img src="./assets/img/icon.png"/>
            <span>
              <span>E-</span>
              <span>SAFRA</span>
            </span>
        </h2>
	    	<nav>
	    		<a href="index.php">Home</a>
	    		<a href="about.php"  class="active">About</a>
	    		<a href="signup.php">Sign Up</a>
	    		<a href="login.php">Login</a>
	    		
	    		
	    	</nav>
    	</header>
    </section>
<section class="about-modern py-5 text-white" id="about">
  <div class="container">
    
    <!-- Welcome Message -->
    <div class="text-center mb-5">
			
      <h2 class="fw-bold"> Welcome to E-SAFRA</h2>
      <p class="fs-5">
        Your space to learn, teach, and connect — built by the ESSTHS community for the ESSTHS community.
      </p>
    </div>

		<div class="col-lg-6 text-center text-lg-start">
			<h1 class="fw-bold mb-3">Who We Are</h1>

			<p class="fs-5">
				E-SAFRA was born at <strong>ESSTHS</strong> — an institution filled with bright, driven, and passionate students...
			</p>

			<p class="fs-5">
				We’re not just a platform — we’re a movement...
			</p>

			<p>
				Whether you're watching lectures in your PJs or dropping knowledge in a forum...
			</p>

			<!-- ✅ Centered Button -->
			<div class="text-center mt-4">
				<a href="#join-instructor" class="btn btn-light btn-lg px-4 rounded-pill fw-bold">Join the Movement</a>
			</div>
		</div>

    </div>
  </div>
</section>

    <section class="section-2">

    	<h1 style="text-align: center;">

    		<img src="assets/img/icon.png"><br>
    		E-SAFRA 
    	</h1>
    	<p>
    	The online learning system website aims to provide a user-friendly and accessible platform for learners, instructors, and administrators. The system is designed to facilitate seamless interaction, efficient course management, and a rich learning experience. The website incorporates the following versions:
    	</p>
    	<h1>Goals</h1>
    	<p>
    		  - Enable users to easily navigate and explore available courses. <br>
    		  - Streamline the course enrollment process for a hassle-free experience. <br>
    		  - Provide an intuitive dashboard for tracking course progress, achievements, and certificates. <br>
    		  - Implement responsive design for optimal user experience across devices.<br>
    		  - Foster engagement through discussion forums, ratings, and reviews.<br>
    		  - Offer instructors a straightforward interface for course creation and content management.<br>
		     - Provide tools for quiz and assignment creation, as well as grading functionalities.<br>
		     - Enable instructors to view and analyze user progress and quiz performance.<br>
		     - Facilitate the generation of certificates for course completion.<br>
		     - Support effective communication through discussion forums.<br>
    	</p>

    </section>
		

<section class="section-2">
    	<h1>Welcome to e-safra</h1>
    	<p>
    	Welcome to our Online Learning System, where knowledge meets accessibility. Our platform is crafted to empower learners, instructors, and administrators with the tools they need for a dynamic and enriching educational experience.
    	</p>
    	<h1>For Learners:</h1>
    	<p>
    		Embark on your learning journey with ease. Browse through a diverse range of courses, enroll effortlessly, and track your progress in real-time. Engage with fellow learners through discussion forums, share insights, and earn certificates as a testament to your accomplishments.
    	</p>
    	<h1>For Instructors:</h1>
    	<p>
    		Shape the future of education by creating captivating courses. Our instructor version provides an intuitive environment for content creation, quiz management, and grading. Stay connected with your students through forums, monitor their progress, and witness the impact of your expertise.

    		
    	</p>
    	<p>
    		At the heart of our platform is a commitment to fostering a collaborative and interactive learning experience. Join us on this educational adventure, where knowledge knows no bounds. Welcome to a world of learning at your fingertips.
    	</p>
			<p>
				helllooooooo
			</p>



    </section>
     
    <footer class="main-footer">
      <h4>E_Safra&copy;2025</h4>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <script>
    	$(document).ready(function(){
    		$(window).on('scroll', function(){
    			if ($(window).scrollTop()) {
                    $("header").addClass('bgc');
    			}else{
                    $("header").removeClass('bgc');
    			}
    		});
    	});
    </script>
</body>
</html>