<?php

include("connect.php");

if (!isset($_GET['id'])) {
    header("Location: adminContact.php");
    exit();
}

$message_id = $_GET['id'];

$sql = "
SELECT
    cm.*,
    s.student_name,
    s.student_email
FROM contact_message cm
JOIN student s
ON cm.student_email = s.student_email
WHERE cm.message_id='$message_id'
";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

/* SAVE REPLY */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $reply = mysqli_real_escape_string($conn, $_POST['admin_reply']);

    $update = "
    UPDATE contact_message
    SET admin_reply='$reply'
    WHERE message_id='$message_id'
    ";

    mysqli_query($conn, $update);

    /* CREATE NOTIFICATION */

    $student_email = $row['student_email'];

    $notification_type = "reply";

    $title = "Reply from Administrator";

    $message = $reply;

    $is_read = 0;

    $insertNotification = "
INSERT INTO notification
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
    '$notification_type',
    '$title',
    '$message',
    NOW(),
    $is_read,
    NULL,
    NULL
)
";

    mysqli_query($conn, $insertNotification);

    echo "<script>
            alert('Reply sent successfully.');
            window.location='adminContact.php';
          </script>";

    exit();
}

?>



<!DOCTYPE html>

<html>

<head>

    <meta charset="UTF-8">

    <title>Reply Message</title>

    <link rel="stylesheet" href="adminReply.css">
    <link rel="stylesheet" href="sidebar.css">

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

</head>

<body>

    <?php include("sidebar.php"); ?>

    <main>

        <article>

            <!-- ================= HEADER ================= -->

            <div id="topContainer">

                <div id="topSection">

                    <div id="pageTitle">

                        <h1>Reply to Message</h1>

                        <p>View the student message and send a reply</p>

                    </div>

                    <a href="adminContact.php" class="backBtn">

                        <span class="material-symbols-outlined">
                            arrow_back
                        </span>

                        Back to Messages

                    </a>

                </div>

                <div id="breadcrumb">

                    <a href="adminContact.php">

                        Contact Messages

                    </a>

                    <span class="material-symbols-outlined">
                        chevron_right
                    </span>

                    <span>

                        Reply to Message

                    </span>

                </div>

            </div>

            <div id="contentContainer">
                <!-- STUDENT INFO -->

                <div class="card">

                    <h2>Student Information</h2>

                    <div class="infoContainer">

                        <div class="leftInfo">

                            <span class="material-symbols-outlined profileIcon">
                                account_circle
                            </span>

                            <div id="studentDetails">

                                <label>Student Name</label>

                                <h3>

                                    <?= $row['student_name']; ?>

                                </h3>

                                <label>Email</label>

                                <p>

                                    <?= $row['student_email']; ?>

                                </p>

                                <label>Date Sent</label>

                                <p>

                                    <?= date("d/m/Y h:i A", strtotime($row['sent_at'])); ?>

                                </p>

                            </div>

                        </div>

                        <div class="rightInfo">

                            <label>Status</label>

                            <?php

                            if (empty($row['admin_reply'])) {

                            ?>

                                <span class="newStatus">

                                    New

                                </span>

                            <?php

                            } else {

                            ?>

                                <span class="replyStatus">

                                    Replied

                                </span>

                            <?php

                            }

                            ?>

                        </div>

                    </div>

                </div>

                <!-- MESSAGE -->

                <h2>Student Message</h2>

                <div class="messageCard">


                    <div class="messageBox">

                        <?= nl2br(htmlspecialchars($row['message'])); ?>

                    </div>

                </div>

                <!-- REPLY -->

                <h2>Your Reply</h2>

                <form method="POST">

                    <div class="replyCard">

                        <label>

                            Reply to Student

                        </label>

                        <textarea

                            name="admin_reply"

                            maxlength="1000"

                            required

                            placeholder="Type your reply here..."><?php

                                                                    if (!empty($row['admin_reply'])) {

                                                                        echo htmlspecialchars($row['admin_reply']);
                                                                    }

                                                                    ?></textarea>

                        <div class="buttonSection">

                            <a

                                href="adminContact.php"

                                class="cancelBtn">

                                Cancel

                            </a>

                            <button

                                type="submit"

                                class="sendBtn">

                                <span class="material-symbols-outlined">
                                    send
                                </span>

                                Send Reply

                            </button>

                        </div>

                    </div>

                </form>
            </div>

        </article>

    </main>

</body>

</html>