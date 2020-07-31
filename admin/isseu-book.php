<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:mainpage.php');
}
else{ 

if(isset($_POST['issue']))
{
$studentid=strtoupper($_POST['studentid']);
$studentid2 = strtoupper($_POST['studentid2']);
$bookid = $_POST['bookid'];
if($studentid2==''){
$sql="INSERT INTO  tblissuedbookdetails(StudentID,ISBNNumber)VALUES('".$studentid."','".$bookid."')";
}
else{
$sql="INSERT INTO  tblissuedbookdetails(StudentID,StudentId2,ISBNNumber)VALUES('".$studentid."','".$studentid2."',
'".$bookid."')";
}
$sql1="select ISBNNumber from tblissuedbookdetails where ISBNNumber = '".$bookid."';";

$conn = mysqli_connect("localhost","root","","library");
$result1 = mysqli_query($conn,$sql1);

if(mysqli_num_rows($result1)==0)
{
mysqli_query($conn,$sql);
$_SESSION['msg']="Book issued successfully";
header('location:manage-issued-books.php');
}

else{
    $_SESSION['error']="Book is already issued";
    header('location:manage-issued-books.php');
}
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <script src= 
"https://code.jquery.com/jquery-1.12.4.min.js"> 
    </script> 
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | Issue a new Book</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <style type="text/css">
        .selectt { 
            
        
            display: none; 
            width: 100%;             
        } 
          
        
    </style>
<script>
// function for get student name
function getstudent() {
$("#loaderIcon").show();
jQuery.ajax({
url: "get_student.php",
data:'studentid='+$("#studentid").val(),
type: "POST",
success:function(data){
$("#get_student_name").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}

function getstudent2() {
$("#loaderIcon").show();
jQuery.ajax({
url: "get_student2.php",
data:'studentid2='+$("#studentid2").val(),
type: "POST",
success:function(data){
$("#get_student_name2").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}


//function for book details
function getbook() {
$("#loaderIcon").show();
jQuery.ajax({
url: "get_book.php",
data:'bookid='+$("#bookid").val(),
type: "POST",
success:function(data){
$("#get_book_name").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}

            $(document).ready(function() { 
                $('input[type="radio"]').click(function() { 
                    var inputValue = $(this).attr("value"); 
                    var targetBox = $("." + inputValue); 
                    $(".selectt").not(targetBox).hide(); 
                    $(targetBox).show(); 
                }); 
            }); 
  




</script> 
<style type="text/css">
  .others{
    color:red;
}

</style>


</head>
<body>
      <!------MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->
    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Issue a New Book</h4>
                
                            </div>

</div>
<div class="row">
<div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1">
<div class="panel panel-info">
<div class="panel-heading">
Issue a New Book
</div>
<div class="panel-body">

    <?php
$ISBN=$_GET['isb'];
$conn = mysqli_connect("localhost","root","","library");
if($conn){
  $sql = "SELECT StudentId,ISBN from reservedbooks where ISBN = '".$ISBN."'";
  $result = mysqli_query($conn,$sql); 
  if(mysqli_num_rows($result)>0){
  foreach ($result as $row) {

?>
<form role="form" method="post">

<div class="form-group">
<label>Student id<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="studentid" id="studentid" onBlur="getstudent()" autocomplete="off" value="<?php echo htmlentities($row['StudentId'])?>" required />
</div>

<div class="form-group">
<span id="get_student_name" style="font-size:16px;"></span> 
</div>
<div class="form-group">
 <label><input type="radio" name="colorRadio" 
                       value="self" required="required">Self</label><br> 
            <label> 
                <input type="radio" name="colorRadio" 
                       value="shared">Shared</label> 
</div>
<div class="shared selectt">
<label>Student id<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="studentid2" id="studentid2" onBlur="getstudent2()" autocomplete="off" >
</div>

<div class="form-group">
<span id="get_student_name2" style="font-size:16px;"></span> 
</div>


<div class="form-group">
<label>ISBN Number or Book Title<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="bookid" id="bookid" onBlur="getbook()" value="<?php echo htmlentities($ISBN)?>" required="required" />
</div>

 <div class="form-group">

  <select  class="form-control" name="bookdetails" id="get_book_name" readonly>
   
 </select>
 </div>
<button type="submit" name="issue" id="submit" class="btn btn-info">Issue Book </button>

                                    </form>
                            </div>
                        </div>
                            </div>

        </div>
   
    </div>
    </div>
     <!-- CONTENT-WRAPPER SECTION END-->
  <?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>

</body>
</html>
<?php } }}}?>
