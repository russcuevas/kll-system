<?php
include '../database/connection.php';
include 'session_not_login.php';

if (isset($_GET['id'])) {
    $course_id = $_GET['id'];

    // Fetch the course data using the course ID
    $stmt = $conn->prepare("SELECT course_picture FROM tbl_courses WHERE id = :id");
    $stmt->bindParam(':id', $course_id);
    $stmt->execute();
    $course = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if course exists
    if ($course) {
        // Decode the JSON array of image filenames
        $images = json_decode($course['course_picture'], true);

        // Delete the image files from the server
        if (!empty($images)) {
            $target_dir = "profile/courses/";
            foreach ($images as $image) {
                $image_path = $target_dir . $image;
                if (file_exists($image_path)) {
                    unlink($image_path);  // Delete the image file
                }
            }
        }

        // Delete the course record from the database
        $stmt_delete = $conn->prepare("DELETE FROM tbl_courses WHERE id = :id");
        $stmt_delete->bindParam(':id', $course_id);
        $stmt_delete->execute();

        // Redirect to a page with a success message (e.g., the course list page)
        $_SESSION['success'] = "Course and images deleted successfully!";
        header('Location: course.php');  // Adjust the redirect to your course list page
        exit;
    } else {
        // If course is not found
        $_SESSION['error'] = "Course not found!";
        header('Location: course.php');  // Redirect to the course list page
        exit;
    }
} else {
    // If ID is not provided
    $_SESSION['error'] = "Invalid request!";
    header('Location: course.php');  // Redirect to the course list page
    exit;
}
