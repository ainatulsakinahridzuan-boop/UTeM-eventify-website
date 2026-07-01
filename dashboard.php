<?php
include("connect.php");
$currentPage = "dashboard";

// Query to get total events
$sqlEvent = "SELECT COUNT(*) AS total FROM event";
$resultEvent = mysqli_query($conn, $sqlEvent);
$rowEvent = mysqli_fetch_assoc($resultEvent);
$totalEvents = $rowEvent['total'];

// Query to get total users
$sqlStudent = "SELECT COUNT(*) AS total FROM student";
$resultStudent = mysqli_query($conn, $sqlStudent);
$rowStudent = mysqli_fetch_assoc($resultStudent);
$totalUsers = $rowStudent['total'];

// Query to get upcoming events
$today = date("Y-m-d");

$sqlUpcoming = "SELECT COUNT(*) AS total
                FROM event
                WHERE event_date >= '$today'";

$resultUpcoming = mysqli_query($conn, $sqlUpcoming);
$rowUpcoming = mysqli_fetch_assoc($resultUpcoming);
$upcomingEvents = $rowUpcoming['total'];

// Query to get events overview
$today = date("Y-m-d");

$sqlEvents = "
SELECT *
FROM event
WHERE event_date >= '$today'
ORDER BY event_date ASC
LIMIT 5
";

$resultEvents = mysqli_query($conn, $sqlEvents);

$sqlGraph = "
SELECT
MONTH(registration_date) AS month,
COUNT(*) AS total
FROM registration
GROUP BY MONTH(registration_date)
ORDER BY MONTH(registration_date)
";

$resultGraph = mysqli_query($conn, $sqlGraph);

$months = [];
$registrations = [];

while ($row = mysqli_fetch_assoc($resultGraph)) {
    $months[] = date("M", mktime(0, 0, 0, $row['month'], 1));
    $registrations[] = $row['total'];
}

$sqlPie = "
    SELECT event_category,
    COUNT(*) total
    FROM event
    GROUP BY event_category
    ";

$resultPie = mysqli_query($conn, $sqlPie);

$category = [];
$count = [];

while ($row = mysqli_fetch_assoc($resultPie)) {
    $category[] = $row['event_category'];
    $count[] = $row['total'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>UTeM Eventify Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="dashboard.css">
    <link rel="stylesheet" href="sidebar.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<body>

    <div id="wrapper">

        <!-- SIDEBAR -->
        <?php include("sidebar.php") ?>

        <!-- CONTENT -->
        <main>

            <article>

                <h1>Welcome Admin!</h1>


                <!-- TOP BOX -->
                <div id="boxContainer">

                    <div class="box purpleBox">
                        <p>Total Events</p>
                        <h2><?php echo $totalEvents; ?></h2>
                    </div>

                    <div class="box greenBox">
                        <p>Registered Users</p>
                        <h2><?php echo $totalUsers; ?></h2>
                    </div>

                    <div class="box redBox">
                        <p>Upcoming Events</p>
                        <h2><?php echo $upcomingEvents; ?></h2>
                    </div>

                </div>


                <!-- GRAPH AREA -->
                <div id="graphContainer">

                    <div class="graphSection">

                        <div id="graphBox">

                            <h3>Registrations Overview</h3>

                            <canvas id="lineChart"></canvas>

                        </div>

                    </div>


                    <div class="graphSection">

                        <div id="pieChart">
                            <div class="sectionHeader">
                                <h3>Events Categories</h3>
                                <a href="report.php" class="viewReport">
                                    <span class="material-symbols-outlined">
                                        arrow_forward
                                    </span>
                                </a>
                            </div>

                            <canvas id="pieChartCanvas"></canvas>

                        </div>

                    </div>

                </div>


                <!-- EVENT LIST -->
                <div id="eventSection">

                    <h3>Events Overview</h3>

                    <div id="eventList">
                        <?php
                        while ($event = mysqli_fetch_assoc($resultEvents)) {
                        ?>
                            <div class="eventRow">

                                <div class="poster">
                                    <img src="poster/<?php echo $event['poster']; ?>" alt="">
                                </div>

                                <div class="eventInfo">
                                    <h2><?php echo $event['event_name']; ?></h2>

                                    <p>

                                        <span class="material-symbols-outlined">
                                            calendar_month
                                        </span>

                                        <?php echo date("d/m/Y", strtotime($event["event_date"])); ?>
                                    </p>

                                    <p>
                                        <span class="material-symbols-outlined">
                                            location_on
                                        </span>

                                        <?php echo $event["event_venue"]; ?>
                                    </p>
                                </div>

                                <div class="statusBtn">
                                    <?php

                                    $today = date("Y-m-d");

                                    if ($event['event_date'] > $today) {
                                        echo "<span class='upcomingStatus'>Upcoming</span>";
                                    } elseif ($event['event_date'] == $today) {
                                        echo "<span class='openStatus'>Open</span>";
                                    } else {
                                        echo "<span class='closedStatus'>Closed</span>";
                                    }

                                    ?>
                                </div>

                            </div>
                        <?php
                        }
                        ?>
                    </div>

                </div>

            </article>

        </main>

    </div>

    <script>
        const months = <?php echo json_encode($months); ?>;
        const registrations = <?php echo json_encode($registrations); ?>;


        new Chart(document.getElementById("lineChart"), {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Registrations',
                    data: registrations,
                    borderColor: '#6C63FF',
                    fill: false,
                    tension: 0.3,
                    pointRadius: 0
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });


        const category = <?php echo json_encode($category); ?>;
        const count = <?php echo json_encode($count); ?>;

        new Chart(document.getElementById("pieChartCanvas"), {
            type: 'pie',
            data: {
                labels: category,
                datasets: [{
                    data: count,
                    backgroundColor: [
                        "#6C63FF",
                        "#43A047",
                        "#EF5350",
                        "#FFA726"
                    ]
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>

</body>

</html>