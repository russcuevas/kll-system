﻿<?php
include '../database/connection.php';
include 'session_not_login.php';

// GET THE ADMIN
$get_admin_total = "SELECT COUNT(*) AS admin_total FROM `tbl_admin`";
$stmt_admin_total = $conn->prepare($get_admin_total);
$stmt_admin_total->execute();
$result_admin_total = $stmt_admin_total->fetch(PDO::FETCH_ASSOC);
$admin_total = $result_admin_total['admin_total'];
// END GET TOTAL ADMIN

// GET THE EXAMINEES
$get_examinees_list = "SELECT COUNT(*) AS examinees_list FROM `tbl_examiners`";
$stmt_examinees_list = $conn->prepare($get_examinees_list);
$stmt_examinees_list->execute();
$result_examinees_list = $stmt_examinees_list->fetch(PDO::FETCH_ASSOC);
$examinees_list = $result_examinees_list['examinees_list'];
// END GET TOTAL ADMIN

// GET THE COURSE
$get_available_course = "SELECT COUNT(*) AS available_course FROM `tbl_courses`";
$stmt_available_course = $conn->prepare($get_available_course);
$stmt_available_course->execute();
$result_available_course = $stmt_available_course->fetch(PDO::FETCH_ASSOC);
$available_course = $result_available_course['available_course'];
// END GET TOTAL COURSE

//FETCH COURSE
$get_course = "SELECT * FROM `tbl_courses`";
$get_stmt = $conn->query($get_course);
$courses = $get_stmt->fetchAll(PDO::FETCH_ASSOC);

// FETCH ALL STUDENTS INFO
$query_students = "SELECT id, default_id, fullname, gender, age, birthday, strand FROM tbl_examiners";
$stmt_students = $conn->prepare($query_students);
$stmt_students->execute();
$students = $stmt_students->fetchAll(PDO::FETCH_ASSOC);

// FETCH PREFERRED COURSES FOR ALL STUDENTS
$query_courses = "
SELECT 
    pc.user_id, 
    c1.course_name AS course_1_name,
    c2.course_name AS course_2_name,
    c3.course_name AS course_3_name
FROM 
    tbl_preferred_courses pc
LEFT JOIN tbl_courses c1 ON pc.course_1 = c1.id
LEFT JOIN tbl_courses c2 ON pc.course_2 = c2.id
LEFT JOIN tbl_courses c3 ON pc.course_3 = c3.id
";
$stmt_courses = $conn->prepare($query_courses);
$stmt_courses->execute();
$preferred_courses = $stmt_courses->fetchAll(PDO::FETCH_ASSOC);

// FETCH ANALYTICS DATA FOR ALL STUDENTS
$query_analytics = "
SELECT 
    r.user_id,
    SUM(CASE WHEN r.selected_option_id = 1 THEN 1 ELSE 0 END) AS total_points
FROM 
    tbl_responses r
GROUP BY 
    r.user_id
";
$stmt_analytics = $conn->prepare($query_analytics);
$stmt_analytics->execute();
$analytics_data = $stmt_analytics->fetchAll(PDO::FETCH_ASSOC);

// FETCH EXAM DATES FOR ALL STUDENTS
$query_date = "SELECT user_id, MIN(created_at) AS exam_date FROM tbl_responses GROUP BY user_id";
$stmt_date = $conn->prepare($query_date);
$stmt_date->execute();
$exam_dates = $stmt_date->fetchAll(PDO::FETCH_ASSOC);

// FETCH COURSE POINTS TO SUGGEST TOP 5 COURSES
$query_course_points = "
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
    tbl_responses r ON q.id = r.question_id
GROUP BY 
    c.id
HAVING total_points > 0
ORDER BY 
    total_points DESC
LIMIT 5
";
$stmt_course_points = $conn->prepare($query_course_points);
$stmt_course_points->execute();
$top_courses = $stmt_course_points->fetchAll(PDO::FETCH_ASSOC);

// Combine preferred courses and analytics data with student data
$students_data = [];
foreach ($students as $student) {
    // Find corresponding preferred courses for the student
    $student_courses = array_filter($preferred_courses, function ($course) use ($student) {
        return $course['user_id'] == $student['id'];
    });
    $student_courses = reset($student_courses); // Get the first matching record

    // Find corresponding analytics data for the student
    $student_analytics = array_filter($analytics_data, function ($analytics) use ($student) {
        return $analytics['user_id'] == $student['id'];
    });
    $student_analytics = reset($student_analytics); // Get the first matching record

    // Find corresponding exam date for the student
    $student_exam_date = array_filter($exam_dates, function ($exam_date) use ($student) {
        return $exam_date['user_id'] == $student['id'];
    });
    $student_exam_date = reset($student_exam_date); // Get the first matching record

    // Prepare student data
    $students_data[] = [
        'student' => $student,
        'preferred_courses' => $student_courses,
        'analytics' => $student_analytics,
        'exam_date' => isset($student_exam_date['exam_date']) ? date('F d, Y h:i A', strtotime($student_exam_date['exam_date'])) : 'N/A',
        'top_courses' => $top_courses // Add the top courses to the data
    ];
}
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
    <!-- Morris Chart Css-->
    <link href="plugins/morrisjs/morris.css" rel="stylesheet" />
    <!-- JQuery DataTable Css -->
    <link href="plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">
    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="css/themes/all-themes.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/custom.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

        body {
            font-family: 'Poppins', sans-serif !important;
        }

        .select-form {
            display: block !important;
            width: 100% !important;
            height: 34px !important;
            padding: 6px 12px !important;
            font-size: 14px !important;
            line-height: 1.42857143 !important;
            color: #555 !important;
            background-color: #fff !important;
            background-image: none !important;
            border: 1px solid #ccc !important;
            border-radius: 4px !important;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075) !important;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075) !important;
            -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s !important;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s !important;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s !important;
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
                    <li class="dropdown">
                        <ul class="dropdown-menu">
                            <li class="header">TASKS</li>
                            <li class="body">
                                <ul class="menu tasks">
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Footer display issue
                                                <small>32%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-pink" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 32%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Make new buttons
                                                <small>45%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-cyan" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Create new dashboard
                                                <small>54%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-teal" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 54%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Solve transition issue
                                                <small>65%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-orange" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 65%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Answer GitHub questions
                                                <small>92%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-purple" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 92%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="javascript:void(0);">View All Tasks</a>
                            </li>
                        </ul>
                    </li>
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
        <div class="container-fluid">
            <!-- ALERTS -->
            <?php if (isset($_SESSION['success'])) : ?>
                <div class="alert alert-success" role="alert">
                    <?= $_SESSION['success']; ?>
                </div>
                <?php unset($_SESSION['success']);
                ?>
            <?php elseif (isset($_SESSION['errors'])) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= $_SESSION['errors']; ?>
                </div>
                <?php unset($_SESSION['errors']);
                ?>
            <?php endif; ?>
            <!-- END ALERTS -->
            <div class="block-header">
                <h2 style="font-size: 25px; font-weight: 900; color: #7D0A0A !important;">DATA ANALYTICS</h2>
            </div>

            <!-- Widgets -->
            <div class="row clearfix">
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" onclick="window.location.href='admin_management.php';">
                    <div class="info-box bg-red hover-expand-effect" style="background-color: #7D0A0A !important; cursor: pointer;">
                        <div class="icon">
                            <i class="material-icons">admin_panel_settings</i>
                        </div>
                        <div class="content">
                            <div class="text" style="color: white !important;">TOTAL ADMIN</div>
                            <div class="" style="font-size: 20px; color: white !important"><?php echo $admin_total ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" onclick="window.location.href='add_examiners.php';">
                    <div class="info-box bg-red hover-expand-effect" style="background-color: #7D0A0A !important; cursor: pointer;">
                        <div class="icon">
                            <i class="material-icons">groups</i>
                        </div>
                        <div class="content">
                            <div class="text" style="color: white !important;">TOTAL EXAMINEES</div>
                            <div class="" style="font-size: 20px; color: white !important"><?php echo $examinees_list ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" onclick="window.location.href='course.php';">
                    <div class="info-box bg-red hover-expand-effect" style="background-color: #7D0A0A !important; cursor: pointer;">
                        <div class="icon">
                            <i class="material-icons">done_all</i>
                        </div>
                        <div class="content">
                            <div class="text" style="color: white !important;">TOTAL COURSE</div>
                            <div class="" style="font-size: 20px; color: white !important"><?php echo $available_course ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Widgets -->
            <!-- CPU Usage -->
            <div class="row clearfix">
                <!-- Bar Chart -->
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 style="font-size: 17px; font-weight: 900; color: #7D0A0A;">
                                YEARLY EXAMINEES
                            </h2>
                        </div>
                        <div class="body">
                            <canvas id="yearly_examinees" height="139"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 style="font-size: 17px; font-weight: 900; color: #7D0A0A;">
                                EXAMINERS BASED ON SEX
                            </h2>
                        </div>
                        <div class="body">
                            <form action="">
                                <div class="form-group" style="display: flex; align-items: center;">
                                    <label for="year-select-gender" style="font-weight: 600; margin-right: 10px;">Year:</label>
                                    <div class="form-line" style="width: 100px">
                                        <select class="select-form" id="year-select-gender" style="border: none; box-shadow: none;">
                                            <option value="2025">2025</option>
                                            <option value="2026">2026</option>
                                            <option value="2027">2027</option>
                                            <option value="2028">2028</option>
                                            <option value="2029">2029</option>
                                            <option value="2030">2030</option>
                                            <option value="2031">2031</option>
                                            <option value="2032">2032</option>
                                            <option value="2033">2033</option>
                                            <option value="2034">2034</option>
                                            <option value="2035">2035</option>
                                        </select>
                                    </div>
                                </div>
                                <canvas id="gender-chart" height="105"></canvas>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- #END# Bar Chart -->
            </div>

            <div class="row clearfix">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 style="font-size: 17px; font-weight: 900; color: #7D0A0A;">
                                OFFERED COURSE
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <table
                                            class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Course Name</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1;
                                                foreach ($courses as $course) : ?>
                                                    <tr>
                                                        <td><?= $i++; ?></td>
                                                        <td><?= htmlspecialchars($course['course_name']); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 style="font-size: 17px; font-weight: 900; color: #7D0A0A;">
                                TOP PREFERRED COURSE
                            </h2>
                        </div>
                        <div class="body">
                            <form action="">
                                <div class="form-group" style="display: flex; align-items: center;">
                                    <label for="year-select-top-course" style="font-weight: 600; margin-right: 10px;">Year:</label>
                                    <div class="form-line" style="width: 100px">
                                        <select class="select-form" id="year-select-top-course" style="border: none; box-shadow: none;">
                                            <option value="2025">2025</option>
                                            <option value="2026">2026</option>
                                            <option value="2027">2027</option>
                                            <option value="2028">2028</option>
                                            <option value="2029">2029</option>
                                            <option value="2030">2030</option>
                                            <option value="2031">2031</option>
                                            <option value="2032">2032</option>
                                            <option value="2033">2033</option>
                                            <option value="2034">2034</option>
                                            <option value="2035">2035</option>
                                        </select>
                                    </div>
                                </div>
                                <canvas id="preferred-course-chart" height="159"></canvas>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 style="font-size: 17px; font-weight: 900; color: #752738;">
                                ANALYTICS PREFERENCE BASED ON RESULTS
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Full Name</th>
                                                    <th>Score </th>
                                                    <th>Preferred Courses</th>
                                                    <th>Suggested Courses</th>
                                                    <th>Exam Date</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($students_data as $data): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($data['student']['default_id']) ?></td>
                                                        <td><?= htmlspecialchars($data['student']['fullname']) ?></td>
                                                        <td><?= $data['analytics']['total_points'] ?? 0 ?></td>
                                                        <td>
                                                            <?= !empty($data['preferred_courses']['course_1_name']) ? htmlspecialchars($data['preferred_courses']['course_1_name']) : 'N/A' ?><br>
                                                            <?= !empty($data['preferred_courses']['course_2_name']) ? htmlspecialchars($data['preferred_courses']['course_2_name']) : 'N/A' ?><br>
                                                            <?= !empty($data['preferred_courses']['course_3_name']) ? htmlspecialchars($data['preferred_courses']['course_3_name']) : 'N/A' ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if (!empty($data['top_courses'])) {
                                                                foreach ($data['top_courses'] as $course) {
                                                                    echo htmlspecialchars($course['course_name']) . ' (' . $course['total_points'] . ' points)<br>';
                                                                }
                                                            } else {
                                                                echo 'No suggestions available';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?= $data['exam_date'] ?></td>
                                                        <td> <a href="view_results.php?user_id=<?= $data['student']['id'] ?>" class="btn btn-warning">View Results</a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

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
    <!-- ChartJs -->
    <script src="plugins/chartjs/Chart.bundle.js"></script>
    <!-- Flot Charts Plugin Js -->
    <script src="plugins/flot-charts/jquery.flot.js"></script>
    <script src="plugins/flot-charts/jquery.flot.resize.js"></script>
    <script src="plugins/flot-charts/jquery.flot.pie.js"></script>
    <script src="plugins/flot-charts/jquery.flot.categories.js"></script>
    <script src="plugins/flot-charts/jquery.flot.time.js"></script>
    <!-- Sparkline Chart Plugin Js -->
    <script src="plugins/jquery-sparkline/jquery.sparkline.js"></script>
    <!-- Jquery DataTable Plugin Js -->
    <script src="plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
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

    <!-- CHARTS -->

    <!-- YEARLY EXAMINEES -->
    <script>
        function fetchYearlyExaminees(year = null) {
            const url = year ? `charts/fetch_yearly_examinees.php?year=${year}` : `charts/fetch_yearly_examinees.php`;

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data && data.length > 0) {
                        const years = data.map(item => item.year);
                        const examineesCount = data.map(item => item.examinees_count);

                        yearlyExamineesChart.data.labels = years;
                        yearlyExamineesChart.data.datasets[0].data = examineesCount;
                        yearlyExamineesChart.update();
                    } else {
                        console.error('No data returned from the server');
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        }

        var ctx = document.getElementById('yearly_examinees').getContext('2d');
        var yearlyExamineesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['2025', '2026', '2027', '2028', '2029', '2030', '2031', '2032', '2033', '2034', '2035'],
                datasets: [{
                    label: 'Number of Examinees',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    backgroundColor: '#7D0A0A',
                    borderColor: '#7D0A0A',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        fetchYearlyExaminees();
    </script>




    <!-- GENDER CHART -->
    <script>
        var ctx2 = document.getElementById('gender-chart').getContext('2d');
        var genderChart;

        function fetchGenderData(year) {
            fetch(`charts/fetch_gender_examiners.php?year=${year}`)
                .then(response => response.json())
                .then(data => {
                    if (data.male !== undefined && data.female !== undefined) {
                        if (genderChart) {
                            genderChart.destroy();
                        }

                        genderChart = new Chart(ctx2, {
                            type: 'bar',
                            data: {
                                labels: ['Male', 'Female'],
                                datasets: [{
                                    label: 'Examinees',
                                    data: [data.male, data.female],
                                    backgroundColor: ['#3498db', '#e74c3c'],
                                    borderColor: ['#2980b9', '#c0392b'],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    title: {
                                        display: true,
                                        text: `Examinees Based on Gender for ${year}`,
                                        font: {
                                            size: 18,
                                            weight: 'bold'
                                        },
                                        color: '#2c3e50'
                                    }
                                }
                            }
                        });
                    } else {
                        console.error("Invalid data format returned from the server.");
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        }

        fetchGenderData(2025);

        document.getElementById('year-select-gender').addEventListener('change', function() {
            var selectedYear = this.value;
            fetchGenderData(selectedYear);
        });
    </script>

    <!-- YEARLY COMPARISSON -->
    <script>
        const ctx3 = document.getElementById('preferred-course-chart').getContext('2d');
        let preferredCourseChart;

        function fetchTopCourses(year) {
            fetch(`charts/fetch_top_courses.php?year=${year}`)
                .then(async response => {
                    const contentType = response.headers.get("content-type");
                    if (!contentType || !contentType.includes("application/json")) {
                        const text = await response.text();
                        throw new Error("Expected JSON but received: " + text);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        console.error('Server error:', data.message);
                        return;
                    }



                    if (data.labels.length === 0 || data.data.length === 0) {
                        data.labels = ["No Data Available"];
                        data.data = [1]; // Only 1 slice for no data (with red color)
                    }

                    // Destroy the existing chart if it exists
                    if (preferredCourseChart) {
                        preferredCourseChart.destroy();
                    }

                    preferredCourseChart = new Chart(ctx3, {
                        type: 'pie',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Top Preferred Courses',
                                data: data.data,
                                backgroundColor: ['#FF5733', '#33FF57', '#3357FF'],
                                borderColor: ['#fff', '#fff', '#fff'],
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top'
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return tooltipItem.label + ': ' + tooltipItem.raw;
                                        }
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('Error fetching course data:', error.message);
                });
        }

        // Initial fetch with default year
        fetchTopCourses(2025);

        // Add change event listener
        document.getElementById('year-select-top-course').addEventListener('change', function() {
            const selectedYear = this.value;
            fetchTopCourses(selectedYear);
        });
    </script>


    <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <script src="js/pages/index.js"></script>

    <!-- Demo Js -->
    <script src="js/demo.js"></script>
</body>

</html>