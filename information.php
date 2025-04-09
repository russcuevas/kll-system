<?php
include 'database/connection.php';
include 'session_not_login.php';

// INSERT TO PREFERRED COURSE
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_1 = $_POST['course_1'];
    $course_2 = $_POST['course_2'];
    $course_3 = $_POST['course_3'];
    $user_id = $_SESSION['user_id'];

    $insert_query = "INSERT INTO tbl_preferred_courses (user_id, course_1, course_2, course_3) VALUES (:user_id, :course_1, :course_2, :course_3)";
    $insert_stmt = $conn->prepare($insert_query);

    $insert_stmt->bindParam(':user_id', $user_id);
    $insert_stmt->bindParam(':course_1', $course_1);
    $insert_stmt->bindParam(':course_2', $course_2);
    $insert_stmt->bindParam(':course_3', $course_3);

    if ($insert_stmt->execute()) {
        echo "<script>window.location.href = 'assessment.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to save preferred courses. Please try again.');</script>";
    }
}

// FETCH COURSE
$course_query = "SELECT id, course_name FROM tbl_courses";
$course_stmt = $conn->prepare($course_query);
$course_stmt->execute();
$courses = $course_stmt->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- BOOTSTRAP AND FONTS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- WAVES -->
    <link href="assets/plugins/node-waves/waves.css" rel="stylesheet" />
    <!-- ANIMATION -->
    <link href="assets/plugins/animate-css/animate.css" rel="stylesheet" />
    <!-- CUSTOM AND STYLE -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/custom.css" rel="stylesheet">
    <!-- FAVICON -->
    <link rel="shortcut icon" href="assets/images/kll-logo.jpg" type="image/x-icon">
    <title>KLL - Assesstments</title>
    <style>
        .info-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .info-item {
            font-weight: 600;
            flex: 1;
            margin-right: 10px;
        }

        .info-item:last-child {
            margin-right: 0;
        }

        .instructions {
            font-size: 15px;
            font-weight: bold;
            text-align: left;
        }
    </style>
</head>

<body>

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

    <div id="nav-bar" class="d-flex justify-content-center align-items-center">
        <div>
            <img class="ub-logo" src="assets/images/kll-logo.jpg" alt="KLL Logo" />
        </div>
        <div style="padding:10px;">
            <div>
                <div id="school-name">
                    KOLEHIYO NG LUNGSOD NG LIPA
                </div>
                <div class="sub-details">
                    Sample Location
                </div>
                <div class="sub-details">
                    Sample Email
                </div>
                <div class="sub-details">
                    Sample Contact Number
                </div>
            </div>
        </div>
    </div>

    <div id="nav-body" class="d-flex justify-content-center" style="margin-bottom:50px;">
        <div id="form-container" class="row">
            <div class="d-flex justify-content-end mt-4">
                <a class="btn btn-danger waves-effect" href="logout.php">Logout</a>
            </div>
            <h2 class="mt-2 mb-5 text-center w-100" style="color: black">
                <img style="height: 70px; border-radius: 50px;" alt=""> Welcome ID: <?php echo $_SESSION['default_id']; ?>
            </h2>

            <form method="POST" class="form-validation w-100" action="">
                <input type="hidden" value="<?php echo $_SESSION['user_id'] ?>" name="user_id">
                <div class="row" style="background-color: white; padding: 20px;">
                    <div class="col-md-6">
                        <h6>Personal Information</h6>
                        <div id="division"></div>
                        <div class="content mt-3">
                            <div class="justify-content-between row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <label style="margin-bottom: 0px !important;" class="form-label">Fullname</label>
                                        <div class="form-line">
                                            <input style="background-color: gray; color: white; padding: 10px;" type="text" class="form-control" name="fullname" value="<?php echo $_SESSION['fullname']; ?>" required readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="justify-content-between row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <label style="margin-bottom: 0px !important;" class="form-label">Email</label>
                                        <div class="form-line">
                                            <input style="background-color: gray; color: white; padding: 10px;" type="email" class="form-control" name="email" value="<?php echo $_SESSION['email']; ?>" required readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="justify-content-between row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <label style="margin-bottom: 0px !important;" class="form-label">Birthday</label>
                                        <div class="form-line">
                                            <input style="background-color: gray; color: white; padding: 10px;" type="date" class="form-control" name="birthday" value="<?php echo $_SESSION['birthday']; ?>" required readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="justify-content-between row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <label style="margin-bottom: 0px !important;" class="form-label">Sex</label>

                                        <div class="form-line">
                                            <input style="background-color: gray; color: white; padding: 10px; text-transform: capitalize;" type="text" class="form-control" name="gender" value="<?php echo $_SESSION['gender']; ?>" required readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="justify-content-between row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <label style="margin-bottom: 0px !important;" class="form-label">Age</label>

                                        <div class="form-line">
                                            <input style="background-color: gray; color: white; padding: 10px;" type="text" class="form-control" name="age" value="<?php echo $_SESSION['age']; ?>" required readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="justify-content-between row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <label style="margin-bottom: 0px !important;" class="form-label">Strand</label>
                                        <div class="form-line">
                                            <input style="background-color: gray; color: white; padding: 10px;" type="text" class="form-control" name="strand" value="<?php echo $_SESSION['strand']; ?>" required readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h6>Please select top 3 preferred course</h6>
                        <div id="division"></div>
                        <div class="content mt-3">
                            <div class="justify-content-between row clearfix">
                                <div class="col-md-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <label>Course 1</label>
                                            <select class="form-select" style="border: none !important;" name="course_1" required>
                                                <option value="">Select a course</option>
                                                <?php foreach ($courses as $course): ?>
                                                    <option value="<?php echo $course->id; ?>"><?php echo $course->course_name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="justify-content-between row clearfix">
                                <div class="col-md-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <label>Course 2</label>
                                            <select class="form-select" style="border: none !important;" name="course_2" required>
                                                <option value="">Select a course</option>
                                                <?php foreach ($courses as $course): ?>
                                                    <option value="<?php echo $course->id; ?>"><?php echo $course->course_name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="justify-content-between row clearfix">
                                <div class="col-md-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <label>Course 3</label>
                                            <select class="form-select" style="border: none !important;" name="course_3" required>
                                                <option value="">Select a course</option>
                                                <?php foreach ($courses as $course): ?>
                                                    <option value="<?php echo $course->id; ?>"><?php echo $course->course_name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary waves-effect">
                            Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- JQUERY JS -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <!-- BOOTSTRAP JS -->
    <script src="assets/plugins/bootstrap/js/bootstrap.js"></script>
    <!-- SLIMSCROLL JS -->
    <script src="assets/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
    <!-- JQUERY VALIDATION JS -->
    <script src="assets/plugins/jquery-validation/jquery.validate.js"></script>
    <!-- JQUERY STEPS JS -->
    <script src="assets/plugins/jquery-steps/jquery.steps.js"></script>
    <!-- SWEETALERT JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/js/HoldOn.js"></script>
    <!-- WAVES EFFECTS JS -->
    <script src="assets/plugins/node-waves/waves.js"></script>
    <script>
        setTimeout(function() {
            document.querySelector('.page-loader-wrapper').style.display = 'none';
        }, 700);
    </script>

    <!-- EXAM CONFIRMATION -->
    <script>
        $(document).ready(function() {
            $('form').on('submit', function(event) {
                event.preventDefault();

                const fullname = $('input[name="fullname"]').val();
                const email = $('input[name="email"]').val();
                const birthday = $('input[name="birthday"]').val();
                const gender = $('input[name="gender"]').val();
                const age = $('input[name="age"]').val();
                const strand = $('input[name="strand"]').val();
                const course_1 = $('select[name="course_1"]').find('option:selected').text();
                const course_2 = $('select[name="course_2"]').find('option:selected').text();
                const course_3 = $('select[name="course_3"]').find('option:selected').text();

                const confirmationMessage = `
                <strong>Full Name:</strong> ${fullname}<br>
                <strong>Email:</strong> ${email}<br>
                <strong>Birthday:</strong> ${birthday}<br>
                <strong>Gender:</strong> ${gender}<br>
                <strong>Age:</strong> ${age}<br>
                <strong>Strand:</strong> ${strand}<br>
                <strong>Preferred Courses:</strong><br>
                1. ${course_1}<br>
                2. ${course_2}<br>
                3. ${course_3}
            `;

                swal({
                    title: "Are you sure?",
                    text: "To proceed in examination please confirm that all information is correct.",
                    icon: "warning",
                    html: true,
                    buttons: {
                        cancel: {
                            text: "Cancel",
                            value: null,
                            visible: true,
                            className: "btn btn-danger",
                            closeModal: true
                        },
                        confirm: {
                            text: "Proceed to Exam",
                            value: true,
                            visible: true,
                            className: "btn btn-primary",
                            closeModal: true
                        }
                    }
                }).then((willSubmit) => {
                    if (willSubmit) {
                        this.submit();
                    }
                });

            });
        });
    </script>


</body>

</html>