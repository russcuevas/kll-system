<?php
include '../database/connection.php';
session_start();


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

header('Content-Type: application/json');

$current_date = date('Ymd');
$search_pattern = $current_date . '%';

$query = "SELECT default_id FROM tbl_examiners WHERE default_id LIKE :current_date ORDER BY default_id DESC LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bindParam(':current_date', $search_pattern);
$stmt->execute();
$existing_id = $stmt->fetch(PDO::FETCH_ASSOC);

$sequence_number = $existing_id ? substr($existing_id['default_id'], -2) : '00';
$next_sequence = str_pad($sequence_number + 1, 2, '0', STR_PAD_LEFT);
$default_id = $current_date . '-' . $next_sequence;

$fullname = $_POST['fullname'];
$email = $_POST['email'];
$gender = $_POST['gender'];
$age = $_POST['age'];
$birthday = $_POST['birthday'];
$strand = $_POST['strand'];

$email_check_query = "SELECT COUNT(*) FROM tbl_examiners WHERE email = :email";
$stmt = $conn->prepare($email_check_query);
$stmt->bindParam(':email', $email);
$stmt->execute();
$email_exists = $stmt->fetchColumn();

if ($email_exists > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Email already exists']);
    exit;
}

$default_password = "kll1234";
$hashed_password = sha1($default_password);
$created_at = $updated_at = date("Y-m-d H:i:s");

$query = "INSERT INTO tbl_examiners (default_id, fullname, gender, age, birthday, strand, email, password, created_at, updated_at)
          VALUES (:default_id, :fullname, :gender, :age, :birthday, :strand, :email, :password, :created_at, :updated_at)";
$stmt = $conn->prepare($query);
$stmt->bindParam(':default_id', $default_id);
$stmt->bindParam(':fullname', $fullname);
$stmt->bindParam(':gender', $gender);
$stmt->bindParam(':age', $age);
$stmt->bindParam(':birthday', $birthday);
$stmt->bindParam(':strand', $strand);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password', $hashed_password);
$stmt->bindParam(':created_at', $created_at);
$stmt->bindParam(':updated_at', $updated_at);

if ($stmt->execute()) {
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'assistmentskll@gmail.com';
        $mail->Password   = 'geazxbnxsqmkqkrk';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('assistmentskll@gmail.com', 'KLL Examiners');
        $mail->addAddress($email, $fullname);
        $mail->isHTML(true);
        $mail->Subject = 'Welcome to KLL Examiners Portal';
        $mail->Body = "
                    <h3>Welcome, $fullname!</h3>
                    <p>You have been successfully registered as an examiner.</p>
                    <p><strong>Default ID:</strong> $default_id</p>
                    <p><strong>Email:</strong> $email</p>
                    <p><strong>Temporary Password:</strong> $default_password</p>
                    <p>Please change your password after logging in.</p>
                    <br>
                    <p>Regards,<br>KLL Admin</p>
                ";
        $mail->send();
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Email failed to send: ' . $mail->ErrorInfo]);
        exit;
    }

    $_SESSION['success'] = 'Examiner added successfully!';
    echo json_encode(['status' => 'success', 'message' => 'Examiner added successfully.']);
} else {
    $_SESSION['errors'] = 'Unable to add examiner.';
    echo json_encode(['status' => 'error', 'message' => 'Unable to add examiner.']);
}
