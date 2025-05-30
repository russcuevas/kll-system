<?php
session_start();
include 'database/connection.php';

// FETCH COURSES
$get_course = "SELECT * FROM tbl_courses";
$stmt = $conn->query($get_course);
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KLL - Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="shortcut icon" href="assets/images/kll-logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/homepage.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css" />
    <link href="assets/css/bot.css" rel="stylesheet" />
    <style>
        .nav-link.active {
            color: #FEC653 !important;
        }

        .slick-container img {
            width: 100%;
            height: auto;
        }

        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #7D0A0A;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .logo-preloader {
            border-radius: 50px !important;

            width: 100px;
            animation: tibok 1s infinite;
        }

        @keyframes tibok {
            0% {
                transform: scale(1);
            }

            25% {
                transform: scale(1.2);
            }

            50% {
                transform: scale(1);
            }

            75% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }

        .pagination .page-item.active .page-link {
            background-color: #7D0A0A !important;
            border-color: #7D0A0A !important;
            color: #fff !important;
        }

        .pagination .page-link {
            color: #7D0A0A;
        }

        .pagination .page-link:hover {
            background-color: #FEC653;
            color: #7D0A0A;
        }
    </style>
</head>

<body>

    <div id="preloader">
        <img class="logo-preloader" src="assets/images/kll-logo.jpg" alt="UB Logo" class="logo">
    </div>


    <nav class="navbar navbar-expand-lg navbar-dark" id="navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="">
                <img style="height: 60px" src="assets/images/kll-logo.jpg" alt="UB Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="home.php">Overview</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin/admin_login.php">Admin Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Examiners Login</a>
                        </li>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">My Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['admin_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="admin/index.php">Admin Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin/logout.php">Logout</a>
                        </li>
                    <?php endif; ?>
                </ul>


            </div>
        </div>
    </nav>

    <header>
        <h1>
            FUTURE: Facilitating University Track <br> Understanding and Recommendation Engine
        </h1>
        <p></p>
    </header>

    <div class="container">
        <h3 class="mt-5">OFFERED COURSE</h3>
        <div class="row">
            <?php foreach ($courses as $course): ?>
                <div class="col-12 col-sm-6 col-md-4 mb-4 d-flex align-items-stretch">
                    <div class="course-card d-flex flex-column">
                        <div class="slick-container">
                            <!-- Default image if none is in DB -->
                            <?php
                            $images = json_decode($course['course_picture'], true);
                            ?>

                            <?php if (!empty($images) && is_array($images)): ?>
                                <?php foreach ($images as $image): ?>
                                    <img style="height: 300px" src="public/courses/<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($course['course_name']) ?>">
                                <?php endforeach; ?>
                            <?php else: ?>
                                <img style="height: 300px" src="assets/images/default-course.jpg" alt="Default Image">
                            <?php endif; ?>
                        </div>
                        <h2><?= htmlspecialchars($course['course_name']) ?></h2>
                        <p>
                            <?= htmlspecialchars(strlen($course['course_description']) > 50
                                ? substr($course['course_description'], 0, 50) . '...'
                                : $course['course_description']) ?>
                        </p>
                        <div class="mt-auto">
                            <a href="view_course.php?id=<?= $course['id'] ?>" class="btn btn-primary learn-btn">Learn More</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="d-flex justify-content-center">
            </div>
        </div>
    </div>


    <?php include 'chatbot.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.slick-container').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: true,
                arrows: true,
                infinite: true,
                autoplay: true,
                autoplaySpeed: 2000,
                adaptiveHeight: true
            });
        });
    </script>
    <script>
        setTimeout(function() {
            document.getElementById('preloader').style.display = 'none';
        }, 1500);
    </script>
</body>

</html>