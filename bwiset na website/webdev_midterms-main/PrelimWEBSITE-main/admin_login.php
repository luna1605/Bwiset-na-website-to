<?php
session_start();

if (isset($_SESSION['email']) && $_SESSION['email'] === 'admin123@gmail.com') {
    header("Location: adminacc.php"); // Redirect if already logged in
    exit();
}

// Include your database connection here if needed
// Example: require('db_connection.php');

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Assuming you fetch the hashed password from the database
    $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    // Check the password
    if (password_verify($password, $hashed_password)) {
        // Check if the user is admin
        if ($email === 'admin123@gmail.com') {
            $_SESSION['email'] = $email;
            header("Location: admin_login.php"); // Redirect to admin dashboard
            exit();
        } else {
            // Redirect to user account page for non-admin users
            header("Location: accadmin.php");
            exit();
        }
    } else {
        echo "<script>alert('Invalid email or password.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>
    <h1>Admin Login</h1>
    <form action="admin_login.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        
        <input type="submit" name="login" value="Login">
    </form>
</body>
</html>
