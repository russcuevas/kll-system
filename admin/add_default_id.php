<?php
include '../database/connection.php';  // Include the PDO connection
include 'session_not_login.php';  // Include session check (optional)

// Get today's date in YYYYMMDD format
$current_year = date('Y');
$current_month = date('m');
$current_day = date('d');
$current_date = $current_year . $current_month . $current_day;

// Create a variable for the value you want to bind to the query
$search_pattern = $current_date . '%';

// Query the database to find the highest sequence number for the current date
$query = "SELECT default_id FROM tbl_examiners WHERE default_id LIKE :current_date ORDER BY default_id DESC LIMIT 1";
$stmt = $conn->prepare($query);

// Bind the parameter using the variable
$stmt->bindParam(':current_date', $search_pattern); // Use the variable with the value
$stmt->execute();

// Check if there are existing IDs for today
$existing_id = $stmt->fetch(PDO::FETCH_ASSOC);

if ($existing_id) {
    // Extract the sequence number from the existing ID
    $existing_id_value = $existing_id['default_id'];
    $sequence_number = substr($existing_id_value, -2); // Get the last 2 digits (sequence)
    $next_sequence = str_pad($sequence_number + 1, 2, '0', STR_PAD_LEFT);
} else {
    // If no existing ID for today, start with 01
    $next_sequence = '01';
}

// Generate the new random ID
$random_id = $current_date . '-' . $next_sequence;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and retrieve form inputs
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $birthday = $_POST['birthday'];
    $strand = $_POST['strand'];
    $default_id = $_POST['default_id']; // Default ID, now included as hidden field

    // Check if email already exists
    $email_check_query = "SELECT COUNT(*) FROM tbl_examiners WHERE email = :email";
    $stmt = $conn->prepare($email_check_query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $email_exists = $stmt->fetchColumn();

    if ($email_exists > 0) {
        // Email already exists, store error message in session
        $_SESSION['errors'] = "The email address is already registered.";
    } else {
        // If email is not taken, proceed with adding the new examiner

        // Set the default password to "kll1234" and hash it using SHA-1
        $default_password = "kll1234";
        $hashed_password = sha1($default_password); // Hash the password

        // Get the current timestamp for created_at and updated_at
        $created_at = $updated_at = date("Y-m-d H:i:s");

        // Prepare the SQL query
        $query = "INSERT INTO tbl_examiners (default_id, fullname, gender, age, birthday, strand, email, password, created_at, updated_at)
        VALUES (:default_id, :fullname, :gender, :age, :birthday, :strand, :email, :password, :created_at, :updated_at)";

        // Prepare the statement
        $stmt = $conn->prepare($query);

        // Bind the parameters to the prepared statement
        $stmt->bindParam(':default_id', $default_id);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':birthday', $birthday);
        $stmt->bindParam(':strand', $strand);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password); // Insert the hashed password
        $stmt->bindParam(':created_at', $created_at);
        $stmt->bindParam(':updated_at', $updated_at);

        // Execute the prepared statement
        if ($stmt->execute()) {
            // On success, redirect and clear the error session
            $_SESSION['success'] = "Examiners added successfully";
            unset($_SESSION['error']); // Clear any previous error messages
            header("Location: " . $_SERVER['PHP_SELF']); // Refresh the page
            exit; // Always call exit after header redirection
        } else {
            // Error message
            $_SESSION['errors'] = "Unable to add examiner.";
        }
    }
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

        input::placeholder {
            color: white !important;
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
                    <li class="active"><i style="font-size: 20px;" class="material-icons">add</i> Add Examiners
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
                            <form id="add_default_id_validation" method="POST" action="">
                                <div class="form-group form-float" style="margin-top: 20px !important;">
                                    <div class="form-line">

                                        <input style="background-color: gray;" type="text" class="form-control" name="default_id" value="<?php echo $random_id; ?>" placeholder="<?php echo $random_id; ?>" readonly>
                                        <label class="form-label">Examiners ID</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="fullname" required>
                                        <label class="form-label">Fullname</label>
                                    </div>
                                </div>

                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="email" class="form-control" name="email" required>
                                        <label class="form-label">Email</label>
                                    </div>
                                </div>

                                <div class="form-group form-float">
                                    <div>
                                        <label class="form-label">Sex</label>
                                        <div style="display:flex;">
                                            <div>
                                                <input name="gender" type="radio" id="male" value="male" checked />
                                                <label class="radio" for="male">Male</label>
                                            </div>
                                            <div>
                                                <input name="gender" type="radio" id="female" value="female" />
                                                <label class="radio" for="female">Female</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="number" class="form-control" name="age" required>
                                        <label class="form-label">Age</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="date" class="form-control" name="birthday" required>
                                        <label class="form-label">Birthday</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select id="strand" name="strand" required class="form-control">
                                            <option value="HUMSS">HUMSS</option>
                                            <option value="ABM">ABM</option>
                                            <option value="STEM">STEM</option>
                                        </select>
                                        <label class="form-label">Strand</label>
                                    </div>
                                </div>
                                <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Advanced Validation -->


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

    <script>
        $(function() {
            $('#form_validation').validate({
                rules: {
                    'checkbox': {
                        required: true
                    },
                    'gender': {
                        required: true
                    }
                },
                highlight: function(input) {
                    $(input).parents('.form-line').addClass('error');
                },
                unhighlight: function(input) {
                    $(input).parents('.form-line').removeClass('error');
                },
                errorPlacement: function(error, element) {
                    $(element).parents('.form-group').append(error);
                }
            });

            //Advanced Form Validation
            $('#add_default_id_validation').validate({
                rules: {
                    'date': {
                        customdate: true
                    },
                    'creditcard': {
                        creditcard: true
                    }
                },
                highlight: function(input) {
                    $(input).parents('.form-line').addClass('error');
                },
                unhighlight: function(input) {
                    $(input).parents('.form-line').removeClass('error');
                },
                errorPlacement: function(error, element) {
                    $(element).parents('.form-group').append(error);
                }
            });

            //Custom Validations ===============================================================================
            //Date
            $.validator.addMethod('customdate', function(value, element) {
                    return value.match(/^\d\d\d\d?-\d\d?-\d\d$/);
                },
                'Please enter a date in the format YYYY-MM-DD.'
            );

            //Credit card
            $.validator.addMethod('creditcard', function(value, element) {
                    return value.match(/^\d\d\d\d?-\d\d\d\d?-\d\d\d\d?-\d\d\d\d$/);
                },
                'Please enter a credit card in the format XXXX-XXXX-XXXX-XXXX.'
            );
            //==================================================================================================
        });
    </script>
    <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <script src="js/pages/index.js"></script>

    <!-- Demo Js -->
    <script src="js/demo.js"></script>
</body>

</html>