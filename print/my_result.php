<?php
include '../database/connection.php';
include '../session_not_login.php';

// Validate user ID from query string
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];  // Retrieve user ID from session
} else {
    echo "You are not logged in.";
    exit;
}

// Fetch student info
$query_student = "SELECT default_id, fullname, gender, age, birthday, strand FROM tbl_examiners WHERE id = :user_id";
$stmt_student = $conn->prepare($query_student);
$stmt_student->bindParam(':user_id', $user_id);
$stmt_student->execute();
$student = $stmt_student->fetch(PDO::FETCH_ASSOC);

// Fetch preferred courses
$query_courses = "
SELECT 
    c1.course_name AS course_1_name,
    c2.course_name AS course_2_name,
    c3.course_name AS course_3_name
FROM 
    tbl_preferred_courses pc
LEFT JOIN tbl_courses c1 ON pc.course_1 = c1.id
LEFT JOIN tbl_courses c2 ON pc.course_2 = c2.id
LEFT JOIN tbl_courses c3 ON pc.course_3 = c3.id
WHERE pc.user_id = :user_id
";
$stmt_courses = $conn->prepare($query_courses);
$stmt_courses->bindParam(':user_id', $user_id);
$stmt_courses->execute();
$preferred_courses = $stmt_courses->fetch(PDO::FETCH_ASSOC);

// Fetch analytics data
$query = "
SELECT 
    q.id AS question_id,
    q.question_text,
    GROUP_CONCAT(DISTINCT c.course_name SEPARATOR '<br>') AS related_courses,
    COUNT(DISTINCT CASE WHEN r.selected_option_id = 1 THEN r.id ELSE NULL END) AS total_points
FROM 
    tbl_questions q
LEFT JOIN 
    tbl_responses r ON q.id = r.question_id AND r.user_id = :user_id
LEFT JOIN 
    tbl_question_courses qc ON q.id = qc.question_id
LEFT JOIN 
    tbl_courses c ON qc.course_id = c.id
GROUP BY 
    q.id
ORDER BY 
    q.id;
";
$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$analytics_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate total points
$total_points = 0;
foreach ($analytics_data as $data) {
    $total_points += $data['total_points'];
}

// Get course points
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
";
$stmt_courses_points = $conn->prepare($query_courses_points);
$stmt_courses_points->bindParam(':user_id', $user_id);
$stmt_courses_points->execute();
$courses_points = $stmt_courses_points->fetchAll(PDO::FETCH_ASSOC);

// Suggested courses based on points > 0
$suggested_courses = [];
foreach ($courses_points as $course_data) {
    if ($course_data['total_points'] > 0) {
        $suggested_courses[] = $course_data['course_name'];
    }
}

$query_date = "
    SELECT MIN(created_at) AS exam_date
    FROM tbl_responses
    WHERE user_id = :user_id
";
$stmt_date = $conn->prepare($query_date);
$stmt_date->bindParam(':user_id', $user_id);
$stmt_date->execute();
$date_result = $stmt_date->fetch(PDO::FETCH_ASSOC);
$exam_date = $date_result['exam_date'] ? date('F d, Y h:i A', strtotime($date_result['exam_date'])) : 'N/A';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Results - Print</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <style>
        /* Print Styles */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 20px;
        }

        .highlight {
            color: red;
            font-weight: bold;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #f4f4f4;
        }

        @media print {
            body {
                font-size: 12px;
            }

            .no-print {
                display: none;
            }

            .container {
                padding: 20px;
                max-width: 800px;
                margin: auto;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="no-print">
            <button onclick="window.print()" style="float: right; padding: 20px; background-color: red; color: white; border: none;">PRINT THE RESULT</button>
        </div>
        <div>
            <h2>Exam Results for <?php echo $student['fullname']; ?></h2>
            <p><strong>Exam Date:</strong> <?php echo $exam_date; ?></p>
            <strong>Student ID:</strong> <?php echo $student['default_id']; ?><br>
            <strong>Gender:</strong> <?php echo $student['gender']; ?><br>
            <strong>Age:</strong> <?php echo $student['age']; ?><br>
            <strong>Birthday:</strong> <?php echo $student['birthday']; ?><br>
            <strong>Strand:</strong> <?php echo $student['strand']; ?><br>
            <br>
            <h3>Preferred Courses</h3>
            <ul>
                <?php
                $courses = [
                    $preferred_courses['course_1_name'],
                    $preferred_courses['course_2_name'],
                    $preferred_courses['course_3_name']
                ];
                foreach ($courses as $course) {
                    if ($course) {
                        echo "<li>{$course}</li>";
                    }
                }
                ?>
            </ul>

            <h3>Assessment Summary</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Question</th>
                        <th>Related Course</th>
                        <th>Points</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($analytics_data as $index => $data): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo $data['question_text']; ?></td>
                            <td><?php echo $data['related_courses']; ?></td>
                            <td><?php echo isset($data['total_points']) ? $data['total_points'] . ' points' : '0 points'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h3>Total Points: <?php echo $total_points; ?> points</h3>

            <?php
            // Check if $preferred_courses is not empty before initializing the array
            if (!empty($preferred_courses)) {
                $preferred_courses_array = [
                    $preferred_courses['course_1_name'],
                    $preferred_courses['course_2_name'],
                    $preferred_courses['course_3_name']
                ];
            } else {
                $preferred_courses_array = []; // Initialize as empty array if no preferred courses
            }

            ?>
            <h2>Suggested Courses <br> <span style="color: brown; font-size: 20px;"><i>(the red highlighted courses are related to your preferred courses)</i></span><br><br></h2>
            <h6 style="color: brown; font-weight: 900;">SUGGESTED COURSE</h6>
            <div class="row">
                <!-- Top 5 Courses -->
                <div class="col-md-4">
                    <h6 style="color: brown; font-weight: 900;">Top 5 Courses</h6>
                    <ul style="margin-bottom: 50px !important;">
                        <?php
                        $top_5_courses = array_slice($courses_points, 0, 5);  // Get the top 5 courses
                        foreach ($top_5_courses as $course_data):
                            $course = $course_data['course_name'];
                            $course_points = $course_data['total_points'];
                            // Check if it's a preferred course
                            if (in_array($course, $preferred_courses_array)) {
                                echo "<li><span class='highlight'>{$course} - {$course_points} point" . ($course_points > 1 ? 's' : '') . "</span></li>";
                            } else {
                                echo "<li><span>{$course} - {$course_points} point" . ($course_points > 1 ? 's' : '') . "</span></li>";
                            }
                        endforeach;
                        ?>
                    </ul>
                </div>

                <!-- Top 3 Courses -->
                <div class="col-md-4">
                    <h6 style="color: brown; font-weight: 900;">Top 3 Courses</h6>
                    <ul style="margin-bottom: 50px !important;">
                        <?php
                        $top_3_courses = array_slice($courses_points, 0, 3);  // Get the top 3 courses
                        foreach ($top_3_courses as $course_data):
                            $course = $course_data['course_name'];
                            $course_points = $course_data['total_points'];
                            // Check if it's a preferred course
                            if (in_array($course, $preferred_courses_array)) {
                                echo "<li><span class='highlight'>{$course} - {$course_points} point" . ($course_points > 1 ? 's' : '') . "</span></li>";
                            } else {
                                echo "<li><span>{$course} - {$course_points} point" . ($course_points > 1 ? 's' : '') . "</span></li>";
                            }
                        endforeach;
                        ?>
                    </ul>
                </div>

                <!-- Top 1 Course -->
                <div class="col-md-4">
                    <h6 style="color: brown; font-weight: 900;">Top 1 Course</h6>
                    <ul style="margin-bottom: 50px !important;">
                        <?php
                        $top_1_course = $courses_points[0];  // Get the top 1 course (first one after sorting)
                        $course = $top_1_course['course_name'];
                        $course_points = $top_1_course['total_points'];
                        // Check if it's a preferred course
                        if (in_array($course, $preferred_courses_array)) {
                            echo "<li><span class='highlight'>{$course} - {$course_points} point" . ($course_points > 1 ? 's' : '') . "</span></li>";
                        } else {
                            echo "<li><span>{$course} - {$course_points} point" . ($course_points > 1 ? 's' : '') . "</span></li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>



        </div>
    </div>
</body>

</html>