<?php
include '../database/connection.php';
include 'session_not_login.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $conn->beginTransaction();

    $query1 = "DELETE FROM tbl_preferred_courses WHERE user_id = :id";
    $stmt1 = $conn->prepare($query1);
    $stmt1->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt1->execute();

    $query2 = "DELETE FROM tbl_examiners WHERE id = :id";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt2->execute();

    $conn->commit();
    $_SESSION['success'] = "Examiners deleted successfully!";
    header("Location: examinees_list.php");
    exit;
} else {
    $_SESSION['errors'] = "Invalid examiners ID.";
    header("Location: examinees_list.php");
    exit;
}
