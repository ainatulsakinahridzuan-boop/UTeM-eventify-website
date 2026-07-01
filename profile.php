<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="profile.css">
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

            <!--DROP DOWN-->
            <div id="dropdownBtn">
                <span>User Profile Management</span>
                <span class="material-symbols-outlined dropdownSymbol">
                    arrow_drop_down                    
                </span>
            </div>
            
            <!--MENU-->
            <div id="menu">
                <ul>
                    <li><a href="profile.html" class="active">Profile</a></li>
                    <li><a href="registeredEvent.html" class="notActive">Registered Event</a></li> <!--HTML BELUM BUAT-->
                </ul>
            </div>

            <!--SIGN OUT-->
            <div id="signOut">
                <button type="button" onclick="window.location.href='login.html'">
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

                    <h4>Ainatul Sakinah binti<br>Muhd Ridzuan </h4>
                    <hr>

                    <p>
                        <span class="material-symbols-outlined matricSymbol">
                        badge
                        </span>
                        Dxxxxxxxxx
                    </p>

                    <p>
                        <span class="material-symbols-outlined mailSymbol">
                            mail
                        </span>
                        xxxxx@student.utem.edu.my
                    </p>

                    <p>
                        <span class="material-symbols-outlined callSymbol">
                            call
                        </span>
                        01x-xxxxxxx
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
                        <input type="text" value="Ainatul Sakinah binti Muhd Ridzuan" readonly>
                        <span class="material-symbols-outlined lockSymbol">
                            lock
                        </span>
                    </div>

                    <!--EMAIL-->
                    <p class="formLabel">Email</p>
                    <div class="inputBox">
                        <input type="email" value="xxxxx@student.utem.edu.my" readonly>
                        <span class="material-symbols-outlined lockSymbol">
                            lock
                        </span>
                    </div>

                    <!--MATRIC NUM-->
                    <p class="formLabel">Matric Number</p>
                    <div class="inputBox">
                        <input type="text" value="Dxxxxxxxxx" readonly>
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
                    <p class="formLabel">Phone Number</p>
                    <div class="inputBox">
                        <input type="text" value="01x-xxxxxxx">
                    </div>
    
                    <!--SAVE BUTTON-->
                    <button type="button" class="saveBtn">Save Changes</button>
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
                    <p class="formLabel">Current Password</p>
                    <div class="inputBox">
                        <input type="password" placeholder="Enter current password">
                        <span class="material-symbols-outlined eyeSymbol">
                            visibility
                        </span>
                    </div>

                    <!--NEW PASS-->
                    <p class="formLabel">New Password</p>
                    <div class="inputBox">
                        <input type="password" placeholder="Enter new password">
                        <span class="material-symbols-outlined eyeSymbol">
                            visibility
                        </span>
                    </div>

                    <!--CONFIRM PASS-->
                    <p class="formLabel">Confirm New Password</p>
                    <div class="inputBox">
                        <input type="password" placeholder="Confirm new password">
                        <span class="material-symbols-outlined eyeSymbol">
                            visibility
                        </span>
                    </div>

                    <!--SAVE BUTTON-->
                    <button type="button" class="saveBtn">Update Password</button>
                </div>

                <!------------------------------------------------------------------------------>
                <!--NEED HELP-->
                <div class="helpBox">
                    <span class="material-symbols-outlined helpSymbol">
                        help
                    </span>

                    <p>Need help? Contact us if you need to update your account information</p>
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
</script>


</body>
</html>