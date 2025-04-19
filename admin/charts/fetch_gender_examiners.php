<?php
include '../../database/connection.php';

if (isset($_GET['year'])) {
    $year = $_GET['year'];
    $query = "
        SELECT 
            YEAR(created_at) AS year,
            gender, 
            COUNT(*) AS examinees_count
        FROM 
            tbl_examiners
        WHERE 
            YEAR(created_at) = :year
        GROUP BY 
            gender, YEAR(created_at)
        ORDER BY 
            gender;
    ";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':year', $year);
    $stmt->execute();
} else {
    $query = "
        SELECT 
            YEAR(created_at) AS year,
            gender, 
            COUNT(*) AS examinees_count
        FROM 
            tbl_examiners
        GROUP BY 
            gender, YEAR(created_at)
        ORDER BY 
            year DESC, gender;
    ";
    $stmt = $conn->prepare($query);
    $stmt->execute();
}

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialize male and female counts
$maleCount = 0;
$femaleCount = 0;

// Loop through results and assign the counts based on gender
foreach ($results as $row) {
    if ($row['gender'] === 'Male') {
        $maleCount = $row['examinees_count'];
    } elseif ($row['gender'] === 'Female') {
        $femaleCount = $row['examinees_count'];
    }
}

// Return the data in the format expected by JavaScript
echo json_encode([
    'male' => $maleCount,
    'female' => $femaleCount
]);
