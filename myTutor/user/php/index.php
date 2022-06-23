<?php

    session_start();
    if (!isset($_SESSION['sessionid'])){
        echo "<script>alert ('Session not available. Please login');s </script>";
        echo "<script>window.location.replace('login.php')</script>";
    }

    include_once("dbconnect.php");
 
    if(isset($_POST['submit'])){
        $operation = $_POST['submit'];
        if ($operation == 'search'){
            $search = $_POST['search'];
            $option = $_POST['option'];
            if($option == "name"){
                $sqlsubjects = "SELECT * FROM tbl_subjects WHERE subject_name LIKE '%$search%'";
            }else if ($option == "subjectID"){
                if ($search != null && is_numeric($search) == true){
                    $sqlsubjects = "SELECT * FROM tbl_subjects WHERE subject_id = '$search'";
                }else if ($search != null && is_numeric($search) === false){
                    echo "<script>alert ('Please input integer only')</script>";
                    $sqlsubjects = "SELECT * FROM tbl_subjects";
                }else{
                    $sqlsubjects = "SELECT * FROM tbl_subjects";
                }
            }else if ($option == "tutorID"){
                if ($search != null && is_numeric($search) == true){
                    $sqlsubjects = "SELECT * FROM tbl_subjects WHERE tutor_id = '$search'";
                }else if($search != null && is_numeric($search) == false){
                    echo "<script>alert ('Please input integer only')</script>";
                    $sqlsubjects = "SELECT * FROM tbl_subjects";
                }else{
                    $sqlsubjects = "SELECT * FROM tbl_subjects";
                }
            }
           
        }
    }
    else{
        $sqlsubjects = "SELECT * FROM tbl_subjects";
    }

    $results_per_page = 10;
    if(isset($_GET['pageno'])){ 
        $pageno = (int)$_GET['pageno'];
        $page_first_result = ($pageno - 1) * $results_per_page;
    }else{
        $pageno = 1;
        $page_first_result = 0;
    }

    $stmtSubject = $conn->prepare( $sqlsubjects);
    $stmtSubject->execute();
    $number_of_result = $stmtSubject->rowCount();
    $number_of_page = ceil($number_of_result / $results_per_page);
    $sqlsubjects = $sqlsubjects . " LIMIT $page_first_result , $results_per_page";
    $stmtSubject = $conn->prepare( $sqlsubjects);
    $stmtSubject->execute();
    $result = $stmtSubject->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $stmtSubject->fetchAll();

    function truncate($string, $length, $dots = "..."){
        return (strlen($string) > $length) ? substr($string, 0, $length - strlen($dots)) . $dots : $string;
    }

    $conn= null;
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
    <title>MyTutor User Main Page</title>
</head>

<body>
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

    <div class="w3-blue" style="text-align:center">
        <h3>Subject List</h3>
    </div>

    <div class="w3-card w3-container w3-padding w3-margin w3-round">
        <h3>Subject Search</h3>
        <form method="post">
            <div>
                <select class="w3-input w3-block w3-round w3-border w3-text-blue" name="option">
                    <option value="name">Search by Subject Name</option>
                    <option value="subjectID">Search by Subject ID</option>
                    <option value="tutorID">Search by Tutor ID</option>
                </select>
                <input class="w3-input w3-round w3-border" type="search" name="search" id="idsearch" placeholder="Enter you search term">
            </div>
            <br>
            <button class="w3-button w3-blue w3-round w3-right" type="submit" name="submit" value="search">Search</button>
        </form>
    </div>

    <div class="w3-margin w3-border w3-grid-template">
            <?php

                $i=0;
                foreach ($rows as $subjects) {
                    $i++;
                    $subjectID =  $subjects['subject_id'];
                    $subjectName = $subjects['subject_name'];
                    $subjectDescription = $subjects['subject_description'];
                    $subjectPrice = $subjects['subject_price'];
                    $subjectTutor = $subjects['tutor_id'];
                    $subjectSessions = $subjects['subject_sessions'];
                    $subjectRating = $subjects['subject_rating'];
                    echo "<a href ='subjectDetail.php?subjectID=$subjectID' style='text-decoration:none;'> <div class='w3-card w3-white w3-margin'>
                    <header class='w3-container w3-blue'>" . truncate($subjectName,15) . "</header>";
                    echo "<img class='w3-image' src='../resources/courses/$subjectID.png'" . " onerror=this.onerror=null; this.src='../resources/courses/$subjectID.png'" . " style='width:100%;height:300px;'>";
                    echo "<hr>";
                    echo "<div class='w3-blue'>
                        <p>ID: $subjectID</p>
                        <p>Price: RM$subjectPrice</p>
                        <p>Tutor ID: $subjectTutor</p> 
                        <p>Sessions: $subjectSessions</p>
                        <p>Rating: $subjectRating</p>
                        </div>
                    </div> </a>";
                }
                   
            ?>
    </div>

    <br>

    <?php 
        $num = 1;
        if ($pageno == 1){
            $num = 1;
        } else if ($pageno == 2){
            $num = ($num) + 10;
        }else {
            $num = $pageno * 10 - 9;
        }
        echo "<div class='w3-container w3-row'>";
        echo "<center>";
        for ($page = 1; $page <= $number_of_page; $page++){
            echo '<a href="index.php?pageno=' . $page . '" style="text-decoration:none">&nbsp&nbsp' . $page . ' </a>';
        }
        echo "( " . $pageno . " )";
        echo "</center>";
        echo "</div>";
    ?>

    <footer class="w3-footer w3-center w3-blue"><p>MyTutor</p></footer>

</body>
</html>