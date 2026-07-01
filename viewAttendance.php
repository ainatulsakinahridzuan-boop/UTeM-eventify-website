<?php

include("connect.php");

/* PAGINATION */

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$limit = 10;
$offset = ($page - 1) * $limit;

/* GET PAST EVENTS */

$sqlEvent = "
SELECT event_id,event_name
FROM event
WHERE event_date < CURDATE()
ORDER BY event_date DESC
";

$eventResult = mysqli_query($conn, $sqlEvent);

$where = "";
$result = null;
$totalPages = 0;

/* FILTER EVENT */

if (isset($_GET['event_id']) && $_GET['event_id'] != "") {

    $event_id = mysqli_real_escape_string($conn, $_GET['event_id']);

    $where .= " AND r.event_id='$event_id'";
}

/* SEARCH */

if (isset($_GET['search']) && $_GET['search'] != "") {

    $search = mysqli_real_escape_string($conn, $_GET['search']);

    $where .= "

    AND (

    s.student_name LIKE '%$search%'

    OR

    s.matric_no LIKE '%$search%'

    )";
}

/* TABLE */

if (isset($event_id)) {

    $sql = "

    SELECT

    s.student_name,
    s.matric_no,
    r.attendance_status

    FROM registration r

    JOIN student s
    ON r.student_email=s.student_email

    JOIN event e
    ON r.event_id=e.event_id

    WHERE

    e.event_date<CURDATE()

    $where

    ORDER BY s.student_name

    LIMIT $limit OFFSET $offset

    ";

    $result = mysqli_query($conn, $sql);
}

/* SUMMARY */

$registered = "-";
$present = "-";
$absent = "-";
$percentage = "-";

if (isset($event_id)) {

    $sqlSummary = "

    SELECT

    COUNT(*) AS registered,

    COALESCE(SUM(CASE WHEN r.attendance_status='Present' THEN 1 ELSE 0 END),0) AS present,

    COALESCE(SUM(CASE WHEN r.attendance_status='Absent' THEN 1 ELSE 0 END),0) AS absent

    FROM registration r

    JOIN event e

    ON r.event_id=e.event_id

    WHERE

    e.event_date<CURDATE()

    $where

    ";
    $summaryResult = mysqli_query($conn, $sqlSummary);
    $summary = mysqli_fetch_assoc($summaryResult);

    $registered = $summary['registered'];
    $present = $summary['present'];
    $absent = $summary['absent'];

    if ($registered > 0) {
        $percentage = number_format(($present / $registered) * 100, 2) . "%";
    } else {
        $percentage = "0%";
    }
}
/* TOTAL PAGE */
if (isset($event_id)) {
    $countSql = "
    SELECT COUNT(*) AS total
    FROM registration r
    JOIN student s
    ON r.student_email=s.student_email
    JOIN event e
    ON r.event_id=e.event_id
    WHERE
    e.event_date<CURDATE()
    $where
    ";
    $countResult = mysqli_query($conn, $countSql);
    $countRow = mysqli_fetch_assoc($countResult);
    $totalPages = ceil($countRow['total'] / $limit);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>UTeM Eventify Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="viewAttendance.css">
    <link rel="stylesheet" href="sidebar.css">

    <!--GOOGLE ICON-->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

</head>

<body>
    <?php include("sidebar.php"); ?>
    <!-- CONTENT -->
    <main>

        <article>
            <div id="topContainer">
                <div id="topSection">

                    <div>
                        <h1>Attendance</h1>
                        <p>Track and manage event attendance</p>
                    </div>

                </div>

                <!--SEARCH SECTION-->
                <form method="GET">
                    <div id="searchSection">
                        <div id="eventSection">

                            <label>Select Event</label>
                            <select name="event_id" id="event">

                                <option value="">Select Event</option>

                                <?php

                                while ($event = mysqli_fetch_assoc($eventResult)) {

                                ?>

                                    <option
                                        value="<?= $event['event_id']; ?>"

                                        <?php

                                        if (
                                            isset($_GET['event_id']) &&
                                            $_GET['event_id'] == $event['event_id']
                                        ) {

                                            echo "selected";
                                        }

                                        ?>>

                                        <?= htmlspecialchars($event['event_name']); ?>

                                    </option>

                                <?php

                                }

                                ?>

                            </select>
                        </div>

                        <div id="participantSection">
                            <label>Search Participant</label>
                            <div id="searchBox">

                                <span class="material-symbols-outlined search">
                                    search
                                </span>
                                <input
                                    type="text"
                                    name="search"
                                    placeholder="Search User"
                                    value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">

                            </div>
                        </div>
                        <button type="submit" id="searchBtn">SEARCH</button>
                    </div>
                </form>
            </div>


            <!--SUMMARY-->
            <div id="summaryContainer">

                <div class="summaryBox">
                    <span class="material-symbols-outlined registerIcon">
                        assignment
                    </span>

                    <div>
                        <h2><?= $registered; ?></h2>
                        <p>Registered</p>
                    </div>
                </div>

                <div class="summaryBox">
                    <span class="material-symbols-outlined presentIcon">
                        group
                    </span>

                    <div>
                        <h2><?= $present; ?></h2>
                        <p>Present</p>
                    </div>
                </div>

                <div class="summaryBox">
                    <span class="material-symbols-outlined absentIcon">
                        x_circle
                    </span>

                    <div>
                        <h2><?= $absent; ?></h2>
                        <p>Absent</p>
                    </div>
                </div>

                <div class="summaryBox">
                    <span class="material-symbols-outlined percentIcon">
                        percent
                    </span>

                    <div>
                        <h2><?php

                            if ($percentage == "-") {

                                echo "-";
                            } else {

                                echo $percentage;
                            }

                            ?></h2>
                        <p>Percentage</p>
                    </div>
                </div>

            </div>

            <!--TABLE-->
            <div id="tableContainer">
                <h3>Participant List
                    (<?= $result ? mysqli_num_rows($result) : 0; ?>)</h3>

                <div id="tableSection">

                    <table>
                        <tr>
                            <th>NAME</th>
                            <th>MATRIC NO.</th>
                            <th>STATUS</th>
                        </tr>
                        <?php

                        if ($result && mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {

                        ?>
                                <tr>

                                    <td class="profileCell">
                                        <span class="material-symbols-outlined profileIcon">
                                            account_circle
                                        </span>

                                        <span class="profileName">
                                            <?= htmlspecialchars($row['student_name']); ?>
                                        </span>
                                    </td>

                                    <td>
                                        <?= $row['matric_no']; ?>
                                    </td>

                                    <td>

                                        <?php if ($row['attendance_status'] == "Present") { ?>

                                            <div class="presentStatus">
                                                Attended
                                            </div>

                                        <?php } else { ?>

                                            <div class="absentStatus">
                                                Absent
                                            </div>

                                        <?php } ?>

                                    </td>

                                </tr>
                            <?php

                            } // tutup while

                        } else {

                            ?>

                            <tr>
                                <td colspan="3" style="text-align:center;">
                                    Please select an event.
                                </td>
                            </tr>

                        <?php

                        }

                        ?>

                    </table>

                    <!--BUTTON-->

                    <!-- PAGE NUMBER -->

                    <div id="pageNumberSection">

                        <!-- Previous Button -->

                        <?php if ($page > 1) { ?>

                            <a class="pageBtn"
                                href="?page=<?= $page - 1 ?>&event_id=<?= urlencode($event_id ?? '') ?>&search=<?= urlencode($search ?? '') ?>">

                                <span class="material-symbols-outlined arrowback">
                                    arrow_back
                                </span>

                            </a>

                        <?php } ?>

                        <?php

                        $start = max(1, $page - 1);
                        $end = min($totalPages, $start + 2);

                        if (($end - $start) < 2) {
                            $start = max(1, $end - 2);
                        }

                        for ($i = $start; $i <= $end; $i++) {

                        ?>

                            <a
                                class="pageNumber <?= ($i == $page) ? 'activeNumber' : ''; ?>"
                                href="?page=<?= $i ?>&event_id=<?= urlencode($event_id ?? '') ?>&search=<?= urlencode($search ?? '') ?>">

                                <?= $i ?>

                            </a>

                        <?php } ?>

                        <!-- Next Button -->

                        <?php if ($page < $totalPages) { ?>

                            <a class="pageBtn"
                                href="?page=<?= $page + 1 ?>&event_id=<?= urlencode($event_id ?? '') ?>&search=<?= urlencode($search ?? '') ?>">

                                <span class="material-symbols-outlined arrowforward">
                                    arrow_forward
                                </span>

                            </a>

                        <?php } ?>

                    </div>

                </div>
            </div>

        </article>

    </main>

    </div>

</body>

</html>