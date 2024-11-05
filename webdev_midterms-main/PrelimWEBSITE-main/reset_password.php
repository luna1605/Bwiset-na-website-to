<?php
session_start();

if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot_password.php");
    exit(); // Stop script execution after redirect
}

if (isset($_POST['update_password'])) {
    $new_password = $_POST['new_password'];
    $email = $_SESSION['reset_email'];
    
    // Update the password in the users.txt file
    $file = 'users.txt';
    $users = file($file);
    $updated = false;

    foreach ($users as &$line) {
        list($stored_email, $stored_password, $stored_name, $stored_birthdate) = explode(':', trim($line));
        if ($email === $stored_email) {
            $line = "$stored_email:$new_password:$stored_name:$stored_birthdate\n"; // Update password
            $updated = true;
        }
    }

    if ($updated) {
        file_put_contents($file, $users);
        // Use header for redirection instead of echo
        header("Location: accadmin.php"); // Redirect to login
        exit(); // Stop script execution
    } else {
        echo "<script>alert('Failed to update password.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="accadmin.css">
</head>
<body>
    <div class="container">
        <div class="reset-password-form">
            <h2>Reset Password</h2>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" required><br><br>
                <input type="submit" name="update_password" value="Update Password">
            </form>
        </div>
    </div>
</body>
</html>
