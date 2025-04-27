<?php 
include "Utils/Validation.php";

$fname = $uname = $email = $bd = $lname ="";
if (isset($_GET["fname"])) {
    $fname = Validation::clean($_GET["fname"]);
}
if (isset($_GET["uname"])) {
    $uname = Validation::clean($_GET["uname"]);
}
if (isset($_GET["email"])) {
    $email = Validation::clean($_GET["email"]);
}
if (isset($_GET["bd"])) {
    $bd = Validation::clean($_GET["bd"]);
}
if (isset($_GET["lname"])) {
    $lname = Validation::clean($_GET["lname"]);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up</title>
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
            max-width: 600px;
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

        .form-header a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
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

        .form-group input {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 2.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 0.75rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
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

        .home-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--light-gray);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .home-link:hover {
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

        .alert.success {
            background: #dcfce7;
            color: var(--success-color);
        }

        @media (max-width: 640px) {
            .form-holder {
                padding: 1.5rem;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
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
                <h2>Create New Account</h2>
                <p>Already have an account? <a href="login.php">Sign In</a></p>
            </div>

            <?php if (isset($_GET['error'])) { ?>
                <div class="alert error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= Validation::clean($_GET['error']) ?>
                </div>
            <?php } ?>
            <?php if (isset($_GET['success'])) { ?>
                <div class="alert success">
                    <i class="fas fa-check-circle"></i>
                    <?= Validation::clean($_GET['success']) ?>
                </div>
            <?php } ?>

            <form class="form" action="Action/signup.php" method="POST">
                <div class="form-grid">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="fname" placeholder="First name" value="<?= $fname ?>">
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="lname" placeholder="Last name" value="<?= $lname ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="Email" value="<?= $email ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Birth Date</label>
                    <div class="input-with-icon">
                        <i class="fas fa-calendar-alt"></i>
                        <input type="date" name="date_of_birth" value="<?= $bd ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" placeholder="Username" value="<?= $uname ?>">
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-with-icon">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <div class="input-with-icon">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="re_password" placeholder="Confirm Password">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="submit-btn">
                        <span>Sign Up</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>

                <div class="form-footer">
                    <a href="index.php" class="home-link">
                        <i class="fas fa-arrow-left"></i>
                        Back to Home
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>