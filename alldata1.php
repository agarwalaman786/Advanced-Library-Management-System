<?php
session_start();
error_reporting(0);
include('includes/config.php');
$query= $_GET['query'];
$option = $_GET['idx'];
if(isset($_GET['inid']))
{
$id=$_GET['inid'];
$query = "SELECT BookName from tblbooks where ISBNNumber = '".$id."';";
$conn = mysqli_connect("localhost","root","","library");
$result = mysqli_query($conn,$query);
foreach ($result as $row) {
$sid=$_SESSION['stdid'];
$conn = mysqli_connect("localhost","root","","library");
$sql = "INSERT INTO  reservedbooks(ISBN,StudentId,title)VALUES('".$id."','".$sid."','".$row['BookName']."')";
mysqli_query($conn,$sql);
header('location:reserved.php');
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
    <BookName>Online Library Management System</BookName>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <!------MENU SECTION START-->
<?php include('includes/header.php');?>
<div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Searched Books</h4>
    </div>
    
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Results of <?php echo "'".$query."'"?>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th><center>#</center></th>
                                            <th><center>ISBN </center></th>
                                            <th><center>Book Name</center></th>
                                            <th><center>Category</center></th>
                                            <th><center>Author</center></th>
                                            <th><center>Reserved</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php 
if($option=='lb')
$sql="SELECT ISBNNumber,BookName,category, author from tblbooks where BookName like '%".$query."%' or ISBNNumber like '%".$query."%' or category like '%".$query."%' or author like '%".$query."%'Limit 100000";
elseif ($option=='au') {
$sql="SELECT ISBNNumber, BookName, category, author from tblbooks where author like '%".$query."%' Limit 100000";
}
elseif ($option=='ti') {
   $sql="SELECT ISBNNumber, BookName, category, author from tblbooks where BookName like '%".$query."%' Limit 100000";
}
elseif($option='gn'){
    $sql="SELECT ISBNNumber, BookName, category, author from tblbooks where category like '%".$query."%' Limit 100000";

}
else{
    $sql="SELECT ISBNNumber, BookName, category, author from tblbooks where ISBNNumber like '%".$query."%' Limit 100000";
}
    
$query = $dbh -> prepare($sql);
$query-> bindParam(':sid', $sid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>                                      
                                        <tr class="odd gradeX">

                                            <td class="center"><center><?php echo htmlentities($cnt);?></center></td>
                                            <td class="center"><center><?php echo htmlentities($result->ISBNNumber);?></center></td>
                                            <td class="center"><center><?php echo htmlentities($result->BookName);?></center></td>
                                            <td class="center"><center><?php echo htmlentities($result->category);?></center></td>
                                            <td class="center"><center><?php echo htmlentities($result->author);?></center></td>
                                            <td class="center"><a href="alldata1.php?inid=<?php echo htmlentities($result->ISBNNumber)?>" style="cursor: pointer;"><i class="fa fa-shopping-cart" style="font-size: 150%;"></i></a></td>
 <?php $cnt=$cnt+1;}} ?>                                      
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>            
    </div>
    </div>
    </div>

<script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- DATATABLE SCRIPTS  -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>


<?php include('includes/footer.php');?>

</body>
</html>