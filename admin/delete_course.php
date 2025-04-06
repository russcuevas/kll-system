<?php
include '../database/connection.php';
include 'session_not_login.php';

if (isset($_GET['id'])) {
    $course_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT course_picture FROM tbl_courses WHERE id = :id");
    $stmt->bindParam(':id', $course_id);
    $stmt->execute();
    $course = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($course) {
        $images = json_decode($course['course_picture'], true);
        if (!empty($images)) {
            $target_dir = "profile/courses/";
            foreach ($images as $image) {
                $image_path = $target_dir . $image;
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }
        }

        $stmt_delete = $conn->prepare("DELETE FROM tbl_courses WHERE id = :id");
        $stmt_delete->bindParam(':id', $course_id);
        $stmt_delete->execute();

        $_SESSION['success'] = "Course deleted successfully!";
        header('Location: course.php');
        exit;
    } else {
        $_SESSION['error'] = "Course not found!";
        header('Location: course.php');
        exit;
    }
} else {
    // If ID is not provided
    $_SESSION['error'] = "Invalid request!";
    header('Location: course.php');
    exit;
}
