<?php
include '../database/connection.php';
include 'session_not_login.php';

// Check if a default_id was passed
if (isset($_GET['default_id'])) {
    $default_id = $_GET['default_id'];

    // Prepare the delete query
    $query = "DELETE FROM tbl_examiners WHERE default_id = :default_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':default_id', $default_id, PDO::PARAM_STR);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to the main page with a success message
        session_start();
        $_SESSION['success'] = "Examiner deleted successfully!";
    } else {
        // Redirect to the main page with an error message
        session_start();
        $_SESSION['error'] = "Failed to delete the examiner.";
    }

    // Redirect back to the page that lists examiners
    header("Location: add_examiners.php");  // Make sure to replace this with your actual page
    exit();
} else {
    // Redirect back to the page if no `default_id` is provided
    header("Location: add_examiners.php");
    exit();
}
