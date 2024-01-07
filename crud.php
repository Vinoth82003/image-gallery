<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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

// Create $tableName table if not exists
$sql = "CREATE TABLE IF NOT EXISTS $tableName (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image_url VARCHAR(255) NOT NULL
)";

$conn->query($sql);

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
        echo '<div class="col-md-4 mb-4">
                <div class="card">
                    <img src="' . $image['image_url'] . '" class="card-img-top" alt="' . $image['title'] . '">
                    <div class="card-body">
                        <h5 class="card-title">' . $image['title'] . '</h5>
                        <p class="card-text">' . $image['description'] . '</p>
                        <button class="btn btn-info edit-btn" data-id="' . $image['id'] . '">Edit</button>
                        <button class="btn btn-danger delete-btn" data-id="' . $image['id'] . '">Delete</button>
                    </div>
                </div>
            </div>';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'edit') {
            // Edit image in the database
            $id = $_POST['id'];
            $result = $conn->query("SELECT * FROM $tableName WHERE id='$id'");
            $image = $result->fetch_assoc();

            // Check if the image is found
            if ($image) {
                // Return image data as JSON
                $image['status'] = "success";

                header('Content-Type: application/json');
                echo json_encode($image);
                exit;
            } else {
                // Image not found
                header('HTTP/1.1 404 Not Found');
                exit;
            }
        } elseif ($_POST['action'] === 'delete') {
            // Delete image from the database
            $id = $_POST['id'];

            $conn->query("DELETE FROM $tableName WHERE id='$id'");
            // Respond with success status
            echo json_encode(['status' => 'success']);
            exit;
        } elseif ($_POST['action'] === 'edit-submit') {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];

            // Update image details in the database
            $conn->query("UPDATE `$tableName` SET `title`='$title', `description`='$description' WHERE `id`='$id'");

            echo json_encode(['status' => 'success']);
            exit;

            // Add other conditions if needed
        }
    } else {
        // Add image to the database
        $title = $_POST['title'];
        $description = $_POST['description'];

        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $conn->query("INSERT INTO $tableName (title, description, image_url) VALUES ('$title', '$description', '$uploadFile')");
            // Respond with success status
            echo json_encode(['status' => 'success']);
            exit;
        }
    }
}
