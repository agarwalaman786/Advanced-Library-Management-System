<?php

// Here the user id is harcoded.
// You can integrate your authentication code here to get the logged in user id
session_start();
$userId = 1;
$sid=$_SESSION['stdid'];
if (isset($_POST["index"], $_POST["ISBN"])) {
    
    $bookId = $_POST["ISBN"];
    $rating = $_POST["index"];
    $conn = mysqli_connect("localhost", "root", '', "library") or die("Connection failed: " . mysqli_connect_error());
    if (mysqli_connect_errno()) {
          printf("Connect failed: %s\n", mysqli_connect_error());
          exit();  
    }
    $checkIfExistQuery = "select * from rating where StudentID = '" . $sid . "' and ISBN = '" . $bookId . "'";
    if ($result = mysqli_query($conn, $checkIfExistQuery)) {
        $rowcount = mysqli_num_rows($result);
    }
    
    if ($rowcount == 0) {
        $insertQuery = "INSERT INTO rating(StudentID,ISBN,rate) VALUES ('" . $sid . "','" . $bookId . "','" . $rating . "') ";
        $result = mysqli_query($conn, $insertQuery);
        echo "success";
    } else {
        echo "Already Voted!";
    }
}
