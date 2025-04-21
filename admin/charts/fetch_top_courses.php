<?php
header('Content-Type: application/json');
require_once '../../database/connection.php';

$year = isset($_GET['year']) ? $_GET['year'] : date('Y');

$sql = "
        SELECT c.course_name, COUNT(*) AS total
        FROM (
            SELECT course_1 AS course_id FROM tbl_preferred_courses WHERE YEAR(created_at) = :year
            UNION ALL
            SELECT course_2 FROM tbl_preferred_courses WHERE YEAR(created_at) = :year
            UNION ALL
            SELECT course_3 FROM tbl_preferred_courses WHERE YEAR(created_at) = :year
        ) AS preferred
        INNER JOIN tbl_courses c ON preferred.course_id = c.id
        GROUP BY c.course_name
        ORDER BY total DESC
        LIMIT 3
    ";

$stmt = $conn->prepare($sql);
$stmt->execute(['year' => $year]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$labels = [];
$data = [];

foreach ($results as $row) {
    $labels[] = $row['course_name'];
    $data[] = (int)$row['total'];
}

echo json_encode([
    "labels" => $labels,
    "data" => $data
]);
