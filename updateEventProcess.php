<?php
include("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $event_id = $_POST['event_id'];

    $event_name = mysqli_real_escape_string($conn, $_POST['event_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $venue = mysqli_real_escape_string($conn, $_POST['venue']);

    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $category = $_POST['category'];
    $organiser = mysqli_real_escape_string($conn, $_POST['organiser']);
    $fee = $_POST['fee'];

    $quota = (int)$_POST['quota'];

    $oldPoster = $_POST['oldPoster'];

    $result = mysqli_query(
        $conn,
        "SELECT event_quota FROM event WHERE event_id='$event_id'"
    );

    $row = mysqli_fetch_assoc($result);

    $currentQuota = $row['event_quota'];

    if ((int)$quota <= (int)$currentQuota) {

        echo "<script>
            alert('New quota must be greater than the current quota!');
            window.history.back();
          </script>";
        exit();
    }

    $poster = $oldPoster;

    if (!empty($_FILES['poster']['name'])) {

        $poster = time() . "_" . $_FILES['poster']['name'];

        $target = "poster/" . $poster;

        if (move_uploaded_file($_FILES['poster']['tmp_name'], $target)) {

            if (file_exists("poster/" . $oldPoster)) {
                unlink("poster/" . $oldPoster);
            }
        }
    }

    $sql = "UPDATE event SET

        event_name='$event_name',
        event_desc='$description',
        event_date='$event_date',
        event_time='$event_time',
        event_venue='$venue',
        event_category='$category',
        organiser_name='$organiser',
        event_fee='$fee',
        event_quota='$quota',
        poster='$poster'

        WHERE event_id='$event_id'";

    if (mysqli_query($conn, $sql)) {
        // Get all registered participants
        $getParticipant = mysqli_query(
            $conn,
            "SELECT registration_id, student_email
            FROM registration
            WHERE event_id='$event_id'"
        );

        while ($participant = mysqli_fetch_assoc($getParticipant)) {
            $registration_id = $participant['registration_id'];
            $student_email = $participant['student_email'];

            $type = "Event Updated";

            $message = "There are new updates for the event '$event_name' has been updated. Please check the latest event details.";

            $date = date("Y-m-d H:i:s");

            mysqli_query(
                $conn,
                "INSERT INTO notification
    (
        notification_type,
        message,
        notification_date,
        registration_id,
        event_id,
        student_email
    )
    VALUES
    (
        '$type',
        '$message',
        '$date',
        '$registration_id',
        '$event_id',
        '$student_email'
    )"
            );
        }

        echo "<script>
                alert('Event updated successfully!');
                window.location='event.php';
              </script>";
    } else {

        echo "<script>
                alert('Failed to update event!');
                window.history.back();
              </script>";
    }
}
