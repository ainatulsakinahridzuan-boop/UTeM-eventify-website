<?php
include("connect.php");

if (!isset($_GET['id'])) {
    header("Location: event.php");
    exit();
}

$event_id = $_GET['id'];
$today = date("Y-m-d");

//GET EVENT DETAILS
$getEvent = mysqli_query(
    $conn,
    "SELECT event_date, poster
     FROM event
     WHERE event_id='$event_id'"
);

if (mysqli_num_rows($getEvent) == 0) {

    echo "
    <script>
        alert('Event not found.');
        window.location='event.php';
    </script>";
    exit();
}

$event = mysqli_fetch_assoc($getEvent);


//CHECK EVENT DATE
if ($event['event_date'] <= $today) {

    echo "
    <script>
        alert('Only upcoming events can be deleted.');
        window.location='event.php';
    </script>";
    exit();
}


//CHECK REGISTERED PARTICIPANTS
$checkParticipant = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM registration
     WHERE event_id='$event_id'
     AND registration_status='Registered'"
);

$row = mysqli_fetch_assoc($checkParticipant);

if ($row['total'] > 0) {

    echo "
    <script>
        alert('This event cannot be deleted because participants have already registered.');
        window.location='event.php';
    </script>";
    exit();
}


//DELETE POSTER
if (!empty($event['poster']) && file_exists("poster/" . $event['poster'])) {
    unlink("poster/" . $event['poster']);
}


// DELETE EVENT 
$result = mysqli_query(
    $conn,
    "DELETE FROM event
     WHERE event_id='$event_id'"
);

if ($result) {

    echo "
    <script>
        alert('Event deleted successfully.');
        window.location='event.php';
    </script>";
} else {

    echo "
    <script>
        alert('Failed to delete event.');
        window.location='event.php';
    </script>";
}
?>