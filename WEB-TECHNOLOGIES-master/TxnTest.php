<?php
session_start();
error_reporting(0);
include('C:\xampp\htdocs\onlinelibrarymanagement\library\includes\config.php');
	header("Pragma: no-cache");
	header("Cache-Control: no-cache");
	header("Expires: 0");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Check Out Page</title>

<meta name="GENERATOR" content="Evrsoft First Page">
   

    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="http://localhost/onlinelibrarymanagement/library/assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="http://localhost/onlinelibrarymanagement/library/assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="http://localhost/onlinelibrarymanagement/library/assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
<div class="content-wrapper">
<div class="container">
<div class="row pad-botm">
<div class="col-md-12">
</div>
</div>
             
<!--LOGIN PANEL START-->           
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" >
<div class="panel panel-info">
<div class="panel-heading">
 PAYMENT 
</div>
<div class="panel-body">
<form role="form" method="post" action="pgRedirect.php">
<?php
$ISBNNum = $_GET["ISBNNum"];
$_SESSION['bisbn']=$ISBNNum;
$conn = mysqli_connect("localhost","root","","library");
$sql = "SELECT * from tblissuedbookdetails where ISBNNumber = '".$ISBNNum."'";

$results = mysqli_query($conn,$sql);
if($conn){
	foreach ($results as $result) {

		?>
		<div class="form-group">
	<label>Payment for</label><br>
	<input class="form-control" id="CUST_ID" tabindex="2" maxlength="12" size="12" name="CUST_ID" autocomplete="off" value="<?php echo "Library"?>">
</div>
		<div class="form-group">
	<label>ORDER ID</label><br>
	<input class="form-control" id="ORDER_ID" tabindex="2" maxlength="12" size="12" name="ORDER_ID" autocomplete="off" value="<?php echo  "ORDS" . rand(10000,99999999)?>">
</div>
<div class="form-group">
<label>Student ID</label>
<input class="form-control" type="text" name="Student_ID" required autocomplete="Open"  value="<?php 
$sid = $_SESSION['stdid'];
echo $sid;
?>"/>
</div>
<div class="form-group">
    <label>Book ISBN</label><br>
    <input class="form-control" id="INDUSTRY_TYPE_ID" tabindex="4" maxlength="12" size="12" name="INDUSTRY_TYPE_ID" autocomplete="off" value="<?php echo htmlentities($result['ISBNNumber']);?>">
</div>

<div class="form-group">
	<label>PATH</label>
	<input class="form-control" id="CHANNEL_ID" tabindex="4" maxlength="12" size="12" name="CHANNEL_ID" autocomplete="off" value="WEB">
</div>
<div class ="form-group">
<label>FINE</label>
<input class="form-control" type="fine" name="TXN_AMOUNT" required autocomplete="Open" value="<?php echo htmlentities($result['fine'])?>">
</div>
<?php 
}
} ?>
<button name="pay" class="btn btn-info" value="CheckOut" type="submit"	>PAY</button>
</form>
 </div>
</div>
</div>
</div>  
<!---LOGIN PABNEL END-->            
             
 
    </div>
    </div>
     <!-- CONTENT-WRAPPER SECTION END-->

</body>
</html>
