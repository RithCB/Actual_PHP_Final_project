<?php
session_start();
include("Database.php"); 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['record_id'])) {
    $recordId = $_POST['record_id'];

    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare("DELETE FROM student_borrow WHERE borrowID = ?");
    $stmt->bind_param("i", $recordId);

    if ($stmt->execute()) {
        // Redirect back to dashboard with a success message
        header("Location: admin_dashboard.php"); 
    } else {
        echo "Error deleting record: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

mysqli_close($conn);

?>

