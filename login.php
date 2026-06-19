<?php

session_start();
include("db_connect.php");

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // CHECK STUDENT

    $studentSql = "SELECT * FROM student
                   WHERE student_email='$email'";

    $studentResult = mysqli_query($conn, $studentSql);

    if (mysqli_num_rows($studentResult) == 1) {
        $row = mysqli_fetch_assoc($studentResult);

        if (password_verify($password, $row['password'])) {
            $_SESSION['role'] = "student";
            $_SESSION['student_email'] = $row['student_email'];
            $_SESSION['student_name'] = $row['student_name'];
            $_SESSION['matric_no'] = $row['matric_no'];

            echo "<script>
                    alert('Student Login Successful!');
                    window.location='home_page.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Incorrect Password!');
                  </script>";
        }
    }

    // CHECK ADMIN

    else {
        $adminSql = "SELECT * FROM admin
                     WHERE admin_email='$email'";

        $adminResult = mysqli_query($conn, $adminSql);

        if (mysqli_num_rows($adminResult) == 1) {
            $row = mysqli_fetch_assoc($adminResult);

            if (password_verify($password, $row['password'])) {
                $_SESSION['role'] = "admin";
                $_SESSION['admin_email'] = $row['admin_email'];
                $_SESSION['position'] = $row['position'];

                echo "<script>
                        alert('Admin Login Successful!');
                        window.location='dashboard.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Incorrect Password!');
                      </script>";
            }
        } else {
            echo "<script>
                    alert('Email not found!');
                  </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="login.css">
    <title>Document</title>
</head>

<body>

    <div id="login-section">
        <h2 class="form-title">Welcome Back</h2>
        <h3 class="form-title">We're so excited to see you again!</h3>
        <form method="post" action="login.php">


            <div class="input-group">
                <label for="email">E-mail Address</label>
                <input type="email" name="email" id="email" required>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div class="show-password">
                <input type="checkbox"
                    onclick="showPassword('password')">

                <label>Show Password</label>
            </div>


            <div id="forgotpassword">
                <a href="forgotpassword.php">Forgot Password?</a>
            </div>

            <button type="submit" id="LogIn-btn" name="login">LOG IN</button>

        </form>

        <div id="SignUp-btn">
            Already have an account?
            <a href="signup.php">Sign Up</a>
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