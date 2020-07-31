<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(isset($_POST['change']))
{
$mobile=$_POST['mobile'];
$_SESSION['session_phone'] = $mobile;
  $sql ="SELECT MobileNumber FROM tblstudents WHERE MobileNumber=:mobile";
$query= $dbh -> prepare($sql);
$query-> bindParam(':mobile', $mobile, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
$apiKey = urlencode('mx5LazLxP2o-XsDJMdIBwK0VWdyYJxL8CAH2by8J5Q');
$numbers = urlencode($_POST["mobile"]);
$sender = urlencode('TXTLCL');
$message = rand(10000,99999);
echo $message;
$_SESSION['session_otp'] = $message;
$data = 'apikey=' . $apiKey . '&numbers=' . $numbers . "&sender=" . $sender . "&message=" . $message;
$ch = curl_init('https://api.textlocal.in/send/?' . $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$numbers='';
}
else {
echo "<script>alert('Mobile Number is not registered.');</script>"; 
}
}


if(isset($_POST['verify_otp']))
{
	$otp = $_POST['otp'];
	if($otp == $_SESSION['session_otp'])
	{
		unset($_SESSION['session_otp']);
		echo "Verified";
		ob_start();
		header("Location: newpassword.php");
		ob_end_flush();
		die();

	}
	else{
		echo "Enter correct OTP";
	}
}


/*if(isset($_POST['verify_otp']))
{
	$otp = $_POST['otp'];
	echo $otp;
	echo $message;
	echo "hello";
	if($otp == $message)
	{
		echo "Verified";
	}
	else{
		echo "Enter correct OTP";
	}
}*/
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | Password Recovery </title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    <script>
function myFunction() {
  document.getElementById("demo").innerHTML = '<label>Enter OTP :</label><br><input type="" name=""/><button type="submit" name="change" class="btn btn-info">Verify OTP</button>';
}
</script>

</head>
<body>
    <!------MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->
<div class="content-wrapper">
<div class="container">
<div class="row pad-botm">
<div class="col-md-12">
<h4 class="header-line">User Password Recovery</h4>
</div>
</div>
             
<!--LOGIN PANEL START-->           
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" >
<div class="panel panel-info">
<div class="panel-heading">
 PASSWORD RECOVERY
</div>
<div class="panel-body">
<form role="form" name="chngpwd" method="post">

<div class="form-group">
<label>Enter Reg Mobile No</label>
<input class="form-control" type="text" name="mobile" required autocomplete="off" />
</div>
 <button type="submit" name="change" class="btn btn-info">Send OTP</button>
</form>


<form name="verifyotp" method="post">
 <div class="form-group">
<label>Enter OTP</label>
<input class="form-control" type="text" name="otp" required autocomplete="off" />
</div>
<button type="submit" name="verify_otp" class="btn btn-info">Verify OTP</button>
</form>

 </div>
</div>
</div>
</div>  

<!---LOGIN PABNEL END-->            
             
 
    </div>
    </div>
     <!-- CONTENT-WRAPPER SECTION END-->
 <?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>

</body>
</html>
