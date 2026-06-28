<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="sidebar.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <title>Sidebar Utem Eventify</title>
</head>

<body>
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

                    <li>
                        <a class="<?php echo ($currentPage == "dashboard") ? "activePage" : ""; ?>"
                            href="dashboard.php">
                            Dashboard
                        </a>
                    </li>

                    <li>
                        <a class="<?php echo ($currentPage == "event") ? "activePage" : ""; ?>"
                            href="event.php">
                            Events
                        </a>
                    </li>

                    <li>
                        <a class="<?php echo ($currentPage == "user") ? "activePage" : ""; ?>"
                            href="user.php">
                            Users
                        </a>
                    </li>

                    <li>
                        <a class="<?php echo ($currentPage == "registration") ? "activePage" : ""; ?>"
                            href="registrationDetails.php">
                            Registration
                        </a>
                    </li>

                    <li>
                        <a class="<?php echo ($currentPage == "attendance") ? "activePage" : ""; ?>"
                            href="attendance.php">
                            Attendance
                        </a>
                    </li>

                    <li>
                        <a class="<?php echo ($currentPage == "report") ? "activePage" : ""; ?>"
                            href="report.php">
                            Reports
                        </a>
                    </li>

                </ul>

            </div>

        </div>

        <div id="signOut">
            <button type="button" onclick="window.location.href='login.html'">
                Sign Out
            </button>
        </div>

    </nav>
</body>

</html>