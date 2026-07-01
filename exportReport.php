<?php
include("connect.php");

$year = $_GET['year'] ?? date('Y');
$month = $_GET['month'] ?? '';

// FILTER
$filter = " WHERE YEAR(e.event_date) = $year ";

if ($month != '') {
    $filter .= " AND MONTH(e.event_date) = $month ";
}

// ================= SUMMARY =================
$sqlSummary = "
SELECT
    COUNT(DISTINCT e.event_id) AS total_events,
    COUNT(r.registration_id) AS total_registration,

SUM(
    CASE
        WHEN r.attendance_status='Present'
        THEN 1
        ELSE 0
    END
) AS total_attendance,

SUM(
    CASE
        WHEN r.attendance_status='Absent'
        THEN 1
        ELSE 0
    END
) AS total_absent
FROM event e
LEFT JOIN registration r
ON e.event_id = r.event_id
$filter
";

$summary = mysqli_fetch_assoc(mysqli_query($conn, $sqlSummary));

// ================= EVENT DETAILS =================
$sql = "
SELECT
    e.event_name,
    e.event_date,
    e.event_category,
    e.category_name,
    e.organiser_name,
    COUNT(r.registration_id) AS total_registration,
    SUM(
        CASE
            WHEN r.attendance_status='Present'
            THEN 1
            ELSE 0
        END
    ) AS total_attendance
FROM event e
LEFT JOIN registration r
ON e.event_id = r.event_id
$filter
GROUP BY e.event_id
ORDER BY e.event_date DESC
";

$result = mysqli_query($conn, $sql);

// FILE NAME
$filename = "UTeM_Event_Report_" . $year;

if ($month != '') {
    $filename .= "_" . $month;
}

$filename .= ".csv";

// DOWNLOAD
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $filename);

$output = fopen("php://output", "w");

// ================= REPORT HEADER =================

fputcsv($output, ["UTeM EVENTIFY REPORT"]);
fputcsv($output, []);

fputcsv($output, ["Year", $year]);
fputcsv($output, ["Month", ($month == "" ? "All Months" : date("F", mktime(0, 0, 0, $month, 1)))]);
fputcsv($output, []);

fputcsv($output, ["Total Events", $summary['total_events']]);
fputcsv($output, ["Total Registrations", $summary['total_registration']]);
fputcsv($output, ["Total Attendance", $summary['total_attendance']]);

fputcsv($output, []);
fputcsv($output, []);

// ================= TABLE HEADER =================

fputcsv($output, [
    "Event Name",
    "Date",
    "Category",
    "Sub Category",
    "Organiser",
    "Registration",
    "Attendance",
    "Absent",
    "Attendance Rate"
]);

// ================= TABLE DATA =================

while ($row = mysqli_fetch_assoc($result)) {

    $rate = 0;

    if ($row['total_registration'] > 0) {
        $rate = round(
            ($row['total_attendance'] / $row['total_registration']) * 100,
            1
        ) . "%";
    } else {
        $rate = "0%";
    }

    fputcsv($output, [
        $row['event_name'],
        date("d M Y", strtotime($row['event_date'])),
        $row['event_category'],
        $row['category_name'],
        $row['organiser_name'],
        $row['total_registration'],
        $row['total_attendance'],
        $row['total_absent'],
        $rate
    ]);
}

fclose($output);
exit;
