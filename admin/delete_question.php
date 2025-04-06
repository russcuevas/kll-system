<?php
include '../database/connection.php';
include 'session_not_login.php';

if (isset($_GET['id'])) {
    $question_id = $_GET['id'];

    $sql_check = "SELECT * FROM tbl_questions WHERE id = :question_id";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bindParam(':question_id', $question_id);
    $stmt_check->execute();

    if ($stmt_check->rowCount() == 0) {
        $_SESSION['errors'] = "Question not found!";
        header('Location: questionnaire.php');
        exit();
    }

    $delete_question_courses_sql = "DELETE FROM tbl_question_courses WHERE question_id = :question_id";
    $delete_question_courses_stmt = $conn->prepare($delete_question_courses_sql);
    $delete_question_courses_stmt->bindParam(':question_id', $question_id);
    $delete_question_courses_stmt->execute();

    $delete_question_sql = "DELETE FROM tbl_questions WHERE id = :question_id";
    $delete_question_stmt = $conn->prepare($delete_question_sql);
    $delete_question_stmt->bindParam(':question_id', $question_id);
    $delete_question_stmt->execute();

    $_SESSION['success'] = "Question deleted successfully!";
    header('Location: questionnaire.php');
    exit();
} else {
    $_SESSION['errors'] = "No question ID provided!";
    header('Location: questionnaire.php');
    exit();
}
