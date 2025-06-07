<?php

include("Database.php");
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && 
isset($_POST['book_title'])) {
    $studentName = $_SESSION['student_name']; 
    $bookTitle = $_POST['book_title'];
    $borrowDate = date("Y-m-d H:i:s");

    $stmt = $conn->prepare("INSERT INTO student_borrow
(student_name, book_title, borrow_date) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $studentName, $bookTitle, 
$borrowDate);

    if ($stmt->execute()) {
        header("Location: index_for_member.php"); 
       
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();

?>

