<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="college.css?v=3">
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
            <button class="categoryBtn">University-Wide</button>
            </a>

            <a href="faculty.php">
            <button class="categoryBtn">Faculty</button>
            </a>

            <a href="college.php">
            <button class="categoryBtn">Residential College</button>
            </a>

            <a href="club_society.php">
            <button class="categoryBtn active">Club / Society</button>
            </a>
        </section>
        
        <!----------------------------------------------------------------------------------------------------->
        <!--EVENT OVERVIEW-->
            <div class="eventCard">
                
                <!--ACADEMIC//CAREER-->
                <a href="browse.php?category=club&sub=Academic%20%26%20Career" class="cardLink">
                <div class="defaultEvent">

                    <!--GAMBAR CLUB-->
                    <div class="defaultPoster">
                        <img src="image/academic.png" alt="Academic and Career">
                    </div> 

                    <!--KOTAK INFO DEFAULT-->
                    <div class="defaultInfo">
                            <!--NAMA CLUB-->
                            <h4>ACADEMIC AND<br>CAREER</h4>
                    </div>
                </div>
                </a>

                <!----------------------------------------------------------------------------------------------------->
                <!--LEADERSHIP//MANAGEMENT-->
                <a href="browse.php?category=club&sub=Leadership%20%26%20Management" class="cardLink">
                <div class="defaultEvent">

                    <!--GAMBAR CLUB-->
                    <div class="defaultPoster">
                        <img src="image/leadership.png" alt="Leadership and Management">
                    </div> 

                    <!--KOTAK INFO DEFAULT-->
                    <div class="defaultInfo">
                            <!--NAMA CLUB-->
                            <h4>LEADERSHIP AND<br>MANAGEMENT</h4>
                    </div>
                </div>
                </a>

                <!----------------------------------------------------------------------------------------------------->
                <!--VOLUNTEERISM-->
                <a href="browse.php?category=club&sub=Volunteerism" class="cardLink">
                <div class="defaultEvent">

                    <!--GAMBAR CLUB-->
                    <div class="defaultPoster">
                        <img src="image/volunteerism.png" alt="Volunteerism">
                    </div> 

                    <!--KOTAK INFO DEFAULT-->
                    <div class="defaultInfo">
                            <!--NAMA ClUB-->
                            <h4>VOLUNTEERISM</h4>
                    </div>
                </div>
                </a>

                <!----------------------------------------------------------------------------------------------------->
                <!--SPORTS//RECREATIONAL-->
                <a href="browse.php?category=club&sub=Sports%20%26%20Recreation" class="cardLink">
                <div class="defaultEvent">

                    <!--GAMBAR CLUB-->
                    <div class="defaultPoster">
                        <img src="image/sports.png" alt="Sports and Recretional">
                    </div> 

                    <!--KOTAK INFO DEFAULT-->
                    <div class="defaultInfo">
                            <!--NAMA ClUB-->
                            <h4>SPORTS AND<br>RECRETIONAL</h4>
                    </div>
                </div>
                </a>

                <!----------------------------------------------------------------------------------------------------->
                <!--CULTURE//NATIONAL IDENTITY-->
                <a href="browse.php?category=club&sub=Culture%20%26%20National%20Identity" class="cardLink">
                <div class="defaultEvent">

                    <!--GAMBAR CLUB-->
                    <div class="defaultPoster">
                        <img src="image/culture.png" alt="Culture and National Identity">
                    </div> 

                    <!--KOTAK INFO DEFAULT-->
                    <div class="defaultInfo">
                            <!--NAMA ClUB-->
                            <h4>CULTURE AND<br>NATIONAL IDENTITY</h4>
                    </div>
                </div>
                </a>
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
</html><!--HTML ENDS HERE-->    
