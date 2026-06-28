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

    // ambil semua data form
    $name = $_POST['event_name'];
    $desc = $_POST['description'];
    $date = $_POST['event_date'];
    $time = $_POST['event_time'];
    $venue = $_POST['venue'];
    $category = $_POST['category'];
    if (empty($category)) {
        echo "<script>
            alert('Please select a category.');
            window.history.back();
          </script>";
        exit();
    }
    $fee = $_POST['fee'];
    $quota = $_POST['quota'];

    // upload poster
    $file_name = $_FILES['poster']['name'];
    $tmp_name = $_FILES['poster']['tmp_name'];

    // folder simpan gambar
    $folder = "uploads/" . $file_name;

    // move file ke folder uploads
    move_uploaded_file($tmp_name, $folder);
    $sql = "INSERT INTO event 
    (event_name, event_desc, event_date, event_time, event_venue, event_category, event_fee, event_quota, poster, admin_email)
    VALUES 
    ('$name', '$desc', '$date', '$time', '$venue', '$category', '$fee', '$quota', '$file_name', '$admin_email')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "Event has successfully added!";
        echo "<script>
            window.location.href='event.php';
        </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    ?>
</body>

</html>