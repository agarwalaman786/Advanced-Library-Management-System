<?php
session_start();
error_reporting(0);
include('includes/config.php');
$query= $_GET['query'];
$option = $_GET['idx']
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System</title>
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
                                        </tr>
                                    </thead>
                                    <tbody>
<?php 
if($option=='lb')
$sql="SELECT ISBN, title, Genre, author from universaldataset where title like '%".$query."%' or ISBN like '%".$query."%' or Genre like '%".$query."%' or author like '%".$query."%'Limit 100000";
elseif ($option=='au') {
$sql="SELECT ISBN, title, Genre, author from universaldataset where author like '%".$query."%' Limit 100000";
}
elseif ($option=='ti') {
   $sql="SELECT ISBN, title, Genre, author from universaldataset where title like '%".$query."%' Limit 100000";
}
elseif($option='gn'){
    $sql="SELECT ISBN, title, Genre, author from universaldataset where Genre like '%".$query."%' Limit 100000";

}
else{
    $sql="SELECT ISBN, title, Genre, author from universaldataset where ISBN like '%".$query."%' Limit 100000";
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
                                            <td class="center"><center><?php echo htmlentities($result->ISBN);?></center></td>
                                            <td class="center"><center><?php echo htmlentities($result->title);?></center></td>
                                            <td class="center"><center><?php echo htmlentities($result->Genre);?></center></td>
                                            <td class="center"><center><?php echo htmlentities($result->author);?></center></td>
                                            
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