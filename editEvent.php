<?php
include('connect.php');
$currentPage = "event";

if (!isset($_GET['id'])) {
    header("Location: event.php");
    exit();
}

$event_id = $_GET['id'];

$sql = "SELECT * FROM event WHERE event_id='$event_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "Event not found.";
    exit();
}

$row = mysqli_fetch_assoc($result);

$name = $row['event_name'];
$desc = $row['event_desc'];
$date = $row['event_date'];
$time = $row['event_time'];
$venue = $row['event_venue'];
$category = $row['event_category'];
$fee = $row['event_fee'];
$quota = $row['event_quota'];
$poster = $row['poster'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>UTeM Eventify Edit Event</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="editEvent.css">

    <!--Google Material Icons-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined">
</head>

<body>
    <div id="wrapper">

        <!-- SIDEBAR -->
        <?php include("sidebar.php") ?>

        <!-- CONTENT -->
        <main>

            <div id="topContainer">
                <h1>Edit Event</h1>
                <p>Update event information</p>
            </div>

            <div id="contentSection">

                <div id="formContainer">

                    <div id="titleSection">
                        <h3>Event Information</h3>
                    </div>

                    <form method="post" action="updateEventProcess.php" enctype="multipart/form-data">
                        <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                        <input type="hidden" name="oldPoster" value="<?php echo $poster; ?>">
                        <label>Event Name <span class="required">*</span></label>
                        <input type="text" name="event_name" id="event_name" value="<?php echo $name; ?>">
                        <label>Description <span class="required">*</span></label>
                        <textarea name="description" id="description"><?php echo $desc; ?></textarea>

                        <div class="row">
                            <div class="inputBox">
                                <label>Date <span class="required">*</span></label>
                                <input type="date" name="event_date" id="event_date" value="<?php echo $date; ?>" readonly>
                            </div>

                            <div class="inputBox">
                                <label>Time <span class="required">*</span></label>
                                <input type="time" name="event_time" id="event_time" value="<?php echo $time; ?>">
                            </div>
                        </div>

                        <label>Venue <span class="required">*</span></label>
                        <input type="text"
                            name="venue"
                            id="venue"
                            value="<?php echo $venue; ?>">
                        <div class="row">

                            <div class="inputBox">
                                <label>Category <span class="required">*</span></label>

                                <select id="category" disabled>

                                    <option value="University Wide"
                                        <?php if ($category == "University Wide") echo "selected"; ?>>
                                        University Wide
                                    </option>

                                    <optgroup label="Faculty">
                                        <option value="FTKEK" <?php if ($category == "FTKEK") echo "selected"; ?>>FTKEK</option>
                                        <option value="FTKE" <?php if ($category == "FTKE") echo "selected"; ?>>FTKE</option>
                                        <option value="FTKM" <?php if ($category == "FTKM") echo "selected"; ?>>FTKM</option>
                                        <option value="FTKIP" <?php if ($category == "FTKIP") echo "selected"; ?>>FTKIP</option>
                                        <option value="FTMK" <?php if ($category == "FTMK") echo "selected"; ?>>FTMK</option>
                                        <option value="FAIX" <?php if ($category == "FAIX") echo "selected"; ?>>FAIX</option>
                                        <option value="FPTT" <?php if ($category == "FPTT") echo "selected"; ?>>FPTT</option>
                                    </optgroup>

                                    <optgroup label="Residential Colleges">

                                        <option value="KOLEJ KEDIAMAN LESTARI" <?php if ($category == "KOLEJ KEDIAMAN LESTARI") echo "selected"; ?>>
                                            KOLEJ KEDIAMAN LESTARI
                                        </option>

                                        <option value="KOLEJ KEDIAMAN AL-JAZARI" <?php if ($category == "KOLEJ KEDIAMAN AL-JAZARI") echo "selected"; ?>>
                                            KOLEJ KEDIAMAN AL-JAZARI
                                        </option>

                                        <option value="KOLEJ KEDIAMAN SATRIA TUAH" <?php if ($category == "KOLEJ KEDIAMAN SATRIA TUAH") echo "selected"; ?>>
                                            KOLEJ KEDIAMAN SATRIA TUAH
                                        </option>

                                        <option value="KOLEJ KEDIAMAN SATRIA JEBAT" <?php if ($category == "KOLEJ KEDIAMAN SATRIA JEBAT") echo "selected"; ?>>
                                            KOLEJ KEDIAMAN SATRIA JEBAT
                                        </option>

                                        <option value="KOLEJ KEDIAMAN SATRIA KASTURI" <?php if ($category == "KOLEJ KEDIAMAN SATRIA KASTURI") echo "selected"; ?>>
                                            KOLEJ KEDIAMAN SATRIA KASTURI
                                        </option>

                                        <option value="KOLEJ KEDIAMAN SATRIA LEKIR" <?php if ($category == "KOLEJ KEDIAMAN SATRIA LEKIR") echo "selected"; ?>>
                                            KOLEJ KEDIAMAN SATRIA LEKIR
                                        </option>

                                        <option value="KOLEJ KEDIAMAN SATRIA LEKIU" <?php if ($category == "KOLEJ KEDIAMAN SATRIA LEKIU") echo "selected"; ?>>
                                            KOLEJ KEDIAMAN SATRIA LEKIU
                                        </option>

                                    </optgroup>

                                    <optgroup label="Club/Society">

                                        <option value="ACADEMIC AND CAREER" <?php if ($category == "ACADEMIC AND CAREER") echo "selected"; ?>>
                                            ACADEMIC AND CAREER
                                        </option>

                                        <option value="LEADERSHIP AND MANAGEMENT" <?php if ($category == "LEADERSHIP AND MANAGEMENT") echo "selected"; ?>>
                                            LEADERSHIP AND MANAGEMENT
                                        </option>

                                        <option value="VOLUNTEERISM" <?php if ($category == "VOLUNTEERISM") echo "selected"; ?>>
                                            VOLUNTEERISM
                                        </option>

                                        <option value="SPORTS AND RECREATION" <?php if ($category == "SPORTS AND RECREATION") echo "selected"; ?>>
                                            SPORTS AND RECREATION
                                        </option>

                                        <option value="CULTURE AND NATIONAL IDENTITY" <?php if ($category == "CULTURE AND NATIONAL IDENTITY") echo "selected"; ?>>
                                            CULTURE AND NATIONAL IDENTITY
                                        </option>
                                    </optgroup>
                                </select>

                                <input type="hidden" name="category" value="<?php echo $category; ?>">
                            </div>

                            <div class="inputBox">
                                <label>Organiser <span class="required">*</span></label>
                                <input type="text" name="organiser" value="<?php echo $row['organiser_name']; ?>" readonly>
                            </div>
                        </div>

                        <label>Fee <span class="required">*</span></label>
                        <input type="number" step="0.01" name="fee" id="fee" value="<?php echo $fee; ?>" readonly>

                        <label>Quota <span class="required">*</span></label>
                        <input type="number" name="quota" id="quota" value="<?php echo $quota; ?>" min="<?php echo $quota; ?>">

                        <label>Current Poster</label>
                        <div style="margin-bottom:15px;">
                            <img src="poster/<?php echo $poster; ?>" style="width:250px;border-radius:10px;">
                        </div>

                        <label>Upload New Poster</label>
                        <label for="poster" id="uploadBox">
                            <p>
                                <span class="clickText">Click to upload</span>
                                or drag and drop
                            </p>
                            <p>PNG or JPG (Optional)</p>
                        </label>

                        <input type="file" id="poster" name="poster" accept=".png,.jpg,.jpeg" hidden>
                        <p id="fileName"></p>

                        <div id="buttonSection">
                            <button type="submit" id="saveBtn">
                                Update Event
                            </button>

                            <button type="button" id="cancelBtn" onclick="window.location='event.php'">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>

                <div id="previewContainer">

                    <h3>Preview</h3>
                    <div id="previewPoster">

                        <div class="eventImage">
                            <img id="previewImg" src="poster/<?php echo $poster; ?>" style="width:100%;">
                        </div>

                        <h2 id="previewName">
                            <?php echo $name; ?>
                        </h2>

                        <p id="previewDate">
                            Date: <?php echo $date; ?>
                        </p>

                        <p id="previewVenue">
                            Venue: <?php echo $venue; ?>
                        </p>

                        <p id="previewTime">
                            Time: <?php echo $time; ?>
                        </p>

                        <p id="previewFee">
                            Fee: RM <?php echo $fee; ?>
                        </p>

                    </div>

                    <br>

                    <div id="previewOrganiserSection">

                        <h3>Organised By</h3>

                        <p id="previewOrganiser">
                            <?php echo $row['organiser_name']; ?>
                        </p>

                    </div>
                </div>
            </div>

        </main>

    </div>

    <script>
        // Preview Poster
        document.getElementById("poster").addEventListener("change", function(e) {

            let file = e.target.files[0];

            if (file) {

                let reader = new FileReader();

                reader.onload = function(event) {
                    document.getElementById("previewImg").src = event.target.result;
                }

                reader.readAsDataURL(file);

                document.getElementById("fileName").innerHTML =
                    "File : " + file.name;

            }

        });


        // Event Name
        document.getElementById("event_name").addEventListener("input", function() {
            document.getElementById("previewName").innerHTML = this.value;
        });

        // Time
        document.getElementById("event_time").addEventListener("input", function() {
            document.getElementById("previewTime").innerHTML = "Time: " + this.value;
        });


        // Venue
        document.getElementById("venue").addEventListener("input", function() {
            document.getElementById("previewVenue").innerHTML = "Venue: " + this.value;
        });

        const quota = document.getElementById("quota");
        const oldQuota = Number(quota.defaultValue);

        quota.addEventListener("input", function() {

            if (Number(this.value) <= oldQuota) {

                this.setCustomValidity(
                    "New quota must be greater than the original quota."
                );

            } else {

                this.setCustomValidity("");

            }

        });
    </script>
</body>

</html>