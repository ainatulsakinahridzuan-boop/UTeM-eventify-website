<?php
include("connect.php");

$event_id = $_GET['id'] ?? 0;

if($event_id == 0){
    header("Location: browse.php");
    exit();
}

$sql = "SELECT * FROM event WHERE event_id = $event_id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Event Registration</title>
        <link rel="stylesheet" href="registration.css">

        <!--Google Material Icons-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined">

    </head>
    <body>
        <div class="container">
            <h1>Register for <?php echo $row['event_name']; ?></h1>
            <hr>

            <div class="main-content">
                <!--DETAILS FORM-->
                <form class="left-section" id="registerForm">

                    <!--DETAILS SECTION-->
                    <div class="form-card">
                        <div class="card-header">
                            <h2>1. Fill in Your Details</h2>
                        </div>
                        <div class="card-body">
                            <label>Full Name</label>
                            <br>
                            <input type="text" required>
                            <br>

                            <label>Matric Number</label>
                            <br>
                            <input type="text" required>
                            <br>

                            <label>Phone Number</label>
                            <br>
                            <input type="tel" placeholder="01x-xxxxxxx" required>
                            <br>

                            <label>E-mail Address</label>
                            <br>
                            <input type="email" required>
                            <br>

                            <select required>
                                <option value="">Select Faculty</option>
                                <option>FTMK</option>
                                <option>FTKEK</option>
                                <option>FTKM</option>
                                <option>FTKE</option>
                                <option>FPTT</option>
                                <option>FTKIP</option>
                            </select>

                           
                            
                        </div>


                    </div>

                    <!--PAYMENT SECTION-->
                    <div class="payment-card">

                        <div class="card-header">
                            <h2>2. Payment</h2>
                        </div>

                        <div class="card-body">
                            

                          

                            <div class="bank-details">
                                <h3>Bank Details</h3>
                                <p><strong>Bank:</strong> Maybank</p>
                                <p><strong>Account Name:</strong> UTeM Admin </p>
                                <p><strong>Account Number:</strong> 1234567890</p>
                            </div>

                            <label>Upload Payment Receipt</label>
                            <br>
                            <input type="file" accept="image/*,.pdf" required>

                            <div class="refund-policy">

                                <span class="material-symbols-outlined">
                                    warning
                                </span>

                                <strong>Cancelation & Refund Policy:</strong>

                                If you cancel your registration, 
                                please note that no refunds will be made

                            </div>

                            <hr>

                            <div class="payment-summary">

                                <p>Payment Summary</p>
                                <p>RM <?php echo number_format($row['event_fee'], 2); ?></p>

                            </div>




                        </div>
                    </div>


                    <button type="submit">
                        Confirm Registration
                    </button>




                
                </form>

                <!--EVENT DETAILS CARD-->

                <div class="right-section">
                    
                    <div class="event-card">

                        <div class ="event-image">
                             <img src="poster/<?php echo $row['poster']; ?>" alt="Event Poster">
                        </div>

                        <h2><?php echo $row['event_name']; ?></h2>

                        <p>
                            <span class="material-symbols-outlined">calendar_month</span>
                            <?php echo $row['event_date']; ?>
                        </p>

                        <p>
                            <span class="material-symbols-outlined">location_on</span>
                            <?php echo $row['event_venue']; ?>
                        </p>

                        <p>
                            <span class="material-symbols-outlined">schedule</span>
                            <?php echo $row['event_time']; ?>
                        </p>

                        <p>
                            <span class="material-symbols-outlined">attach_money</span>
                            RM <?php echo $row['event_fee']; ?>
                        </p>

                      

                        <hr>

                        <div class="seat-alert">

                            <span class="material-symbols-outlined">
                                warning
                            </span>

                            Only 25 seats left!
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <script>
        document.getElementById("registerForm").addEventListener("submit", function(e){

            e.preventDefault();

            alert("Registration confirmed! Thank you for registering.");

});
</script>


    </body>
</html>