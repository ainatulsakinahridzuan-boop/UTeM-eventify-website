<?php
session_start();
include("connect.php");

//UNIWIDE
$uniwideSql="
SELECT *
FROM event
WHERE event_category='University-Wide'
AND event_date >= CURDATE()
";

$uniwideResult= mysqli_query($conn, $uniwideSql);

if (!$uniwideResult)
    {
        die("University-Wide query failed: " . mysqli_error($conn));
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="university_wide.css?v=17">
    <title>UTeM Eventify</title>
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
            <input type="text" id="searchInput" placeholder="Search Events...">
            <div id="searchResult"></div>        
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
            <a href="profile.php">
            <span class="material-symbols-outlined profileSymbol">account_circle</span>
            </a>
        </div>
    </nav>

    <!--BANNER-->
     <div id="banner">
        <h1>Never Miss What's Happening at UTeM</h1>
        <h5>All campus events in one place - discover, join and stay connected</h5>
        
        <!--BUTTON BROWSE EVENT-->
        <a href="browse.php">
        <button id ="browseEventBtn">Browse Event</button>
        </a>
    </div>

<!--------------------------------------------------------------------------------------------------->
    <!--MAIN-->
    <div id="main">

        <!--CATEGORY SECTION-->
        <section class="category">
            <a href="home_page.php">
            <button class="categoryBtn" >Featured</button>
            </a>

            <a href="university_wide.php">
            <button class="categoryBtn active">University-Wide</button>
            </a>

            <a href="faculty.php">
            <button class="categoryBtn">Faculty</button>
            </a>

            <a href="college.php">
            <button class="categoryBtn">Residential College</button>
            </a>

            <a href="club_society.php">
            <button class="categoryBtn">Club / Society</button>
            </a>
        </section>
        
        <!----------------------------------------------------------------------------------------------------->
        <!--EVENT OVERVIEW-->
            <div class="eventCard">
                
            <?php
            if(mysqli_num_rows($uniwideResult)==0)
                {
                    echo"<p>No University-Wide events available at the moment. </p>";
                }
                while ($event= mysqli_fetch_assoc($uniwideResult))
                    {
                        ?>
                        <a href="eventdetails.php?id=<?php echo $event['event_id']; ?>" class="eventLink">
                        <!--DEFAULT EVENT-->
                        <div class="defaultEvent">

                            <!--POSTER DEFAULT EVENT-->
                            <div class="defaultPoster">
                                <img src="poster/<?php echo $event['poster']; ?>" alt="Event Poster">
                            </div> 

                            <!--KOTAK INFO DEFAULT-->
                            <div class="defaultInfo">
                                    <!--NAMA EVENT-->
                                    <h4><?php echo $event['event_name']; ?></h4>
                                    
                                    <!--DATE-->
                                    <p class="infoD">
                                        <span class="material-symbols-outlined dateSymbol">calendar_today</span>
                                        <span class="infoText"><?php echo $event['event_date']; ?></span>
                                    </p>
                                    
                                    <!--VENUE-->
                                    <p class="infoD">
                                        <span class="material-symbols-outlined venueSymbol">location_on</span>
                                        <span class="infoText"><?php echo $event['event_venue']; ?></span>
                                    </p>
                            </div>
                        </div>
                        </a>
                <?php } ?>
            </div>    
    </div> <!--MAIN PUNYA-->

<!--JS STARTS HERE-->
 <script>

    document.getElementById("searchInput").addEventListener("keyup", function()
    {
        let keyword = this.value;

        if(keyword.length === 0)
        {
            document.getElementById("searchResult").style.display="none";
            document.getElementById("searchResult").innerHTML="";
            return;
        }

        fetch("live_search.php?keyword=" +keyword)
        .then(response => response.text())
        .then(data =>
            {
                document.getElementById("searchResult").style.display="block";
                document.getElementById("searchResult").innerHTML=data;
            });
    });


</script>
</body>
</html> <!--HTML ENDS HERE-->
