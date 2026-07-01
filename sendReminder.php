<?php

include("connect.php");

/*GET ALL EVENTS THAT WILL HAPPEN TOMORROW*/

$sql = "
SELECT
    r.registration_id,
    r.student_email,
    e.event_id,
    e.event_name,
    e.event_date,
    e.event_time,
    e.event_venue

FROM registration r

JOIN event e
ON r.event_id = e.event_id

WHERE
    e.event_date = DATE_ADD(CURDATE(), INTERVAL 1 DAY)
    AND r.registration_status = 'Registered'
";

$result = mysqli_query($conn, $sql);

/*LOOP EVERY REGISTERED STUDENT*/

while ($row = mysqli_fetch_assoc($result)) {

    $registration_id = $row['registration_id'];
    $student_email   = $row['student_email'];
    $event_id        = $row['event_id'];

    /*
    CHECK IF REMINDER ALREADY EXISTS
    */

    $check = mysqli_query(
        $conn,

        "SELECT notification_id
         FROM notification
         WHERE registration_id='$registration_id'
         AND notification_type='reminder'"
    );

    if (mysqli_num_rows($check) == 0) {

        /*CREATE REMINDER*/

        $title = "Event Reminder";

        $message =
            "Reminder !!

The event \"" . $row['event_name'] . "\" will take place tomorrow.
Venue : " . $row['event_venue'] . "
Time : " . date("h:i A", strtotime($row['event_time'])) . "
Please arrive on time.";

        mysqli_query(

            $conn,

            "INSERT INTO notification
            (
                student_email,
                notification_type,
                title,
                message,
                notification_date,
                is_read,
                registration_id,
                event_id
            )

            VALUES

            (
                '$student_email',
                'reminder',
                '$title',
                '$message',
                NOW(),
                'No',
                '$registration_id',
                '$event_id'
            )"

        );
    }
}

echo "Reminder checking completed.";

?>
