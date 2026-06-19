<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "utem_eventify"
);

if (!$conn)
{
    die("Connection Failed: " . mysqli_connect_error());
}

?>