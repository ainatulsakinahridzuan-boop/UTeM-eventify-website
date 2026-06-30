<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="faculty.css?v=3">
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
            <button class="categoryBtn active">Faculty</button>
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
                
                <!--FTKEK-->
                <div class="defaultEvent">

                    <!--GAMBAR FACULTY-->
                    <div class="defaultPoster">
                        <img src="image/ftkek.jpeg" alt="FTKEK">
                    </div> 

                    <!--KOTAK INFO DEFAULT-->
                    <div class="defaultInfo">
                            <!--NAMA EVENT-->
                            <h4>FACULTY OF ELECTRONICS AND COMPUTER TECHNOLOGY AND ENGINEERING (FTKEK)</h4>
                    </div>
                </div>

                <!----------------------------------------------------------------------------------------------------->
                <!--FTKE-->
                <div class="defaultEvent">

                    <!--GAMBAR FACULTY-->
                    <div class="defaultPoster">
                        <img src="image/ftke.jpeg" alt="FTKE">
                    </div> 

                    <!--KOTAK INFO DEFAULT-->
                    <div class="defaultInfo">
                            <!--NAMA EVENT-->
                            <h4>FACULTY OF ELECTRICAL TECHNOLOGY AND ENGINEERING (FTKE)</h4>
                    </div>
                </div>

                <!----------------------------------------------------------------------------------------------------->
                <!--FTKM-->
                <div class="defaultEvent">

                    <!--GAMBAR FACULTY-->
                    <div class="defaultPoster">
                        <img src="image/ftkm.jpeg" alt="FTKM">
                    </div> 

                    <!--KOTAK INFO DEFAULT-->
                    <div class="defaultInfo">
                            <!--NAMA EVENT-->
                            <h4>FACULTY OF MECHNICAL TECHNOLOGY AND ENGINEERING (FTKM)</h4>
                    </div>
                </div>

                <!----------------------------------------------------------------------------------------------------->
                <!--FTKIP-->
                <div class="defaultEvent">

                    <!--GAMBAR FACULTY-->
                    <div class="defaultPoster">
                        <img src="image/ftkip.jpeg" alt="FTKIP">
                    </div> 

                    <!--KOTAK INFO DEFAULT-->
                    <div class="defaultInfo">
                            <!--NAMA EVENT-->
                            <h4>FACULTY OF INDUSTRIAL AND MANUFACTURING TECHNOLOGY AND ENGINEERING (FTKIP)</h4>
                    </div>
                </div>

                <!----------------------------------------------------------------------------------------------------->
                <!--FTMK-->
                <div class="defaultEvent">

                    <!--GAMBAR FACULTY-->
                    <div class="defaultPoster">
                        <img src="image/ftmk.jpeg" alt="FTMK">
                    </div> 

                    <!--KOTAK INFO DEFAULT-->
                    <div class="defaultInfo">
                            <!--NAMA EVENT-->
                            <h4>FACULTY OF INFORMATION AND COMMUNICATIONS TECHNOLOGY (FTMK)</h4>
                    </div>
                </div>

                <!----------------------------------------------------------------------------------------------------->
                <!--FAIX-->
                <div class="defaultEvent">

                    <!--GAMBAR FACULTY-->
                    <div class="defaultPoster">
                        <img src="image/faix.jpeg" alt="FAIX">
                    </div> 

                    <!--KOTAK INFO DEFAULT-->
                    <div class="defaultInfo">
                            <!--NAMA EVENT-->
                            <h4>FACULTY OF ARTIFICIAL INTELLIGENCE AND CYBER SECURITY (FAIX)</h4>
                    </div>
                </div>

                <!----------------------------------------------------------------------------------------------------->
                <!--FPTT-->
                <div class="defaultEvent">

                    <!--GAMBAR FACULTY-->
                    <div class="defaultPoster">
                        <img src="image/fptt.jpeg" alt="FPTT">
                    </div> 

                    <!--KOTAK INFO DEFAULT-->
                    <div class="defaultInfo">
                            <!--NAMA EVENT-->
                            <h4>FACULTY OF TECHNOLOGY MANAGEMENT AND TECHNOPRENEURSHIP (FPTT)</h4>
                    </div>
                </div>

                <!----------------------------------------------------------------------------------------------------->
                <!--PPB-->
                <div class="defaultEvent">

                    <!--GAMBAR FACULTY-->
                    <div class="defaultPoster">
                        <img src="image/ppb.jpeg" alt="PPB">
                    </div> 

                    <!--KOTAK INFO DEFAULT-->
                    <div class="defaultInfo">
                            <!--NAMA EVENT-->
                            <h4>SCHOOL OF INTERNATIONAL STUDIES AND GLOBAL LANGUAGES</h4>
                    </div>
                </div>
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
