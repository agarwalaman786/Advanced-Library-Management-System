<?php 
require_once("includes/config.php");
if(!empty($_POST["studentid2"])) {
  $studentid2= strtoupper($_POST["studentid2"]);
 
    $sql ="SELECT FullName,Status FROM tblstudents WHERE StudentId=:studentid2 ";
$query= $dbh -> prepare($sql);
$query-> bindParam(':studentid2', $studentid2, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query -> rowCount() > 0)
{
foreach ($results as $result) {
if($result->Status==0)
{
echo "<span style='color:red'> Student ID Blocked </span>"."<br />";
echo "<b>Student Name-</b>" .$result->FullName;
 echo "<script>$('#submit').prop('disabled',true);</script>";
} else {
?>


<?php  
echo htmlentities($result->FullName);
 echo "<script>$('#submit').prop('disabled',false);</script>";
}
}
}
 else{
  
  echo "<span style='color:red'> Invaid Student Id. Please Enter Valid Student id .</span>";
 echo "<script>$('#submit').prop('disabled',true);</script>";
}
}



?>
