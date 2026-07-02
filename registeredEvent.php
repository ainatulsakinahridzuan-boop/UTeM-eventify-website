<?php 
session_start();
include("connect.php");
date_default_timezone_set('Asia/Kuala_Lumpur');

if(!isset($_SESSION['matric_no']))
    {
        header("Location: login.php");
        exit();
    }
    $matric_no = $_SESSION['matric_no'];

    //ambik email student login
    $studentSql="SELECT * FROM student WHERE matric_no='$matric_no'";
    $studentResult=mysqli_query($conn,$studentSql);
    $student=mysqli_fetch_assoc($studentResult);

    $student_email=$student['student_email'];

    

    //absent
    $updateAbsentSql = "UPDATE registration
                    JOIN event ON registration.event_id = event.event_id
                    SET registration.attendance_status = 'Absent'
                    WHERE registration.student_email = '$student_email'
                    AND registration.attendance_status = 'Pending'
                    AND DATE_ADD(CONCAT(event.event_date, ' ', event.event_time), INTERVAL 12 HOUR) <= NOW()";
    mysqli_query($conn, $updateAbsentSql);

    //filter button
    $filter=isset($_GET['filter']) ? $_GET['filter'] : 'all';
    $whereFilter="";
    $orderBy = "DESC";

    if($filter == "upcoming" || $filter == "past")
    {
        $orderBy = "ASC";
    }
    
    if($filter=="upcoming")
        {
            $whereFilter ="AND event.event_date >= CURDATE()";
        }
        else if($filter =="past")
        {
            $whereFilter="AND event.event_date <CURDATE()";
        }

    //display 5 event je per page
    $limit =5;
    $page = isset($_GET['page']) ? $_GET['page']:1;
    $start = ($page - 1) *$limit;

    //kira total registered events
    $countSql= "SELECT COUNT(*) AS total
                FROM registration
                JOIN event ON registration.event_id = event.event_id
                WHERE student_email='$student_email'
                $whereFilter";
    $countResult=mysqli_query($conn, $countSql);
    $countRow=mysqli_fetch_assoc($countResult);
    $totalRecords = $countRow['total'];
    $totalPages= ceil($totalRecords/$limit);

    //ambil registered event ikut page
    $sql = "SELECT registration.*, event.event_name, event.event_date, event.event_time
            FROM registration
            JOIN event ON registration.event_id=event.event_id
            WHERE registration.student_email='$student_email'
            $whereFilter
            ORDER BY event.event_date $orderBy
            LIMIT $start, $limit";
    $result=mysqli_query($conn, $sql);

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="registeredEvent.css?v=7">
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
            <h4>Registered Event</h4>
            <p>User Profile Management
                <span class="material-symbols-outlined arrowSymbol">
                    chevron_right
                </span>
                Registered Event
            </p>
        </div>

        <!-------------------------------------------------------------------------------------------->
        <!--MAIN-->
        <div id="main">
            <div class="registeredCard">

                <!--SEARCH BOX-->
                <div class="searchBox">
                    <span class="material-symbols-outlined searchSymbol">search</span>
                    <input type="text" id="searchInput" placeholder="Search Events...">
                </div>

                <hr>

                <!--FILTER BUTTON-->
                <?php $filter = isset($_GET['filter'])? $_GET['filter'] : 'all'; ?>
                <div class="filterBtnGroup">

                    <!--all event-->
                    <a href="registeredEvent.php">
                        <button class="filterBtn <?php echo ($filter=="all")? "activeFilter" : ""; ?>">
                            All
                        </button>
                    </a>

                    <!--upcoming event-->
                    <a href="registeredEvent.php?filter=upcoming">
                        <button class="filterBtn <?php echo ($filter=="upcoming")? "activeFilter" : ""; ?>">
                            Upcoming
                        </button>
                    </a>
                    
                    <!--past event-->
                    <a href="registeredEvent.php?filter=past">
                        <button class="filterBtn <?php echo ($filter=="past")? "activeFilter" : ""; ?>">
                            Past
                        </button>
                    </a>
                </div>

                <!--TABLE-->
                <table>
                    <tr> 
                        <th>EVENT NAME</th>
                        <th>DATE</th>
                        <th>ACTION</th>
                        <th>ATTENDANCE</th>
                    </tr>

                    <?php while($row = mysqli_fetch_assoc($result)) {?>
                    <tr>
                        <td><?php echo $row['event_name']; ?></td>
                        <td><?php echo $row['event_date']; ?></td>
                        
                        <!--VIEW DETAILS-->
                        <td>
                            <a href="eventdetails.php?id=<?php echo $row['event_id']; ?>"
                            class="viewBtn">View Details
                            </a>
                        </td>

                        <!--ATTENDANCE-->
                        <td>
                            <?php 
                            $status = $row['attendance_status'];
                            $today = date("Y-m-d");
                            $currentDateTime = time();
                            $eventDateTime = strtotime($row['event_date'] . " " . $row['event_time']);
                            $absentTime = $eventDateTime + (12 * 60 * 60); // tambah 12 jam
                           
                            if($status == "Present")
                            {
                                ?>
                                <button class="attendedBtn" disabled>Attended</button>
                                <?php
                            }
                            else if($status == "Absent")
                            {
                                ?>
                                <button class="absentBtn" disabled>Absent</button>
                                <?php
                            }
                            else if(time() >= $absentTime)
                            {
                                ?>
                                <button class="absentBtn" disabled>Absent</button>
                                <?php
                            }
                            else if(time() >= $eventDateTime)
                            {
                                ?>
                                <a href="attendance.php?event_id=<?php echo $row['event_id']; ?>" class="checkInBtn">
                                    Check-In
                                </a>
                                <?php
                            }
                            else
                            {
                                ?>
                                <button class="pendingBtn" disabled>Not Available</button>
                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
                <hr>

                <!--PAGE FIRST-->
                <div class="page">
                    <?php if($page >1)
                    {
                        ?>
                        <a href="registeredEvent.php?page=<?php echo $page-1; ?>&filter=<?php echo $filter; ?>">                            <button>&lt;</button>
                        </a>
                    <?php } ?>

                    <?php for($i = 1; $i<=$totalPages; $i++)
                    {
                        ?>
                        <a href="registeredEvent.php?page=<?php echo $i; ?>&filter=<?php echo $filter; ?>">
                            <button class="<?php echo ($i==$page)? 'pageActive':''; ?>">
                                <?php echo $i; ?>
                            </button>
                        </a>
                    <?php } ?>

                    <!--TOTAL PAGE -->
                    <?php if($page <$totalPages)
                    {
                        ?>
                        <a href="registeredEvent.php?page=<?php echo $page + 1; ?>&filter=<?php echo $filter; ?>">
                            <button>&gt;</button>
                        </a>
                    <?php } ?>
                </div>

                

            </div> <!--REGISTERED CARD PUNYA-->
        </div> <!--MAIN PUNYA-->




<!--JS STARTS HERE-->
<script>

    document.getElementById("searchInput").addEventListener("keyup", function()
    {
        let keyword = this.value.toLowerCase();
        let rows= document.querySelectorAll("table tr");

        for (let i=1; i<rows.length; i++)
        {
            let eventName = rows[i].children[0].textContent.toLowerCase();

            if(eventName.includes(keyword))
            {
                rows[i].style.display="";
            }
            else
            {
                rows[i].style.display="none";
            }
        }

    });

    function confirmSignOut() {
        if (confirm("Are you sure you want to sign out?")) {
            window.location.href = "signout.php";
        }
    }
</script>
</body>
</html>