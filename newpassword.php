<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(isset($_POST['change']))
{
$pass1=md5($_POST['pass1']);
$pass2=md5($_POST['pass2']);
$mobile = $_SESSION['session_phone'];

if($pass1 == $pass2){
  $sql ="UPDATE tblstudents SET Password = :pass1 WHERE MobileNumber= :mobile";
$query= $dbh -> prepare($sql);
$query-> bindParam(':mobile', $mobile, PDO::PARAM_STR);
$query-> bindParam(':pass1', $pass1, PDO::PARAM_STR);
$query-> execute();
echo "<script>alert('Successfully updated');
window.location.href='index.php';</script>";
}
else{
    echo "<script>alert('New Password and Confirm Password doesn't match')</script>";
}
}
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

</head>
<body>
    <!------MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->
<div class="content-wrapper">
<div class="container">
<div class="row pad-botm">
<div class="col-md-12">
<h4 class="header-line">New Password</h4>
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
<label>New Password</label>
<input class="form-control" type="text" name="pass1" required autocomplete="off" />
<label>Confirm Password</label>
<input class="form-control" type="text" name="pass2" required autocomplete="off" />
<button type="submit" name="change" class="btn btn-info">Submit</button>
</div>
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