<?php
include '../../database/connection.php'; // Make sure the connection is correct

// Get the year parameter from GET request, default to null (all years)
$year = isset($_GET['year']) ? $_GET['year'] : null;

// Query to get the number of examinees per year
$query = "
    SELECT YEAR(created_at) AS year, COUNT(*) AS examinees_count
    FROM tbl_examiners
";

// If a year is selected, add it as a filter
if ($year) {
    $query .= " WHERE YEAR(created_at) = :year";
}

// Group by year to get the count per year
$query .= " GROUP BY YEAR(created_at) ORDER BY YEAR(created_at)";

$stmt = $conn->prepare($query);

// Bind the year parameter if it's set
if ($year) {
    $stmt->bindParam(':year', $year, PDO::PARAM_INT);
}

$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare the response in a format that the frontend can use (JSON)
$response = [];
foreach ($data as $row) {
    $response[] = [
        'year' => $row['year'],
        'examinees_count' => $row['examinees_count']
    ];
}

// Return the data as JSON
echo json_encode($response);
