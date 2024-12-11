<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MotionMate: Your Safety, Our Priority</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <?php
    
    session_start();
    $isLoggedIn = isset($_SESSION['user']); 
        $username = $isLoggedIn ? htmlspecialchars($_SESSION['user']['name']) : 'Guest';
   ?>

   <div class="top-box">
    <input type="text" placeholder="Search..." class="search-bar">
</div>
<div class="left-box">
    <h2>Motion Mate</h2>
    <h3>Your Safety, Our Priority</h3>
<ul>
    <li><a href="home.php">Home</a></li>
    <li><a href="police.php">Police Station</a></li>
    <li><a href="routes.php">Routes</a></li>
    <li><a href="updates.php">Updates</a></li>
</ul>
<div class="alert-container">
    <?php if ($isLoggedIn): ?>
        <p>Welcome, <?php echo $username; ?>!</p>
        <form action="logout.php" method="post" style="display: inline;">
            <button type="submit">Logout</button>
        </form>
        <?php else: ?>
            <button onclick="window.location.href='login.php'">Login</button>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>