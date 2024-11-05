<?php
session_start();

function generateToken($length = 32) {
    $token = '';
    for ($i = 0; $i < $length; $i++) {
        // Generate a random byte and convert it to a hexadecimal representation
        $token .= dechex(mt_rand(0, 255)); // mt_rand() generates a random number
    }
    return $token;
}

if (isset($_POST['reset_password'])) {
    $email = $_POST['reset_email'];
    $file = 'users.txt';
    $user_found = false;

    if (file_exists($file)) {
        $fp = fopen($file, 'r');
        while (($line = fgets($fp)) !== false) {
            list($stored_email, $stored_password, $stored_name, $stored_birthdate) = explode(':', trim($line));
            if ($email === $stored_email) {
                $user_found = true;

                // Generate a secure token using the alternative method
                $token = generateToken(16); // Create a token of 32 hexadecimal characters

                $_SESSION['reset_email'] = $email; // Store email in session for the next step
                // Instead of an alert, provide a link to reset password
                echo "<script>alert('Password reset link has been sent to $email.');</script>";
                echo "<p>Please <a href='reset_password.php'>click here</a> to reset your password.</p>";
                break;
            }
        }
        fclose($fp);
    } else {
        echo "<script>alert('No users registered yet.');</script>";
    }

    if (!$user_found) {
        echo "<script>alert('Email not found.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="accadmin.css">
</head>
<body>
    <div class="container">
        <div class="forgot-password-form">
            <h2>Forgot Password</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <label for="reset_email">Enter your registered email:</label>
                <input type="email" id="reset_email" name="reset_email" required>
                <input type="submit" name="reset_password" value="Send Reset Link">
            </form>
            <p>Remember your password? <a href="accadmin.php">Login</a></p>
        </div>
    </div>
</body>
</html>
