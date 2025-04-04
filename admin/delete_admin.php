<?php
include '../database/connection.php';
include 'session_not_login.php';

if (isset($_GET['id'])) {
    $admin_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT profile_picture FROM tbl_admin WHERE id = :id");
    $stmt->bindParam(':id', $admin_id);
    $stmt->execute();

    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        $profile_picture = $admin['profile_picture'];

        if ($profile_picture && file_exists("profile/images/" . $profile_picture)) {
            unlink("profile/images/" . $profile_picture);
        }

        $delete_stmt = $conn->prepare("DELETE FROM tbl_admin WHERE id = :id");
        $delete_stmt->bindParam(':id', $admin_id);

        if ($delete_stmt->execute()) {
            $_SESSION['success'] = "Admin deleted successfully!";
        } else {
            $_SESSION['errors'] = "Failed to delete admin.";
        }
    } else {
        $_SESSION['errors'] = "Admin not found.";
    }

    header("Location: admin_management.php");
    exit;
} else {
    $_SESSION['errors'] = "Invalid admin ID.";
    header("Location: admin_management.php");
    exit;
}
