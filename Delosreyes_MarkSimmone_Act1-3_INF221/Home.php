<?php  
session_start();

$isLoggedIn = isset($_SESSION['user']);
$username = $isLoggedIn ? htmlspecialchars($_SESSION['user']['name']) : 'Guest';

// Database connection
$servername = "localhost"; 
$usernameDB = "root"; 
$passwordDB = ""; 
$dbname = "motionmate"; 

$conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function fetchCities($conn) {
    $sql = "SELECT * FROM cities";
    $result = $conn->query($sql);
    $cities = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $cities[] = $row;
        }
    }
    return $cities;
}

$items = fetchCities($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add-city'])) {
    $newCity = htmlspecialchars(trim($_POST['city-name'])); 

    if (!empty($newCity)) {
        $stmt = $conn->prepare("INSERT INTO cities (name) VALUES (?)");
        $stmt->bind_param("s", $newCity);
        $stmt->execute();
        $stmt->close();
        header("Location: " . $_SERVER['PHP_SELF']); 
        exit();
    } else {
        echo "<p style='color: red;'>City name cannot be empty.</p>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete-id'])) {
    $deleteId = intval($_GET['delete-id']);
    $stmt = $conn->prepare("DELETE FROM cities WHERE id = ?");
    $stmt->bind_param("i", $deleteId);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']); 
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update-city'])) {
    $updateId = intval($_POST['city-id']);
    $updatedName = htmlspecialchars(trim($_POST['city-name'])); 

    if (!empty($updatedName)) {
        $stmt = $conn->prepare("UPDATE cities SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $updatedName, $updateId);
        $stmt->execute();
        $stmt->close();
        header("Location: " . $_SERVER['PHP_SELF']); 
        exit();
    } else {
        echo "<p style='color: red;'>City name cannot be empty.</p>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php"); // Redirect to login page
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MotionMate: Your Safety, Our Priority</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="home.css"> <!-- Link to the external CSS -->
</head>
<body>

    <div class="top-box">
        <input class="search-bar" type="text" placeholder="Search for a city...">
    </div>

    <div class="left-box">
        <h2>Welcome, <?php echo $username; ?>!</h2>
        <form class="alert-container" method="POST">
            <button class="logout-btn" type="submit" name="logout">Logout</button>
        </form>
    </div>

    <div class="manage-cities-box">
        <h2>Manage Cities</h2>

        <!-- Display Existing Cities -->
        <ul>
            <?php foreach ($items as $item) : ?>
                <li>
                    <?php echo $item['name']; ?>
                    <a href="?delete-id=<?php echo $item['id']; ?>" class="delete-btn">Delete</a>
                    <a href="?edit-id=<?php echo $item['id']; ?>" class="edit-btn">Edit</a>
                </li>
            <?php endforeach; ?>
        </ul>

        <!-- Add New City Form (Moved to the Bottom) -->
        <form method="POST">
            <h3>Enter a new city name:</h3>
            <input type="text" name="city-name" placeholder="City Name" required>
            <button type="submit" name="add-city">Add City</button>
        </form>

        <!-- Edit City Form (If Edit Mode is Activated) -->
        <?php if (isset($_GET['edit-id'])): ?>
            <?php 
                $editId = $_GET['edit-id'];
                $editCity = array_filter($items, function($city) use ($editId) {
                    return $city['id'] == $editId;
                });
                $editCity = reset($editCity); // Get the first match (should only be one)
            ?>
            <form method="POST">
                <h3>Edit City Name:</h3>
                <input type="hidden" name="city-id" value="<?php echo $editCity['id']; ?>">
                <input type="text" name="city-name" value="<?php echo $editCity['name']; ?>" required>
                <button type="submit" name="update-city">Update City</button>
            </form>
        <?php endif; ?>
    </div>

</body>
</html>
