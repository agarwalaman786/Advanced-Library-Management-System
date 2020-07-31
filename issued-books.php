<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
    {   
header('location:mainpage.php');
}
else{ 
if(isset($_GET['del']))
{
$id=$_GET['del'];
$sql = "delete from tblbooks  WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
$_SESSION['delmsg']="Category deleted scuccessfully ";
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
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>

    <style type="text/css">
        li.star {
    list-style: none;
    display: inline-block;
    margin-right: 5px;
    cursor: pointer;
    color: #9E9E9E;
}

li.star.selected {
    color: #ff6e00;
}

    </style>


</head>
<body  onload="showRestaurantData('getRatingData.php')">
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
                                            <th><center>#</center></th>
                                            <th><center>Book Name</center></th>
                                            <th><center>ISBN </center></th>
                                            <th><center>Issued Date</center></th>
                                            <th><center>Return Date</center></th>
                                            <th><center>Fine in(USD)</center></th>
                                            <th><center>Payment</center></th>
                                            <th><center>Ratings</center></th>
                                            <th><center>Status</center></th>

                                        </tr>
                                    </thead>
                                    <tbody>
<?php 
$sid=$_SESSION['stdid'];
$sql="SELECT tblbooks.BookName,tblissuedbookdetails.ISBNNumber,tblissuedbookdetails.IssuesDate,tblissuedbookdetails.ReturnDate,tblissuedbookdetails.fine,tblissuedbookdetails.StudentId2 from  tblissuedbookdetails,tblbooks where tblissuedbookdetails.ISBNNumber=tblbooks.ISBNNumber and tblissuedbookdetails.StudentID=:sid";
$query = $dbh -> prepare($sql);
$query-> bindParam(':sid', $sid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{   
if($result->ReturnDate==""){            
    ?>                                      
                                        <tr class="odd gradeX">

                                            <td class="center"><center><?php echo htmlentities($cnt);?></center></td>
                                            <td class="center"><center><?php echo htmlentities($result->BookName);?></center></td>
                                            <td class="center"><center><?php echo htmlentities($result->ISBNNumber);?></center></td>
                                            <td class="center"><center><?php echo htmlentities($result->IssuesDate);?></center></td>
                                            <td class="center"><center><?php if($result->ReturnDate=="")
                                            {?>
                                            <span style="color:red">
                                             <?php   echo htmlentities("Not Return Yet"); ?>
                                                </span>
                                            <?php } else {
                                            echo htmlentities($result->ReturnDate);
                                        }
                                            ?></center></td>
                                              <td class="center"><center><?php 
                                              $date1 = strtotime(date("Y-m-d"));
                                              $date2 = strtotime(date("Y-m-d",strtotime('-16 days',strtotime($result->IssuesDate))));
                                              $date3 = $date1 - $date2;
                                              $days = $date3/86400;
                                              $fin=0;
                                             
                                              if($days>15){
                                                $fin = $days - 15;
                                                $conn = mysqli_connect("localhost","root","","library");
                                                if($result->StudentId2!="")
                                                    $fin=$fin/2;
                                                $sql = "update tblissuedbookdetails set fine = '".$fin."'";
                                                 $_SESSION['fines']=$fin;
                                                mysqli_query($conn,$sql);
                                                echo htmlentities($fin);
                                           }
                                           else{
                                            echo htmlentities($fin);
                                           }?></center></td>
                                            <td>
                                                <center><a href="/onlinelibrarymanagement/library/WEB-TECHNOLOGIES-master/TxnTest.php?ISBNNum=<?php echo htmlentities($result->ISBNNumber);?>"><i class="fab fa-amazon-pay" style="font-size: 200%; cursor: pointer;"></i></a>


                                                </center>
                                            </td>
                                            <td><span id="rating_list">
                                                
                                            </span></td>
                                         <td class="center"><?php
                                         if($result->StudentId2=="")
                                            echo htmlentities("Self");
                                            else {
                                            echo htmlentities("Shared");
                                            }
                                             ?></td>
                                        </tr>
 <?php $cnt=$cnt+1;}} }?>                                      
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
<script type="text/javascript">

    function showRestaurantData(url)
    {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200)
            {
                document.getElementById("rating_list").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", url, true);
        xhttp.send();

    } 

    function mouseOverRating(bookId, r) {

        resetRatingStars(bookId)

        for (var i = 1; i <= r; i++)
        {
            var ratingId = bookId + "_" + i;
            document.getElementById(ratingId).style.color = "#ff6e00";

        }
    }

    function resetRatingStars(bookId)
    {
        for (var i = 1; i <= 5; i++)
        {
            var ratingId = bookId + "_" + i;
            document.getElementById(ratingId).style.color = "#9E9E9E";
        }
    }

   function mouseOutRating(bookId, userRating) {
       var ratingId;
       if(userRating !=0) {
               for (var i = 1; i <= userRating; i++) {
                      ratingId = bookId + "_" + i;
                  document.getElementById(ratingId).style.color = "#ff6e00";
               }
       }
       if(userRating <= 5) {
               for (var i = (userRating+1); i <= 5; i++) {
                  ratingId = bookId + "_" + i;
              document.getElementById(ratingId).style.color = "#9E9E9E";
           }
       }
    }

    function addRating (bookId, ratingValue) {
            var xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function ()
            {
                if (this.readyState == 4 && this.status == 200) {

                    showRestaurantData('getRatingData.php');
                    
                    if(this.responseText != "success") {
                           alert(this.responseText);
                    }
                }
            };

            xhttp.open("POST", "insertRating.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            var parameters = "index=" + ratingValue + "&ISBN=" + bookId;
            xhttp.send(parameters);
    }
</script>
