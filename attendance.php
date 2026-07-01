<?php
session_start();
include("connect.php");

//ambikk data student
$matric_no = $_SESSION['matric_no'];

$studentSql = "SELECT * FROM student WHERE matric_no = '$matric_no'";
$studentResult = mysqli_query($conn, $studentSql);
$student = mysqli_fetch_assoc($studentResult);

//ambik data event
$event_id = $_GET['event_id'];

$sql = "SELECT * FROM event WHERE event_id = '$event_id'";
$result = mysqli_query($conn, $sql);
$event = mysqli_fetch_assoc($result);

//berjaya check in
if(isset($_POST['check_in']))
{
    $updateSql = "UPDATE registration
                  SET attendance_status = 'Present'
                  WHERE event_id = '$event_id'
                  AND student_email = '".$student['student_email']."'";

    mysqli_query($conn, $updateSql);

    echo "<script>
            alert('Check-in successful!');
            window.location='registeredEvent.php';
          </script>";
    exit();
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="attendance.css?v=3">
    <title>UTeM Eventify</title>
    <!--GOOGLE ICON-->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>
<body>
     <!-- SIDEBAR -->
        <nav id="sidebar">

            <!--LOGO-->
            <div id="logoSection">
                <img src="image/logo.png" alt="logo">
                <div id="logoText">
                    <span>UTeM</span>
                    <span>Eventify</span>                    
                </div>
            </div>

            
            <!--MENU-->
            <div id="menu">
                <h4>User Profile Management</h4>
                <ul>
                    <li><a href="profile.php" class="notActive">Profile</a></li>
                    <li><a href="registeredEvent.php" class="active">Registered Event</a></li> <!--HTML BELUM BUAT-->
                </ul>
            </div>

            <!--HOME//SIGN OUT-->
            <div id="btn">
                <a href="home_page.php" class="homeBtn">
                    <span class="material-symbols-outlined home">home</span>
                    Home
                </a>

                <button type="button" class="signoutBtn" onclick="confirmSignOut()">
                    <span class="material-symbols-outlined logout">logout</span>
                    Sign Out
                </button>
            </div>

        </nav>

        <!-------------------------------------------------------------------------------------------->
        <!--BANNER-->
        <div id="banner">
            <h4>Attendance</h4>
            <p>User Profile Management
                <span class="material-symbols-outlined arrowSymbol">
                    chevron_right
                </span>
                Registered Event

                <span class="material-symbols-outlined arrowSymbol">
                    chevron_right
                </span>
                Attendance
            </p>
        </div>

        <!-------------------------------------------------------------------------------------------->
        <!--MAIN-->
        <div id="main">
            <div class="attendance">
                <h4>Event Check-In</h4>
                <p class="description">
                    For security, your location will be validate. Please make sure you are at the event location before checking in
                </p>

                <hr>

                <!-------------------------------------------------------------------------------------------->
                <!--FORM KIRI-->
                <div class="checkIn">

                    <div class="checkInForm">

                        <!--NAME-->
                        <p class="formLabel">Name</p>
                        <div class="inputBox">
                            <input type="text" value="<?php echo $student['student_name'];?>" readonly>
                            <span class="material-symbols-outlined lockSymbol">
                                lock
                            </span>
                        </div>         

                        <!--MATRIC NUM-->
                        <p class="formLabel">Matric Number</p>
                        <div class="inputBox">
                            <input type="text" value="<?php echo $student['matric_no'];?>" readonly>
                            <span class="material-symbols-outlined lockSymbol">
                                lock
                            </span>
                        </div>

                        <!--CHECK IN-->
                        <form method="POST">
                            <button type="submit" name="check_in" id="checkInBtn">
                                Check-In
                            </button>
                        </form>
                    </div>

                    <!-------------------------------------------------------------------------------------------->
                    <!--DETAILS KANAN-->
                    <div id="eventPreview">

                        <!--POSTER-->
                        <div class="eventPoster">
                            <img src="poster/<?php echo $event['poster']; ?>" alt="Event Poster">
                        </div>

                        <!--NAMA-->
                        <h4><?php echo $event['event_name']; ?></h4>

                        <!--DATE-->
                        <p>
                            <span class="material-symbols-outlined dateSymbol">calendar_today</span>
                            <?php echo $event['event_date']; ?>
                        </p>

                        <!--VENUE-->
                        <p>
                            <span class="material-symbols-outlined venueSymbol">location_on</span>
                            <?php echo $event['event_venue']; ?>
                        </p>

                        <!--MASA-->
                        <p>
                            <span class="material-symbols-outlined scheduleSymbol">schedule</span>
                            <?php echo $event['event_time']; ?>
                        </p>

                        <!--FEE-->
                        <p>
                            <span class="material-symbols-outlined moneySymbol">attach_money</span>
                            RM <?php echo $event['event_fee']; ?>
                        </p>

                    </div>
                </div>
            </div> <!--ATTENDANCE PUNYA-->
        </div> <!--MAIN PUNYA-->

<script>
    function confirmSignOut() {
        if (confirm("Are you sure you want to sign out?")) {
            window.location.href = "signout.php";
        }
    }
</script>
</body>
</html>