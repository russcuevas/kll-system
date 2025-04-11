<?php
include 'database/connection.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$query = "
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
    total_points DESC;
";

$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$courses_points = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($courses_points);
