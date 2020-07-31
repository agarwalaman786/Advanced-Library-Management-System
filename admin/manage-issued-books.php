<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:mainpage.php');
}
else{ 


if(isset($_GET['inid']))
{
$id=$_GET['inid'];
$status=1;
echo $id;
$time = date("Y-m-d h:i:sa");
$sql = "update tblissuedbookdetails set RetrunStatus='".$status."',ReturnDate = '".$time."' WHERE ISBNNumber='".$id."'";
$conn = mysqli_connect("localhost","root","","library");
mysqli_query($conn,$sql);
header('location:manage-issued-books.php');
}
    ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | Manage Issued Books</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- DATATABLE STYLE  -->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


</head>
<body>
      <!------MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->
    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Manage Issued Books</h4>
    </div>
     <div class="row">
    <?php if($_SESSION['error']!="")
    {?>
<div class="col-md-6">
<div class="alert alert-danger" >
 <strong>Error :</strong> 
 <?php echo htmlentities($_SESSION['error']);?>
<?php echo htmlentities($_SESSION['error']="");?>
</div>
</div>
<?php } ?>
<?php if($_SESSION['msg']!="")
{?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo htmlentities($_SESSION['msg']);?>
<?php echo htmlentities($_SESSION['msg']="");?>
</div>
</div>
<?php } ?>



   <?php if($_SESSION['delmsg']!="")
    {?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo htmlentities($_SESSION['delmsg']);?>
<?php echo htmlentities($_SESSION['delmsg']="");?>
</div>
</div>
<?php } ?>

</div>


        </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Issued Books 
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Student ID</th>
                                            <th>Book Name</th>
                                            <th>ISBN </th>
                                            <th>Issued Date</th>
                                            <th>Return Date</th>
                                            <th>Status</th>
                                            <th>Sharing</th>
                                            <th>StudentID 2 </th>
                                            <th>Fine</th>
                                            <th>Raise Issue</th>
                                            <th>Return Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php $sql = "SELECT tblissuedbookdetails.StudentID, tblissuedbookdetails.StudentId2, tblissuedbookdetails.ISBNNumber, tblissuedbookdetails.IssuesDate, tblissuedbookdetails.ReturnDate, tblbooks.BookName, tblbooks.Status, tblissuedbookdetails.fine, tblissuedbookdetails.RetrunStatus from tblbooks,tblissuedbookdetails where tblissuedbookdetails.ISBNNumber = tblbooks.ISBNNumber;";

$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>                                      
                                        <tr class="odd gradeX">
                                            <td class="center"><?php echo htmlentities($cnt);?></td>
                                            <td class="center"><?php echo htmlentities($result->StudentID);?></td>
                                            <td class="center"><?php echo htmlentities($result->BookName);?></td>
                                            <td class="center"><?php echo htmlentities($result->ISBNNumber);?></td>
                                            <td class="center"><?php echo htmlentities($result->IssuesDate);?></td>
                                            <td class="center"><?php if($result->ReturnDate=="")
                                            {
                                                echo htmlentities("Not Return Yet");
                                            } else {

                                            echo htmlentities($result->ReturnDate);
}
                                            ?></td>
                                            <td class="center"><?php
                                            if($result->Status==1){
                                                echo htmlentities("Open");
                                            }
                                            else{
                                                echo htmlentities("Private");
                                            }
                                            ?></td>
                                            <td class="center">
                                                <?php 
                                                if($result->StudentId2=="")
                                                    echo htmlentities("Self");
                                                else{
                                                    echo htmlentities("Shared");
                                                }?>
                                            </td>
                                            <td class="center">
                                                <?php echo htmlentities($result->StudentId2);  ?>
                                            </td>
                                            <td class="center">
                                                <?php echo htmlentities($result->fine);  ?>
                                            </td>
                                            <td class="center" style="width: 5%;"><?php
                                            if($result->Status==1){
                                                ?>
                                                <a style="cursor: pointer;"><i class="material-icons">error_outline</i></a>
                                                <?php
                                            }
                                            ?>
                                            </td>
                                                <td class="center">
<?php if($result->RetrunStatus==0)
 {?>
<a href="manage-issued-books.php?inid=<?php echo htmlentities($result->ISBNNumber);?>" onclick="return confirm('Are you sure you want to return the book?');">  <button class="btn btn-danger">Return</button>
<?php } else {?>

                                            <a href="manage-issued-books.php"><button class="btn btn-danger" disabled="disabled">Return</button> 
                                            <?php } ?>
                                          
                                            </td>
                                        </tr>
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

     <!-- CONTENT-WRAPPER SECTION END-->
  <?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- DATATABLE SCRIPTS  -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
