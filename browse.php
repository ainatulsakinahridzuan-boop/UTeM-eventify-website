<?php
include("connect.php");
$category = $_GET['category'] ?? 'all';
$date = $_GET['date'] ?? 'all';

$sql = "SELECT * FROM event";
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

        <!--MAIN CONTENT-->

        <div class="main-container">

            <!--SIDEBAR-->
            <div class="sidebar">
               <details class="filter-box" open>

    <summary>Categories</summary>

    <a href="browse.php?category=all"
       class="side-btn <?php if($category=='all') echo 'active'; ?>">
       All Events
    </a>

    <a href="browse.php?category=university"
       class="side-btn <?php if($category=='university') echo 'active'; ?>">
       University-wide
    </a>

    <a href="browse.php?category=faculty"
       class="side-btn <?php if($category=='faculty') echo 'active'; ?>">
       Faculty
    </a>

    <a href="browse.php?category=residential"
       class="side-btn <?php if($category=='residential') echo 'active'; ?>">
       Residential College
    </a>

    <a href="browse.php?category=club"
       class="side-btn <?php if($category=='club') echo 'active'; ?>">
       Club / Society
    </a>

</details>

                    <details class="filter-box" <?php if($date != 'all') echo 'open'; ?>>
                    <summary>Date</summary>

                    <a href="browse.php?category=<?php echo $category; ?>&date=today"
                        class="side-btn <?php if($date=='today') echo 'active'; ?>">
                        Today
                    </a>

                    <a href="browse.php?category=<?php echo $category; ?>&date=week"
                        class="side-btn <?php if($date=='week') echo 'active'; ?>">
                        This Week
                    </a>

                    <a href="browse.php?category=<?php echo $category; ?>&date=month"
                        class="side-btn <?php if($date=='month') echo 'active'; ?>">
                        This Month
                    </a>

                    </details>

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

                if($date == 'today')
                    echo " &gt; Today";
                elseif($date == 'week')
                    echo " &gt; This Week";
                elseif($date == 'month')
                    echo " &gt; This Month";

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
            <a href="eventdetails.php?id=<?php echo $row['event_id']; ?>&category=<?php echo $category; ?>&date=<?php echo $date; ?>">
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