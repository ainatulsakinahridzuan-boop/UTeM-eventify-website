<?php 
session_start();
include("connect.php");

if (!isset($_SESSION['matric_no']))
    {
        header("Location: login.php");
        exit();
    }

    $matric_no = $_SESSION['matric_no'];

    $sql= "SELECT * FROM student WHERE matric_no='$matric_no'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if (isset($_POST['save_phone']))
        {
            $phone_number = $_POST['phone_number'];

            $updateSql="UPDATE student
                        SET phone_number= '$phone_number'
                        WHERE matric_no='$matric_no'";

            mysqli_query($conn, $updateSql);

            echo "<script>
            alert('Phone number updated successfully!');
            window.location='profile.php'
            </script>";
            exit();
        }

        $sql ="SELECT * FROM student WHERE matric_no='$matric_no'";
        $result= mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        //CHANGE PASS
        if (isset($_POST['update_password']))
            {
                $current_password = $_POST['current_password'];
                $new_password = $_POST ['new_password'];
                $confirm_password=$_POST['confirm_password'];

                if (!password_verify($current_password, $row['password']))
                    {
                        echo "<script> alert('Current password is incorrect'); </script>";
                    }
                    else if($new_password != $confirm_password)
                        {
                            echo "<script> alert('New password and confirm password does not match'); </script>";
                        }
                        else 
                            {
                                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                                $updatePasswordSql="UPDATE student
                                                    SET password='$hashed_password'
                                                    WHERE matric_no='$matric_no'";

                                mysqli_query($conn, $updatePasswordSql);

                                echo "<script>
                                alert('Password updated successfully!');
                                window.location='profile.php'
                                </script>";
                                exit();

                            }
            }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="profile.css?v=2">
    <title>UTeM Eventify</title>
    <!--GOOGLE ICON-->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>
<body>
     <!-- SIDEBAR -->
        <nav id="sidebar">

            <!--LOGO-->
            <div id="logoSection">
                <img src="image/logo.png" alt="logo">
                <div id="logoText">
                    <span>UTeM</span>
                    <span>Eventify</span>                    
                </div>
            </div>

            <!--MENU-->
            <div id="menu">                
                <h4>User Profile Management</h4>
                <ul>
                    <li><a href="profile.php" class="active">Profile</a></li>
                    <li><a href="registeredEvent.php" class="notActive">Registered Event</a></li> <!--HTML BELUM BUAT-->
                </ul>
            </div>

            <!--SIGN OUT-->
            <div id="btn">
                <button type="button" onclick="window.location.href='home_page.php'">
                        Home
                </button>

                <button type="button" onclick="window.location.href='login.php'">
                    Sign Out
                </button>
            </div>

        </nav>

        <!-------------------------------------------------------------------------------------------->
        <!--BANNER-->
        <div id="banner">
            <h4>User Profile</h4>
            <p>User Profile Management
                <span class="material-symbols-outlined arrowSymbol">
                    chevron_right
                </span>
                Profile
            </p>
        </div>

        <!-------------------------------------------------------------------------------------------->
        <!--MAIN-->
        <div id="main">

            <!--CONTAINER PROFILE-->
            <div id="profileContainer">

                <!--CONTENT DALAM CONTAINER-->
                <div id="profileCard">
                    <span class="material-symbols-outlined profile">
                        account_circle
                    </span>

                    <h4><?php echo $row ['student_name']; ?> </h4>
                    <hr>

                    <p>
                        <span class="material-symbols-outlined matricSymbol">
                        badge
                        </span>
                        <?php echo $row ['matric_no']; ?>
                    </p>

                    <p>
                        <span class="material-symbols-outlined mailSymbol">
                            mail
                        </span>
                        <?php echo $row['student_email']; ?>
                    </p>

                    <p>
                        <span class="material-symbols-outlined callSymbol">
                            call
                        </span>
                        <?php echo $row['phone_number']; ?>
                    </p>
                </div>
            </div>

            <!------------------------------------------------------------------------------->
            <div id="rightSection">

                <!--ACC INFO-->
                <div class="infoCard">
                    <h4>
                        <span class="material-symbols-outlined lockSymbol1">
                            lock
                        </span>
                        Account Information
                    </h4>

                    <p class="description">
                        This information is managed by the system and cannot be changed
                    </p>

                    <!--NAMA-->
                    <p class="formLabel">Full Name</p>
                    <div class="inputBox">
                        <input type="text" value="<?php echo $row['student_name'];?>" readonly>
                        <span class="material-symbols-outlined lockSymbol">
                            lock
                        </span>
                    </div>

                    <!--EMAIL-->
                    <p class="formLabel">Email</p>
                    <div class="inputBox">
                        <input type="email" value="<?php echo $row['student_email'];?>" readonly>
                        <span class="material-symbols-outlined lockSymbol">
                            lock
                        </span>
                    </div>

                    <!--MATRIC NUM-->
                    <p class="formLabel">Matric Number</p>
                    <div class="inputBox">
                        <input type="text" value="<?php echo $row['matric_no'];?>" readonly>
                        <span class="material-symbols-outlined lockSymbol">
                            lock
                        </span>
                    </div>
                </div>

                <!------------------------------------------------------------------------------>
                <!--EDITABLE INFO-->
                <div class="editableInfo">
                    <h4>
                        <span class="material-symbols-outlined editSymbol">
                            edit_square
                        </span>
                        Editable Information
                    </h4>

                    <p class="description">
                        Update your contact information
                    </p>

                    <!--PHONE NUM-->
                    <form method="POST" action="profile.php">

                    <p class="formLabel">Phone Number</p>

                    <div class="inputBox">
                        <input type="text" name="phone_number" value="<?php echo $row['phone_number'];?>" placeholder="Enter phone number">
                    </div>
    
                    <!--SAVE BUTTON-->
                    <button type="submit" name="save_phone" class="saveBtn">Save Changes</button>
                    </form>
                </div>

                <!------------------------------------------------------------------------------>
                <!--CHANGE PASSWORD-->
                <div class="changePass">
                    <h4>
                        <span class="material-symbols-outlined passSymbol">
                            password
                        </span>
                        Change Password
                    </h4>

                    <p class="description">
                        For your security, please use a strong password
                    </p>

                    <!--CURRENT PASS-->
                    <form method="POST" action="profile.php">
                    <p class="formLabel">Current Password</p>
                    <div class="inputBox">
                        <input type="password" id="current_password" name="current_password" placeholder="Enter current password">
                        <span class="material-symbols-outlined eyeSymbol"
                            onclick="togglePassword('current_password', this)">    
                            visibility
                        </span>
                    </div>

                    <!--NEW PASS-->
                    <p class="formLabel">New Password</p>
                    <div class="inputBox">
                        <input type="password" id="new_password" name="new_password" placeholder="Enter new password">
                        <span class="material-symbols-outlined eyeSymbol"
                            onclick="togglePassword('new_password', this)">    
                            visibility
                        </span>
                    </div>

                    <!--CONFIRM PASS-->
                    <p class="formLabel">Confirm New Password</p>
                    <div class="inputBox">
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password">
                        <span class="material-symbols-outlined eyeSymbol"
                            onclick="togglePassword('confirm_password', this)">        
                            visibility
                        </span>
                    </div>

                    <!--SAVE BUTTON-->
                    <button type="submit" name="update_password" class="saveBtn">Update Password</button>
                    </form>
                </div>
                

                <!------------------------------------------------------------------------------>
                <!--NEED HELP-->
                <div class="helpBox">
                    <span class="material-symbols-outlined helpSymbol">
                        help
                    </span>

                    <p>Need help? <a href="contact.php">Contact</a> 
                    us if you need to update your account information</p>
                </div>

            </div> <!--RIGHT SECTION PUNYA-->
        </div> <!--MAIN PUNYA-->



    
    

<!--JS STARTS HERE-->
<script>
    const dropdownBtn = document.getElementById("dropdownBtn");
    const menu = document.getElementById("menu");
    const arrow = document.querySelector(".dropdownSymbol");

    //hide menu bila tekan button drop down
    dropdownBtn.addEventListener("click", function(){
    menu.classList.toggle("hideMenu");
    arrow.classList.toggle("rotate");
    })

    function togglePassword(id, icon)
    {
        let input = document.getElementById(id);
        if (input.type ==="password")
        {
            input.type="text";
            icon.textContent="visibility_off";
        }
        else 
        {
            input.type="password";
            icon.textContent="visibility"
        }
    }
</script>


</body>
</html>