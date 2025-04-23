<?php
require 'vendor/autoload.php';
require 'database/connection.php';
require 'session_not_login.php';

use Dompdf\Dompdf;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Fetch user session info
$user_id = $_SESSION['user_id'];
$default_id = $_SESSION['default_id'];
$fullname = $_SESSION['fullname'];
$email = $_SESSION['email'];

// Fetch assessment responses
$query = "SELECT q.question_text, r.selected_option_id
          FROM tbl_responses r
          JOIN tbl_questions q ON r.question_id = q.id
          WHERE r.user_id = :user_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$responses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch top 5 suggested courses
$query_courses_points = "
    SELECT 
        c.course_name,
        SUM(CASE WHEN r.selected_option_id = 1 THEN 1 ELSE 0 END) AS total_points
    FROM 
        tbl_courses c
    LEFT JOIN 
        tbl_question_courses qc ON c.id = qc.course_id
    LEFT JOIN 
        tbl_questions q ON qc.question_id = q.id
    LEFT JOIN 
        tbl_responses r ON q.id = r.question_id AND r.user_id = :user_id
    GROUP BY 
        c.id
    ORDER BY 
        total_points DESC
    LIMIT 5;
";

$stmt_courses = $conn->prepare($query_courses_points);
$stmt_courses->bindParam(':user_id', $user_id);
$stmt_courses->execute();
$courses_points = $stmt_courses->fetchAll(PDO::FETCH_ASSOC);

// Split into Top 5, Top 3, Top 1
$top_5 = array_slice($courses_points, 0, 5);
$top_3 = array_slice($courses_points, 0, 3);
$top_1 = array_slice($courses_points, 0, 1);

// Generate HTML for PDF
ob_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>KLL Assessment Result</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
        }

        .info {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        .highlight {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2>FUTURE: Facilitating University Track <br> Understanding and Recommendation Engine</h2>

    <div class="info">
        <p><strong>Student ID:</strong> <?= htmlspecialchars($default_id) ?></p>
        <p><strong>Name:</strong> <?= htmlspecialchars($fullname) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
    </div>

    <h3>Assessment Responses</h3>
    <table>
        <thead>
            <tr>
                <th>Question</th>
                <th>Your Answer</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($responses as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['question_text']) ?></td>
                    <td><?= $row['selected_option_id'] == 1 ? 'True' : 'False' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Suggested Courses</h3>

    <p><strong>Top 5 Courses</strong></p>
    <ul>
        <?php foreach ($top_5 as $course): ?>
            <li><?= htmlspecialchars($course['course_name']) ?> - <?= $course['total_points'] ?> point<?= $course['total_points'] > 1 ? 's' : '' ?></li>
        <?php endforeach; ?>
    </ul>

    <p><strong>Top 3 Courses</strong></p>
    <ul>
        <?php foreach ($top_3 as $course): ?>
            <li><?= htmlspecialchars($course['course_name']) ?> - <?= $course['total_points'] ?> point<?= $course['total_points'] > 1 ? 's' : '' ?></li>
        <?php endforeach; ?>
    </ul>

    <p><strong>Top 1 Course</strong></p>
    <ul>
        <?php foreach ($top_1 as $course): ?>
            <li><?= htmlspecialchars($course['course_name']) ?> - <?= $course['total_points'] ?> point<?= $course['total_points'] > 1 ? 's' : '' ?></li>
        <?php endforeach; ?>
    </ul>
</body>

</html>

<?php
$html = ob_get_clean();

// Generate PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$pdfOutput = $dompdf->output();

// Send Email
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'assistmentskll@gmail.com';
    $mail->Password   = 'geazxbnxsqmkqkrk';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('assistmentskll@gmail.com', 'KLL Assistments');
    $mail->addAddress($email, $fullname);
    $mail->Subject = 'Your Assessment Result';
    $mail->Body    = 'Dear ' . $fullname . ",\n\nAttached is your assessment result in PDF format including your top suggested courses.\n\nBest regards,\nKLL";

    $mail->addStringAttachment($pdfOutput, 'KLL_Assessment_Result.pdf');
    // $mail->addAttachment('mail/RIASEC.pdf', 'RIASEC_Guide.pdf');
    $mail->send();

    echo "<script>
        alert('Submitted successfully!');
        window.location.href='generate_result.php';
    </script>";
} catch (Exception $e) {
    echo "Error sending email: {$mail->ErrorInfo}";
}
?>