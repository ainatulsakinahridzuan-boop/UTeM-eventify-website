<?php
include("connect.php");

$event_id = $_GET['id'] ?? 0;
$category = $_GET['category'] ?? 'all';
$date = $_GET['date'] ?? 'all';
$sub = $_GET['sub'] ?? 'all';


$sql = "SELECT * FROM event WHERE event_id = $event_id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$quota = $row['event_quota'];

$countSql = "SELECT COUNT(*) AS total_registered
             FROM registration
             WHERE event_id = $event_id
             AND registration_status = 'Registered'";

$countResult = $conn->query($countSql);
$countRow = $countResult->fetch_assoc();

$totalRegistered = $countRow['total_registered'];
$seatsLeft = $quota - $totalRegistered;

$today = date('Y-m-d');
$eventDate = $row['event_date'];

$closingDate = date('Y-m-d', strtotime($eventDate . ' -1 day'));

if ($today >= $closingDate) {
    $registrationClosed = true;
} else {
    $registrationClosed = false;
}




if (!isset($_GET['category'])) {
    $category = strtolower($row['event_category']);

    if ($category == 'university-wide') {
        $category = 'university';
    } elseif ($category == 'residential college') {
        $category = 'residential';
    } elseif ($category == 'club / society') {
        $category = 'club';
    }

    $sub = strtolower($row['category_name']);

switch ($sub) {
    case 'academic & career':
        $sub = 'academic';
        break;

    case 'sports & recreation':
        $sub = 'sports';
        break;

    case 'culture & national identity':
        $sub = 'cultural';
        break;

    case 'leadership & management':
        $sub = 'leadership';
        break;

    case 'tuah':
        $sub = 'tuah';
        break;

    case 'jebat':
        $sub = 'jebat';
        break;

    case 'lekir':
        $sub = 'lekir';
        break;

    case 'lekiu':
        $sub = 'lekiu';
        break;

    case 'kasturi':
        $sub = 'kasturi';
        break;

    case 'lestari':
        $sub = 'lestari';
        break;

    case 'al-jazari':
        $sub = 'aljazari';
        break;
}
    $date = 'all';
}

$recommend_sql = "SELECT * FROM event
                  WHERE event_id != $event_id
                  ORDER BY RAND()
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
        <li><a href="home_page.php" class="active-nav">Home</a></li>
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

        
       <!--universitywide-->

        <a href="browse.php?category=all" class="side-btn <?php if($category=='all') echo 'active'; ?>">All Events</a>
        <a href="browse.php?category=university" class="side-btn <?php if($category=='university') echo 'active'; ?>">University-wide</a>

        <!--faculty-->

    <details class="sub-filter" <?php if($category=='faculty') echo 'open'; ?>>
        <summary class="side-btn <?php if($category=='faculty') echo 'active'; ?>">Faculty</summary>

        <a href="browse.php?category=faculty&sub=ftkek"
        class="sub-link <?php if($sub=='ftkek') echo 'active'; ?>">
        FTKEK
        </a>

        <a href="browse.php?category=faculty&sub=ftke"
        class="sub-link <?php if($sub=='ftke') echo 'active'; ?>">
        FTKE
        </a>

        <a href="browse.php?category=faculty&sub=ftkm"
        class="sub-link <?php if($sub=='ftkm') echo 'active'; ?>">
        FTKM
        </a>

        <a href="browse.php?category=faculty&sub=ftkip"
        class="sub-link <?php if($sub=='ftkip') echo 'active'; ?>">
        FTKIP
        </a>

        <a href="browse.php?category=faculty&sub=ftmk"
        class="sub-link <?php if($sub=='ftmk') echo 'active'; ?>">
        FTMK
        </a>

        <a href="browse.php?category=faculty&sub=faix"
        class="sub-link <?php if($sub=='faix') echo 'active'; ?>">
        FAIX
        </a>

        <a href="browse.php?category=faculty&sub=fptt"
        class="sub-link <?php if($sub=='fptt') echo 'active'; ?>">
        FPTT
        </a>
    </details>

    <!--college-->

    <details class="sub-filter" <?php if($category=='residential') echo 'open'; ?>>
        <summary class="side-btn <?php if($category=='residential') echo 'active'; ?>">Residential College</summary>

         <a href="browse.php?category=residential&sub=tuah"
            class="sub-link <?php if($sub=='tuah') echo 'active'; ?>">
            Tuah (SATRIA)
        </a>

        <a href="browse.php?category=residential&sub=jebat"
            class="sub-link <?php if($sub=='jebat') echo 'active'; ?>">
            Jebat (SATRIA)
        </a>

        <a href="browse.php?category=residential&sub=lekir"
            class="sub-link <?php if($sub=='lekir') echo 'active'; ?>">
            Lekir (SATRIA)
        </a>

        <a href="browse.php?category=residential&sub=lekiu"
            class="sub-link <?php if($sub=='lekiu') echo 'active'; ?>">
            Lekiu (SATRIA)
        </a>

        <a href="browse.php?category=residential&sub=kasturi"
            class="sub-link <?php if($sub=='kasturi') echo 'active'; ?>">
            Kasturi (SATRIA)
        </a>

        <a href="browse.php?category=residential&sub=lestari"
            class="sub-link <?php if($sub=='lestari') echo 'active'; ?>">
            Lestari
        </a>

        <a href="browse.php?category=residential&sub=aljazari"
            class="sub-link <?php if($sub=='aljazari') echo 'active'; ?>">
            Al-Jazari
        </a>
    </details>


    <!--club-->

    <details class="sub-filter" <?php if($category=='club') echo 'open'; ?>>
    <summary class="side-btn <?php if($category=='club') echo 'active'; ?>">Club / Society</summary>

    <a href="browse.php?category=club&sub=academic"
       class="sub-link <?php if($sub=='academic') echo 'active'; ?>">
       Academic and Career
    </a>

    <a href="browse.php?category=club&sub=sports"
       class="sub-link <?php if($sub=='sports') echo 'active'; ?>">
       Sports and Recreation
    </a>

    <a href="browse.php?category=club&sub=cultural"
       class="sub-link <?php if($sub=='cultural') echo 'active'; ?>">
       Culture and National Identity
    </a>

    <a href="browse.php?category=club&sub=leadership"
       class="sub-link <?php if($sub=='leadership') echo 'active'; ?>">
       Leadership and Management
    </a>

    <a href="browse.php?category=club&sub=volunteerism"
       class="sub-link <?php if($sub=='volunteerism') echo 'active'; ?>">
       Volunteerism
    </a>

    </details>
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

    if($sub != 'all')
    echo " &gt; " . strtoupper($sub);

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

<?php if (!$registrationClosed) { ?>
    <div class="seat-warning">
        <span class="material-icons">event_seat</span>
        Only <?php echo $seatsLeft; ?> seats left!
    </div>
<?php } ?>

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

<?php if ($registrationClosed) { ?>

    <button class="closed-btn" disabled>
        <span class="material-icons">lock</span>
        Registration Closed
    </button>

<?php } else { ?>

    <a href="registration.php?id=<?php echo $row['event_id']; ?>" class="register-btn">
        Register Now
    </a>

    <div class="closing-box">
        Registration closes on <?php echo date('d M Y', strtotime($closingDate)); ?>
    </div>

<?php } ?>
                </div>

                    
                <div class="organiser-card">

                    <h2>Organised By</h2>

                    <div class="organiser-line"></div>

                    

                    <p class="organiser-name">
                        <?php echo $row['organiser_name']; ?>
                    </p>

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

       