<?php
$currentPage = "event";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>UTeM Eventify Add Event</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="addEvent.css">

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
                <h1>Add New Event</h1>
                <p>Fill in the details to create a new event</p>
            </div>

            <div id="contentSection">
                <!--Event form-->
                <div id="formContainer">
                    <div id="titleSection">
                        <h3>Event Information</h3>
                    </div>

                    <form method="post" action="addeventprocess.php" enctype="multipart/form-data">
                        <label>Event Name <span class="required">*</span></label>
                        <input type="text" placeholder="Enter event name" name="event_name" id="event_name">

                        <label>Description <span class="required">*</span></label>
                        <textarea placeholder="Tell us about the event...." name="description" id="description"></textarea>
                        <div class="row">

                            <div class="inputBox">
                                <label>Date <span class="required">*</span></label>
                                <input type="date" name="event_date" id="event_date">
                            </div>

                            <div class="inputBox">
                                <label>Time <span class="required">*</span></label>
                                <input type="time" name="event_time" id="event_time">
                            </div>
                        </div>

                        <label>Venue <span class="required">*</span></label>
                        <input type="text" placeholder="Enter venue" name="venue" id="venue">

                        <div class="row">
                            <div class="inputBox">
                                <label>Category <span class="required">*</span></label>
                                <select name="category" id="category">
                                    <option value="" selected disabled>Select Category</option>
                                    <option value="University Wide">University Wide</option>
                                    <optgroup label="Faculty">
                                        <option value="FTKEK">FTKEK</option>
                                        <option value="FTKE">FTKE</option>
                                        <option value="FTKM">FTKM</option>
                                        <option value="FTKIP">FTKIP</option>
                                        <option value="FTMK">FTMK</option>
                                        <option value="FAIX">FAIX</option>
                                        <option value="FPTT">FPTT</option>
                                    </optgroup>
                                    <optgroup label="Residential Colleges">
                                        <option value="KOLEJ KEDIAMAN LESTARI">KOLEJ KEDIAMAN LESTARI</option>
                                        <option value="KOLEJ KEDIAMAN AL-JAZARI">KOLEJ KEDIAMAN AL-JAZARI</option>
                                        <option value="KOLEJ KEDIAMAN SATRIA TUAH">KOLEJ KEDIAMAN SATRIA TUAH</option>
                                        <option value="KOLEJ KEDIAMAN SATRIA JEBAT">KOLEJ KEDIAMAN SATRIA JEBAT</option>
                                        <option value="KOLEJ KEDIAMAN SATRIA KASTURI">KOLEJ KEDIAMAN SATRIA KASTURI</option>
                                        <option value="KOLEJ KEDIAMAN SATRIA LEKIR">KOLEJ KEDIAMAN SATRIA LEKIR</option>
                                        <option value="KOLEJ KEDIAMAN SATRIA LEKIU">KOLEJ KEDIAMAN SATRIA LEKIU</option>
                                    </optgroup>
                                    <optgroup label="Club/Society">
                                        <option value="ACADEMIC AND CAREER">ACADEMIC AND CAREER</option>
                                        <option value="LEADERSHIP AND MANAGEMENT">LEADERSHIP AND MANAGEMENT</option>
                                        <option value="VOLUNTEERISM">VOLUNTEERISM</option>
                                        <option value="SPORTS AND RECREATION">SPORTS AND RECREATION</option>
                                        <option value="CULTURE AND NATIONAL IDENTITY">CULTURE AND NATIONAL IDENTITY</option>
                                    </optgroup>
                                </select>
                            </div>

                            <div class="inputBox">
                                <label>Organiser <span class="required">*</span></label>
                                <input type="text" placeholder="Enter organiser name" name="organiser" id="organiser">
                            </div>
                        </div>

                        <label>Fee <span class="required">*</span></label>
                        <input type="number" placeholder="RM x.xx" name="fee" id="fee">

                        <label>Quota <span class="required">*</span></label>
                        <input type="number" placeholder="Enter maximum amount of participants" name="quota">

                        <label>Upload Poster <span class="required">*</span></label>

                        <label for="poster" id="uploadBox">
                            <p class="uploadText">
                                <span class="clickText">Click to upload</span>
                                <span class="dragText">or drag and drop</span>
                            <p>PNG or JPEG up to 10MB</p>
                            </p>
                        </label>
                        <input type="file" id="poster" name="poster" accept=".png,.jpg,.jpeg" hidden>
                        <p id="fileName"></p>

                        <div id="buttonSection">

                            <button type="submit" id="saveBtn">
                                Save Event
                            </button>

                            <button type="reset" id="cancelBtn">
                                Cancel
                            </button>

                        </div>
                    </form>

                </div>

                <div id="previewContainer">

                    <h3>Preview</h3>

                    <div id="previewPoster">


                        <div class="eventImage">
                            <img id="previewImg" src="" alt="Preview Image">
                        </div>

                        <h2 id="previewName">Event Name</h2>

                        <p id="previewDate">Date</p>
                        <p id="previewVenue">Venue</p>
                        <p id="previewTime">Time</p>
                        <p id="previewFee">Fee</p>
                    </div>
                    <br>
                    <div id="previewOrganiserSection">
                        <h2>Organised By:</h2>
                        <p id="previewOrganiser">Organiser Name</p>
                    </div>

                </div>
            </div>
        </main>

    </div>

    <script>
        // Display preview image when a file is selected
        document.getElementById('poster').addEventListener('change', function(event) {

            let file = event.target.files[0];

            if (file) {
                let reader = new FileReader();

                reader.onload = function(e) {
                    let img = document.getElementById('previewImg');
                    img.src = e.target.result;
                    img.style.display = "block";
                }

                reader.readAsDataURL(file);
            }
        });


        // EVENT NAME
        document.getElementById('event_name').addEventListener('input', function() {
            document.getElementById('previewName').innerText = this.value;
        });

        // DATE
        document.getElementById('event_date').addEventListener('input', function() {
            document.getElementById('previewDate').innerText = "Date: " + this.value;
        });

        // TIME
        document.getElementById('event_time').addEventListener('input', function() {
            document.getElementById('previewTime').innerText = "Time: " + this.value;
        });

        // VENUE
        document.getElementById('venue').addEventListener('input', function() {
            document.getElementById('previewVenue').innerText = "Venue: " + this.value;
        });

        // CATEGORY
        document.getElementById('category').addEventListener('change', function() {

            let organiser = "";
            let isEditable = false;

            switch (this.value) {

                case "University Wide":
                    organiser = "";
                    isEditable = true;
                    break;

                case "FTKEK":
                    organiser = "TELeCSA";
                    break;

                case "FTKE":
                    organiser = "";
                    break;

                case "FTKM":
                    organiser = "MeTECH";
                    break;

                case "FTKIP":
                    organiser = "SMET";
                    break;

                case "FTMK":
                    organiser = "FICTS";
                    break;

                case "FAIX":
                    organiser = "AIXA";
                    break;

                case "FPTT":
                    organiser = "TeMAN";
                    break;

                case "KOLEJ KEDIAMAN LESTARI":
                    organiser = "JAKSIS LESTARI";
                    break;
                case "KOLEJ KEDIAMAN AL-JAZARI":
                    organiser = "JAKSIS AL-JAZARI";
                    break;
                case "KOLEJ KEDIAMAN SATRIA TUAH":
                    organiser = "JAKSIS SATRIA TUAH";
                    break;
                case "KOLEJ KEDIAMAN SATRIA JEBAT":
                    organiser = "JAKSIS SATRIA JEBAT";
                    break;
                case "KOLEJ KEDIAMAN SATRIA KASTURI":
                    organiser = "JAKSIS SATRIA KASTURI";
                    break;
                case "KOLEJ KEDIAMAN SATRIA LEKIR":
                    organiser = "JAKSIS SATRIA LEKIR";
                    break;
                case "KOLEJ KEDIAMAN SATRIA LEKIU":
                    organiser = "JAKSIS SATRIA LEKIU";
                    break;


                case "ACADEMIC AND CAREER":
                case "LEADERSHIP AND MANAGEMENT":
                case "VOLUNTEERISM":
                case "SPORTS AND RECREATION":
                case "CULTURE AND NATIONAL IDENTITY":
                    organiser = "";
                    isEditable = true;
                    break;

                default:
                    organiser = "";
                    isEditable = false;
            }

            let organiserInput = document.getElementById('organiser');
            let previewOrganiser = document.getElementById('previewOrganiser');

            organiserInput.value = organiser;
            organiserInput.readOnly = !isEditable;

            // Update preview
            if (isEditable) {
                previewOrganiser.innerText = organiserInput.value || "Organiser Name";
            } else {
                previewOrganiser.innerText = organiser;
            }
        });

        // ORGANISER
        document.getElementById('organiser').addEventListener('input', function() {

            document.getElementById('previewOrganiser').innerText = this.value;

        });

        // FEE
        document.getElementById('fee').addEventListener('input', function() {
            document.getElementById('previewFee').innerText = "Fee: RM " + this.value;
        });

        // Display file name and size when a file is selected
        document.getElementById('poster').onchange = function() {
            let file = this.files[0];
            document.getElementById('fileName').innerHTML =
                "File: " + file.name + " (" + (file.size / 1024).toFixed(1) + " KB)";
        }
    </script>

</body>

</html>