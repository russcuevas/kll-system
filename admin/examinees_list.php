<?php
include '../database/connection.php';
include 'session_not_login.php';

$filterMonth = isset($_GET['month']) ? $_GET['month'] : '';
$filterYear = isset($_GET['year']) ? $_GET['year'] : '';

$where = "WHERE (pc.course_1 IS NOT NULL OR pc.course_2 IS NOT NULL OR pc.course_3 IS NOT NULL)";
if (!empty($filterMonth)) {
    $where .= " AND MONTH(e.created_at) = :month";
}
if (!empty($filterYear)) {
    $where .= " AND YEAR(e.created_at) = :year";
}

$query = "
SELECT 
    e.id,
    e.default_id,
    e.fullname,
    e.gender,
    e.age,
    e.birthday,
    e.strand,
    e.created_at,
    e.updated_at,
    c1.course_name AS course_1_name,
    c2.course_name AS course_2_name,
    c3.course_name AS course_3_name
FROM tbl_examiners e
LEFT JOIN tbl_preferred_courses pc ON e.id = pc.user_id
LEFT JOIN tbl_courses c1 ON pc.course_1 = c1.id
LEFT JOIN tbl_courses c2 ON pc.course_2 = c2.id
LEFT JOIN tbl_courses c3 ON pc.course_3 = c3.id
$where
";

$stmt = $conn->prepare($query);

if (!empty($filterMonth)) {
    $stmt->bindParam(':month', $filterMonth, PDO::PARAM_INT);
}
if (!empty($filterYear)) {
    $stmt->bindParam(':year', $filterYear, PDO::PARAM_INT);
}

$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);



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

        @media only screen and (max-width: 600px) {
            .btn {
                font-size: 9px !important;
                height: 27px;
                padding-top: 0 !important;
                padding-bottom: 0 !important;
            }


            .btn .material-icons {
                font-size: 14px !important;
                top: 2px;
            }

            .filter-button {
                margin: 0 auto 20px;
                height: 34px;
                display: block;
            }


        }

        @media (min-width: 992px) {

            .select-form-lg {
                margin-left: -20px !important;
            }

            .filter-button {
                margin: 0 auto 20px;
                height: 33px;
                margin-left: -40px !important;
            }
        }

        .table-responsive {
            border: none !important;
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
        <div class="container-fluid">
            <div class="block-header">
                <ol style="font-size: 15px;" class="breadcrumb breadcrumb-col-red">
                    <li><a href="index.php"><i style="font-size: 20px;" class="material-icons">home</i>
                            Dashboard</a></li>
                    <li class="active"><i style="font-size: 20px;" class="material-icons">groups</i>
                        Examinees
                    </li>
                    <li class="active"><i style="font-size: 20px;" class="material-icons">badge</i>
                        Examinees List
                    </li>
                </ol>
            </div>

            <!-- Widgets -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                                <h2 class="m-0" style="font-size: 25px; font-weight: 900; color: #7D0A0A;">
                                    List of Examinees
                                </h2>
                                <div id="print-container">
                                    <?php
                                    $monthQuery = isset($_GET['month']) ? $_GET['month'] : '';
                                    $yearQuery = isset($_GET['year']) ? $_GET['year'] : '';
                                    $printUrl = "print/examinees_list.php?month=$monthQuery&year=$yearQuery";
                                    ?>

                                    <a href="<?= $printUrl ?>" target="_blank" class="btn bg-red waves-effect btn-sm">
                                        <i class="material-icons">print</i>
                                        <span>CLICK TO PRINT</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php
                        $currentMonth = isset($_GET['month']) ? $_GET['month'] : '';
                        $currentYear = isset($_GET['year']) ? $_GET['year'] : '';
                        ?>
                        <div class="body">
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
                            <div class="row mb-3">
                                <div class="form-group">
                                    <form action="" method="GET">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 mb-2">
                                                <select class="form-control select-form" id="month" name="month">
                                                    <option value="">All months</option>
                                                    <?php
                                                    for ($m = 1; $m <= 12; $m++) {
                                                        $monthValue = str_pad($m, 2, '0', STR_PAD_LEFT);
                                                        $selected = ($monthValue == $currentMonth) ? 'selected' : '';
                                                        echo "<option value=\"$monthValue\" $selected>" . date('F', mktime(0, 0, 0, $m, 1)) . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <!-- Year Dropdown -->
                                            <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 mb-2">
                                                <select class="form-control select-form" id="year" name="year">
                                                    <option value="">All years</option>
                                                    <?php
                                                    for ($y = 2025; $y <= 2050; $y++) {
                                                        $selected = ($y == $currentYear) ? 'selected' : '';
                                                        echo "<option value=\"$y\" $selected>$y</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <!-- Buttons -->
                                            <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 mb-2">
                                                <div class="d-flex justify-content-start" style="gap: 10px;">
                                                    <!-- FILTER Button -->
                                                    <button type="submit" class="btn bg-red waves-effect btn-sm">
                                                        <i class="material-icons">filter_list</i>
                                                        <span class="filter-span">FILTER</span>
                                                    </button>

                                                    <!-- RESET Button -->
                                                    <a href="examinees_list.php" class="btn bg-grey waves-effect btn-sm">
                                                        <i class="material-icons">restart_alt</i>
                                                        <span class="filter-span">RESET</span>
                                                    </a>
                                                </div>
                                            </div>


                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div id="printable-area" class="table-responsive mt-3">
                                <div id="printable-area" class="table-responsive mt-3">
                                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Fullname</th>
                                                <th>Sex</th>
                                                <th>Age</th>
                                                <th>Birthday</th>
                                                <th>Strand</th>
                                                <th>Preferred Courses</th>
                                                <th>Created</th>
                                                <th>Updated</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($students as $student): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($student['default_id']) ?></td>
                                                    <td><?= htmlspecialchars($student['fullname']) ?></td>
                                                    <td><?= htmlspecialchars($student['gender']) ?></td>
                                                    <td><?= htmlspecialchars($student['age']) ?></td>
                                                    <td><?= date('m/d/Y', strtotime($student['birthday'])) ?></td>
                                                    <td><?= htmlspecialchars($student['strand']) ?></td>
                                                    <td>
                                                        1.) <?= htmlspecialchars($student['course_1_name'] ?? 'N/A') ?><br>
                                                        2.) <?= htmlspecialchars($student['course_2_name'] ?? 'N/A') ?><br>
                                                        3.) <?= htmlspecialchars($student['course_3_name'] ?? 'N/A') ?>
                                                    </td>
                                                    <td><?php echo date('F j, Y - g:i A', strtotime($student['updated_at'])); ?></td>
                                                    <td><?php echo date('F j, Y - g:i A', strtotime($student['updated_at'])); ?></td>
                                                    <td>
                                                        <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $student['id']; ?>);" class="btn btn-danger">Delete</a>

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

    <!-- EXAMINEES CONFIRMATION DELETE -->
    <script type="text/javascript">
        function confirmDelete(examineesId) {
            var confirmation = confirm("Are you sure you want to delete this ID?");
            if (confirmation) {
                window.location.href = "delete_id.php?id=" + examineesId;
            } else {
                return false;
            }
        }
    </script>

    <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <script src="js/pages/index.js"></script>

    <!-- Demo Js -->
    <script src="js/demo.js"></script>
</body>

</html>