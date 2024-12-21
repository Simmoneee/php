<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


$host = 'localhost';
$dbname = 'motionmate';
$username = 'root';
$password = ''; 

$message = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';


    if (empty($email) || empty($password)) {
        $message = "Please enter both email and password.";
    } else {
     
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

   
        if ($user && $password === $user['Password']) {
         
            session_start();
            $_SESSION['user_id'] = $user['id']; 
            $_SESSION['user_email'] = $user['email'];

            header("Location: Home.php");
            exit;
        } else {
            $message = "Invalid email or password.";
        }
    }
}
?>


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
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <h2>Login</h2>
            <?php if (!empty($message)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($message); ?></p>
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