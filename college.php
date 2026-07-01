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
            <button class="categoryBtn active">Residential College</button>
            </a>

            <a href="club_society.php">
            <button class="categoryBtn">Club / Society</button>
            </a>
        </section>
        
        <!----------------------------------------------------------------------------------------------------->
        <!--EVENT OVERVIEW-->
            <div class="eventCard">
                
                <!--TUAH-->
                <div class="defaultEvent">

                    <!--GAMBAR COLLEGE-->
                    <div class="defaultPoster">
                        <img src="image/tuah.jpg" alt="TUAH">
                    </div> 

                    <!--KOTAK INFO DEFAULT-->
                    <div class="defaultInfo">
                            <!--NAMA KOLEJ-->
                            <h4>KOLEJ KEDIAMAN SATRIA<br>(TUAH)</h4>
                    </div>
                </div>

                <!----------------------------------------------------------------------------------------------------->
                <!--JEBAT-->
                <div class="defaultEvent">

                    <!--GAMBAR COLLEGE-->
                    <div class="defaultPoster">
                        <img src="image/jebat.jpg" alt="JEBAT">
                    </div> 

                    <!--KOTAK INFO DEFAULT-->
                    <div class="defaultInfo">
                            <!--NAMA KOLEJ-->
                            <h4>KOLEJ KEDIAMAN SATRIA<br>(JEBAT)</h4>
                    </div>
                </div>

                <!----------------------------------------------------------------------------------------------------->
                <!--LEKIR-->
                <div class="defaultEvent">

                    <!--GAMBAR COLLEGE-->
                    <div class="defaultPoster">
                        <img src="image/lekir.jpg" alt="LEKIR">
                    </div> 

                    <!--KOTAK INFO DEFAULT-->
                    <div class="defaultInfo">
                            <!--NAMA KOLEJ-->
                            <h4>KOLEJ KEDIAMAN SATRIA<br>(LEKIR)</h4>
                    </div>
                </div>

                <!----------------------------------------------------------------------------------------------------->
                <!--LEKIU-->
                <div class="defaultEvent">

                    <!--GAMBAR COLLEGE-->
                    <div class="defaultPoster">
                        <img src="image/lekiu.jpg" alt="LEKIU">
                    </div> 

                    <!--KOTAK INFO DEFAULT-->
                    <div class="defaultInfo">
                            <!--NAMA KOLEJ-->
                            <h4>KOLEJ KEDIAMAN SATRIA<br>(LEKIU)</h4>
                    </div>
                </div>

                <!----------------------------------------------------------------------------------------------------->
                <!--KASTURI-->
                <div class="defaultEvent">

                    <!--GAMBAR COLLEGE-->
                    <div class="defaultPoster">
                        <img src="image/kasturi.jpg" alt="KASTURI">
                    </div> 

                    <!--KOTAK INFO DEFAULT-->
                    <div class="defaultInfo">
                            <!--NAMA KOLEJ-->
                            <h4>KOLEJ KEDIAMAN SATRIA<br>(KASTURI)</h4>
                    </div>
                </div>

                <!----------------------------------------------------------------------------------------------------->
                <!--LESTARI-->
                <div class="defaultEvent">

                    <!--GAMBAR COLLEGE-->
                    <div class="defaultPoster">
                        <img src="image/lestari.jpg" alt="LESTARI">
                    </div> 

                    <!--KOTAK INFO DEFAULT-->
                    <div class="defaultInfo">
                            <!--NAMA KOLEJ-->
                            <h4>KOLEJ KEDIAMAN LESTARI</h4>
                    </div>
                </div>

                <!----------------------------------------------------------------------------------------------------->
                <!--AL JAZARI-->
                <div class="defaultEvent">

                    <!--GAMBAR COLLEGE-->
                    <div class="defaultPoster">
                        <img src="image/aj.jpg" alt="AL-JAZARI">
                    </div> 

                    <!--KOTAK INFO DEFAULT-->
                    <div class="defaultInfo">
                            <!--NAMA EVENT-->
                            <h4>KOLEH KEDIAMAN AL-JAZARI</h4>
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
</html><!--HTML ENDS HERE-->    
