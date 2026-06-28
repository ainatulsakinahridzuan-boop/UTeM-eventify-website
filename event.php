<?php
session_start();
include("connect.php");
$currentPage = "event";

//SEARCH FILTER
$search = isset($_GET['search']) ? $_GET['search'] : '';
$statusFilter = isset($_GET['status']) ? $_GET['status'] : 'All Status';

// PAGINATION
// PAGINATION
$limit = 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$today = date("Y-m-d");

$sql = "SELECT *,
(
    CASE
        WHEN event_date = '$today' THEN 'Open'

        WHEN event_date > '$today' AND event_quota >
            (SELECT COUNT(*)
             FROM registration
             WHERE registration.event_id = event.event_id
             AND registration_status='Registered')
        THEN 'Upcoming'

        WHEN event_date > '$today' AND event_quota <=
            (SELECT COUNT(*)
             FROM registration
             WHERE registration.event_id = event.event_id
             AND registration_status='Registered')
        THEN 'Closed'

        ELSE 'Ended'
    END
) AS event_status

FROM event
WHERE 1=1";

// SEARCH 
if (!empty($search)) {
    $sql .= " AND event_name LIKE '%$search%'";
}

if ($statusFilter != "All Status") {
    $sql .= " AND (
        CASE
    WHEN event_date > '$today' AND event_quota >
        (SELECT COUNT(*) FROM registration 
         WHERE registration.event_id = event.event_id
         AND registration_status='Registered')
    THEN 'Upcoming'

    WHEN event_date > '$today' AND event_quota <=
        (SELECT COUNT(*) FROM registration 
         WHERE registration.event_id = event.event_id
         AND registration_status='Registered')
    THEN 'Closed'

    WHEN event_date = '$today'
    THEN 'Open'

    ELSE 'Ended'
END
    ) = '$statusFilter'";
}/* STATUS FILTER */
if ($statusFilter != "All Status") {
    $sql .= " HAVING event_status = '$statusFilter'";
}

//ORDER
$sql .= " ORDER BY event_date DESC";

// COUNT TOTAL (for pagination) 
$countSQL = "SELECT COUNT(*) AS total FROM (
    SELECT *,
    (
        CASE
            WHEN event_date = '$today' THEN 'Open'

            WHEN event_date > '$today' AND event_quota >
                (SELECT COUNT(*)
                 FROM registration
                 WHERE registration.event_id = event.event_id
                 AND registration_status='Registered')
            THEN 'Upcoming'

            WHEN event_date > '$today' AND event_quota <=
                (SELECT COUNT(*)
                 FROM registration
                 WHERE registration.event_id = event.event_id
                 AND registration_status='Registered')
            THEN 'Closed'

            ELSE 'Ended'
        END
    ) AS event_status
    FROM event
    WHERE 1=1
";

if (!empty($search)) {
    $countSQL .= " AND event_name LIKE '%$search%'";
}

$countSQL .= ") AS temp";

$countResult = mysqli_query($conn, $countSQL);
$countRow = mysqli_fetch_assoc($countResult);
$totalRecords = $countRow['total'];

$totalPages = ceil($totalRecords / $limit);

/* LIMIT */
$sql .= " LIMIT $limit OFFSET $offset";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>UTeM Eventify Manage Events</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="event.css?v=2">
    <!--GOOGLE ICON-->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
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
                            <h1>Manage Event</h1>
                            <p>View and manage all events</p>
                        </div>

                        <button id="addBtn"
                            onclick="window.location.href='addEvent.php'">
                            + Add Event
                        </button>

                    </div>

                    <form method="GET" id="searchSection">

                        <div id="searchBox">
                            <span class="material-symbols-outlined search">search</span>

                            <input type="text"
                                name="search"
                                placeholder="Search Event"
                                value="<?php echo $search; ?>">
                        </div>

                        <div id="statusSection">
                            <select id="status" name="status" onchange="this.form.submit()">
                                <option value="All Status" <?php if ($statusFilter == "All Status") echo "selected"; ?>>
                                    All Status
                                </option>

                                <option value="Open" <?php if ($statusFilter == "Open") echo "selected"; ?>>Open</option>

                                <option value="Upcoming" <?php if ($statusFilter == "Upcoming") echo "selected"; ?>>Upcoming</option>

                                <option value="Closed" <?php if ($statusFilter == "Closed") echo "selected"; ?>>Closed</option>

                                <option value="Ended" <?php if ($statusFilter == "Ended") echo "selected"; ?>>Ended</option>
                            </select>
                        </div>
                    </form>
                </div>

                <div id="tableSection">

                    <table>


                        <tr>
                            <th>POSTER</th>
                            <th>EVENT NAME</th>
                            <th>DATE</th>
                            <th>PARTICIPATION</th>
                            <th>STATUS</th>
                            <th>ACTION</th>
                        </tr>

                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {

                            $eventID = $row['event_id'];
                            $status = $row['event_status']; // GUNA SQL SAHAJA

                            // SET CLASS
                            if ($status == "Upcoming") {
                                $class = "upcomingStatus";
                            } elseif ($status == "Closed") {
                                $class = "closedStatus";
                            } elseif ($status == "Open") {
                                $class = "openStatus";
                            } else {
                                $class = "endedStatus";
                            }

                            // COUNT PARTICIPANT
                            $participantQuery = mysqli_query(
                                $conn,
                                "SELECT COUNT(*) AS total
         FROM registration
         WHERE event_id='$eventID'
         AND registration_status='Registered'"
                            );

                            $participant = mysqli_fetch_assoc($participantQuery);

                            $current = $participant['total'];
                            $quota = $row['event_quota'];
                        ?>
                            <tr>

                                <td>

                                    <?php
                                    if (!empty($row['poster'])) {
                                    ?>
                                        <img src="poster/<?php echo $row['poster']; ?>"
                                            width="90"
                                            height="90"
                                            style="border-radius:8px;">
                                    <?php
                                    } else {
                                        echo "<div class='poster'>No Poster</div>";
                                    }
                                    ?>

                                </td>

                                <td><?php echo $row['event_name']; ?></td>

                                <td>
                                    <?php
                                    echo date("d/m/Y", strtotime($row['event_date']));
                                    ?>
                                </td>

                                <td>
                                    <?php echo $current . "/" . $quota; ?>
                                </td>

                                <td>
                                    <div class="<?php echo $class; ?>">
                                        <?php echo $status; ?>
                                    </div>
                                </td>

                                <td>

                                    <div class="actionSection">

                                        <button class="editBtn"
                                            onclick="location.href='editEvent.php?id=<?php echo $eventID; ?>'">

                                            <span class="material-symbols-outlined">
                                                edit
                                            </span>

                                        </button>

                                        <button class="deleteBtn"
                                            onclick="location.href='deleteEvent.php?id=<?php echo $eventID; ?>'">

                                            <span class="material-symbols-outlined">
                                                delete
                                            </span>

                                        </button>

                                    </div>

                                </td>

                            </tr>

                        <?php
                        }
                        ?>

                    </table>

                    <!--BUTTON-->
                    <div id="pageNumberSection">

                        <?php if ($page > 1) { ?>
                            <a href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($statusFilter); ?>">
                                <span class="material-symbols-outlined arrowback">
                                    arrow_back
                                </span>
                                </button>
                            </a>
                        <?php } ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>

                            <a href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>">
                                <button class="pageNumber <?php if ($page == $i) echo 'activeNumber'; ?>">
                                    <?php echo $i; ?>
                                </button>
                            </a>

                        <?php } ?>

                        <?php if ($page < $totalPages) { ?>
                            <a href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($statusFilter); ?>">
                                <button class="pageBtn">
                                    <span class="material-symbols-outlined arrowforward">
                                        arrow_forward
                                    </span>
                                </button>
                            </a>
                        <?php } ?>

                    </div>

                </div>

            </article>

        </main>
</body>

</html>