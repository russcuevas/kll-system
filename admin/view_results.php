<?php
include '../database/connection.php';
include 'session_not_login.php';

// Validate user ID from query string
if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
} else {
    echo "Invalid or missing User ID.";
    exit;
}

// Fetch student info
$query_student = "SELECT default_id, fullname, gender, age, birthday, strand FROM tbl_examiners WHERE id = :user_id";
$stmt_student = $conn->prepare($query_student);
$stmt_student->bindParam(':user_id', $user_id);
$stmt_student->execute();
$student = $stmt_student->fetch(PDO::FETCH_ASSOC);

// Fetch preferred courses
$query_courses = "
SELECT 
    c1.course_name AS course_1_name,
    c2.course_name AS course_2_name,
    c3.course_name AS course_3_name
FROM 
    tbl_preferred_courses pc
LEFT JOIN tbl_courses c1 ON pc.course_1 = c1.id
LEFT JOIN tbl_courses c2 ON pc.course_2 = c2.id
LEFT JOIN tbl_courses c3 ON pc.course_3 = c3.id
WHERE pc.user_id = :user_id
";
$stmt_courses = $conn->prepare($query_courses);
$stmt_courses->bindParam(':user_id', $user_id);
$stmt_courses->execute();
$preferred_courses = $stmt_courses->fetch(PDO::FETCH_ASSOC);

// Fetch analytics data
$query = "
SELECT 
    q.id AS question_id,
    q.question_text,
    GROUP_CONCAT(DISTINCT c.course_name SEPARATOR '<br>') AS related_courses,
    COUNT(DISTINCT CASE WHEN r.selected_option_id = 1 THEN r.id ELSE NULL END) AS total_points
FROM 
    tbl_questions q
LEFT JOIN 
    tbl_responses r ON q.id = r.question_id AND r.user_id = :user_id
LEFT JOIN 
    tbl_question_courses qc ON q.id = qc.question_id
LEFT JOIN 
    tbl_courses c ON qc.course_id = c.id
GROUP BY 
    q.id
ORDER BY 
    q.id;
";
$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$analytics_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate total points
$total_points = 0;
foreach ($analytics_data as $data) {
    $total_points += $data['total_points'];
}

// Get course points
$query_courses_points = "
SELECT 
    c.course_name,
    SUM(CASE WHEN r.selected_option_id = 1 THEN 1 ELSE 0 END) AS total_points
FROM 
    tbl_courses c
LEFT JOIN 
    tbl_question_courses qc ON c.id = qc.course_id
LEFT JOIN 
    tbl_questions q ON qc.question_id = q.id
LEFT JOIN 
    tbl_responses r ON q.id = r.question_id AND r.user_id = :user_id
GROUP BY 
    c.id
ORDER BY 
    total_points DESC
";
$stmt_courses_points = $conn->prepare($query_courses_points);
$stmt_courses_points->bindParam(':user_id', $user_id);
$stmt_courses_points->execute();
$courses_points = $stmt_courses_points->fetchAll(PDO::FETCH_ASSOC);

// Suggested courses based on points > 0
$suggested_courses = [];
foreach ($courses_points as $course_data) {
    if ($course_data['total_points'] > 0) {
        $suggested_courses[] = $course_data['course_name'];
    }
}

$query_date = "
    SELECT MIN(created_at) AS exam_date
    FROM tbl_responses
    WHERE user_id = :user_id
";
$stmt_date = $conn->prepare($query_date);
$stmt_date->bindParam(':user_id', $user_id);
$stmt_date->execute();
$date_result = $stmt_date->fetch(PDO::FETCH_ASSOC);
$exam_date = $date_result['exam_date'] ? date('F d, Y h:i A', strtotime($date_result['exam_date'])) : 'N/A';


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Admin Panel</title>
    <!-- Favicon-->
    <!-- <link rel="icon" href="favicon.ico" type="image/x-icon"> -->
    <!-- Google Fonts -->
    <!-- <link rel="stylesheet" href="css/fonts/Roboto.css"> -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />
    <!-- Animation Css -->
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />
    <!-- JQuery DataTable Css -->
    <link href="plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">
    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="css/themes/all-themes.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/custom.css">

    <style>
        /* Custom Styles */
        body {
            font-family: 'Poppins', sans-serif !important;
        }

        #nav-bar {
            padding: 20px;
            flex-wrap: wrap;
            background-color: #7D0A0A;
            color: #ecf0f1;
            text-align: left;
            box-shadow: 0px 5px 5px -5px rgba(107, 102, 107, 0.67);
        }

        #division {
            border: 0;
            border-bottom: 3px solid #7D0A0A;
            width: 100%;
            margin-top: 10px;
        }

        .container-box {
            width: 100%;
            max-width: 100%;
            padding-left: 50px;
            padding-right: 50px;
            margin-top: 30px;
            margin-bottom: 30px;
            background-color: white;
            border: #ccc solid 1px;
        }

        .highlight {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body class="theme-red">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-green">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->

    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a id="app-title" style="display:flex;align-items:center" class="navbar-brand" href="index.php">
                    <img id="bcas-logo" style="width:45px;display:inline;margin-right:10px;" src="images/dashboard/kll-logo.jpg" />
                    FUTURE: Facilitating University Track <br> Understanding and Recommendation Engine
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Call Search -->
                    <!-- <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li> -->
                    <!-- #END# Call Search -->
                    <!-- Notifications -->
                    <li class="dropdown">

                    </li>
                    <!-- #END# Notifications -->
                    <!-- Tasks -->

                    <!-- #END# Tasks -->
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">account_circle</i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <?php include 'components/left_sidebar.php' ?>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <?php include 'components/right_sidebar.php' ?>
        <!-- #END# Right Sidebar -->
    </section>

    <section class="content">
        <div class="container">
            <div id="nav-bar" class="d-flex justify-content-center align-items-center">
                <div>
                    <img class="ub-logo" style="height: 80px; width: 80px;" src="assets/images/kll-logo.jpg" alt="KLL Logo" />
                    &nbsp; <?php echo $student['default_id']; ?>
                </div>
            </div>
            <div class="container-box">
                <a class="btn bg-red waves-effect me-2" style="float: right; margin-top: 30px; color: white;" href="print/exam_results.php?user_id=<?php echo $user_id; ?>" target="_blank">DOWNLOAD FOR PRINT</a>
                <h2>RESULTS</h2>
                <!-- Display Student Information -->
                <ul>
                    <strong>Fullname:</strong> <?php echo $student['fullname']; ?><br>
                    <strong>Sex:</strong> <?php echo $student['gender']; ?><br>
                    <strong>Age:</strong> <?php echo $student['age']; ?><br>
                    <strong>Birthday:</strong> <?php echo $student['birthday']; ?><br>
                    <strong>Strand:</strong> <?php echo $student['strand']; ?><br>

                    <strong>Preferred Course:</strong><br>
                    <?php
                    // Check if the courses exist and display them
                    $courses = [
                        $preferred_courses['course_1_name'],
                        $preferred_courses['course_2_name'],
                        $preferred_courses['course_3_name']
                    ];
                    foreach ($courses as $course) {
                        if ($course) {
                            echo "<span>→ " . $course . "</span><br>";
                        }
                    }
                    ?>
                </ul>

                <div id="division"></div>

                <h2>ASSESSMENT SUMMARY</h2>

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="analyticsTable" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Questions</th>
                                        <th>Related Course</th>
                                        <th>Points</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($analytics_data as $index => $data):
                                        $points_display = isset($data['total_points']) ? $data['total_points'] . ' points' : '0 point';
                                    ?>
                                        <tr>
                                            <td><?php echo $index + 1; ?></td>
                                            <td><?php echo $data['question_text']; ?></td>
                                            <td><?php echo $data['related_courses']; ?></td>
                                            <td><?php echo $points_display; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" style="text-align: right;"><strong>Total Points</strong></td>
                                        <td><strong><?php echo $total_points; ?> point<?php echo $total_points > 1 ? 's' : ''; ?></strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="division"></div>

                <h1>Points Analytics</h1>

                <!-- Donut Chart -->
                <div style="width: 50%; height: 100vh; display: flex !important; justify-content: center !important; align-items: center !important;">
                    <canvas id="myDonutChart" width="50" height="70"></canvas>
                </div>

                <div id="division"></div>


                <!-- COURSE SUMMARY POINTS -->
                <div>
                    <h1>Course Summary Points</h1>
                    <p>Each course is displayed below with its total points based on your responses:</p>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Course Name</th>
                                <th>Total Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($courses_points as $course_data): ?>
                                <tr>
                                    <td><?php echo $course_data['course_name']; ?></td>
                                    <td>
                                        <?php
                                        // If the course has points, display the points, otherwise display '0 points'
                                        echo $course_data['total_points'] > 0 ? $course_data['total_points'] . " points" : "0 point";
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>


                <div id="division"></div>

                <?php
                // Check if $preferred_courses is not empty before initializing the array
                if (!empty($preferred_courses)) {
                    $preferred_courses_array = [
                        $preferred_courses['course_1_name'],
                        $preferred_courses['course_2_name'],
                        $preferred_courses['course_3_name']
                    ];
                } else {
                    $preferred_courses_array = []; // Initialize as empty array if no preferred courses
                }

                ?>
                <h2>Suggested Courses <br> <span style="color: brown; font-size: 20px;"><i>(the red highlighted courses are related to your preferred courses)</i></span><br><br></h2>
                <h6 style="color: brown; font-weight: 900;">SUGGESTED COURSE</h6>
                <div class="row">
                    <!-- Top 5 Courses -->
                    <div class="col-md-4">
                        <h6 style="color: brown; font-weight: 900;">Top 5 Courses</h6>
                        <ul style="margin-bottom: 50px !important;">
                            <?php
                            $top_5_courses = array_slice($courses_points, 0, 5);  // Get the top 5 courses
                            foreach ($top_5_courses as $course_data):
                                $course = $course_data['course_name'];
                                $course_points = $course_data['total_points'];
                                // Check if it's a preferred course
                                if (in_array($course, $preferred_courses_array)) {
                                    echo "<li><span class='highlight'>{$course} - {$course_points} point" . ($course_points > 1 ? 's' : '') . "</span></li>";
                                } else {
                                    echo "<li><span>{$course} - {$course_points} point" . ($course_points > 1 ? 's' : '') . "</span></li>";
                                }
                            endforeach;
                            ?>
                        </ul>
                    </div>

                    <!-- Top 3 Courses -->
                    <div class="col-md-4">
                        <h6 style="color: brown; font-weight: 900;">Top 3 Courses</h6>
                        <ul style="margin-bottom: 50px !important;">
                            <?php
                            $top_3_courses = array_slice($courses_points, 0, 3);  // Get the top 3 courses
                            foreach ($top_3_courses as $course_data):
                                $course = $course_data['course_name'];
                                $course_points = $course_data['total_points'];
                                // Check if it's a preferred course
                                if (in_array($course, $preferred_courses_array)) {
                                    echo "<li><span class='highlight'>{$course} - {$course_points} point" . ($course_points > 1 ? 's' : '') . "</span></li>";
                                } else {
                                    echo "<li><span>{$course} - {$course_points} point" . ($course_points > 1 ? 's' : '') . "</span></li>";
                                }
                            endforeach;
                            ?>
                        </ul>
                    </div>

                    <!-- Top 1 Course -->
                    <div class="col-md-4">
                        <h6 style="color: brown; font-weight: 900;">Top 1 Course</h6>
                        <ul style="margin-bottom: 50px !important;">
                            <?php
                            $top_1_course = $courses_points[0];  // Get the top 1 course (first one after sorting)
                            $course = $top_1_course['course_name'];
                            $course_points = $top_1_course['total_points'];
                            // Check if it's a preferred course
                            if (in_array($course, $preferred_courses_array)) {
                                echo "<li><span class='highlight'>{$course} - {$course_points} point" . ($course_points > 1 ? 's' : '') . "</span></li>";
                            } else {
                                echo "<li><span>{$course} - {$course_points} point" . ($course_points > 1 ? 's' : '') . "</span></li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>

            </div>
        </div>


    </section>

    <!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Jquery Validation Plugin Css -->
    <script src="plugins/jquery-validation/jquery.validate.js"></script>
    <script src="js/pages/forms/form-validation.js"></script>
    <!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js"></script>
    <!-- Slimscroll Plugin Js -->
    <script src="plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>
    <!-- Jquery CountTo Plugin Js -->
    <script src="plugins/jquery-countto/jquery.countTo.js"></script>
    <!-- Morris Plugin Js -->
    <script src="plugins/raphael/raphael.min.js"></script>
    <script src="plugins/morrisjs/morris.js"></script>
    <!-- Jquery DataTable Plugin Js -->
    <script src="plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script>
        $(document).ready(function() {
            $('#analyticsTable').DataTable({
                "pageLength": 10,
                "lengthChange": true,
                "ordering": true,
                "searching": true
            });
        });
    </script>
    <script>
        $(function() {
            $('.js-basic-example').DataTable({
                responsive: true,
                pageLength: 5,
                lengthChange: false
            });

            $('.js-exportable').DataTable({
                dom: 'Bfrtip',
                responsive: true,
                pageLength: 5,
                lengthChange: false,
                buttons: [{
                        extend: 'copy',
                        className: 'custom-button'
                    },
                    {
                        extend: 'csv',
                        className: 'custom-button'
                    },
                    {
                        extend: 'excel',
                        className: 'custom-button'
                    },
                    {
                        extend: 'pdf',
                        className: 'custom-button'
                    },
                    {
                        extend: 'print',
                        className: 'custom-button'
                    }
                ]
            });
        });
    </script>

    <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <script src="js/pages/index.js"></script>

    <!-- Demo Js -->
    <script src="js/demo.js"></script>
    <script src="plugins/chartjs/Chart.bundle.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch('calculate_points.php')
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(item => item.course_name);
                    const points = data.map(item => parseInt(item.total_points));

                    const ctx = document.getElementById('myDonutChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: points,
                                backgroundColor: ['#ff6384', '#36a2eb', '#cc65fe', '#ffcd56', '#4bc0c0', '#ff9f40'],
                                hoverBackgroundColor: ['#ff2b3d', '#2188d6', '#9a47d9', '#f6b800', '#34b8b8', '#ff781f']
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top'
                                }
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('Error fetching chart data:', error);
                });
        });
    </script>
</body>

</html>