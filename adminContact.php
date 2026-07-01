<?php

include("connect.php");
$currentPage = "message";

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$limit = 10;
$offset = ($page - 1) * $limit;

$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? '';

$sql = "

SELECT
    cm.message_id,
    s.student_name,
    s.student_email,
    cm.message,
    cm.admin_reply,
    cm.sent_at

FROM contact_message cm

JOIN student s
ON cm.student_email = s.student_email

WHERE 1=1

";

/* SEARCH */

if (!empty($search)) {

    $sql .= "

    AND
    (

        s.student_name LIKE '%$search%'
        OR s.student_email LIKE '%$search%'
        OR cm.message LIKE '%$search%'

    )

    ";
}

/* STATUS FILTER */

if ($status == "new") {

    $sql .= "

    AND cm.admin_reply IS NULL

    ";
} elseif ($status == "replied") {

    $sql .= "

    AND cm.admin_reply IS NOT NULL

    ";
}

/* ORDER + PAGINATION */

$sql .= "

ORDER BY
CASE
    WHEN cm.admin_reply IS NULL THEN 0
    ELSE 1
END,
cm.sent_at DESC

LIMIT $limit OFFSET $offset

";

/* COUNT QUERY */

$countQuery = "

SELECT COUNT(*) AS total

FROM contact_message cm

JOIN student s
ON cm.student_email = s.student_email

WHERE 1=1

";

/* SEARCH */

if (!empty($search)) {

    $countQuery .= "

    AND
    (

        s.student_name LIKE '%$search%'
        OR s.student_email LIKE '%$search%'
        OR cm.message LIKE '%$search%'

    )

    ";
}

/* STATUS FILTER */

if ($status == "new") {

    $countQuery .= "

    AND cm.admin_reply IS NULL

    ";
} elseif ($status == "replied") {

    $countQuery .= "

    AND cm.admin_reply IS NOT NULL

    ";
}

/* GET TOTAL RECORD */

$countResult = mysqli_query($conn, $countQuery);

$countRow = mysqli_fetch_assoc($countResult);

$totalRecords = $countRow['total'];

$totalPages = ceil($totalRecords / $limit);

/* GET DATA */

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>UTeM Eventify Contact Messages</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="adminContact.css">
    <link rel="stylesheet" href="sidebar.css">

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

</head>

<body>

    <?php include("sidebar.php"); ?>

    <main>

        <article>

            <div id="topContainer">

                <div id="topSection">

                    <h1>Contact Messages</h1>

                    <p>View and reply to user messages</p>

                </div>

                <form method="GET">

                    <div id="searchSection">

                        <div id="searchBox">

                            <span class="material-symbols-outlined search">
                                search
                            </span>

                            <input
                                type="text"
                                name="search"
                                placeholder="Search by name, email or message..."
                                value="<?= htmlspecialchars($search); ?>">

                        </div>

                        <div id="statusSection">

                            <select
                                id="status"
                                name="status">

                                <option value="">All Status</option>

                                <option value="new"
                                    <?= ($status == "new") ? "selected" : ""; ?>>
                                    New
                                </option>

                                <option value="replied"
                                    <?= ($status == "replied") ? "selected" : ""; ?>>
                                    Replied
                                </option>

                            </select>

                        </div>

                        <button type="submit">
                            Search
                        </button>
                    </div>

                </form>

            </div>

            <div id="tableSection">

                <table>

                    <tr>
                        <th>NAME</th>
                        <th>EMAIL</th>
                        <th>MESSAGE</th>
                        <th>STATUS</th>
                        <th>ACTION</th>
                    </tr>

                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                        <tr>

                            <td>

                                <?= $row['student_name']; ?>

                            </td>

                            <td>

                                <?= $row['student_email']; ?>

                            </td>

                            <td>

                                <?= substr($row['message'], 0, 55); ?>...

                            </td>

                            <td>

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

                            </td>

                            <td>

                                <?php

                                if (empty($row['admin_reply'])) {

                                ?>

                                    <a
                                        class="replyBtn"
                                        href="adminReply.php?id=<?= $row['message_id']; ?>">

                                        Reply

                                    </a>

                                <?php

                                } else {

                                ?>

                                    <a
                                        class="viewBtn"
                                        href="adminReply.php?id=<?= $row['message_id']; ?>">

                                        View

                                    </a>

                                <?php

                                }

                                ?>

                            </td>

                        </tr>

                    <?php } ?>

                </table>

                <div id="pageNumberSection">

                    <?php if ($page > 1) { ?>

                        <a class="pageBtn"
                            href="?page=<?= $page - 1 ?>&search=<?= $search ?>&status=<?= $status ?>">

                            <span class="material-symbols-outlined arrowback">

                                arrow_back

                            </span>

                        </a>

                    <?php } ?>

                    <?php

                    for ($i = 1; $i <= $totalPages; $i++) {

                    ?>

                        <a
                            class="pageNumber <?= ($i == $page) ? 'activeNumber' : ''; ?>"
                            href="?page=<?= $i ?>&search=<?= $search ?>&status=<?= $status ?>">

                            <?= $i ?>

                        </a>

                    <?php

                    }

                    ?>

                    <?php if ($page < $totalPages) { ?>

                        <a
                            class="pageBtn"
                            href="?page=<?= $page + 1 ?>&search=<?= $search ?>&status=<?= $status ?>">

                            <span class="material-symbols-outlined arrowforward">

                                arrow_forward

                            </span>

                        </a>

                    <?php } ?>

                </div>

            </div>

        </article>

    </main>

</body>

</html>