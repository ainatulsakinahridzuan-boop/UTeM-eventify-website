<?php
include("connect.php");

session_start();

if (!isset($_SESSION['student_email'])) {
    header("Location: login.php");
    exit();
}

$student_email = $_SESSION['student_email'];

/* GET STUDENT */

$studentSql = "SELECT * FROM student WHERE student_email='$student_email'";
$studentResult = mysqli_query($conn, $studentSql);
$student = mysqli_fetch_assoc($studentResult);

/* GET EVENT */

$event_id = (int)($_GET['id'] ?? 0);

if ($event_id == 0) {
    header("Location: browse.php");
    exit();
}

$sql = "SELECT * FROM event WHERE event_id='$event_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

/* CHECK EVENT EXIST */

if (!$row) {
    die("Event not found.");
}

/* CHECK EVENT DATE */

if (strtotime($row['event_date']) < strtotime(date("Y-m-d"))) {

    echo "<script>
    alert('Registration for this event has closed.');
    window.location='browse.php';
    </script>";

    exit();
}

/* CHECK SEATS */

$quota = $row['event_quota'];

$countSql = "
SELECT COUNT(*) AS total_registered
FROM registration
WHERE event_id='$event_id'
AND registration_status='Registered'
";

$countResult = mysqli_query($conn, $countSql);
$countRow = mysqli_fetch_assoc($countResult);

$totalRegistered = $countRow['total_registered'];
$seatsLeft = $quota - $totalRegistered;

/* REGISTER */

if (isset($_POST['register'])) {

    /* DUPLICATE CHECK */

    $check = mysqli_query(
        $conn,
        "SELECT *
         FROM registration
         WHERE student_email='$student_email'
         AND event_id='$event_id'"
    );

    if (mysqli_num_rows($check) > 0) {

        echo "<script>
        alert('You have already registered for this event.');
        </script>";
    }

    elseif ($seatsLeft <= 0) {

        echo "<script>
        alert('Sorry, this event is full.');
        </script>";
    }

    else {

        /* UPLOAD RECEIPT - ONLY IF EVENT HAS FEE */

$receipt = "";

if ($row['event_fee'] > 0) {

    if ($_FILES['payment_receipt']['error'] == 0) {

        $receipt = time() . "_" . $_FILES['payment_receipt']['name'];
        $tmp = $_FILES['payment_receipt']['tmp_name'];

        if (!move_uploaded_file($tmp, "receipt/" . $receipt)) {
            die("Failed to upload receipt.");
        }

    } else {
        echo "<script>
        alert('Please upload your payment receipt.');
        </script>";
        exit();
    }

} else {
    $receipt = "FREE_EVENT";
}


     
        /* INSERT REGISTRATION */

        $registration_date = date("Y-m-d H:i:s");

        $register = mysqli_query(
            $conn,
            "INSERT INTO registration
            (
                student_email,
                attendance_status,
                registration_date,
                registration_status,
                event_id
            )

            VALUES
            (
                '$student_email',
                'Pending',
                '$registration_date',
                'Registered',
                '$event_id'
            )"
        );

        if (!$register) {
            die(mysqli_error($conn));
        }

        $registration_id = mysqli_insert_id($conn);

        /* INSERT PAYMENT */

        $payment = mysqli_query(
            $conn,
            "INSERT INTO payment
            (
                registration_id,
                payment_method,
                payment_receipt,
                payment_status
            )

            VALUES
            (
                '$registration_id',
                'Receipt Upload',
                '$receipt',
                'Paid'
            )"
        );

        if (!$payment) {
            die(mysqli_error($conn));
        }

        /* CREATE NOTIFICATION */

        $title = "Event Registration";

        $message = "You have successfully registered for \"" . $row['event_name'] . "\".";

        $notification = mysqli_query(
    $conn,
    "INSERT INTO notification
    (
        notification_type,
        message,
        notification_date,
        registration_id,
        event_id
    )

    VALUES
    (
        'event',
        '$message',
        NOW(),
        '$registration_id',
        '$event_id'
    )"
);

     if (!$notification) {
    die("Notification Error: " . mysqli_error($conn));
}


        echo "<script>
        alert('Registration Successful!');
        window.location='browse.php';
        </script>";

        exit();
    }
}
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Event Registration</title>
        <link rel="stylesheet" href="registration.css">

        <!--Google Material Icons-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined">
       
    <body>
        <div class="container">
            <h1>Register for <?php echo $row['event_name']; ?></h1>
            <hr>

            <div class="main-content">
                <!--DETAILS FORM-->
                <form
                    class="left-section"
                    method="POST"
                    enctype="multipart/form-data">

                    <!--DETAILS SECTION-->
                    <div class="form-card">
                        <div class="card-header">
                            <h2>1. Fill in Your Details</h2>
                        </div>
                        <div class="card-body">
                            <label>Full Name</label>
                            <br>
                            <input
                                type="text"
                                name="student_name"
                                value="<?php echo $student['student_name']; ?>"
                                readonly>
                            <br>

                            <label>Matric Number</label>
                            <br>
                            <input
type="text"
name="matric_no"
value="<?php echo $student['matric_no']; ?>"
readonly>
                            <br>

                            <label>Phone Number</label>
                            <br>
                            <input
type="text"
name="phone_number"
value="<?php echo $student['phone_number']; ?>"
readonly>
                            <br>

                            <label>E-mail Address</label>
                            <br>
                            <input
type="email"
name="student_email"
value="<?php echo $student['student_email']; ?>"
readonly>
                           <label>Faculty</label>
<br>

<input
type="text"
name="faculty"
value="<?php echo $student['faculty']; ?>"
readonly>
                           
                            
                        </div>


                    </div>

                   <?php if ($row['event_fee'] > 0) { ?>

                <!--PAYMENT SECTION-->
                <div class="payment-card">

                        <div class="card-header">
                            <h2>2. Payment</h2>
                        </div>

                        <div class="card-body">
                            
                            <div class="bank-details">
                                <h3>Bank Details</h3>
                                <p><strong>Bank:</strong> Maybank</p>
                                <p><strong>Account Name:</strong> UTeM Admin </p>
                                <p><strong>Account Number:</strong> 1234567890</p>
                            </div>

                            <label>Upload Payment Receipt</label>
<br>

<input
type="file"
name="payment_receipt"
accept="image/*,.pdf"
<?php if ($row['event_fee'] > 0) echo 'required'; ?>>

                            <div class="refund-policy">

                                <span class="material-symbols-outlined">
                                    warning
                                </span>

                                <strong>Cancelation & Refund Policy:</strong>

                                If you cancel your registration, 
                                please note that no refunds will be made

                            </div>

                            <hr>

                            <div class="payment-summary">

                                <p>Payment Summary</p>
                                <p>RM <?php echo number_format($row['event_fee'], 2); ?></p>

                            </div>

                        </div>
                    </div>

                    <?php } else { ?>

<div class="payment-card">

    <div class="card-header">
        <h2>2. Registration Confirmation</h2>
    </div>

    <div class="card-body">

        <div style="
            background:#e8f5e9;
            border:1px solid #4CAF50;
            color:#2E7D32;
            padding:20px;
            border-radius:10px;
            text-align:center;
            font-size:18px;
            font-weight:bold;
        ">
             This is a FREE event.<br><br>
            No payment or receipt upload is required.
        </div>

    </div>

</div>

<?php } ?>

                    <button
type="submit"
name="register">
                        Confirm Registration
                    </button>

                
                </form>

                <!--EVENT DETAILS CARD-->

                <div class="right-section">
                    
                    <div class="event-card">

                        <div class ="event-image">
                             <img src="poster/<?php echo $row['poster']; ?>" alt="Event Poster">
                        </div>

                        <h2><?php echo $row['event_name']; ?></h2>

                        <p>
                            <span class="material-symbols-outlined">calendar_month</span>
                            <?php echo $row['event_date']; ?>
                        </p>

                        <p>
                            <span class="material-symbols-outlined">location_on</span>
                            <?php echo $row['event_venue']; ?>
                        </p>

                        <p>
                            <span class="material-symbols-outlined">schedule</span>
                            <?php echo $row['event_time']; ?>
                        </p>

                       <p>
    <span class="material-symbols-outlined">attach_money</span>

    <?php
    if ($row['event_fee'] > 0) {
        echo "RM " . number_format($row['event_fee'], 2);
    } else {
        echo "FREE";
    }
    ?>
</p>

                        <hr>

                        <div class="seat-warning">
                            <span class="material-symbols-outlined">event_seat</span>
                            Only <?php echo $seatsLeft; ?> seats left!
                        </div>
                        
                    </div>
                </div>


            </div>
        </div>




    </body>
</html>