<?php
include 'database/connection.php';
include 'session_not_login.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Student Dashboard</title>
    <!-- Favicon-->
    <!-- <link rel="icon" href="favicon.ico" type="image/x-icon"> -->
    <!-- Google Fonts -->
    <!-- <link rel="stylesheet" href="css/fonts/Roboto.css"> -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <!-- Bootstrap Core Css -->
    <link href="admin/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Bootstrap Select Css -->
    <link href="admin/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet">
    <!-- Waves Effect Css -->
    <link href="admin/plugins/node-waves/waves.css" rel="stylesheet" />
    <!-- Animation Css -->
    <link href="admin/plugins/animate-css/animate.css" rel="stylesheet" />
    <!-- JQuery DataTable Css -->
    <link href="admin/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    <!-- Custom Css -->
    <link href="admin/css/style.css" rel="stylesheet">
    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="admin/css/themes/all-themes.css" rel="stylesheet" />
    <link rel="stylesheet" href="admin/css/custom.css">
    <!-- FAVICON -->
    <link rel="shortcut icon" href="assets/images/kll-logo.jpg" type="image/x-icon">

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
                    <img id="bcas-logo" style="width:45px;display:inline;margin-right:10px;" src="assets/images/kll-logo.jpg" />
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
        <aside id="leftsidebar" class="sidebar">

            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header" style="font-size:14px !important; color: #333 !important;">Welcome <br> <label style="font-weight:700; color: #7D0A0A;"><?php echo $_SESSION['default_id']; ?> <br>
                            <?php echo $_SESSION['fullname']; ?></label></li>
                    <li class="active">
                        <a href="dashboard.php">
                            <i class="material-icons">home</i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="my_results.php">
                            <i class="material-icons">done_all</i>
                            <span>My Results</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">

            </div>
            <!-- #Footer -->
        </aside> <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active"><a href="#account" data-toggle="tab">ACCOUNT</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active in active" id="account">
                    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 548px;">
                        <ul class="account-settings" style="overflow: hidden; width: auto; height: 548px;">
                            <li style="display: flex; align-items: center;" data-toggle="modal" data-target="#changePassModal">
                                <div>
                                    <label class="mb-0 hov-pointer">
                                        <i class="material-icons mr-2" style="font-size: 18px; vertical-align: middle;">lock</i> Change Password
                                    </label>
                                </div>
                            </li>

                            <li onclick="window.location.href=('logout.php');" style="display: flex; align-items: center;">
                                <div>
                                    <label class=" mb-0 hov-pointer">
                                        <i class="material-icons mr-2" style="font-size:18px; vertical-align: middle;">exit_to_app</i>
                                        Log Out
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </aside>

        <div class="modal fade" id="changePassModal" tabindex="-1" role="dialog" style="display: none;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">Change Password</h4>
                    </div>
                    <div class="modal-body">
                        <form action="" id="form_advanced_validation" style="margin-top:10px;" method="POST">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="new_password" maxlength="10" minlength="3" required>
                                    <label class="form-label">New Password</label>
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="confirm_password" maxlength="10" minlength="3" required>
                                    <label class="form-label">Confirm Password</label>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn bg-teal waves-effect" type="submit">SAVE</button>
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                    </form>
                </div>
            </div>
        </div> <!-- #END# Right Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="font-size: 25px; font-weight: 900; color: #7D0A0A !important;">STUDENT DASHBOARD</h2>
            </div>

    </section>

    <!-- Jquery Core Js -->
    <script src="admin/plugins/jquery/jquery.min.js"></script>
    <!-- Jquery Validation Plugin Css -->
    <script src="admin/plugins/jquery-validation/jquery.validate.js"></script>
    <script src="admin/js/pages/forms/form-validation.js"></script>
    <!-- Bootstrap Core Js -->
    <script src="admin/plugins/bootstrap/js/bootstrap.js"></script>
    <!-- Select Plugin Js -->
    <script src="admin/plugins/bootstrap-select/js/bootstrap-select.js"></script>
    <!-- Slimscroll Plugin Js -->
    <script src="admin/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
    <!-- Waves Effect Plugin Js -->
    <script src="admin/plugins/node-waves/waves.js"></script>
    <!-- Jquery CountTo Plugin Js -->
    <script src="admin/plugins/jquery-countto/jquery.countTo.js"></script>
    <!-- Morris Plugin Js -->
    <script src="admin/plugins/raphael/raphael.min.js"></script>
    <script src="admin/plugins/morrisjs/morris.js"></script>
    <!-- Jquery DataTable Plugin Js -->
    <script src="admin/plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="admin/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
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
    <script src="admin/js/admin.js"></script>
    <script src="admin/js/pages/index.js"></script>

    <!-- Demo Js -->
    <script src="admin/js/demo.js"></script>
</body>

</html>