<?php
// Start session to get user data
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get the user's full name from the session
$fullname = $_SESSION['fullname'];

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "bursary_system";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Fetch the application status from the database
$sql = "SELECT application_status FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($application_status);
$stmt->fetch();
$stmt->close();

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Bursary Management System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        Welcome, <?= htmlspecialchars($fullname) ?>!
    </header>
    
    <main>
        <div class="profile-container">
            <section class="status-section">
                <h2>Application Status</h2>
                <p>Your bursary application status: <span id="status"><?= htmlspecialchars($application_status) ?></span></p>
            </section>

            <section class="bursary-availability-section">
                <h2>Bursary Availability</h2>
                <p id="availability">Bursary Available: Yes</p> <!-- This could also be dynamic -->
            </section>

            <section class="apply-bursary-section">
                <h2>Apply for Bursary</h2>
                <form action="apply_bursary.php" method="POST">
                    <label for="amount">Requested Amount:</label>
                    <input type="number" id="amount" name="amount" required>

                    <button type="submit">Submit Application</button>
                </form>
            </section>

            <!-- Logout Button -->
            <section class="logout-section">
                <a href="logout.php"><button class="button">Logout</button></a>
            </section>
        </div>
    </main>
    
    <footer>
        &copy; 2025 Bursary Management System. All rights reserved.
    </footer>
</body>
</html>
