<?php

include("connect.php");

if (isset($_POST['signup'])) {
    $student_name = $_POST['fname'];
    $student_email = $_POST['email'];
    $matric_no = $_POST['matric_no'];
    $phone_number = $_POST['phonenum'];
    $faculty = $_POST['faculty'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check UTeM student email
    $domain = "@student.utem.edu.my";

    if (substr($student_email, -strlen($domain)) != $domain) {
        echo "<script>
                alert('Please use your UTeM student email.');
              </script>";
    } else {
        // Check duplicate email
        $checkEmail = mysqli_query(
            $conn,
            "SELECT * FROM student
             WHERE student_email='$student_email'"
        );

        if (mysqli_num_rows($checkEmail) > 0) {
            echo "<script>
                    alert('Email already registered!');
                  </script>";
        } else {
            $sql = "INSERT INTO student
                    (student_email, password, matric_no, student_name, faculty, phone_number)
                    VALUES
                    ('$student_email',
                     '$password',
                     '$matric_no',
                     '$student_name',
                     '$faculty',
                     '$phone_number')";

            if (mysqli_query($conn, $sql)) {

                include ("sendWelcomeEmail.php");

                echo "<script>
                        alert('Registration Successful!');
                        window.location='login.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Registration Failed!');
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
    <link rel="stylesheet" type="text/css" href="signup.css">
    <title>Document</title>
</head>

<body>

    <div id="signup-section">
        <h2 class="form-title">Welcome to UTeMEventify</h2>
        <form method="post" action="signup.php">

            <div class="input-group">
                <label for="fname">Full Name</label>
                <input type="text" name="fname" id="fname" required>
            </div>

            <div class="input-group">
                <label for="email">E-mail Address</label>
                <input type="email"
                    name="email"
                    id="email"
                    required
                    pattern=".+@student\.utem\.edu\.my$"
                    title="Please use your UTeM student email">
            </div>

            <div class="input-group">
                <label for="matric_no">Matric Number</label>
                <input type="text" name="matric_no" id="matric_no" required>
            </div>

            <div class="input-group">
                <label for="phonenum">Phone Number</label>
                <input type="tel" name="phonenum" id="phonenum" required>
            </div>

            <div class="input-group">
                <label for="faculty">Faculty</label>

                <select name="faculty" id="faculty" required>
                    <option value=""></option>
                    <option value="FTKEK">FTKEK</option>
                    <option value="FTKE">FTKE</option>
                    <option value="FTKM">FTKM</option>
                    <option value="FTKIP">FTKIP</option>
                    <option value="FTMK">FTMK</option>
                    <option value="FAIX">FAIX</option>
                    <option value="FPTT">FPTT</option>
                    <option value="SCHOOL OF INTERNATIONAL STUDIES AND GLOBAL LANGUAGES">SCHOOL OF INTERNATIONAL STUDIES AND GLOBAL LANGUAGES</option>
                    <option value="SPS">SPS</option>
                    <option value="IPTK">IPTK</option>
                </select>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required
                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{8,}">
            </div>

            <div class="show-password">
                <input type="checkbox"
                    onclick="showPassword('password')">

                <label>Show Password</label>
            </div>

            <div class="password-rules">
                <ul>
                    <li>Use 8 or more characters</li>

                    <li>One special character</li>
                </ul>

                <ul>
                    <li>One uppercase character</li>
                    <li>One number</li>
                </ul>

                <ul>
                    <li>One lowercase character</li>
                </ul>

            </div>

            <div id="termsText">

                <p> By creating an account , you agree to the
                Terms of Use
                and
                Privacy Policy</p>
            </div>

            <button type="submit" id="SignUp-btn" name="signup">SIGN UP</button>

        </form>

        <div id="LogIn-btn">
            Already have an account?
            <a href="login.php">Log in</a>
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