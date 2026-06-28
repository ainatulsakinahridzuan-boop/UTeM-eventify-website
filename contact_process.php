<?php
session_start();
include("connect.php");

if (!isset($_SESSION['student_email'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $student_email = $_SESSION['student_email'];
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    if (trim($message) == "") {

        echo "<script>
                alert('Please enter your message.');
                window.location='contact.php';
              </script>";
        exit();
    }

    $sql = "INSERT INTO contact_message
            (student_email, message)
            VALUES
            ('$student_email', '$message')";

    if (mysqli_query($conn, $sql)) {

        echo "<script>
                alert('Your message has been sent successfully!');
                window.location='contact.php';
              </script>";

    } else {

        echo "<script>
                alert('Failed to send message.');
                window.location='contact.php';
              </script>";
    }
}
?>