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

        #nav-bar {
            padding: 20px;
            flex-wrap: wrap;
            background-color: #7D0A0A;
            color: #ecf0f1;
            text-align: left;
            -webkit-box-shadow: 0px 5px 5px -5px rgba(107, 102, 107, 0.67);
            -moz-box-shadow: 0px 5px 5px -5px rgba(107, 102, 107, 0.67);
            box-shadow: 0px 5px 5px -5px rgba(107, 102, 107, 0.67);
        }

        #nav-bar .ub-logo {
            width: 105px;
            margin-right: 10px;
            margin-left: 10px;
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
                    <img id="bcas-logo" style="width:45px;display:inline;margin-right:10px;" src="assets/images/kll-logo.jpg" />
                    KLL Course-Path
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
                    <li class="header" style="font-size:14px !important; color: #333 !important;">Welcome <br> <label style="font-weight:700; color: #7D0A0A;">Mark Angelo Baclayo</label></li>
                    <li class="">
                        <a href="dashboard.php">
                            <i class="material-icons">home</i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="active">
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

                            <li onclick="Logout()" style="display: flex; align-items: center;">
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

            <div class="container">
                <div id="nav-bar" class="d-flex justify-content-center align-items-center">
                    <div>
                        <img class="ub-logo" style="height: 80px; width: 80px;" src="assets/images/kll-logo.jpg" alt="KLL Logo" />
                    </div>
                </div>
                <div class="container-box">
                    <a class="btn bg-red waves-effect me-2" style="float: right; margin-top: 30px;" href="">DOWNLOAD FOR PRINT</a>
                    <h2>RESULTS</h2>

                    <ul>
                        <strong>Fullname:</strong> Mark Angelo Baclayo<br>
                        <strong>Sex:</strong> <span style="text-transform: capitalize">Male</span><br>
                        <strong>Age:</strong> 21<br>
                        <strong>Birthday:</strong> March 13, 2002<br>
                        <strong>Strand:</strong> HUMSS<br>
                        <strong>Preferred Course:</strong><br>
                        <span>→ Bachelor of Science in Criminology</span> <br>
                        <span>→ Bachelor of Science in Business Administration</span> <br>
                        <span>→ Bachelor of Science in Computer Science</span>
                    </ul>

                    <div id="division"></div>

                    <h2>ASSESSTMENT SUMMARY</h2>

                    <div class="row">
                        <div class="col-md-12">
                            <h3></h3>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Questions</th>
                                            <th>Related Course</th>
                                            <th>Points</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>I like to work on cars</td>
                                            <td>
                                                Bachelor of Science in Computer Science <br>
                                                Bachelor of Science in Business Administration <br>
                                                Bachelor of Science in Criminology <br>
                                            </td>
                                            <td>1 point</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" style="text-align: right;"><strong>Total Points</strong></td>
                                            <td><strong>1 point</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>



                    <div style="width: 50%; height: 100vh; display: flex !important; justify-content: center !important; align-items: center !important;">
                        <canvas id="myDonutChart" width="50" height="400"></canvas>
                    </div>


                    <div id="division"></div>

                    <h2>Suggested Courses <br> <span style="color: brown; font-size: 20px;"><i>(the highlighted courses are related to your preferred courses)</i></span><br><br></h2>
                    <h6 style="color: brown; font-weight: 900;">SUGGESTED COURSE</h6>
                    <ul style="margin-bottom: 50px !important;">
                        <li>
                            <span style="font-weight: 900"></span>
                            <span class="highlight">
                                Bachelor of Science in Computer Science <br>
                                Bachelor of Science in Criminology <br>
                                <span style="color: black;">Bachelor of Science in Nursing</span>
                            </span>
                        </li>
                    </ul>
                </div>
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
    <!-- ChartJs -->
    <script src="admin/plugins/chartjs/Chart.bundle.js"></script>
    <!-- Flot Charts Plugin Js -->
    <script src="admin/plugins/flot-charts/jquery.flot.js"></script>
    <script src="admin/plugins/flot-charts/jquery.flot.resize.js"></script>
    <script src="admin/plugins/flot-charts/jquery.flot.pie.js"></script>
    <script src="admin/plugins/flot-charts/jquery.flot.categories.js"></script>
    <script src="admin/plugins/flot-charts/jquery.flot.time.js"></script>
    <!-- Sparkline Chart Plugin Js -->
    <script src="admin/plugins/jquery-sparkline/jquery.sparkline.js"></script>
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
                pageLength: 10,
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

    <script>
        // Donut chart data
        var ctx = document.getElementById('myDonutChart').getContext('2d');
        var myDonutChart = new Chart(ctx, {
            type: 'doughnut', // Type of chart: Doughnut chart
            data: {
                labels: ['Bachelor of Science in Computer Science', 'Bachelor of Science in Criminology', 'Bachelor of Science in Nursing'], // Labels for each section
                datasets: [{
                    label: 'Course Preferences',
                    data: [50, 30, 20], // Data values corresponding to the labels above (example percentages)
                    backgroundColor: ['#ff6384', '#36a2eb', '#cc65fe'], // Colors for each section
                    hoverBackgroundColor: ['#ff2b3d', '#2188d6', '#9a47d9'] // Colors on hover
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        enabled: true
                    }
                }
            }
        });
    </script>
    <!-- Custom Js -->
    <script src="admin/js/admin.js"></script>
    <script src="admin/js/pages/index.js"></script>

    <!-- Demo Js -->
    <script src="admin/js/demo.js"></script>
</body>

</html>