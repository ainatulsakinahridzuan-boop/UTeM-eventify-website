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
            event_fee='$fee',
            event_quota='$quota',
            poster='$poster'

            WHERE event_id='$event_id'";

    if (mysqli_query($conn, $sql)) {

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
