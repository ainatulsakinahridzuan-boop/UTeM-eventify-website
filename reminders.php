<?php

session_start();
include("connect.php");

if(!isset($_SESSION['student_email'])){
    header("Location: login.php");
    exit();
}

$student_email = $_SESSION['student_email'];

/* GET REMINDER */

$sql = "
SELECT *
FROM notification
WHERE student_email='$student_email'
AND notification_type='reminder'
ORDER BY notification_date DESC
";

$result = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="notification.css?v=2">
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
            <h4>Notification</h4>
            <ul>
                <li><a href="notification.php" class="notActive">All</a></li>
                <li><a href="reminders.php" class="active">Reminders</a></li> <!--HTML BELUM BUAT-->
            </ul>
        </div>

        <!--SIGN OUT-->
        <div id="btn">
            <button type="button" onclick="window.location.href='home_page.php'">
                Home
            </button>

            <button type="button" onclick="window.location.href='login.php'">
                Sign Out
            </button>
        </div>
    </nav>

    <!-------------------------------------------------------------------------------------------->
    <!--BANNER-->
    <div id="banner">
        <h4>Event Reminders</h4>
        <p>Never miss your upcoming registered events
        </p>
    </div>
    <div id="notificationContainer">

<?php
$todayPrinted = false;
$yesterdayPrinted = false;
$monthPrinted = false;
$olderPrinted = false;

if(mysqli_num_rows($result)>0){
    while($row=mysqli_fetch_assoc($result)){

    $date = date("Y-m-d", strtotime($row['notification_date']));
    $today = date("Y-m-d");
    $yesterday = date("Y-m-d", strtotime("-1 day"));
    $thirtyDaysAgo = date("Y-m-d", strtotime("-30 days"));
?>

<?php

if($date == $today && !$todayPrinted){

    echo "<div class='dateTitle'>Today</div>";

    $todayPrinted = true;

}
elseif($date == $yesterday && !$yesterdayPrinted){

    echo "<div class='dateTitle'>Yesterday</div>";

    $yesterdayPrinted = true;

}
elseif($date >= $thirtyDaysAgo && $date < $yesterday && !$monthPrinted){

    echo "<div class='dateTitle'>Last 30 Days</div>";

    $monthPrinted = true;

}

?>


<div class="notificationCard">
    <span class="material-symbols-outlined notificationIcon reminderIcon">
        notifications
    </span>
    <div class="notificationContent">
        <h3>
            <?= htmlspecialchars($row['title']); ?>
        </h3>
        <p>
            <?= nl2br(htmlspecialchars($row['message'])); ?>
        </p>
        <small>
            <?= date("d M Y • h:i A",strtotime($row['notification_date'])); ?>
        </small>
    </div>
</div>
<?php
    }
}else{
?>
<div class="notificationCard">
    <div class="notificationContent">
        <h3>No Reminders</h3>
        <p>You don't have any upcoming event reminders.</p>
    </div>
</div>

<?php

}

?>

</div>
</body>
</html>