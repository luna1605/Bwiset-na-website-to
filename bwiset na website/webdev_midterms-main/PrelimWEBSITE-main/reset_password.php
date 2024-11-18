<?php
session_start();
include 'db.php'; // Include your database connection file

if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot_password.php");
    exit(); // Stop script execution after redirect
}

if (isset($_POST['update_password'])) {
    $new_password = $_POST['new_password'];
    $email = $_SESSION['reset_email'];
    
    // Hash the new password
    $hashed_password = md5($new_password); // Use md5 as an alternative for older PHP versions

    // Prepare statement to update password in the database
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashed_password, $email);

    if ($stmt->execute()) {
        // Redirect to login page after successful password update
        header("Location: accadmin.php");
        exit(); // Stop script execution
    } else {
        echo "<script>alert('Failed to update password: " . $stmt->error . "');</script>";
    }

    // Close the statement
    $stmt->close();
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
