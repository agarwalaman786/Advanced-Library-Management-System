<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:mainpage.php');
}
else{ 
if(isset($_GET['del']))
{
$id=$_GET['del'];
$sql = "delete from tblbooks  WHERE ISBNNumber=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
echo "<script>alert('Book Deleted successfully');document.location ='manage-books.php';</script>";

}

if(isset($_GET['inid']))
{
$id=$_GET['inid'];
$status=1;
$sql = "UPDATE tblbooks set Status='.$status.' where ISBNNumber='".$id."'";
$conn= mysqli_connect("localhost","root","","library");
$query = mysqli_query($conn,$sql);
header('location:manage-books.php');
}

//code for active students
if(isset($_GET['id']))
{
$id=$_GET['id'];
$status=0;
$sql = "UPDATE tblbooks set Status='.$status.' WHERE ISBNNumber='".$id."'";
echo $sql;
$conn= mysqli_connect("localhost","root","","library");
$query = mysqli_query($conn,$sql);
header('location:manage-books.php');
}


    ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | Manage Books</title>
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

</head>
<body>
      <!------MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->
    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Manage Books</h4>
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
<?php if($_SESSION['updatemsg']!="")
{?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo htmlentities($_SESSION['updatemsg']);?>
<?php echo htmlentities($_SESSION['updatemsg']="");?>
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
                           Books Listing
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Book Name</th>
                                            <th>Category</th>
                                            <th>Author</th>
                                            <th>ISBN</th>
                                            <th>Price</th>
                                            <th>Action</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php $sql = "SELECT tblbooks.BookName, tblbooks.ISBNNumber,tblbooks.BookPrice,tblbooks.author,tblbooks.category,tblbooks.Status from  tblbooks;";
$conn = mysqli_connect("localhost","root","","library");
$results = mysqli_query($conn,$sql);
$cnt=1;
if(mysqli_num_rows($results)> 0)
{
foreach($results as $result)
{               ?>                                      
                                        <tr class="odd gradeX">
                                            <td class="center"><?php echo htmlentities($cnt);?></td>
                                            <td class="center"><?php echo htmlentities($result['BookName']);?></td>
                                            <td class="center"><?php echo htmlentities($result['category']);?></td>
                                            <td class="center"><?php echo htmlentities($result['author']);?></td>
                                            <td class="center"><?php echo htmlentities($result['ISBNNumber']);?></td>
                                            <td class="center"><?php echo htmlentities($result['BookPrice']);?></td>
                                            <td class="center" >
                                            <a href="edit-book.php?bookid=<?php echo htmlentities($result['ISBNNumber']);?>"><button class="btn btn-primary" style="width: 100%;font-size: 70%;"><i class="fa fa-edit"></i> Edit</button> <br><br>
                                          <a href="manage-books.php?del=<?php echo htmlentities($result['ISBNNumber']);?>" onclick="return confirm('Are you sure you want to delete?');" >  <button class="btn btn-danger" style="width: 100%;font-size: 70%;"><i class="fa fa-pencil"></i> Delete</button>
                                            </td>
                                            <td>
                                                <?php
                                                if($result['Status']==0)

 { ?>
<a href="manage-books.php?inid=<?php echo htmlentities($result['ISBNNumber']);?>" onclick="return confirm('Are you sure you want to Open this book?');" >  <button class="btn btn-danger">Open</button>
<?php } else {?>

                                            <a href="manage-books.php?id=<?php echo htmlentities($result['ISBNNumber']);?>" onclick="return confirm('Are you sure you want to private this book?');"><button class="btn btn-primary">Private</button> 
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
