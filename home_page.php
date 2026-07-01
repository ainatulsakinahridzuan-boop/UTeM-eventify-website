<?php 
session_start(); //sambung data login user
include("connect.php"); //sambung PHP dengan db

//UPCOMING EVENT - FEATURED EVENT
$featuredSql = "SELECT * FROM event 
                WHERE event_date >= CURDATE()
                ORDER BY event_date ASC 
                LIMIT 1";
$featuredResult = mysqli_query($conn, $featuredSql);
$featuredEvent = mysqli_fetch_assoc($featuredResult);

//LABEL DAYS LEFT
$today = new DateTime();
$eventDate = new DateTime($featuredEvent['event_date']);
    //kira how many days left before event start
    if($eventDate > $today)
        {
            $daysLeft = $today->diff($eventDate)->days;
            $label = $daysLeft . " Days Left";
        }
        else if ($eventDate->format('Y-m-d') == $today->format('Y-m-d'))
            {
                $label = "Today";
            }
            else
                {
                    $label = "Ended";
                }

//UPCOMING EVENT - DEFAULT EVENT
$upcomingSql= "SELECT * FROM event
                WHERE event_date >= CURDATE()
                ORDER BY event_date ASC
                LIMIT 4 OFFSET 1";
$upcomingResult= mysqli_query($conn, $upcomingSql);

//TRENDING NOW EVENT
$trendingSql = "SELECT * FROM event LIMIT 6";
$trendingResult = mysqli_query($conn,
"SELECT e.*, COUNT(r.registration_id) AS totalJoin
FROM event e
LEFT JOIN registration r
ON e.event_id = r.event_id
WHERE e.event_date >= CURDATE()
GROUP BY e.event_id
ORDER BY RAND()
LIMIT 6");

//RECOMMENDED EVENT
//display event yang user belum register
$studentEmail = $_SESSION['student_email'];
$recommendedSql = "
SELECT*
FROM event
WHERE event_date >=CURDATE()
AND event_id NOT IN
(
    SELECT event_id
    FROM registration
    WHERE student_email = '$studentEmail'
)
ORDER BY event_date ASC
LIMIT 6";
$recommendedResult = mysqli_query($conn, $recommendedSql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="home_page.css?v=17">
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
            <button class="categoryBtn active" >Featured</button>
            </a>

            <a href="university_wide.php">
            <button class="categoryBtn">University-Wide</button>
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
        <!--UPCOMING EVENTS-->
        <section class="upcomingEvents">

            <!--HEADER-->
            <div class="header">
                <h4>Upcoming Events</h4>

                <!--SEE MORE-->
                <a href="browse.php" class="arrowSymbol">See More<span class="material-symbols-outlined arrowSymbol">arrow_forward</span></a>
            </div>
            
        <!----------------------------------------------------------------------------------------------------->   
        <!--EVENT OVERVIEW-->
            <div class="eventCard">

                <!--FEATURED EVENT-->
                <div class="featuredEvent">

                    <!--POSTER FEATURED EVENT -->
                    <div class="featuredPoster">
                        <img src="poster/<?php echo $featuredEvent['poster']; ?>" alt="Event Poster">
                    </div>

                    <!--KOTAK SEMUA INFO FEATURED EVENT-->
                    <div class="featuredInfo">

                        <!--KOTAK INFO KELABU-->
                        <div class="featuredInfoGray">
                            <p class="flag">
                                <?php echo $label; ?>
                            </p>
                            <h4><?php echo $featuredEvent['event_name']; ?></h4>
                            
                            <!--DATE-->
                            <p class="infoF">
                                <span class="material-symbols-outlined dateSymbol">calendar_today</span>
                                <span class="infoText"><?php echo $featuredEvent['event_date']; ?></span>
                            </p>
                            
                            <!--VENUE-->
                            <p class="infoF">
                                <span class="material-symbols-outlined venueSymbol">location_on</span>
                                <span class="infoText"><?php echo $featuredEvent['event_venue']; ?></span>
                            </p>
                        </div>

                        <!--KOTAK INFO BIRU-->
                        <div class="featuredInfoBlue">
                            <p class="infoBlue">
                                <?php echo $featuredEvent['event_desc']; ?>
                            </p>
                            
                            <a href="eventdetails.php?id=<?php echo $featuredEvent['event_id']; ?>">
                                <button class="viewBtn">View Details</button>
                            </a>
                        </div>
                    </div>
                </div>
                

                <!----------------------------------------------------------------------------------------------------->
                <!--DEFAULT EVENT-->

                <?php while($event = mysqli_fetch_assoc($upcomingResult))
                { ?>
                <a href="eventdetails.php?id=<?php echo $event['event_id']; ?>" class="eventLink">
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
        </section>
        
        <!----------------------------------------------------------------------------------------------------->
        <!--TRENDING EVENTS-->
        <section class="trendingEvents">

            <!--HEADER-->
            <div class="header">
                <h4>Trending Now</h4>

                <!--SEE MORE-->
                <a href="browse.php" class="arrowSymbol">See More<span class="material-symbols-outlined arrowSymbol">arrow_forward</span></a>
            </div>

            <!----------------------------------------------------------------------------------------------------->
            <!--EVENT OVERVIEW-->
            <div class="eventCard">

                <?php  
                $tagList=["Closing Soon", 
                            "Limited Seats",
                            "Most Joined",
                            "Free Event",
                            "Popular"];
                $tagIndex = 0;
                while($event = mysqli_fetch_assoc($trendingResult))
                    {
                        $tagLabel = $tagList[$tagIndex];
                        $tagIndex++;

                        if($tagIndex>= count ($tagList))
                            {
                                $tagIndex=0;
                            }
                ?>

                        <a href="eventdetails.php?id=<?php echo $event['event_id']; ?>" class="eventLink">
                        <!--DEFAULT EVENT 1-->
                        <div class="defaultEvent">

                            <!--POSTER DEFAULT EVENT-->
                            <div class="defaultPoster">
                                <!--TAG-->
                                <p class="tag">
                                <span class="material-symbols-outlined starSymbol">star</span>
                                    <?php echo $tagLabel; ?>
                                </p>
                                <img src="poster/<?php echo $event['poster']; ?>" alt="Event Poster">

                            </div> 

                            <!--KOTAK INFO DEFAULT-->
                            <div class="defaultInfo">
                                    <!--NAMA EVENT-->
                                    <h4><?php echo $event['event_name']; ?></h4>

                                    <p class="infoD"> <!--NANTI DELETE!!-->
                                        <?php echo$event['totalJoin']; ?> Joined
                                    </p>
                                    
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
        </section>      
        <!----------------------------------------------------------------------------------------------------->
        <!--RECOMMENDED FOR YOU EVENTS-->
        <section class="recommendedEvents">

            <!--HEADER-->
            <div class="header">
                <h4>Recommended For You</h4>

                <!--SEE MORE-->
                <a href="browse.php" class="arrowSymbol">See More<span class="material-symbols-outlined arrowSymbol">arrow_forward</span></a>
            </div>
            
        <!----------------------------------------------------------------------------------------------------->  
        <!--EVENT OVERVIEW-->
            <div class="eventCard">

                <!--DEFAULT EVENT-->

                <?php while($event = mysqli_fetch_assoc($recommendedResult))
                { ?>
                <a href="eventdetails.php?id=<?php echo $event['event_id']; ?>" class="eventLink">
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
        </section>

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
</html><!--HTML ENDS HERE-->  