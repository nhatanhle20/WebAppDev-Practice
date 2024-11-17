<?php
$host = "localhost";
$dbname = "final_exam_db";
$username = "root"; 
$password = ""; 

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    // Check if username exists
    $stmt = $conn->prepare("SELECT accountID, password FROM account WHERE username = :username");
    $stmt->bindParam(':username', $inputUsername);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "<div style='color: red;'>Username does not exist!</div>";
    } else {
        // Check if password matches
        if ($user['password'] !== $inputPassword) {
            echo "<div style='color: red;'>Incorrect password!</div>";
        } else {
            // Successful login
            echo "<div style='color: green;'>Login successful!</div>";

            // Fetch photos associated with the user
            $stmt = $conn->prepare("
                SELECT p.data 
                FROM photo p
                JOIN account_photo ap ON p.photoID = ap.photoID
                WHERE ap.accountID = :accountID
            ");
            $stmt->bindParam(':accountID', $user['accountID']);
            $stmt->execute();
            $photos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Display photos in a Bootstrap gallery
            if ($photos) {
                echo "<div class='container mt-4'>";
                echo "<h3>Your Photos:</h3>";
                echo "<div class='row'>";
                foreach ($photos as $photo) {
                    echo "<div class='col-md-3 mb-3'>";
                    echo "<img src='{$photo['data']}' class='img-thumbnail' alt='Photo'>";
                    echo "</div>";
                }
                echo "</div>";
                echo "</div>";
            } else {
                echo "<p>No photos found for this user.</p>";
            }
        }
    }
}
?>
