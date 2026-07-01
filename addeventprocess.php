<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event Process</title>
</head>

<body>
    <?php
    session_start();
    include("connect.php");

    $admin_email = $_SESSION['admin_email'];

    // GET DATA
    $name = $_POST['event_name'];
    $desc = $_POST['description'];
    $date = $_POST['event_date'];
    $time = $_POST['event_time'];
    $venue = $_POST['venue'];

    $category_name = $_POST['category']; // FTKM / University Wide etc

    $event_category = $_POST['event_category']; // Faculty / Club / etc

    $organiser = $_POST['organiser'];
    $fee = $_POST['fee'];
    $quota = $_POST['quota'];

    // VALIDATION
    if (empty($category_name)) {
        echo "<script>
        alert('Please select a category.');
        window.history.back();
    </script>";
        exit();
    }

    if (empty($organiser)) {
        echo "<script>
        alert('Please enter organiser.');
        window.history.back();
    </script>";
        exit();
    }

    // UPLOAD POSTER
    $file_name = $_FILES['poster']['name'];
    $tmp_name = $_FILES['poster']['tmp_name'];

    $folder = "poster/" . $file_name;

    if (move_uploaded_file($tmp_name, $folder)) {

        // INSERT EVENT
        $sql = "INSERT INTO event (
        event_name,
        event_desc,
        event_date,
        event_time,
        event_venue,
        event_category,
        category_name,
        organiser_name,
        event_fee,
        event_quota,
        poster,
        admin_email
    ) VALUES (
        '$name',
        '$desc',
        '$date',
        '$time',
        '$venue',
        '$event_category',
        '$category_name',
        '$organiser',
        '$fee',
        '$quota',
        '$file_name',
        '$admin_email'
    )";

        $result = mysqli_query($conn, $sql);

        if ($result) {

            $event_id = mysqli_insert_id($conn);

            // GET STUDENTS
            $facultyList = [
                "FTKEK",
                "FTKE",
                "FTKM",
                "FTMK",
                "FTKIP",
                "FAIX",
                "FPTT"
            ];

            // University-wide, Club, Residential = semua student
            if (!in_array($category_name, $facultyList)) {

                $studentQuery = mysqli_query(
                    $conn,
                    "SELECT student_email
             FROM student"
                );
            }

            // Faculty = student faculty tersebut sahaja
            else {

                $studentQuery = mysqli_query(
                    $conn,
                    "SELECT student_email
             FROM student
             WHERE faculty='$category_name'"
                );
            }

            // NOTIFICATION DETAILS
            $type = "event";
            $title = "New Event Available";
            $message = "$name has been published.
            Category: $category_name
            Register now before the registration closes.";

            // INSERT NOTIFICATION
            while ($student = mysqli_fetch_assoc($studentQuery)) {
                $email = $student['student_email'];
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
                '$email',
                '$type',
                '$title',
                '$message',
                NOW(),
                'No',
                NULL,
                '$event_id'
            )"
                );
            }

            echo "<script>
        alert('Event added successfully!');
        window.location='event.php';
        </script>";
        } else {
            echo "<script>
            alert('Failed to add event.');
            window.history.back();
        </script>";
        }
    } else {
        echo "<script>
        alert('Failed to upload poster.');
        window.history.back();
    </script>";
    }
    ?>

</body>

</html>