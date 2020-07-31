
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | Add Book</title>
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


<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:mainpage.php');
}
else{  
include('includes/header.php');?>

<!-- MENU SECTION END-->
    <div class="content-wra">
    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Add Book</h4>
                            </div>
    </div>

      <!------MENU SECTION START-->
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<div class="panel panel-info">
<div class="panel-heading">
Book Info
</div>
<div class="panel-body">

<?php
$ISBN=$_POST['isbn'];
$conn = mysqli_connect("localhost","root","","library");
if($conn){
  $sql = "select ISBN,title,author,Genre from universaldataset where ISBN = '".$ISBN."'";
  
  $result = mysqli_query($conn,$sql); 
  if(mysqli_num_rows($result)>0){
  foreach ($result as $row) {

?>

  <form role="form" method="post" action = "AddINDATBASE.php">

  <div class="form-group">
  <label>ISBN Number<span style="color:red;">*</span></label>
  <input class="form-control" type="text" name="isbn"  required="required" autocomplete="off" value="<?php echo $ISBN?>" />
  </div>

  <div class="form-group">
  <label>Book Name<span style="color:red;">*</span></label>
  <input class="form-control" type="text" name="bookname" autocomplete="off"  required="required" value="<?php echo $row['title']?>" />
  </div>

  <div class="form-group">
  <label> Category<span style="color:red;">*</span></label>
  <input class="form-control" type="text" name="category"  required="required" autocomplete="off" value="<?php echo $row['Genre']?>">
  </div>


  <div class="form-group">
  <label> Author<span style="color:red;">*</span></label>
  <input class="form-control" type="text" name="author"  required="required" autocomplete="off" value="<?php echo $row['author']?>" />
  </div>


  <div class="form-group">
  <label>Price<span style="color:red;">*</span></label>
  <input class="form-control" type="text" name="price" autocomplete="off"   required="required" />
  </div>
  <button type="submit" name="add" class="btn btn-info">Add </button>
  </form>
  </div>
  </div>
  </div>

    </div>

    </div>
    </div>
  </div>

  <?php
  }
}
}

else{
echo htmlentities("Enter the correct ISBN number");
header('location:add-book.php');
}

?>

     <!-- CONTENT-WRAPPER SECTION END-->      <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php }
?>
