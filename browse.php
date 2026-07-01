<?php
include("connect.php");
$category = $_GET['category'] ?? 'all';
$date = $_GET['date'] ?? 'all';
$sub = $_GET['sub'] ?? 'all';

$where = [];

if ($category != 'all') {

    if ($category == 'university') {
        $where[] = "event_category = 'University-Wide'";
    } elseif ($category == 'faculty') {
        $where[] = "event_category = 'Faculty'";
    } elseif ($category == 'residential') {
        $where[] = "event_category = 'Residential College'";
    } elseif ($category == 'club') {
        $where[] = "event_category = 'Club / Society'";
    }
}

if ($sub != 'all') {
    $where[] = "LOWER(category_name) = LOWER('$sub')";
}

if ($date == 'today') {
    $where[] = "event_date = CURDATE()";
}
elseif ($date == 'week') {
    $where[] = "YEARWEEK(event_date, 1) = YEARWEEK(CURDATE(), 1)";
}
elseif ($date == 'month') {
    $where[] = "MONTH(event_date) = MONTH(CURDATE())
                AND YEAR(event_date) = YEAR(CURDATE())";
}



$sql = "SELECT * FROM event";

if (count($where) > 0) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Browse Events</title>
        <link rel="stylesheet" href="browse.css">
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
                <input type="text" id="searchBox" placeholder="Search Events...">
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

        <!--MAIN CONTENT-->

        <div class="main-container">

            <!--SIDEBAR-->
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

<a href="browse.php?category=club&sub=Academic%20%26%20Career"
   class="sub-link <?php if($sub=='Academic & Career') echo 'active'; ?>">
   Academic and Career
</a>

<a href="browse.php?category=club&sub=Sports%20%26%20Recreation"
   class="sub-link <?php if($sub=='Sports & Recreation') echo 'active'; ?>">
   Sports and Recreation
</a>

<a href="browse.php?category=club&sub=Culture%20%26%20National%20Identity"
   class="sub-link <?php if($sub=='Culture & National Identity') echo 'active'; ?>">
   Culture and National Identity
</a>

<a href="browse.php?category=club&sub=Leadership%20%26%20Management"
   class="sub-link <?php if($sub=='Leadership & Management') echo 'active'; ?>">
   Leadership and Management
</a>

<a href="browse.php?category=club&sub=Volunteerism"
   class="sub-link <?php if($sub=='Volunteerism') echo 'active'; ?>">
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

                        <!--SIGNOUT-->
                <div class="logout-box">
                    <a href="logout.php" class="logout-btn">
                     Sign Out
                    </a>
                </div>

            </div>

            <!--EVENTS AREA-->

            <div class="events-section">

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

            

                <?php
                while($row = $result->fetch_assoc()) {
                ?>
    <div class="event-card">

        <div class="event-image">
             <img src="poster/<?php echo $row['poster']; ?>" alt="Event Poster">
        </div>

        <div class="event-info">

            <h2><?php echo $row['event_name']; ?></h2>

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

        </div>

        <div class="event-button">
           <a href="eventdetails.php?id=<?php echo $row['event_id']; ?>&category=<?php echo $category; ?>&sub=<?php echo $sub; ?>&date=<?php echo $date; ?>">
                <button>View Details</button>
            </a>
        </div>

    </div>

<?php
}
?>
            </div>

        </div>

        <script>
document.getElementById("searchBox").addEventListener("keypress", function(event)
{
    if(event.key === "Enter")
    {
        let keyword = this.value;

        if(keyword == "")
        {
            alert("Please enter a keyword.");
        }
        else
        {
            alert("Searching for: " + keyword);
        }
    }
});
</script>


    </body>
</html>