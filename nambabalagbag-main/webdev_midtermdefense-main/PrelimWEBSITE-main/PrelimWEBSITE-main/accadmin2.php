<?php
session_start();

// Redirect if user is already logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: membership.php");
    exit();
}

if (isset($_POST['login'])) {
    $email = $_POST['login_email'];
    $password = $_POST['login_password'];
    $file = 'users.txt';
    
    if (file_exists($file)) {
        $fp = fopen($file, 'r');
        $registered = false;
        
        while (($line = fgets($fp)) !== false) {
            list($stored_email, $stored_password, $stored_name, $stored_birthdate) = explode(':', trim($line));
            if ($email === $stored_email && $password === $stored_password) {
                $registered = true;
                $_SESSION['logged_in'] = true; // Set logged in flag
                $_SESSION['name'] = $stored_name; // Store name in session
                header("Location: membership.php");
                fclose($fp);
                exit();
            }
        }
        fclose($fp);

        if (!$registered) {
            echo "<script>alert('Account not detected. Please register first.');</script>";
        }
    } else {
        echo "<script>alert('No users registered yet.');</script>";
    }
}


if (isset($_POST['register'])) {
    $email = $_POST['register_email'];
    $password = $_POST['register_password'];
    $re_password = $_POST['register_re_password'];
    $name = $_POST['register_name'];
    $birthdate = $_POST['register_birthdate'];

    if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        echo "<script>alert('Registration failed: Name can only contain letters and spaces.');</script>";
    } elseif ($password !== $re_password) {
        echo "<script>alert('Registration failed: Passwords do not match.');</script>";
    } else {
        $file = 'users.txt';
        $fp = fopen($file, 'a');
        fwrite($fp, "$email:$password:$name:$birthdate\n");
        fclose($fp);

        echo "<script>alert('User registered successfully!');</script>";
    }
}

$show_login = true;

if (isset($_GET['register'])) {
    $show_login = false;
} elseif (isset($_GET['login'])) {
    $show_login = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Registration</title>
    <link rel="stylesheet" href="accadmin.css">
</head>
<body>
    <div class="container">
        <?php if ($show_login) { ?>
            <div class="login-form">
                <div style="text-align: center; margin-bottom: 20px;">
                    <img src="assets/aid.png" alt="Logo" style="width: 350px; height: 150px;">
                </div>
                <h2>Login</h2>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <label for="login_email">Email:</label>
                    <input type="email" id="login_email" name="login_email" required><br><br>
                    <label for="login_password">Password:</label>
                    <input type="password" id="login_password" name="login_password" required><br><br>
                    <input type="submit" name="login" value="Login">
                </form>
                <p><a href="forgot_password.php">Forgot Password?</a></p>
                <p>Don't have an account? <a href="<?php echo $_SERVER['PHP_SELF']; ?>?register">Register</a></p>
            </div>
        <?php } else { ?>
            <div class="register-form">
                <div style="text-align: center; margin-bottom: 20px;">
                    <img src="assets/aid.png" alt="Logo" style="width: 250px; height: 200px;">
                </div>
                <h2>Register</h2>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <label for="register_email">Email:</label>
                    <input type="email" id="register_email" name="register_email" required><br><br>
                    <label for="register_password">Password:</label>
                    <input type="password" id="register_password" name="register_password" required><br><br>
                    <span id="password-error" style="color: red;"></span>
                    <label for="register_re_password">Re-enter Password:</label>
                    <input type="password" id="register_re_password" name="register_re_password" required><br><br>
                    <span id="re-password-error" style="color: red;"></span>
                    <label for="register_name">Name:</label>
                    <input type="text" id="register_name" name="register_name" required><br><br>
                    <span id="name-error" style="color: red;"></span>
                    <label for="register_birthdate">Birthdate:</label>
                    <input type="date" id="register_birthdate" name="register_birthdate" required><br><br>
                    <input type="submit" name="register" value="Register" required><br><br>
                </form>
                <p>Already have an account? <a href="<?php echo $_SERVER['PHP_SELF']; ?>?login">Login</a></p>
            </div>
        <?php } ?>
    </div>
    <script src="validation.js"></script>
</body>
</html>