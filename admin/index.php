<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Dashboard</title>
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
                    KLL-Assistments
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
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <!-- <div class="user-info">
                <div class="image">
                    <img src="images/user.png" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">John Doe</div>
                    <div class="email">john.doe@example.com</div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>
                            <li role="seperator" class="divider"></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">group</i>Followers</a></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Sales</a></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Likes</a></li>
                            <li role="seperator" class="divider"></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </div> -->
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header" style="font-size:14px !important; color: #333 !important;">Welcome <br> <label style="font-weight:700; color: #7D0A0A;">Russel Vincent Cardi&#241;o Cuevas</label></li>
                    <li class="active">
                        <a href="index.php">
                            <i class="material-icons">home</i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="pages/typography.html">
                            <i class="material-icons">admin_panel_settings</i>
                            <span>Admin</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">groups</i>
                            <span>Examinees</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="pages/ui/alerts.html">Add Examiners</a>
                            </li>
                            <li>
                                <a href="pages/ui/animations.html">Examinees List</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">description</i>
                            <span>Assesstment</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="pages/ui/alerts.html">Course</a>
                            </li>
                            <li>
                                <a href="pages/ui/animations.html">Questionnaire</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="pages/typography.html">
                            <i class="material-icons">done_all</i>
                            <span>Exam Results</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <!-- <div class="copyright">
                    &copy; 2016 - 2017 <a href="javascript:void(0);">AdminBSB - Material Design</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.5
                </div> -->
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
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
        <!-- #END# Right Sidebar -->

        <div class="modal fade" id="changePassModal" tabindex="-1" role="dialog" style="display: none;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">Change Password</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form_advanced_validation" style="margin-top:10px;" method="POST">
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
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="font-size: 25px; font-weight: 900; color: #7D0A0A !important;">DATA ANALYTICS</h2>
            </div>

            <!-- Widgets -->
            <div class="row clearfix">
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box bg-red hover-expand-effect" style="background-color: #7D0A0A !important;">
                        <div class="icon">
                            <i class="material-icons">admin_panel_settings</i>
                        </div>
                        <div class="content">
                            <div class="text" style="color: white !important;">TOTAL ADMIN</div>
                            <div class="" style="font-size: 20px; color: white !important">10</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box bg-red hover-expand-effect" style="background-color: #7D0A0A !important;">
                        <div class="icon">
                            <i class="material-icons">groups</i>
                        </div>
                        <div class="content">
                            <div class="text" style="color: white !important;">TOTAL EXAMINEES</div>
                            <div class="" style="font-size: 20px; color: white !important">10</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box bg-red hover-expand-effect" style="background-color: #7D0A0A !important;">
                        <div class="icon">
                            <i class="material-icons">done_all</i>
                        </div>
                        <div class="content">
                            <div class="text" style="color: white !important;">TOTAL COURSE</div>
                            <div class="" style="font-size: 20px; color: white !important">10</div>
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
                                    <label for="year-select-gender"
                                        style="font-weight: 600; margin-right: 10px;">Year:</label>
                                    <div class="form-line" style="width: 100px">
                                        <select class="form-control show-tick" id="year-select-gender"
                                            style="border: none; box-shadow: none;">
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
                                                <tr>
                                                    <td>1</td>
                                                    <td>Bachelor of Science in Computer Science</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Bachelor of Science in Nursing</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Bachelor of Science in Education</td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>Bachelor of Science in Basic Education</td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>Bachelor of Science in Business Administration</td>
                                                </tr>

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
                            <canvas id="preferred-course-chart" height="193"></canvas>
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
                                        <table
                                            class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Fullname</th>
                                                    <th>Scores</th>
                                                    <th>Suggested Courses</th>
                                                    <th>Preferred Courses</th>
                                                    <th>Date Result</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Mark Angelo Baclayo</td>
                                                    <td>20</td>
                                                    <td>Bachelor of Science in Computer Science</td>
                                                    <td>Bachelor of Science in Criminology</td>
                                                    <td>March 12, 2025</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Hannah</td>
                                                    <td>20</td>
                                                    <td>Bachelor of Science in Nursing</td>
                                                    <td>Bachelor of Science in Computer Science</td>
                                                    <td>March 12, 2025</td>
                                                </tr>
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

    <!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Jquery Validation Plugin Css -->
    <script src="plugins/jquery-validation/jquery.validate.js"></script>

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
        var ctx = document.getElementById('yearly_examinees').getContext('2d');
        var yearlyExamineesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['2025', '2026', '2027', '2028', '2029', '2030', '2031', '2032', '2033', '2034', '2035'],
                datasets: [{
                    label: 'Number of Examinees',
                    data: [2, 3, 4, 5, 3, 6, 2, 4, 7, 8, 9], // Example data for examinees
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
    </script>

    <!-- GENDER CHART -->
    <script>
        var ctx2 = document.getElementById('gender-chart').getContext('2d');
        var genderChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['Male', 'Female'], // Labels for the X axis
                datasets: [{
                    label: 'Examinees', // Label for the dataset
                    data: [2, 3], // Data for male and female
                    backgroundColor: ['#3498db', '#e74c3c'], // Colors for the bars
                    borderColor: ['#2980b9', '#c0392b'], // Border colors for the bars
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true, // Display the title
                        text: 'Examinees Based on Gender', // Title text
                        font: {
                            size: 18, // Font size for the title
                            weight: 'bold' // Font weight for the title
                        },
                        color: '#2c3e50' // Title color
                    }
                }
            }
        });
    </script>

    <!-- YEARLY COMPARISSON -->
    <script>
        // Chart.js configuration
        var ctx = document.getElementById('preferred-course-chart').getContext('2d');
        var preferredCourseChart = new Chart(ctx, {
            type: 'pie', // Pie chart type
            data: {
                labels: ['Course A', 'Course B', 'Course C'], // Names of top 3 courses
                datasets: [{
                    label: 'Top Preferred Courses',
                    data: [30, 40, 30], // Data for each course (adjust the values as necessary)
                    backgroundColor: ['#FF5733', '#33FF57', '#3357FF'], // Different colors for each course
                    borderColor: ['#fff', '#fff', '#fff'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true, // Make chart responsive
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + '%'; // Display percentage
                            }
                        }
                    }
                }
            }
        });
    </script>

    <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <script src="js/pages/index.js"></script>
    <script src="js/pages/forms/form-validation.js"></script>

    <!-- Demo Js -->
    <script src="js/demo.js"></script>
</body>

</html>