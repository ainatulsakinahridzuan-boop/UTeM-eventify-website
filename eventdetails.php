<?php
include("connect.php");

$event_id = $_GET['id'] ?? 0;
$category = $_GET['category'] ?? 'all';
$date = $_GET['date'] ?? 'all';
$sub = $_GET['sub'] ?? 'all';


$sql = "SELECT * FROM event WHERE event_id = $event_id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$recommend_sql = "SELECT * FROM event
                  WHERE event_id != $event_id
                  LIMIT 4";

$recommend_result = $conn->query($recommend_sql);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Event Details</title>
        <link rel="stylesheet" href="eventdetails.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    </head>

    <body>

        <!--HEADER,NAVBAR-->

      <div class="topnav">

            <div class="logo">
                <img src="logo.png" alt="UTeM Eventify Logo">
                <span>UTeM<br>Eventify</span>
            </div>

        <div class="searchBox">
                <span class="material-symbols-outlined searchSymbol">search</span>
                <input type="text" placeholder="Search Events...">
        </div>

    <ul>
        <li><a href="home_page.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="notification.php">Notification</a></li>
    </ul>

    <div class="profile">
        <a href="profile.php">
            <span class="material-symbols-outlined profileSymbol">account_circle</span>
        </a>
    </div>

</div>
        

         <!--PICTURE SECTION-->

        <div class="picture">
            <h1>Find Your Next Event</h1>
        </div>


        <!-- MAIN CONTENT -->

        <div class="main-container">

            <!-- SIDEBAR -->
            <div class="sidebar">
                 <details class="filter-box" open>
                     <summary>Categories</summary>

        <a href="browse.php?category=all&sub=all&date=<?php echo $date; ?>"
           class="side-btn <?php if($category=='all') echo 'active'; ?>">
           All Events
        </a>

        <a href="browse.php?category=university&sub=all&date=<?php echo $date; ?>"
           class="side-btn <?php if($category=='university') echo 'active'; ?>">
           University-wide
        </a>

        <a href="browse.php?category=faculty&sub=all&date=<?php echo $date; ?>"
           class="side-btn <?php if($category=='faculty') echo 'active'; ?>">
           Faculty
        </a>

        <a href="browse.php?category=residential&sub=all&date=<?php echo $date; ?>"
           class="side-btn <?php if($category=='residential') echo 'active'; ?>">
           Residential College
        </a>

        <a href="browse.php?category=club&sub=all&date=<?php echo $date; ?>"
           class="side-btn <?php if($category=='club') echo 'active'; ?>">
           Club / Society
        </a>

    </details>

     <details class="filter-box" <?php if($date != 'all') echo 'open'; ?>>
        <summary>Date</summary>

        <a href="browse.php?category=<?php echo $category; ?>&sub=<?php echo $sub; ?>&date=today"
           class="side-btn <?php if($date=='today') echo 'active'; ?>">
           Today
        </a>

        <a href="browse.php?category=<?php echo $category; ?>&sub=<?php echo $sub; ?>&date=week"
           class="side-btn <?php if($date=='week') echo 'active'; ?>">
           This Week
        </a>

        <a href="browse.php?category=<?php echo $category; ?>&sub=<?php echo $sub; ?>&date=month"
           class="side-btn <?php if($date=='month') echo 'active'; ?>">
           This Month
        </a>

    </details>

</div>



   
        


    <!-- DETAILS SECTION -->
    <div class="details-section">

        <p class="breadcrumb">
    Categories &gt;

    <?php
    if($category == 'all')
        echo 'All Events';
    elseif($category == 'university')
        echo 'University-wide';
    elseif($category == 'faculty')
        echo 'Faculty';
    elseif($category == 'residential')
        echo 'Residential College';
    elseif($category == 'club')
        echo 'Club / Society';

    if($date == 'today')
        echo ' &gt; Today';
    elseif($date == 'week')
        echo ' &gt; This Week';
    elseif($date == 'month')
        echo ' &gt; This Month';
    ?>
</p>

        <div class="details-layout">

            <!-- LEFT CONTENT -->
            <div class="left-content">

                <div class="main-card">

                    <div class="event-poster">
                            <img src="poster/<?php echo $row['poster']; ?>" alt="Event Poster">
                    </div>

                    <div class="event-description">

                        <h2><?php echo $row['event_name']; ?></h2>

                        <p>
                             <?php echo $row['event_desc']; ?>
                        </p>

                    </div>

                    <div class="event-objectives">
                        <h2>Event Objectives</h2>

                        <ul>
                            <li>Gain exposure to current and emerging trends in technology</li>
                            <li>Bridge the gap between academic knowledge and industry practices</li>
                            <li>Provide networking opportunities with industry experts and alumni</li>
                            <li>Enhance students' awareness of career pathways in the tech industry</li>
                            <li>Encourage continuous learning and innovation among students</li>
                        </ul>
                    </div>

                </div>

            </div>

            <!-- RIGHT CONTENT -->
            <div class="right-content">

                <div class="registration-card">

                    <h2>Event Registration</h2>

                    <div class="seat-warning">
                        <span class="material-icons">warning</span>
                        Only 25 seats left!
                    </div>

                    

                  
                    <p>
                         <span class="material-icons">calendar_today</span>
                         <?php echo $row['event_date']; ?>
                    </p>

                    <p>
                         <span class="material-icons">location_on</span>
                         <?php echo $row['event_venue']; ?>
                    </p>

                    <p>
                        <span class="material-icons">schedule</span>
                        <?php echo $row['event_time']; ?>
                    </p>

                    <p>
                        <span class="material-icons">payments</span>
                        RM <?php echo $row['event_fee']; ?>
                    </p>

                    <hr>

                    <a href="registration.php?id=<?php echo $row['event_id']; ?>" class="register-btn">
                        Register Now
                    </a>
                    <div class="closing-box">
                        Registration closes in 5 days
                    </div>

                </div>

                <div class="organiser-card">

                    <h2>Organised By</h2>

                    <div class="organiser-info">

                        <div class="organiser-logo">
                            <img src="ficts.png" alt="FICTS Logo">
                        </div>

                        <p>
                            FTMK Student Club<br>
                            (FICTS)
                        </p>

                    </div>

                </div>

            </div>

        </div>

        <!-- RECOMMENDED SECTION -->
        <div class="recommended-section">

            <h2>Recommended For You</h2>

            <div class="recommended-list">

            <?php while($rec = $recommend_result->fetch_assoc()) { ?>

    <div class="recommend-card">

        <div class="recommend-img">
            <img src="poster/<?php echo $rec['poster']; ?>" alt="Event Poster">
        </div>



        <div class="recommend-info">
            <h3><?php echo $rec['event_name']; ?></h3>

            <p>
                <span class="material-icons">calendar_today</span>
                <?php echo $rec['event_date']; ?>
            </p>

            <p>
                <span class="material-icons">location_on</span>
                <?php echo $rec['event_venue']; ?>
            </p>

               <a href="eventdetails.php?id=<?php echo $rec['event_id']; ?>" class="recommend-btn">
                    View Details
               </a>
        </div>

    </div>

<?php } ?>



              

</body>
</html>

       