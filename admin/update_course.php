<?php
include '../database/connection.php';
include 'session_not_login.php';

if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];

    $query = "SELECT * FROM tbl_courses WHERE id = :course_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':course_id', $course_id);
    $stmt->execute();
    $course = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$course) {
        header('Location: course.php');
        exit;
    }
} else {
    header('Location: course.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_name = $_POST['course_name'];
    $course_description = $_POST['description'];

    $check_query = "SELECT * FROM tbl_courses WHERE course_name = :course_name AND id != :course_id";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bindParam(':course_name', $course_name);
    $check_stmt->bindParam(':course_id', $course_id);
    $check_stmt->execute();
    $existing_course = $check_stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing_course) {
        $_SESSION['errors'] = "Course name already exists.";
    } else {
        $image_names = json_decode($course['course_picture'], true);
        if (!$image_names) {
            $image_names = [];
        }

        if (isset($_FILES['course_picture']) && !empty($_FILES['course_picture']['name'][0])) {
            foreach ($image_names as $image) {
                $image_path = "profile/courses/" . $image;
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }

            $new_image_names = [];
            $target_dir = "profile/courses/";
            $images = $_FILES['course_picture'];

            foreach ($images['name'] as $key => $image_name) {
                $image_extension = pathinfo($image_name, PATHINFO_EXTENSION);
                $new_image_name = uniqid() . '.' . $image_extension;

                $target_file = $target_dir . $new_image_name;
                if (move_uploaded_file($images['tmp_name'][$key], $target_file)) {
                    $new_image_names[] = $new_image_name;
                }
            }

            if (!empty($new_image_names)) {
                $image_names = $new_image_names;
            }
        }

        // If no new images were uploaded, retain the old images
        if (empty($_FILES['course_picture']['name'][0])) {
            // Keep the existing images as they are
            $image_names = json_decode($course['course_picture'], true);
        }

        // Convert the image names array to JSON
        $course_picture_json = json_encode(array_values($image_names));

        // Update the course in the database with new data
        $update_query = "UPDATE tbl_courses SET course_name = :course_name, course_description = :course_description, course_picture = :course_picture WHERE id = :course_id";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bindParam(':course_name', $course_name);
        $update_stmt->bindParam(':course_description', $course_description);
        $update_stmt->bindParam(':course_picture', $course_picture_json);
        $update_stmt->bindParam(':course_id', $course_id);

        if ($update_stmt->execute()) {
            $_SESSION['success'] = "Course updated successfully.";
            // Redirect to avoid resubmitting the form if the page is refreshed
            header("Location: update_course.php?course_id=$course_id");
            exit;
        } else {
            $_SESSION['errors'] = "Failed to update course.";
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
    <!-- Multi Select Css -->
    <link href="plugins/multi-select/css/multi-select.css" rel="stylesheet">
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
                    <li class="active"><i style="font-size: 20px;" class="material-icons">edit</i> Update Course
                    </li>
                </ol>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 style="font-size: 25px; font-weight: 900; color: #7D0A0A;">
                                Update Course
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

                            <form action="" id="update_course_validation" method="POST" enctype="multipart/form-data">
                                <div class="form-group form-float" style="margin-top: 20px !important;">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="course_name" value="<?= htmlspecialchars($course['course_name']) ?>" required>
                                        <label class="form-label">Course Name</label>
                                    </div>
                                </div>

                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <textarea name="description" cols="30" rows="3" class="form-control no-resize" required><?= htmlspecialchars($course['course_description']) ?></textarea>
                                        <label class="form-label">Course Description</label>
                                    </div>
                                </div>

                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="file" class="form-control" name="course_picture[]" onchange="previewImages(event)" multiple>
                                        <label class="form-label">Course Pictures</label>
                                    </div>
                                    <div id="image-preview-container" style="margin-top: 10px;">
                                        <?php
                                        // Display current course images if they exist
                                        $images = json_decode($course['course_picture'], true);
                                        if (is_array($images)) {
                                            foreach ($images as $image) {
                                                echo "<img src='profile/courses/$image' style='width:100px;height:100px;margin-right:10px;'>";
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>

                                <button class="btn btn-primary" type="submit">Update Course</button>
                            </form>
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
    <!-- Select Plugin Js -->
    <script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>
    <!-- Multi Select Plugin Js -->
    <script src="plugins/multi-select/js/jquery.multi-select.js"></script>
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
            $('#update_course_validation').validate({
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

    <!-- IMAGE PREVIEW -->
    <script>
        function previewImages(event) {
            var files = event.target.files;
            var container = document.getElementById('image-preview-container');
            container.innerHTML = ''; // Clear previous previews

            for (var i = 0; i < files.length; i++) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var imgElement = document.createElement('img');
                    imgElement.src = e.target.result;
                    imgElement.style.width = '100px';
                    imgElement.style.height = '100px';
                    imgElement.style.marginRight = '10px';
                    container.appendChild(imgElement);
                }
                reader.readAsDataURL(files[i]);
            }

            // Show the preview container if files are selected
            if (files.length > 0) {
                container.style.display = 'block';
            } else {
                container.style.display = 'none';
            }
        }
    </script>

    <!-- SWEETALERT -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <script src="js/pages/index.js"></script>

    <!-- Demo Js -->
    <script src="js/demo.js"></script>
</body>

</html>