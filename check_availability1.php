<?php 
require_once("includes/config.php");
// code user mobile number availablity
if(!empty($_POST["phoneno"])) {
	$mobileno= $_POST["phoneno"];
		$sql ="SELECT MobileNumber FROM tblstudents WHERE MobileNumber=:mobileno";
$query= $dbh -> prepare($sql);
$query-> bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query -> rowCount() > 0)
{
echo "<span style='color:red'> Mobile number already exists .</span>";
 echo "<script>$('#submit').prop('disabled',true);</script>";
} else{
	echo "<span style='color:green'>Mobile number available for Registration .</span>";
 echo "<script>$('#submit').prop('disabled',false);</script>";
}
}
?>
