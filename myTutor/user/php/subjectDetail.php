<?php
    session_start();
    if (!isset($_SESSION['sessionid'])){
        echo "<script>alert ('Session not available. Please login');s </script>";
        echo "<script>window.location.replace('login.php')</script>";
    }

    include_once("dbconnect.php");

    if (isset($_POST['submit'])){
        $subjectID = $_POST['subjectID'];
        echo "<script> window.location.replace('subjectDetail.php?subjectID=$subjectID')</script>";
        echo "<script>alert('OK.');</script>";
    }
    if (isset($_GET['subjectID'])) {
        $subjectID = $_GET['subjectID'];
        $sqlsubjects = "SELECT tbl_subjects.subject_id, tbl_subjects.subject_name, tbl_subjects.subject_description, tbl_subjects.subject_price, 
        tbl_subjects.tutor_id, tbl_subjects.subject_sessions, tbl_subjects.subject_rating, tbl_tutors.tutor_name, tbl_tutors.tutor_email, 
        tbl_tutors.tutor_phone FROM tbl_subjects INNER JOIN tbl_tutors ON tbl_subjects.tutor_id = tbl_tutors.tutor_id WHERE subject_id = '$subjectID'";
        $stmtSubject = $conn->prepare($sqlsubjects);
        $stmtSubject->execute();
        $number_of_result = $stmtSubject->rowCount();
        if ($number_of_result > 0) {
            $result = $stmtSubject->setFetchMode(PDO::FETCH_ASSOC);
            $rows = $stmtSubject->fetchAll();
        } else {
            echo "<script>alert('Subject not found.');</script>";
            echo "<script> window.location.replace('index.php')</script>";
        }
    }else{
        echo "<script>alert('Page Error.');</script>";
        echo "<script> window.location.replace('index.php')</script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/w3.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="../javaScripts/menu.js"></script>
    <title>MyTutor Subject Details</title>
</head>

<body style="max-width:1200px;margin:0 auto;">
    <div class="w3-sidebar w3-bar-block" style="display:none" id="mySidebar">
        <button onclick="w3_close()" class="w3-bar-item w3-button w3-large w3-blue">Close &times;</button>
        <hr>
        <a href="index.php" class="w3-bar-item w3-button">Dashboard</a>
        <a href="#" class="w3-bar-item w3-button">Courses</a>
        <a href="tutorList.php" class="w3-bar-item w3-button">Tutors</a>
        <a href="#" class="w3-bar-item w3-button">Subscription</a>
        <a href="#" class="w3-bar-item w3-button">Profile</a>
    </div>

    <div class="w3-blue">
        <button class="w3-blue w3-button w3-xlarge" onclick="w3_open()">&#9776</button>
            <div class="w3-container" style="text-align:center">
                <h1>MyTutor</h1>
            </div>
    </div>
    <div><br><div>
    <div class="w3-bar w3-blue" style="text-align:center">
        <h3>Subject Details</h3>
        <a href="index.php" class="w3-bar-item w3-button w3-right">Back</a>
    </div>

    <div>
        <?php
            foreach ($rows as $subjects) {
                $subjectID =  $subjects['subject_id'];
                $subjectName = $subjects['subject_name'];
                $subjectDescription = $subjects['subject_description'];
                $subjectPrice = $subjects['subject_price'];
                $subjectTutorID = $subjects['tutor_id'];
                $subjectTutorName = $subjects['tutor_name'];
                $subjectTutorEmail = $subjects['tutor_email'];
                $subjectTutorPhone = $subjects['tutor_phone'];
                $subjectSessions = $subjects['subject_sessions'];
                $subjectRating = $subjects['subject_rating'];
            }
            echo "<div class='w3-padding w3-center'><img class='w3-image resimg' src=../resources/courses/$subjectID.png" .
            " onerror=this.onerror=null;this.src='../resources/courses/newSubject.png'"
            . " ></div><hr>";
            echo "<div class='w3-container w3-padding-large'><h4><b>$subjectName</b></h4>";
            echo " <div>
                    <p><b>Subject ID:</b> $subjectID</p>
                    <p><b>Description</b><br>$subjectDescription</p>
                    <p><b>Price: </b>RM$subjectPrice</p>
                    <p><b>Subject Tutor Name:</b> $subjectTutorName</p>
                    <p><b>Subject Tutor ID:</b> $subjectTutorID</p>
                    <p><b>Subject Tutor Email:</b> $subjectTutorEmail</p>
                    <p><b>Subject Tutor Phone No:</b> $subjectTutorPhone</p>
                    <p><b>Subject Sessions:</b> $subjectSessions</p>
                    <p><b>Subject Rating:</b> $subjectRating</p>
                    <form action='subjectDetail.php' method='post'> 
                        <input type='hidden'  name='subjectID' value='$subjectID'>
                        <input class='w3-button w3-blue w3-round' type='submit' name='submit' value='Take Subject'>
                    </form>
                    </div>
                    </div>";


        ?>
    </div>

    <footer class="w3-footer w3-center w3-blue"><p>MyTutor</p></footer>
</body>

</html>