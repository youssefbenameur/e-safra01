<?php
include "Utils/Validation.php";
include "Config.php";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login - <?=SITE_NAME?></title>
	<link rel="icon" type="image/x-icon" href="favicon.ico">
	<style>
		:root {
			--primary: #2c3e50;
			--secondary: #3498db;
			--accent: #e67e22;
			--light: #f8f9fa;
		}

		body {
			margin: 0;
			padding: 0;
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
			background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
						url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');
			background-size: cover;
			background-position: center;
			font-family: 'Segoe UI', system-ui, sans-serif;
		}

		.auth-container {
			background: rgba(255,255,255,0.95);
			padding: 2.5rem;
			border-radius: 15px;
			box-shadow: 0 8px 32px rgba(0,0,0,0.1);
			width: 100%;
			max-width: 400px;
			backdrop-filter: blur(10px);
			border: 1px solid rgba(255,255,255,0.2);
		}

		.logo {
			text-align: center;
			margin-bottom: 2rem;
		}

		.logo img {
			width: 80px;
			margin-bottom: 1rem;
		}

		h2 {
			color: var(--primary);
			margin: 0 0 1.5rem 0;
			font-size: 1.8rem;
			font-weight: 600;
		}

		.form-group {
			margin-bottom: 1.5rem;
		}

		label {
			display: block;
			margin-bottom: 0.5rem;
			color: var(--primary);
			font-weight: 500;
		}

		input, select {
			width: 100%;
			padding: 0.8rem;
			border: 1px solid #ddd;
			border-radius: 8px;
			font-size: 1rem;
			transition: all 0.3s ease;
		}

		input:focus, select:focus {
			outline: none;
			border-color: var(--secondary);
			box-shadow: 0 0 0 3px rgba(52,152,219,0.2);
		}

		button {
			width: 100%;
			padding: 0.8rem;
			background: var(--secondary);
			color: white;
			border: none;
			border-radius: 8px;
			font-size: 1rem;
			font-weight: 600;
			cursor: pointer;
			transition: all 0.3s ease;
		}

		button:hover {
			background: #2980b9;
			transform: translateY(-1px);
		}

		.error {
			background: #e74c3c;
			color: white;
			padding: 0.8rem;
			border-radius: 8px;
			margin-bottom: 1rem;
			text-align: center;
		}

		.form-links {
			margin-top: 1.5rem;
			text-align: center;
		}

		.form-links a {
			color: var(--secondary);
			text-decoration: none;
			font-weight: 500;
			transition: color 0.3s ease;
		}

		.form-links a:hover {
			color: #2980b9;
		}

		@media (max-width: 480px) {
			.auth-container {
				padding: 1.5rem;
				margin: 1rem;
			}
		}
	</style>
</head>
<body>
    <div class="auth-container">
    	<div class="logo">
    		<img src="assets/img/icon.png" alt="Site Logo">
    		<h2>Welcome Back</h2>
    	</div>
    	<?php if (isset($_GET['error'])): ?>
    		<p class="error"><?=Validation::clean($_GET['error'])?></p>
    	<?php endif; ?>
    	
    	<form class="form" action="Action/login.php" method="POST">
    		<div class="form-group">
    			<label>Username</label>
    			<input type="text" name="username" required placeholder="Enter username">
    		</div>
    		<div class="form-group">
    			<label>Password</label>
    			<input type="password" name="password" required placeholder="Enter password">
    		</div>
			<div class="form-group">
				<label>Role</label>
				<select name="role" required>
				   <option value="Admin">Admin</option>
				   <option value="Instructor">Instructor</option>
				   <option value="Student" selected>Student</option>
				</select>
    		</div>
    		<div class="form-group">
    			<button type="submit">Sign In</button>
    		</div>
    		<div class="form-links">
    			<a href="signup.php">Create Account</a> • 
    			<a href="index.php">Return Home</a>
    		</div>
    	</form>
    </div>
</body>
</html>