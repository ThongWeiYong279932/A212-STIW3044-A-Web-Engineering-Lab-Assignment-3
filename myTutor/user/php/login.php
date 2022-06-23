<?php
    include_once("dbconnect.php");

    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $password = sha1($_POST['password']);
        $sqlLogin = "SELECT * FROM tbl_users WHERE user_email = '$email' AND user_password = '$password'";
        $statement = $conn->prepare($sqlLogin);
        $statement->execute();
        $number_of_rows = $statement->fetchColumn();
        if ($number_of_rows > 0){
            session_start();
            $_SESSION["sessionid"] = session_id();
            echo "<script>alert('Login Success')</script>";
            echo "<script>window.location.replace('index.php')</script>";
        }else{
            echo "<script>alert('Login Failed')</script>";
            echo "<script>window.location.replace('login.php')</script>";
        }
    }

    $conn= null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css//w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="../javaScripts/login.js"></script>
    <title>MyTutor User Login</title>
</head>

<body onload="loadCookies()">
    <header class="w3-header w3-blue w3-center w3-padding-32">
        <h3>MyTutor User Login Page</h3>
    </header>

    <div>
        <p class="w3-container w3-padding w3-blue w3-center">Login Page</p>
    </div>

    <div style="display: flex;justify-content: center">
        <div class="w3-card w3-padding w3-margin" style="width:600px;margin:auto;">
            <form name="loginForm" action="login.php" method="post">
                <p>
                    <label class="w3-text-blue"><b>Email</b></label>
                    <input class="w3-input w3-round w3-border" type="email" name="email" id="idemail" placeholder="Input your Email" required>
                </p>
                <p>
                    <label class="w3-text-blue"><b>Password</b></label>
                    <input class="w3-input w3-round w3-border" type="password" name="password" id="idpassword" placeholder="Input your Password" required>
                </p>
                <p>
                    <input class="w3-check" name="rememberme" type="checkbox" id="idremember" onclick="rememberMe()">
                    <label>Remember me</label>
                </p>
                <p class="w3-center">
                    <input class="w3-button w3-round w3-border w3-blue " type="submit" name="submit" id="idsubmit" value="Login">
                </p>
            </form>
            <div style="text-align:center">
                <a class="w3-text-blue" href="register.php">Don't have an account? Register first</a>
            </div>
        </div>
    </div>

    <div id="cookieNotice" class="w3-right w3-block" style="display:none;">
        <div class="w3-red">
            <h4>Cookie Consent</h4>
            <p>
                This website uses cookies or similar technologies, to enhance your browsing experience
                and provide personalized recommendations. By continuing to use our website, you agree to our
                <a style="color:#115cfa;" href="/privacy-policy"></a>
            </p>
            <div>
                <button onclick = "acceptCookieConsent();">Accept</button>
            </div>
        </div>        
    </div>
    
    <script>
        let cookie_consent = getCookie("user_cookie_consent");
        if (cookie_consent != ""){
            document.getElementById("cookieNotice").style.display = "none";
        }else{
            document.getElementById("cookieNotice").style.display = "block";
        }
    </script>

    <footer class="w3-footer w3-center w3-blue w3-bottom"><p>MyTutor</p></footer>

</body>
</html>