<?php
// Database connection
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'mydb';

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$tableName = "mytable";

// CRUD operations
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch images from the database
    $result = $conn->query("SELECT * FROM $tableName");

    $images = [];
    while ($row = $result->fetch_assoc()) {
        $images[] = $row;
    }

    // Display images in cards
    foreach ($images as $image) {
        echo '
        <div class="card ">
        <div class="card-seperate card-image">
            <img src="' . $image['image_url'] . '" alt="' . $image['title'] . '">
        </div>
        <div class="card-seperate card-details ">
            <div class="card-title">' . $image['title'] . '</div>
            <div class="card-description">
            ' . $image['description'] . '
            <div class="read-more">More</div></div>
        </div>
    </div>
        ';
    }
}
