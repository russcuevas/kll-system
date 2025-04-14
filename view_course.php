<?php
session_start();
include 'database/connection.php';

// Get course ID from URL
$course_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch course details
$stmt = $conn->prepare("SELECT * FROM tbl_courses WHERE id = :id");
$stmt->bindParam(':id', $course_id, PDO::PARAM_INT);
$stmt->execute();
$course = $stmt->fetch(PDO::FETCH_ASSOC);

// Redirect if course not found
if (!$course) {
    header("Location: index.php");
    exit;
}

// Decode course pictures
$images = json_decode($course['course_picture'], true);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($course['course_name']) ?> - Course Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css" />
    <style>
        .slick-slide img {
            display: block;
            margin: auto;
            max-height: 400px;
            object-fit: cover;
        }
    </style>
</head>

<body>

    <div class="container my-5">
        <a href="index.php" class="btn btn-secondary mb-3">← Back to Homepage</a>

        <h1 class="mb-4"><?= htmlspecialchars($course['course_name']) ?></h1>

        <div class="mb-4">
            <?php if (!empty($images) && is_array($images)): ?>
                <div class="slick-slider">
                    <?php foreach ($images as $img): ?>
                        <div>
                            <img src="public/courses/<?= htmlspecialchars($img) ?>" class="img-fluid" alt="Course Image">
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <img src="assets/images/default-course.jpg" class="img-fluid" alt="Default Image">
            <?php endif; ?>
        </div>

        <p><?= nl2br(htmlspecialchars($course['course_description'] ?? 'No description available.')) ?></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.slick-slider').slick({
                dots: true,
                arrows: true,
                infinite: true,
                autoplay: true,
                autoplaySpeed: 2500,
                adaptiveHeight: true
            });
        });
    </script>
</body>

</html>