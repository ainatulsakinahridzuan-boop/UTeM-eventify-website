<?php
session_start();
include("connect.php");
$currentPage = "registration";

if (!isset($_GET['event_id'])) {
    header("Location: registration.php");
    exit();
}

$event_id = $_GET['event_id'];

//EVENT DETAILS
$eventQuery = mysqli_query($conn, "
SELECT * FROM event WHERE event_id='$event_id'
");

$event = mysqli_fetch_assoc($eventQuery);

if (!$event) {
    echo "Event not found";
    exit();
}

//SEARCH
$search = isset($_GET['search']) ? $_GET['search'] : '';
$searchEsc = mysqli_real_escape_string($conn, $search);

//PAGINATION
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$start = ($page - 1) * $limit;

//TOTAL PARTICIPANTS
$totalQuery = mysqli_query($conn, "
SELECT COUNT(*) as total
FROM registration r
JOIN student s ON r.student_email = s.student_email
WHERE r.event_id='$event_id'
AND (
    s.student_name LIKE '%$searchEsc%'
    OR s.matric_no LIKE '%$searchEsc%'
    OR s.student_email LIKE '%$searchEsc%'
)
");

$total = mysqli_fetch_assoc($totalQuery)['total'];


//PARTICIPANT LIST
$sql = mysqli_query($conn, "
SELECT r.*, s.*
FROM registration r
JOIN student s ON r.student_email = s.student_email
WHERE r.event_id='$event_id'
AND (
    s.student_name LIKE '%$searchEsc%'
    OR s.matric_no LIKE '%$searchEsc%'
    OR s.student_email LIKE '%$searchEsc%'
)
ORDER BY r.registration_date DESC
LIMIT $start, $limit
");


//REGISTERED COUNT
$registeredQuery = mysqli_query($conn, "
SELECT COUNT(*) as total
FROM registration
WHERE event_id='$event_id'
AND registration_status='Registered'
");

$registered = mysqli_fetch_assoc($registeredQuery)['total'];

$quota = $event['event_quota'];
$percentage = ($quota > 0) ? ($registered / $quota) * 100 : 0;

$totalPage = ceil($total / $limit);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTeM Eventify Registration Details</title>

    <!-- GOOGLE ICON -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />

    <link rel="stylesheet" href="backToRegistrationDetails.css">
</head>

<body>

    <div id="wrapper">

        <!-- SIDEBAR -->
        <?php include("sidebar.php") ?>

        <!-- MAIN -->
        <main>

            <!-- BACK BUTTON -->
            <div id="backButton">
                <a href="registrationDetails.php">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <p>Back to Registrations</p>
            </div>

            <!-- EVENT DETAILS -->
            <section id="eventContainer">

                <div id="poster">
                    <img src="poster/<?php echo $event['poster']; ?>">
                </div>

                <div id="eventInfo">
                    <h1><?php echo $event['event_name']; ?></h1>

                    <div class="infoRow">
                        <span class="material-symbols-outlined">calendar_month</span>
                        <p><?php echo date("d/m/Y", strtotime($event['event_date'])); ?></p>
                    </div>

                    <div class="infoRow">
                        <span class="material-symbols-outlined">location_on</span>
                        <p><?php echo $event['event_venue']; ?></p>
                    </div>

                    <div class="infoRow">
                        <span class="material-symbols-outlined">schedule</span>
                        <p><?php echo date("g:i A", strtotime($event['event_time'])); ?></p>
                    </div>
                </div>

                <!-- STATISTICS -->
                <div id="statsSection">

                    <div class="statBox">
                        <div class="circle orange">
                            <span class="material-symbols-outlined">assignment</span>
                        </div>
                        <h2><?php echo $registered; ?></h2>
                        <p>Registered</p>
                    </div>

                    <div class="statBox">
                        <div class="circle blue">
                            <span class="material-symbols-outlined">group</span>
                        </div>
                        <h2><?php echo $quota; ?></h2>
                        <p>Quota</p>
                    </div>

                    <div class="statBox">
                        <div class="circle green">
                            <span class="material-symbols-outlined">percent</span>
                        </div>
                        <h2><?php echo number_format($percentage, 2); ?>%</h2>
                        <p>Percentage</p>
                    </div>

                </div>

            </section>

            <!-- PARTICIPANTS -->
            <section id="participantSection">

                <!-- TOP -->
                <div id="participantTop">
                    <h2>Participants (<?php echo $total; ?>)</h2>
                </div>

                <div id="participantAction">

                    <form method="GET">
                        <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">

                        <div id="searchBox">
                            <span class="material-symbols-outlined">search</span>

                            <input type="text" name="search"
                                placeholder="Search User"
                                value="<?php echo $search; ?>">
                        </div>
                    </form>

                </div>

                <!-- TABLE -->
                <table>

                    <tr>
                        <th>Name</th>
                        <th>Matric No.</th>
                        <th>Faculty</th>
                        <th>Email</th>
                        <th>Registered On</th>
                        <th>Status</th>
                    </tr>

                    <?php while ($row = mysqli_fetch_assoc($sql)) { ?>

                        <tr>
                            <td><?php echo $row['student_name']; ?></td>
                            <td><?php echo $row['matric_no']; ?></td>
                            <td><?php echo $row['faculty']; ?></td>
                            <td><?php echo $row['student_email']; ?></td>
                            <td><?php echo date("d/m/Y", strtotime($row['registration_date'])); ?></td>
                            <td>
                                <span class="status">
                                    <?php echo $row['registration_status']; ?>
                                </span>
                            </td>
                        </tr>

                    <?php } ?>

                </table>

                <!-- PAGINATION -->
                <div id="pageNumberSection">

                    <?php if ($page > 1) { ?>
                        <a href="?event_id=<?php echo $event_id; ?>&page=<?php echo $page - 1; ?>&search=<?php echo $search; ?>">
                            <button class="pageBtn">
                                <span class="material-symbols-outlined arrowback">
                                    arrow_back
                                </span>
                            </button>
                        </a>
                    <?php } ?>

                    <?php for ($i = 1; $i <= $totalPage; $i++) { ?>

                        <a href="?event_id=<?php echo $event_id; ?>&page=<?php echo $i; ?>&search=<?php echo $search; ?>">

                            <button class="pageNumber <?php if ($page == $i) echo 'activeNumber'; ?>">
                                <?php echo $i; ?>
                            </button>

                        </a>

                    <?php } ?>

                    <?php if ($page < $totalPage) { ?>
                        <a href="?event_id=<?php echo $event_id; ?>&page=<?php echo $page + 1; ?>&search=<?php echo $search; ?>">
                            <button class="pageBtn">
                                <span class="material-symbols-outlined arrowforward">
                                    arrow_forward
                                </span>
                            </button>
                        </a>
                    <?php } ?>

                </div>

            </section>

        </main>

    </div>

</body>

</html>