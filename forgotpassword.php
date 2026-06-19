<?php

include("db_connect.php");

if (isset($_POST['reset'])) {
    $email = $_POST['email'];
    $newPassword = $_POST['newpassword'];
    $confirmPassword = $_POST['confirmpassword'];

    if ($newPassword != $confirmPassword) {
        echo "<script>
                alert('Password and Confirm Password do not match!');
              </script>";
    } else {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // CHECK STUDENT
        $studentCheck = mysqli_query(
            $conn,
            "SELECT * FROM student
             WHERE student_email='$email'"
        );

        if (mysqli_num_rows($studentCheck) == 1) {
            mysqli_query(
                $conn,
                "UPDATE student
                 SET password='$hashedPassword'
                 WHERE student_email='$email'"
            );

            echo "<script>
                    alert('Password Updated Successfully!');
                    window.location='login.php';
                  </script>";
        }

        // CHECK ADMIN
        else {
            $adminCheck = mysqli_query(
                $conn,
                "SELECT * FROM admin
                 WHERE admin_email='$email'"
            );

            if (mysqli_num_rows($adminCheck) == 1) {
                mysqli_query(
                    $conn,
                    "UPDATE admin
                     SET password='$hashedPassword'
                     WHERE admin_email='$email'"
                );

                echo "<script>
                        alert('Password Updated Successfully!');
                        window.location='login.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Email not found!');
                      </script>";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" type="text/css" href="forgotpassword.css">
</head>

<body>

    <div id="forgotpassword-section">

        <h2 class="form-title">Forgot Password</h2>
        <h3 class="form-subtitle">Create a new password for your account</h3>

        <form method="post">

            <div class="input-group">
                <label>Email Address</label>
                <input type="email" name="email" required>
            </div>

            <div class="input-group">
                <label>New Password</label>
                <input type="password" name="newpassword" id="newpassword" required>
            </div>

            <div class="show-password">
                <input type="checkbox"
                    onclick="showPassword('newpassword')">

                <label>Show Password</label>
            </div>

            <div class="input-group">
                <label>Confirm Password</label>
                <input type="password" name="confirmpassword" id="confirmpassword" required>
            </div>

            <div class="show-password">
                <input type="checkbox"
                    onclick="showPassword('confirmpassword')">

                <label>Show Password</label>
            </div>

            <button type="submit" id="Reset-btn" name="reset">
                Reset Password
            </button>

        </form>

        <div id="BackToLogin">
            Back to <a href="login.php">Log In</a>
        </div>

    </div>
    <script>

        function showPassword(id) {
            let password = document.getElementById(id);

            if (password.type == "password") {
                password.type = "text";
            } else {
                password.type = "password";
            }
        }

    </script>





</body>

</html>