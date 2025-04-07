<?php
include '../../database/connection.php';
include 'session_login.php';

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the new password and confirm password fields are not empty
    if (!empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Check if the passwords match
        if ($new_password === $confirm_password) {
            // Hash the new password using sha1
            $hashed_password = sha1($new_password);

            // Get the logged-in user's ID from the session
            $admin_id = $_SESSION['admin_id'];

            // Prepare the query to update the password in the database
            $query = "UPDATE tbl_admin SET password = :password WHERE id = :admin_id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
            $stmt->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);

            // Execute the query
            if ($stmt->execute()) {
                // If the password is successfully updated, show a success message
                $success_message = "Password successfully updated!";
            } else {
                // If the update fails, show an error message
                $error_message = "There was an error updating the password.";
            }
        } else {
            // If the passwords do not match, show an error message
            $error_message = "The passwords do not match!";
        }
    } else {
        // If the fields are empty, show an error message
        $error_message = "Please fill in both the new password and confirm password fields.";
    }
}
