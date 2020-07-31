<?php
session_start();
require_once "function.php";
// Here the user id is harcoded.
// You can integrate your authentication code here to get the logged in user id
$userId = 1;
$sid=$_SESSION["stdid"];
$conn = mysqli_connect("localhost", "root", '', "library") or die("Connection failed: " . mysqli_connect_error());
if (mysqli_connect_errno()){
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
$query = "SELECT ISBNNumber,ReturnDate FROM tblissuedbookdetails where StudentID = '".$sid."';";
$result = mysqli_query($conn,$query);
$outputString = '';
foreach($result as $row)
 {
    if($row['ReturnDate']==""){
    $userRating = userRating($sid, $row['ISBNNumber'], $conn);
    $totalRating = totalRating($row['ISBNNumber'], $conn);
    $ISBNNumber = "'".$row['ISBNNumber']."'";
    $outputString .= '

    <ul class="list-inline"  onMouseLeave="mouseOutRating(' .$ISBNNumber.','.$userRating.');"> ';
    for ($count = 1; $count <= 5; $count ++) {
        $starRatingId = $ISBNNumber . '_' . $count;
        
        if ($count <= $userRating) {
            
            $outputString .= '<li value="' . $count . '" ISBN="' . $starRatingId . '" class="star selected">&#9733;</li>';
        } else {
            $outputString .= '<li value="' . $count . '"  ISBN="' . $starRatingId . '" class="star" onclick="addRating(' . $ISBNNumber . ',' . $count . ');" onMouseOver="mouseOverRating(' . $ISBNNumber . ',' . $count . ');">&#9733;</li>';
        }
    }
    $outputString .= '
 </ul>
 <p class="review-note">Total Reviews: ' . $totalRating.'</p>
</div>
 ';

}
}
echo $outputString;
?>