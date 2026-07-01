<?php
include("connect.php");
$currentPage = "report";

//FILTER YEAR & MONTH


$selectedYear = isset($_GET['year']) ? $_GET['year'] : date("Y");
$selectedMonth = isset($_GET['month']) ? $_GET['month'] : "";

$where = "WHERE YEAR(event.event_date) = '$selectedYear'";

if ($selectedMonth != "") {
    $where .= " AND MONTH(event.event_date) = '$selectedMonth'";
}



// LINE CHART Registration VS Attendance

$months = [];
$registrationData = [];
$attendanceData = [];

if ($selectedMonth == "") {

    // ===== ALL MONTHS =====
    $sqlTrend = "
    SELECT
        MONTH(event.event_date) AS label,
        COUNT(registration.registration_id) AS total_registration,
        SUM(
            CASE
            WHEN registration.attendance_status='Present'
            THEN 1
            ELSE 0
            END
        ) AS total_attendance

    FROM event
    LEFT JOIN registration
    ON event.event_id = registration.event_id

    $where

    GROUP BY MONTH(event.event_date)
    ORDER BY MONTH(event.event_date)
    ";
} else {

    // ===== SELECTED MONTH =====
    $sqlTrend = "
    SELECT
        event.event_name AS label,
        COUNT(registration.registration_id) AS total_registration,
        SUM(
            CASE
            WHEN registration.attendance_status='Present'
            THEN 1
            ELSE 0
            END
        ) AS total_attendance

    FROM event
    LEFT JOIN registration
    ON event.event_id = registration.event_id

    $where

    GROUP BY event.event_id
    ORDER BY event.event_date
    ";
}

$resultTrend = mysqli_query($conn, $sqlTrend);

while ($row = mysqli_fetch_assoc($resultTrend)) {

    $months[] = $row['label'];

    $registrationData[] = $row['total_registration'];

    $attendanceData[] = $row['total_attendance'];
}



//PIE CHART

$pieLabel = [];
$pieData = [];

$sqlPie = "

SELECT

event_category,

COUNT(*) total

FROM event

$where

GROUP BY event_category

";

$resultPie = mysqli_query($conn, $sqlPie);

while ($row = mysqli_fetch_assoc($resultPie)) {

    $pieLabel[] = $row['event_category'];

    $pieData[] = $row['total'];
}

//EVENT SUMMARY TABLE

$sqlSummary = "

SELECT

event.event_id,

event.event_name,

event.event_date,

event.event_category,

COUNT(registration.registration_id) AS total_registration,

SUM(

CASE

WHEN registration.attendance_status='Present'

THEN 1

ELSE 0

END

) AS total_attendance

FROM event

LEFT JOIN registration

ON event.event_id=registration.event_id

$where

GROUP BY event.event_id

ORDER BY event.event_date DESC

";

$resultSummary = mysqli_query($conn, $sqlSummary);

//CONVERT TO JSON

$monthJSON = json_encode($months);

$registrationJSON = json_encode($registrationData);

$attendanceJSON = json_encode($attendanceData);

$pieLabelJSON = json_encode($pieLabel);

$pieDataJSON = json_encode($pieData);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>UTeM Eventify Report and Analytics</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="report.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <div id="wrapper">

        <!-- SIDEBAR -->
        <?php include("sidebar.php") ?>

        <!-- CONTENT -->
        <main>

            <article>

                <div id="topContainer">
                    <div id="topSection">

                        <div>
                            <h1>Report & Analytics</h1>
                            <p>Monitor event performance</p>
                        </div>

                        <a href="exportReport.php?year=<?php echo $selectedYear; ?>&month=<?php echo $selectedMonth; ?>">
                            <button id="exportBtn">Export Excel</button>
                        </a>
                    </div>

                    <form method="GET">

                        <div id="filterSection">

                            <div class="filterBox">

                                <label>Year</label>

                                <select
                                    name="year"
                                    onchange="this.form.submit()">

                                    <?php

                                    for ($i = 2026; $i >= 2025; $i--) {

                                    ?>

                                        <option value="<?php echo $i; ?>"
                                            <?php
                                            if ($selectedYear == $i)
                                                echo "selected";
                                            ?>>
                                            <?php echo $i; ?>
                                        </option>

                                    <?php } ?>
                                </select>
                            </div>

                            <div class="filterBox">

                                <label>Month</label>

                                <select
                                    name="month"
                                    onchange="this.form.submit()">

                                    <option value="">

                                        All Months

                                    </option>

                                    <?php

                                    $monthName = array(

                                        1 => "January",

                                        "February",

                                        "March",

                                        "April",

                                        "May",

                                        "June",

                                        "July",

                                        "August",

                                        "September",

                                        "October",

                                        "November",

                                        "December"

                                    );

                                    foreach ($monthName as $number => $name) {

                                    ?>

                                        <option

                                            value="<?php echo $number; ?>"

                                            <?php

                                            if ($selectedMonth == $number)

                                                echo "selected";

                                            ?>>

                                            <?php echo $name; ?>

                                        </option>

                                    <?php

                                    }

                                    ?>

                                </select>


                            </div>

                        </div>
                    </form>

                </div>

                <!-- GRAPH AREA -->
                <div id="graphContainer">

                    <div class="graphSection">

                        <div id="graphBox">

                            <h3>Registrations and Attendance Overview</h3>

                            <canvas
                                id="lineChart">
                            </canvas>

                        </div>

                    </div>


                    <div class="pieWrapper">

                        <h3>Event Category Distribution</h3>

                        <div class="pieContent">

                            <div class="pieBox">
                                <canvas id="pieChart"></canvas>
                            </div>

                            <div id="categoryResult">
                                <h3>Click Pie Chart</h3>
                                <ul id="resultList"></ul>
                            </div>

                        </div>

                    </div>
                </div>

                <!-- EVENT LIST -->
                <div id="tableSection" border="1">

                    <h3>Event Summaries</h3>
                    <p>List of all events based on selected year and month.</p>

                    <div class="tableWrapper">
                        <table>

                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Event Name</th>
                                    <th>Date</th>
                                    <th>Category</th>
                                    <th>Registration</th>
                                    <th>Attendance</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $no = 1;
                                if (mysqli_num_rows($resultSummary) > 0) {
                                    while ($row = mysqli_fetch_assoc($resultSummary)) {
                                ?>

                                        <tr>

                                            <td>
                                                <?php echo $no; ?>
                                            </td>

                                            <td>
                                                <?php echo $row['event_name']; ?>
                                            </td>

                                            <td>
                                                <?php
                                                echo date(
                                                    "d M Y",
                                                    strtotime($row['event_date'])
                                                );
                                                ?>
                                            </td>

                                            <td>
                                                <?php echo $row['event_category']; ?>
                                            </td>

                                            <td>
                                                <?php
                                                echo $row['total_registration'];
                                                ?>
                                            </td>

                                            <td>
                                                <?php
                                                echo $row['total_attendance'];
                                                ?>
                                            </td>
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="6"
                                            style="text-align:center; padding:25px;">
                                            No event found.
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </article>
        </main>
    </div>

    <script>
        // LINE CHART
        new Chart(document.getElementById("lineChart"), {
            type: 'line',
            data: {
                labels: <?= $monthJSON ?>,
                datasets: [{
                        label: "Registration",
                        data: <?= $registrationJSON ?>,
                        borderColor: "#6C63FF",
                        backgroundColor: "transparent",
                        fill: false,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        tension: 0.3,
                        spanGaps: true
                    },
                    {
                        label: "Attendance",
                        data: <?= $attendanceJSON ?>,
                        borderColor: "#FF6B6B",
                        backgroundColor: "transparent",
                        fill: false,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        tension: 0.3,
                        spanGaps: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,

                scales: {

                    x: {
                        ticks: {

                            font: {
                                size: 11
                            },

                            maxRotation: 0,
                            minRotation: 0,

                            callback: function(value) {

                                let label = this.getLabelForValue(value);

                                // Pecahkan nama event ikut ruang
                                return label.split(" ");

                            }
                        }
                    },

                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }

                },

                plugins: {

                    legend: {
                        position: 'bottom',

                        labels: {
                            display: true,
                            boxWidth: 10,
                            padding: 10,
                            font: {
                                size: 11
                            }
                        }

                    }

                }

            }
        });

        // ================= PIE CHART =================
        const pieLabel = <?= $pieLabelJSON ?>;
        const pieData = <?= $pieDataJSON ?>;

        new Chart(document.getElementById("pieChart"), {
            type: 'pie',
            data: {
                labels: pieLabel,
                datasets: [{
                    data: pieData
                }]
            },
            options: {
                onClick: function(evt, el) {
                    if (el.length > 0) {
                        let category = pieLabel[el[0].index];
                        loadCategory(category);
                    }
                },
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 1,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });

        // ================= AJAX =================
        function loadCategory(category) {

            fetch("getCategoryDetails.php?category=" + category + "&year=<?= $selectedYear ?>&month=<?= $selectedMonth ?>")
                .then(res => res.json())
                .then(data => {

                    document.querySelector("#categoryResult h3").innerText = data.title;

                    let list = document.getElementById("resultList");
                    list.innerHTML = "";

                    let max = 0;

                    data.items.forEach(item => {
                        if (item.total > max) {
                            max = item.total;
                        }
                    });

                    data.items.forEach((item, i) => {

                        let percentage = (item.total / max) * 100;

                        const medal =
                            i == 0 ? "🥇" :
                            i == 1 ? "🥈" :
                            i == 2 ? "🥉" :
                            (i + 1);

                        list.innerHTML += `
        <div class="resultCard">

            <span>${medal} ${item.name}</span>

            <div class="bar">
                <div class="fill"
                     style="width:${percentage}%">
                </div>
            </div>

            <div class="total">${item.total} Events</div>

        </div>
    `;

                    });

                });
        }
    </script>

</body>

</html>