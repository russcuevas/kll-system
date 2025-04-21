<?php
include 'database/connection.php';

$query = "SELECT chat_question, bot_response, sequence FROM tbl_chatbot ORDER BY sequence ASC, created_at ASC";
$stmt = $conn->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($results);
