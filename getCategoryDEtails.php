<?php
include("connect.php");

header('Content-Type: application/json');

$category = $_GET['category'] ?? '';
$year = $_GET['year'] ?? date('Y');
$month = $_GET['month'] ?? '';

$where = "WHERE YEAR(e.event_date) = '$year'";

if ($month != "") {
    $where .= " AND MONTH(e.event_date) = '$month'";
}

$response = [
    "title" => "",
    "items" => []
];

$sql = "";


// FACULTY
if ($category == "Faculty") {

    $response['title'] = "Top 5 Faculties";

    $sql = "
SELECT
    e.category_name AS name,
    COUNT(e.event_id) AS total
FROM event e
$where
AND e.event_category='Faculty'
GROUP BY e.category_name
ORDER BY total DESC
LIMIT 5
";
}


// RESIDENTIAL 
else if ($category == "Residential College") {

    $response['title'] = "Top 5 Colleges";

    $sql = "
SELECT
    e.category_name AS name,
    COUNT(e.event_id) AS total
FROM event e
$where
AND e.event_category='Residential College'
GROUP BY e.category_name
ORDER BY total DESC
LIMIT 5
";

}


// CLUB 
else if ($category == "Club / Society") {

    $response['title'] = "Top 5 Organisers";

    $sql = "
SELECT
    e.organiser_name AS name,
    COUNT(e.event_id) AS total
FROM event e
$where
AND e.event_category='Club / Society'
GROUP BY e.organiser_name
ORDER BY total DESC
LIMIT 5
";

}


// UNIVERSITY
else if ($category == "University-Wide") {

    $response['title'] = "Top 5 Organisers";

    $sql = "
    SELECT
        e.organiser_name AS name,
        COUNT(e.event_id) AS total
    FROM event e
    $where
    AND e.event_category='University-Wide'
    GROUP BY e.organiser_name
    ORDER BY total DESC
    LIMIT 5
    ";
}
else {

    echo json_encode($response);
    exit();

}

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $response['items'][] = $row;
}

echo json_encode($response);
