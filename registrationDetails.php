<!DOCTYPE html>
<html lang="en">

<head>
    <title>UTeM Eventify Registration Management</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="registrationDetails.css">
    <!--GOOGLE ICON-->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>

<body>

    <div id="wrapper">

        <!-- SIDEBAR -->
        <nav id="sidebar">

            <div>

                <div id="logoSection">
                    <img src="image/logo.png" alt="logo">
                    <div id="logoText">
                        <span>UTeM</span>
                        <span>Eventify</span>
                    </div>
                </div>

                <div id="menu">

                    <ul>

                        <li><a href="dashboard.html">Dashboard</a></li>
                        <li><a href="event.html">Events</a></li>
                        <li><a href="user.html">Users</a></li>

                        <li><a class="activePage" href="registrationDetails.html">
                                Registration</a>
                        </li>

                        <li><a href="attendance.html">Attendance</a></li>
                        <li><a href="report.html">Reports</a></li>

                    </ul>

                </div>

            </div>

            <div id="signOut">
                <button type="button" onclick="window.location.href='login.html'">
                    Sign Out
                </button>
            </div>

        </nav>

        <!-- CONTENT -->
        <main>

            <article>

                <div id="topContainer">
                    <div id="topSection">

                        <div>
                            <h1>Event Management</h1>
                            <p>View and manage all events</p>
                        </div>
                    </div>



                    <div id="searchSection">

                        <div id="searchBox">

                            <span class="material-symbols-outlined search">
                                search
                            </span>
                            <input type="text" placeholder="Search User">

                        </div>

                        <div id="filterSection">

                            <select id="filter" name="filter" size="1">
                                <option value="All Events">All Events</option>
                                <option value="University-Wide">University-Wide</option>
                                <optgroup label="Faculty">
                                    <option value="FTKEK">FTKEK</option>
                                    <option value="FTKE">FTKE</option>
                                    <option value="FTKM">FTKM</option>
                                    <option value="FTKIP">FTKIP</option>
                                    <option value="FTMK">FTMK</option>
                                    <option value="FAIX">FAIX</option>
                                    <option value="FPTT">FPTT</option>
                                    <option value="SCHOOL OF INTERNATIONAL STUDIES AND GLOBAL LANGUAGES">SCHOOL OF
                                        INTERNATIONAL STUDIES AND GLOBAL LANGUAGES</option>
                                    <option value="SPS">SPS</option>
                                    <option value="IPTK">IPTK</option>
                                </optgroup>
                                <optgroup label="Residential Colleges">
                                    <option value="KOLEJ KEDIAMAN LESTARI">KOLEJ KEDIAMAN LESTARI</option>
                                    <option value="KOLEJ KEDIAMAN AL-JAZARI">KOLEJ KEDIAMAN AL-JAZARI</option>
                                    <option value="KOLEJ KEDIAMAN SATRIA TUAH">KOLEJ KEDIAMAN SATRIA TUAH</option>
                                    <option value="KOLEJ KEDIAMAN SATRIA JEBAT">KOLEJ KEDIAMAN SATRIA JEBAT</option>
                                    <option value="KOLEJ KEDIAMAN SATRIA KASTURI">KOLEJ KEDIAMAN SATRIA KASTURI</option>
                                    <option value="KOLEJ KEDIAMAN SATRIA LEKIR">KOLEJ KEDIAMAN SATRIA LEKIR</option>
                                    <option value="KOLEJ KEDIAMAN SATRIA LEKIU">KOLEJ KEDIAMAN SATRIA LEKIU</option>
                                </optgroup>
                            </select>

                        </div>

                    </div>
                </div>

                <div id="tableSection">

                    <table>


                        <tr>
                            <th>POSTER</th>
                            <th>EVENT NAME</th>
                            <th>STATUS</th>
                            <th>CATEGORIES</th>
                            <th></th>
                        </tr>

                        <tr>
                            <td>
                                <div class="poster">EVENT IMAGE</div>
                            </td>
                            <td>
                                <div class="eventInfo">
                                    <h4>UTeM Tech Talk 2026</h4>
                                    <p>12 May 2026</p>
                                </div>
                            </td>
                            <td>
                                <div class="status"><span class="openStatus">Open</span></div>
                            </td>
                            <td>
                                <div class="category">University-Wide</div>
                            </td>
                            <td>
                                <div class="arrow"> <a href="backToRegistrationDetails.html"> <span
                                            class="material-symbols-outlined">
                                            arrow_menu_open </span>
                                    </a> </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="poster">EVENT IMAGE</div>
                            </td>
                            <td>
                                <div class="eventInfo">
                                    <h4>Event Name</h4>
                                    <p>Date</p>
                                </div>
                            </td>
                            <td>
                                <div class="status"><span class="openStatus">Open</span></div>
                            </td>
                            <td>
                                <div class="category">Category</div>
                            </td>
                            <td>
                                <div class="arrow"> <a href="backToRegistrationDetails.html"> <span
                                            class="material-symbols-outlined">
                                            arrow_menu_open </span>
                                    </a> </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="poster">EVENT IMAGE</div>
                            </td>
                            <td>
                                <div class="eventInfo">
                                    <h4>Event Name</h4>
                                    <p>Date</p>
                                </div>
                            </td>
                            <td>
                                <div class="status"><span class="openStatus">Open</span></div>
                            </td>
                            <td>
                                <div class="category">Category</div>
                            </td>
                            <td>
                                <div class="arrow"> <a href="backToRegistrationDetails.html"> <span
                                            class="material-symbols-outlined">
                                            arrow_menu_open </span>
                                    </a> </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="poster">EVENT IMAGE</div>
                            </td>
                            <td>
                                <div class="eventInfo">
                                    <h4>Event Name</h4>
                                    <p>Date</p>
                                </div>
                            </td>
                            <td>
                                <div class="status"><span class="openStatus">Open</span></div>
                            </td>
                            <td>
                                <div class="category">Category</div>
                            </td>
                            <td>
                                <div class="arrow"> <a href="backToRegistrationDetails.html"> <span
                                            class="material-symbols-outlined">
                                            arrow_menu_open </span>
                                    </a> </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="poster">EVENT IMAGE</div>
                            </td>
                            <td>
                                <div class="eventInfo">
                                    <h4>Event Name</h4>
                                    <p>Date</p>
                                </div>
                            </td>
                            <td>
                                <div class="status"><span class="openStatus">Open</span></div>
                            </td>
                            <td>
                                <div class="category">Category</div>
                            </td>
                            <td>
                                <div class="arrow"> <a href="backToRegistrationDetails.html"> <span
                                            class="material-symbols-outlined">
                                            arrow_menu_open </span>
                                    </a> </div>
                            </td>
                        </tr>

                    </table>

                    <!--BUTTON-->
                    <div id="pageNumberSection">

                        <button class="pageBtn">
                            <span class="material-symbols-outlined arrowback">
                                arrow_back
                            </span>
                        </button>

                        <button class="pageNumber activeNumber">1</button>
                        <button class="pageNumber">2</button>
                        <button class="pageNumber">3</button>

                        <button class="pageBtn">
                            <span class="material-symbols-outlined arrowforward">
                                arrow_forward
                            </span>
                        </button>

                    </div>

                </div>

            </article>

        </main>
</body>

</html>