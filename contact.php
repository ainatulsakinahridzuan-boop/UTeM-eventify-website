<?php
session_start();
include("connect.php");

$student_email = $_SESSION['student_email'];

$sql = "SELECT * FROM student WHERE student_email='$student_email'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$fullName = $row['student_name'];
$phone = $row['phone_number'];   // ikut nama column dalam table student
$email = $row['student_email'];

$name = explode(" ", $fullName, 2);
$firstName = $name[0];
$lastName = isset($name[1]) ? $name[1] : "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="contact.css">
    <title>Contact UTeM Eventify</title>
    <!--GOOGLE ICON-->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>

<!----------------------------------------------------------------------------------------->
<!--HTML STARTS HERE-->

<body>

    <!--TOP NAVIGATION-->
    <nav class="topnav">

        <!--LOGO-->
        <div class="logo">
            <img src="image/logo.png" alt="UTeM Eventify logo">
            <span>UTeM<br>Eventify</span>
        </div>

        <!--SEARCH BOX-->
        <div class="searchBox">
            <span class="material-symbols-outlined searchSymbol">search</span>
            <input type="text" placeholder="Search Events...">
        </div>

        <!--SELECTION-->
        <ul>
            <li><a href="home_page.php" class="active">Home</a></li>
            <li><a href="about.php">About</a></li> 
            <li><a href="contact.php">Contact</a></li>
            <li><a href="notification.php">Notification</a></li>
        </ul>

        <!--PROFILE-->
        <div class="profile">
            <a href="profile.php"> <!--belum buat html-->
            <span class="material-symbols-outlined profileSymbol">account_circle</span>
            </a>
        </div>
    </nav>

    <!--BANNER-->
    <div id="banner">
        <h1>Have Questions? We’re Here to Help</h1>
        <h2>Send us a message anytime, we’d love to assist you</h2>
    </div>

    <!--------------------------------------------------------------------------------------------------->
    <!--MAIN-->
    <div id="main">

        <!-- ABOUT -->
        <section class="contactFormCard">

            <div class="contactHeader">
                <h2>Contact Us</h2>
            </div>

            <form action="contact_process.php" method="POST">

                <label>First Name:</label>
                <input
                    type="text"
                    value="<?= htmlspecialchars($firstName); ?>"
                    readonly>

                <label>Last Name:</label>
                <input
                    type="text"
                    value="<?= htmlspecialchars($lastName); ?>"
                    readonly>

                <label>Mobile Number:</label>
                <input
                    type="text"
                    value="<?= htmlspecialchars($phone); ?>"
                    readonly>

                <label>Email ID:</label>
                <input
                    type="email"
                    value="<?= htmlspecialchars($email); ?>"
                    readonly>

                <label>Message:</label>
                <textarea name="message" id="message" placeholder="Write your message here"></textarea>

                <button type="submit" class="submitBtn">
                    Submit
                </button>

            </form>

        </section>

        <section class="contactInfo">

            <div class="infoCard">
                <span class="material-symbols-outlined infoIcon">
                    call
                </span>

                <h4>Phone Number</h4>
                <p>+60 6-270 1000</p>
            </div>

            <div class="infoCard">
                <span class="material-symbols-outlined infoIcon">
                    mail
                </span>

                <h4>Email</h4>
                <p>mpp@utem.edu.my</p>
            </div>

            <div class="infoCard">
                <a href="https://maps.app.goo.gl/ESe7ouyP4Kj4TPYv6" target="_blank">
                    <span class="material-symbols-outlined infoIcon">
                        location_on
                    </span>

                    <h4>Location</h4>
                    <p>HEPA, Universiti Teknikal Malaysia Melaka</p>
                    <p>Mon – Fri, 8:00 AM – 5:00 PM</p>
                </a>
            </div>

            <div class="infoCard">
                <a href="https://www.instagram.com/mpputem2526?igsh=MTJmMmNyNXBwMzhzOA==" target="_blank">
                    <span class="material-symbols-outlined infoIcon">
                        photo_camera
                    </span>

                    <h4>Instagram</h4>
                    <p>@mpputem2526</p>
                </a>
            </div>

        </section>

    </div>

</body>

</html>