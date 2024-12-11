<!-- Registration Page -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <?php
        // Enable error reporting for debugging
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $message = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Sanitize inputs
            $lastName = trim($_POST['Last_Name'] ?? '');
            $email = trim($_POST['Email'] ?? '');
            $phone = trim($_POST['Phone'] ?? '');
            $password = trim($_POST['Password'] ?? '');
            $confirmPassword = trim($_POST['confirmPassword'] ?? '');

            // Validation checks
            if (empty($lastName) || empty($email) || empty($phone) || empty($password) || empty($confirmPassword)) {
                $message = "All fields are required.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $message = "Invalid email format.";
            } elseif (!preg_match("/^\d{11}$/", $phone)) {
                $message = "Phone number must be 11 digits.";
            } elseif ($password !== $confirmPassword) {
                $message = "Passwords do not match.";
            } else {
                // Simulate successful registration
                $message = "Registration successful! Redirecting to login...";
                echo "<p style='color: green;'>$message</p>"; // Display success message
                // Uncomment the next line in production to redirect
                // header("Refresh: 3; URL=login.php");
                exit;
            }
        }
        ?>
        <form id="registerForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <h2>Create an Account</h2>
            <?php if (!empty($message)): ?>
                <p style="color: red;"><?php echo $message; ?></p>
            <?php endif; ?>
            <div class="input-field">
                <input type="text" id="Last_Name" name="Last_Name" value="<?php echo htmlspecialchars($lastName ?? ''); ?>" required>
                <label for="Last_Name">Last Name</label>
            </div>
            <div class="input-field">
                <input type="email" id="Email" name="Email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                <label for="Email">Email</label>
            </div>
            <div class="input-field">
                <input type="text" id="Phone" name="Phone" value="<?php echo htmlspecialchars($phone ?? ''); ?>" required>
                <label for="Phone">Phone (11 digits)</label>
            </div>
            <div class="input-field">
                <input type="password" id="Password" name="Password" required>
                <label for="Password">Password</label>
            </div>
            <div class="input-field">
                <input type="password" id="confirmPassword" name="confirmPassword" required>
                <label for="confirmPassword">Confirm Password</label>
            </div>
            <button type="submit">Register</button>
            <div class="login-link">
                <p>Already have an account? <a href="login.php">Login here</a></p>
            </div>
        </form>
    </div>
</body>
</html>
