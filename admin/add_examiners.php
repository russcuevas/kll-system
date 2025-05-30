<?php
include '../database/connection.php';
include 'session_not_login.php';

// FETCH COURSE
$get_examiners = "SELECT * FROM `tbl_examiners`";
$stmt_get_examiners = $conn->query($get_examiners);
$examiners = $stmt_get_examiners->fetchAll(PDO::FETCH_ASSOC);
// END FETCH COURSE
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
    <!-- Bootstrap Select Css -->
    <link href="plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet">
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
                        Add Examiners
                    </li>
                </ol>
            </div>

            <!-- Widgets -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 style="font-size: 25px; font-weight: 900; color: #7D0A0A;">
                                Add Examiners
                            </h2>
                        </div>
                        <div class="body">
                            <!-- ALERTS -->
                            <?php if (isset($_SESSION['success'])) : ?>
                                <div class="alert alert-success" role="alert">
                                    <?= $_SESSION['success']; ?>
                                </div>
                                <?php unset($_SESSION['success']); ?>
                            <?php elseif (isset($_SESSION['errors'])) : ?>
                                <div class="alert alert-danger" role="alert">
                                    <?= $_SESSION['errors']; ?>
                                </div>
                                <?php unset($_SESSION['errors']); ?>
                            <?php endif; ?>
                            <!-- END ALERTS -->
                            <div>
                                <a href="add_default_id.php" class="btn bg-red waves-effect" style="margin-bottom: 15px;">+ ADD EXAMINERS</a>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Examiner ID</th>
                                            <th>Fullname</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($examiners as $examinee): ?>
                                            <tr>
                                                <td><?php echo $examinee['default_id'] ?></td>
                                                <td><?php echo $examinee['fullname'] ?></td>
                                                <td><?php echo date('F j, Y - g:i A', strtotime($examinee['created_at'])); ?></td>
                                                <td><?php echo date('F j, Y - g:i A', strtotime($examinee['updated_at'])); ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#viewExamineeModal"
                                                        data-default_id="<?php echo $examinee['default_id']; ?>"
                                                        data-fullname="<?php echo $examinee['fullname']; ?>"
                                                        data-gender="<?php echo $examinee['gender'] ?>"
                                                        data-age="<?php echo $examinee['age'] ?>"
                                                        data-birthday="<?php echo $examinee['birthday'] ?>"
                                                        data-strand="<?php echo $examinee['strand'] ?>"
                                                        data-email="<?php echo $examinee['email'] ?>"
                                                        data-created_at="<?php echo date('F j, Y - g:i A', strtotime($examinee['created_at'])); ?>"
                                                        data-updated_at="<?php echo date('F j, Y - g:i A', strtotime($examinee['updated_at'])); ?>">
                                                        View Information
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="viewExamineeModal" tabindex="-1" role="dialog" style="display: none;">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewExamineeModalLabel">Examinee Information</h5>
                        </div>
                        <div class="modal-body">
                            <p><strong>Examiner ID:</strong> <span id="examiner_id"></span></p>
                            <p><strong>Email:</strong> <span id="email"></span></p>

                            <p><strong>Full Name:</strong> <span id="full_name"></span></p>
                            <p><strong>Gender:</strong> <span id="gender"></span></p>
                            <p><strong>Age:</strong> <span id="age"></span></p>
                            <p><strong>Birthday:</strong> <span id="birthday"></span></p>
                            <p><strong>Strand:</strong> <span id="strand"></span></p>

                            <p><strong>Created At:</strong> <span id="created_at"></span></p>
                            <p><strong>Updated At:</strong> <span id="updated_at"></span></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" id="deleteExaminerBtn">DELETE</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">CLOSE</button>
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
    <!-- Select Plugin Js -->
    <script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>
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

    <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <script src="js/pages/index.js"></script>

    <!-- Demo Js -->
    <script src="js/demo.js"></script>

    <!-- VIEW EXAMINEE SCRIPT -->
    <script>
        $('#viewExamineeModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var default_id = button.data('default_id');
            var fullname = button.data('fullname');
            var gender = button.data('gender');
            var age = button.data('age');
            var birthday = button.data('birthday');
            var strand = button.data('strand');
            var email = button.data('email');
            var created_at = button.data('created_at');
            var updated_at = button.data('updated_at');

            var modal = $(this);
            modal.find('#examiner_id').text(default_id);
            modal.find('#full_name').text(fullname);
            modal.find('#email').text(email);
            modal.find('#gender').text(gender);
            modal.find('#age').text(age);
            modal.find('#birthday').text(birthday);
            modal.find('#strand').text(strand);
            modal.find('#created_at').text(created_at);
            modal.find('#updated_at').text(updated_at);

            // Set the delete button's data-default_id attribute to the selected default_id
            modal.find('#deleteExaminerBtn').data('default_id', default_id);
        });

        // Handle delete click
        $('#deleteExaminerBtn').on('click', function() {
            var default_id = $(this).data('default_id');
            if (confirm('Are you sure you want to delete this examiner?')) {
                window.location.href = 'delete_default_id.php?default_id=' + default_id;
            }
        });
    </script>

</body>

</html>