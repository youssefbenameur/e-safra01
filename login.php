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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #ffc107;
            --primary-hover: #4f46e5;
            --background: #f8fafc;
            --text-color: #0f172a;
            --light-gray: #94a3b8;
            --error-color: #dc2626;
            --success-color: #16a34a;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            padding: 1rem;
        }

        .wrapper {
            width: 100%;
            max-width: 400px;
        }

        .form-holder {
            background: white;
            padding: 2.5rem;
            border-radius: 1.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-header h2 {
            font-size: 2rem;
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }

        .form-header p {
            color: var(--light-gray);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-color);
            font-weight: 500;
            font-size: 0.9rem;
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--light-gray);
            font-size: 1rem;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 2.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 0.75rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            appearance: none;
            background: white;
        }

        .form-group select {
            padding: 0.875rem 1rem;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1em;
        }

        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .submit-btn {
            width: 100%;
            padding: 1rem;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 0.75rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .submit-btn:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(99, 102, 241, 0.3);
        }

        .form-footer {
            margin-top: 1.5rem;
            text-align: center;
        }

        .form-links {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .form-links a {
            color: var(--light-gray);
            text-decoration: none;
            transition: color 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-links a:hover {
            color: var(--primary-color);
        }

        .alert {
            padding: 1rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert i {
            font-size: 1.2rem;
        }

        .alert.error {
            background: #fee2e2;
            color: var(--error-color);
        }

        @media (max-width: 640px) {
            .form-holder {
                padding: 1.5rem;
            }
            
            .form-header h2 {
                font-size: 1.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="form-holder">
            <div class="form-header">
                <h2>Welcome Back</h2>
                <p>Please login to continue</p>
            </div>

            <?php if (isset($_GET['error'])) { ?>
                <div class="alert error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= Validation::clean($_GET['error']) ?>
                </div>
            <?php } ?>

            <form class="form" action="Action/login.php" method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" required placeholder="Enter username">
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" required placeholder="Enter password">
                    </div>
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
                    <button type="submit" class="submit-btn">
                        <span>Sign In</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>

                <div class="form-links">
                    <a href="signup.php">
                        <i class="fas fa-user-plus"></i>
                        Create Account
                    </a>
                    <a href="index.php">
                        <i class="fas fa-home"></i>
                        Return Home
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>