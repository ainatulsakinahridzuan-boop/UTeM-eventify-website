<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="registeredEvent.css">
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

            <!--DROP DOWN-->
            <div id="dropdownBtn">
                <span>User Profile Management</span>
                <span class="material-symbols-outlined dropdownSymbol">
                    arrow_drop_down                    
                </span>
            </div>
            
            <!--MENU-->
            <div id="menu">
                <ul>
                    <li><a href="profile.html" class="notActive">Profile</a></li>
                    <li><a href="registeredEvent.html" class="active">Registered Event</a></li> <!--HTML BELUM BUAT-->
                </ul>
            </div>

            <!--SIGN OUT-->
            <div id="signOut">
                <button type="button" onclick="window.location.href='login.html'">
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

                <!--SEARCH-->
                <div class="searchBox">
                    <span class="material-symbols-outlined searchSymbol">
                        search
                    </span>
                    <input type="text" placeholder="Search Events....">
                </div>

                <!--FILTER BUTTON-->
                <div class="filterBtnGroup">
                    <button class="filterBtn activeFilter">All</button>
                    <button class="filterBtn">Upcoming</button>
                    <button class="filterBtn">Past</button>
                </div>

                <!--TABLE-->
                <table>
                    <tr> 
                        <th>EVENT NAME</th>
                        <th>DATE</th>
                        <th>ACTION</th>
                        <th>ATTENDANCE</th>
                    </tr>

                    <!--EVENT 1 CHECK IN-->
                    <tr>
                        <td>UTeM Tech Talk 2026</td>
                        <td>12 May 2026</td>
                        <td><button class="viewBtn">View Details</button></td>
                        <td><a href="attendance.html"><button class="checkInBtn">Check-In</button></a></td>
                    </tr>

                    <!--EVENT 2 ABSENT-->
                    <tr>
                        <td>Event Name</td>
                        <td>Date</td>
                        <td><button class="viewBtn">View Details</button></td>
                        <td><button class="absentBtn">Absent</button></td>
                    </tr>

                    <!--EVENT 3 DAH ATTENDED-->
                    <tr>
                        <td>Event Name</td>
                        <td>Date</td>
                        <td><button class="viewBtn">View Details</button></td>
                        <td><button class="attendedBtn">Attended</button></td>
                    </tr>

                    <!--EVENT 4 CHECK IN-->
                    <tr>
                        <td>Event Name</td>
                        <td>Date</td>
                        <td><button class="viewBtn">View Details</button></td>
                        <td><a href="attendance.html"><button class="checkInBtn">Check-In</button></a></td>
                    </tr>

                    <!--EVENT 5 CHECK IN-->
                    <tr>
                        <td>Event Name</td>
                        <td>Date</td>
                        <td><button class="viewBtn">View Details</button></td>
                        <td><a href="attendance.html"><button class="checkInBtn">Check-In</button></a></td>
                    </tr>
                </table>

                <!--PAGE-->
                <div class="page">
                    <button>&lt</button>
                    <button class="pageActive">1</button>
                    <button>2</button>
                    <button>3</button>
                    <button>&gt</button>
                </div>

            </div> <!--REGISTERED CARD PUNYA-->
        </div> <!--MAIN PUNYA-->




<!--JS STARTS HERE-->
<script>
    const dropdownBtn = document.getElementById("dropdownBtn");
    const menu = document.getElementById("menu");
    const arrow = document.querySelector(".dropdownSymbol");

    //hide menu bila tekan button drop down
    dropdownBtn.addEventListener("click", function(){
    menu.classList.toggle("hideMenu");
    arrow.classList.toggle("rotate");
    })
</script>
</body>
</html>