<?php
session_start();
include("connect.php");
$currentPage = "registration";

// GET FILTERS
$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'All Events';

// PAGINATION
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// BASE QUERY
$where = "WHERE 1=1";

// SEARCH
if (!empty($search)) {
    $where .= " AND event_name LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'";
}

// FILTER CATEGORY
if ($filter != "All Events") {
    $where .= " AND event_category = '" . mysqli_real_escape_string($conn, $filter) . "'";
}

// COUNT TOTAL
$totalQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM event $where");
$totalRow = mysqli_fetch_assoc($totalQuery);
$totalRecords = $totalRow['total'];
$totalPages = ceil($totalRecords / $limit);

// GET DATA
$query = "
    SELECT * FROM event
    $where
    ORDER BY event_date DESC
    LIMIT $limit OFFSET $offset
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>UTeM Eventify Registration Management</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="registrationDetails.css">
    <!--GOOGLE ICON-->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>

<body>

    <div id="wrapper">

        <!-- SIDEBAR -->
        <?php include("sidebar.php") ?>

        <!-- CONTENT -->
        <main>

            <article>

                <div id="topContainer">
                    <div id="topSection">

                        <div>
                            <h1>Event Management</h1>
                            <p>View and manage all events</p>
                        </div>
                    </div>



                    <form method="GET" id="searchSection">

                        <div id="searchBox">
                            <span class="material-symbols-outlined search">search</span>
                            <input type="text" name="search" placeholder="Search Event" value="<?php echo $search; ?>">
                        </div>

                        <div id="filterSection">
                            <select id="filter" name="filter" onchange="this.form.submit()">

                                <option value="All Events" <?= $filter == "All Events" ? "selected" : "" ?>>All Events</option>
                                <option value="University-Wide" <?= $filter == "University-Wide" ? "selected" : "" ?>>University-Wide</option>
                                <option value="Faculty" <?= $filter == "Faculty" ? "selected" : "" ?>>Faculty</option>
                                <option value="Residential College" <?= $filter == "Residential College" ? "selected" : "" ?>>Residential College</option>
                                <option value="Club / Society" <?= $filter == "Club / Society" ? "selected" : "" ?>>Club / Society</option>

                            </select>
                        </div>

                    </form>
                </div>

                <div id="tableSection">

                    <table>

                        <tr>
                            <th>POSTER</th>
                            <th>EVENT NAME</th>
                            <th>STATUS</th>
                            <th>CATEGORIES</th>
                            <th></th>
                        </tr>

                        <?php while ($row = mysqli_fetch_assoc($result)) {

                            // STATUS LOGIC
                            $today = date("Y-m-d");
                            $status = ($row['event_date'] >= $today) ? "Open" : "Ended";
                        ?>

                            <tr>

                                <td>
                                    <div class="poster">
                                        <img src="poster/<?php echo $row['poster']; ?>">
                                    </div>
                                </td>

                                <td>
                                    <div class="eventInfo">
                                        <h4><?php echo $row['event_name']; ?></h4>
                                        <p><?php echo $row['event_date']; ?></p>
                                    </div>
                                </td>

                                <td>
                                    <span class="<?= $status == "Open" ? "openStatus" : "closedStatus" ?>">
                                        <?php echo $status; ?>
                                    </span>
                                </td>

                                <td>
                                    <div class="category">
                                        <?php echo $row['event_category']; ?>
                                    </div>
                                </td>

                                <td>
                                    <div class="arrow">
                                        <a href="backToRegistrationDetails.php?event_id=<?= $row['event_id']; ?>">
                                            <span class="material-symbols-outlined">
                                                arrow_menu_open
                                            </span>
                                        </a>
                                    </div>
                                </td>

                            </tr>

                        <?php } ?>

                    </table>

                    <!--BUTTON-->
                    <div id="pageNumberSection">

                        <?php if ($page > 1): ?>
                            <a href="?page=<?php echo $page - 1; ?>&search=<?php echo $search; ?>&filter=<?php echo $filter; ?>">
                                <button class="pageBtn">
                                    <span class="material-symbols-outlined arrowback">
                                        arrow_back
                                    </span>
                                </button>
                            </a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>&filter=<?php echo $filter; ?>">
                                <button class="pageNumber <?= ($i == $page) ? 'activeNumber' : '' ?>">
                                    <?php echo $i; ?>
                                </button>
                            </a>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages): ?>
                            <a href="?page=<?php echo $page + 1; ?>&search=<?php echo $search; ?>&filter=<?php echo $filter; ?>">
                                <button class="pageBtn">
                                    <span class="material-symbols-outlined arrowforward">
                                        arrow_forward
                                    </span>
                                </button>
                            </a>
                        <?php endif; ?>

                    </div>

                </div>

            </article>

        </main>
</body>

</html>