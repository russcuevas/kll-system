<?php
include 'database/connection.php';
include 'session_not_login.php';

$user_id = $_SESSION['user_id'];

$check_query = "SELECT COUNT(*) FROM tbl_responses WHERE user_id = :user_id";
$check_stmt = $conn->prepare($check_query);
$check_stmt->bindParam(':user_id', $user_id);
$check_stmt->execute();
$existing_responses = $check_stmt->fetchColumn();

if ($existing_responses > 0) {
    header('Location: dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $all_success = true;

    foreach ($_POST['answer'] as $question_id => $selected_option) {
        $user_id = $_SESSION['user_id'];

        $insert_query = "INSERT INTO tbl_responses (user_id, question_id, selected_option_id, points) 
                         VALUES (:user_id, :question_id, :selected_option, :points)";
        $insert_stmt = $conn->prepare($insert_query);

        // Points logic
        $points = ($selected_option == 1) ? 1 : 0;

        $insert_stmt->bindParam(':user_id', $user_id);
        $insert_stmt->bindParam(':question_id', $question_id);
        $insert_stmt->bindParam(':selected_option', $selected_option);
        $insert_stmt->bindParam(':points', $points);

        if (!$insert_stmt->execute()) {
            $all_success = false;
            break;
        }
    }

    if ($all_success) {
        header('Location: response.php?submitted=success');
        exit();
    } else {
        echo "<script>alert('Something went wrong while submitting. Please try again.');</script>";
    }
}

// FETCH QUESTION
$question_query = "SELECT * FROM tbl_questions";
$question_stmt = $conn->prepare($question_query);
$question_stmt->execute();
$question = $question_stmt->fetchAll(PDO::FETCH_OBJ);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token( ">
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
                    Marawoy, Lipa City, Batangas
                </div>
                <div class="sub-details">
                    kll_lipa@yahoo.com
                </div>
                <div class="sub-details">
                    (043) 774 2420
                </div>
            </div>
        </div>
    </div>

    <div id="nav-body" class="d-flex justify-content-center" style="margin-bottom:50px;">
        <div id="form-container" class="row">
            <div class="info-container" style="margin-top: 50px">
                <div class="info-item">Default ID: <span style="color: brown"><?php echo $_SESSION['default_id']; ?></span></div>
                <div class="info-item">Age: <?php echo $_SESSION['age']; ?></div>
            </div>
            <div class="info-container">
                <div class="info-item">Name: <?php echo $_SESSION['fullname']; ?></div>
                <div class="info-item">Strand: <?php echo $_SESSION['strand']; ?></div>
            </div>

            <h2 style="text-align: center" class="mt-5"></h2>
            <div class="instructions">Direction: This is a course path examination please select "True" or "False" for each statement.</div>
            <form id="submit-response" method="POST">
    <table class="table table-bordered" style="border: 2px solid black;">
        <thead class="table-light">
            <tr>
                <th style="border: 2px solid black;">Question</th>
                <th style="border: 2px solid black;">True</th>
                <th style="border: 2px solid black;">False</th>
            </tr>
        </thead>
        <tbody>
        <?php $counter = 1; ?> <!-- Initialize a counter variable before the loop -->
        <?php foreach ($question as $questions): ?>
        <tr style="border: 2px solid black;">
            <td style="border: 2px solid black;">
                <?php echo $counter; ?>.) <?php echo $questions->question_text; ?> <!-- Add the counter before the question text -->
            </td>
            <td style="border: 2px solid black;">
                <div>
                    <label class="radio-label">
                        <input type="radio" name="answer[<?php echo $questions->id; ?>]" value="1" required> True
                    </label>
                </div>
            </td>
            <td style="border: 2px solid black;">
                <div>
                    <label class="radio-label">
                        <input type="radio" name="answer[<?php echo $questions->id; ?>]" value="0" required> False
                    </label>
                </div>
            </td>
        </tr>
        <?php $counter++; ?> <!-- Increment the counter after each iteration -->
        <?php endforeach; ?>
        </tbody>
    </table>
    <button style="float: right" type="submit" class="btn btn-primary waves-effect mb-5">
        SUBMIT
    </button>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/HoldOn.js"></script>
    <!-- WAVES EFFECTS JS -->
    <script src="assets/plugins/node-waves/waves.js"></script>
    <script>
        document.getElementById('submit-response').addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent default form submit

            Swal.fire({
                title: 'Are you sure?',
                text: "Are you sure you want to submit your answers?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, submit it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Generating results...',
                        html: 'Please wait while we process your answers.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Submit the form using JS after delay or processing
                    setTimeout(() => {
                        e.target.submit(); // Actually submit the form
                    }, 1000); // Simulate loading (optional)
                }
                // If canceled, do nothing
            });
        });
    </script>

</body>

</html>