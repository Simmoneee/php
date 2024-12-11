<!-- Login Page -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <?php
        $message = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (!empty($email) && !empty($password)) {
                if ($email === "example@mail.com" && $password === "password123") {
                    $message = "Welcome to MotionMate!";
                    header("Location: home.php"); // Redirect to home page
                    exit;
                } else {
                    $message = "Invalid email or password.";
                }
            } else {
                $message = "Please enter both email and password.";
            }
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <h2>Login</h2>
            <?php if (!empty($message)): ?>
                <p style="color: red;"><?php echo $message; ?></p>
            <?php endif; ?>
            <div class="input-field">
                <input type="email" id="email" name="email" required>
                <label for="email">Enter your Email</label>
            </div>
            <div class="input-field">
                <input type="password" id="password" name="password" required>
                <label for="password">Enter your Password</label>
            </div>
            <div class="remember-me">
                <label for="remember" class="remember-label">
                    <input type="checkbox" id="remember" name="remember">
                    <span> Remember me</span>
                </label>
            </div>
            <button type="submit">Log In</button>
            <div class="register">
                <p>Don't have an account? <a href="Signup.php">Register here</a></p>
            </div>
        </form>
    </div>
</body>
</html>
