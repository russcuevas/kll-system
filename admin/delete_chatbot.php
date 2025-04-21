<?php
include '../database/connection.php';
include 'session_not_login.php';

if (isset($_GET['id'])) {
    $chatbot_id = $_GET['id'];

    // Fetch the chatbot record
    $stmt = $conn->prepare("SELECT * FROM tbl_chatbot WHERE id = :id");
    $stmt->bindParam(':id', $chatbot_id);
    $stmt->execute();

    $chatbot = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($chatbot) {
        // Proceed to delete the chatbot record without checking for image
        $delete_stmt = $conn->prepare("DELETE FROM tbl_chatbot WHERE id = :id");
        $delete_stmt->bindParam(':id', $chatbot_id);

        if ($delete_stmt->execute()) {
            $_SESSION['success'] = "Chatbot inquiry deleted successfully!";
        } else {
            $_SESSION['errors'] = "Failed to delete the chatbot inquiry.";
        }
    } else {
        $_SESSION['errors'] = "Chatbot inquiry not found.";
    }

    // Redirect back to the chatbot management page
    header("Location: chatbot.php");
    exit;
} else {
    $_SESSION['errors'] = "Invalid chatbot ID.";
    header("Location: chatbot.php");
    exit;
}
