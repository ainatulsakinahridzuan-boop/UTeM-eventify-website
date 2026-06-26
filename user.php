<?php

$currentPage = "user";
include("connect.php");

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$limit = 10;
$offset = ($page - 1) * $limit;

$faculty = $_GET['faculty'] ?? '';
$search = $_GET['search'] ?? '';

$sql = "
SELECT
    s.student_name,
    s.matric_no,
    s.faculty,
    s.student_email,
    COUNT(r.registration_id) AS total_events

FROM student s

LEFT JOIN registration r
ON s.student_email = r.student_email

WHERE 1=1
";

if (!empty($faculty)) {
    $sql .= " AND s.faculty = '$faculty'";
}

if (!empty($search)) {
    $sql .= "
    AND (
        s.student_name LIKE '%$search%'
        OR s.matric_no LIKE '%$search%'
        OR s.student_email LIKE '%$search%'
    )";
}

$sql .= "
GROUP BY
    s.student_email,
    s.student_name,
    s.matric_no,
    s.faculty

ORDER BY s.student_name

LIMIT $limit OFFSET $offset
";

$countQuery = "
SELECT COUNT(*) AS total
FROM student s
WHERE 1=1
";

if (!empty($faculty)) {
    $countQuery .= " AND s.faculty = '$faculty'";
}

if (!empty($search)) {
    $countQuery .= "
    AND (
        s.student_name LIKE '%$search%'
        OR s.matric_no LIKE '%$search%'
        OR s.student_email LIKE '%$search%'
    )";
}

$countResult = $conn->query($countQuery);
$countRow = $countResult->fetch_assoc();

$totalRecords = $countRow['total'];
$totalPages = ceil($totalRecords / $limit);

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>UTeM Eventify Users</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="user.css?v=2">
    <!--GOOGLE ICON-->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>

<body>

    <?php include("sidebar.php"); ?>

    <!-- CONTENT -->
    <main>

        <article>

            <div id="topContainer">
                <div id="topSection">

                    <div>
                        <h1>Manage Users</h1>
                        <p>View and manage all events</p>
                    </div>
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
                                placeholder="Search User"
                                value="<?= htmlspecialchars($search); ?>">

                        </div>

                        <div id="facultySection">

                            <select id="faculty" name="faculty" onchange="this.form.submit()">

                                <option value="">All Faculties</option>

                                <option value="FTKEK" <?= ($faculty == "FTKEK") ? "selected" : ""; ?>>FTKEK</option>
                                <option value="FTKE" <?= ($faculty == "FTKE") ? "selected" : ""; ?>>FTKE</option>
                                <option value="FTKM" <?= ($faculty == "FTKM") ? "selected" : ""; ?>>FTKM</option>
                                <option value="FTKIP" <?= ($faculty == "FTKIP") ? "selected" : ""; ?>>FTKIP</option>
                                <option value="FTMK" <?= ($faculty == "FTMK") ? "selected" : ""; ?>>FTMK</option>
                                <option value="FAIX" <?= ($faculty == "FAIX") ? "selected" : ""; ?>>FAIX</option>
                                <option value="FPTT" <?= ($faculty == "FPTT") ? "selected" : ""; ?>>FPTT</option>
                                <option value="SPS" <?= ($faculty == "SPS") ? "selected" : ""; ?>>SPS</option>
                                <option value="IPTK" <?= ($faculty == "IPTK") ? "selected" : ""; ?>>IPTK</option>

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
                        <th></th>
                        <th>NAME</th>
                        <th>MATRIC NO.</th>
                        <th>FACULTY</th>
                        <th>EMAIL</th>
                        <th>REGISTERED EVENTS</th>
                    </tr>


                    <?php while ($row = $result->fetch_assoc()) { ?>

                        <tr>

                            <td>
                                <span class="material-symbols-outlined profileIcon">
                                    account_circle
                                </span>
                            </td>

                            <td><?php echo $row['student_name']; ?></td>

                            <td><?php echo $row['matric_no']; ?></td>

                            <td><?php echo $row['faculty']; ?></td>

                            <td><?php echo $row['student_email']; ?></td>

                            <td><?php echo $row['total_events']; ?></td>

                        </tr>

                    <?php } ?>
                </table>

                <!--BUTTON-->
                <div id="pageNumberSection">

                    <?php if ($page > 1) { ?>
                        <a class="pageBtn"
                            href="?page=<?= $page - 1 ?>&faculty=<?= $faculty ?>&search=<?= $search ?>">

                            <span class="material-symbols-outlined arrowback">
                                arrow_back
                            </span>

                        </a>
                    <?php } ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++) { ?>

                        <a class="pageNumber <?= ($i == $page) ? 'activeNumber' : ''; ?>"
                            href="?page=<?= $i ?>&faculty=<?= $faculty ?>&search=<?= $search ?>">

                            <?= $i ?>

                        </a>

                    <?php } ?>

                    <?php if ($page < $totalPages) { ?>
                        <a class="pageBtn"
                            href="?page=<?= $page + 1 ?>&faculty=<?= $faculty ?>&search=<?= $search ?>">

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