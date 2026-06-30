<?php 
include("connect.php");

$keyword=$_GET['keyword'];
$sql = "SELECT * FROM event
        WHERE event_name LIKE '%$keyword%'
        AND event_date >=CURDATE()
        ORDER BY event_date ASC";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result)>0)
    {
        while($event = mysqli_fetch_assoc($result))
            {
                echo "
                <a href='eventdetails.php?id="
                .$event['event_id']."' class = 'searchItem'>"
                .$event['event_name']."
                </a>";
            }
    }
    else
        {
            echo "<p class='searchItem'>No event found</p>";
        }
?>