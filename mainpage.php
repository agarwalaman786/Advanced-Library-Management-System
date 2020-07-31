<?php
session_start();
error_reporting(0);
include('includes/config.php');
if($_SESSION['login']!=''){
$_SESSION['login']='';
}
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



    <style type="text/css">
    	#NewArrival{
    		border-top:14px solid black;
    		border-bottom: 14px solid black; 
    		width: 100%;
    		height: 30%;
    	}
    	#NewArrival h4{
    		font-size: 156%;
    		font-family: Times New Roman;
    		font-weight: bold;
    		text-shadow:2px 2px 2px  #558ABB;
    	}

    </style>





    <script type="text/javascript">
    	function startDictation() {

        if (window.hasOwnProperty('webkitSpeechRecognition')) {

          var recognition = new webkitSpeechRecognition();

          recognition.continuous = false;
          recognition.interimResults = false;
          recognition.lang = "en-US";
          recognition.start();

          recognition.onresult = function (e) {
            document.getElementById('transcript').value = e.results[0][0].transcript;
            recognition.stop();
            document.getElementById('labnol').submit();
          };
          recognition.onerror = function(e) {
            recognition.stop();
          }
        }
      }


// Material Select Initialization
$(document).ready(function() {
$('.mdb-select').materialSelect();
});

    </script>



<style>
  .speech {border: 1px solid #DDD; width: 300px; padding: 0; margin: 0}
  .speech input {border: 0; width: 240px; display: inline-block; height: 30px;}
  .speech img {float: right; width: 40px }
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
   <!-- <div class="col-sm-6" style="margin-left: -30%;"><div id="dataTables-example_filter" class="dataTables_filter" ><label><input type="text" x-webkit-speech class="form-control input-sm" aria-controls="dataTables-example" placeholder = "search" style="margin-top: -15%; margin-left:0%; border-radius: 25%,0%,0%,0%"/> <img onclick="startDictation()" src="https://i.imgur.com/cHidSVu.gif" /></label></div></div> -->


   <form id="labnol" method="get" action="alldata.php">
   	<select name="idx" id="masthead_search" style="margin-left: -11%;">
                                    <option value="lb">Library catalog</option>
                                    <option value="ti">Title</option>
                                    <option value="au">Author</option>
                                    <option value="nb">ISBN</option>
                                </select>
   	<div class="speech" style="margin-top: -3%;">
   <input type="search" autocomplete = "off" name = "query" class="form-control input-sm" aria-controls="dataTables-example" name="q" id="transcript" placeholder="search" >

    <img onclick="startDictation()" src="//i.imgur.com/cHidSVu.gif" title="tap to speak" style="cursor: pointer; margin-top: -2%;" />
  </div>
</form>
</div>
</div>


<!--This is code to show the  new arrivals-->
 <div id = 'NewArrival'>
    	<center><h4>New Arrivals</h4></center>
 </div>
 <center>
 <?php
 $conn = mysqli_connect("localhost","root","","library");
 $query = "select Image_link from universaldataset Limit 10;";
 $result = mysqli_query($conn,$query);

 foreach ($result as $row) {
 	$link = $row['Image_link'];
 ?>

 	<a href="#?<?php $_SESSION['lk'] = $row['Image_link'];?>"><img height="200px" width="150px" data-toggle="modal" data-target="#myModal" style="margin-top: 4%; margin-left:4%;text-shadow: 2px 2px black;border-radius: 4%;  -webkit-filter: drop-shadow(5px 5px 5px #222); cursor: pointer;" src="<?php echo $link;?>"/></a>
 <?php
 }

?>
</center>


<!--Modal-->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Book Info</h4>
        </div>
        <div class="modal-body">
          <h3>Title :</h3>
          <p>
          	<?php
          	$conn = mysqli_connect('localhost','root','','library');
          	if($conn){
          	    $query = "select ISBN, title, author, Genre from universaldataset where Image_link = '".$_SESSION['lk']."'";
          	    $result = mysqli_query($conn,$query);
          	    foreach ($result as $row) {
          	    	echo $row['title'];
          	    	?>
          	    	<h3>ISBN :</h3>
          	    	<?php
          	    	echo $row['ISBN'];
          	    	?>
          	    	<h3>Author :</h3>
          	    	<?php
          	    	echo $row['author'];
          	    	?>
          	    	<h3>Genre :</h3>
          	    	<?php
          	    	echo $row['Genre'];
          	    	?>
          	    	<?php
          	    };
          	} 
          	?>
          		
          	</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

 

 <div id = 'NewArrival' style="margin-top: 6%;">
    	<center><h4>Top 10 Liked books</h4></center>
    	</div>
 <center>
 <?php
 $conn = mysqli_connect("localhost","root","","library");
 $query = "select Image_link from universaldataset,rating where universaldataset.ISBN = rating.ISBN order by rating.rate desc Limit 10;";
 $result = mysqli_query($conn,$query);

 foreach ($result as $row) {
 	$link = $row['Image_link'];
 ?>

 	<a href="#?<?php $_SESSION['lk'] = $row['Image_link'];?>"><img height="200px" width="150px" data-toggle="modal" data-target="#myModal" style="margin-top: 4%; margin-left:4%;text-shadow: 2px 2px black;border-radius: 4%;  -webkit-filter: drop-shadow(5px 5px 5px #222); cursor: pointer;" src="<?php echo $link;?>"/></a>
 <?php
 }

?>
</center>

 </div>
 
<!--LOGIN PANEL START-->
    </div>
    </div>
<!---LOGIN PABNEL END-->                  
     <!-- CONTENT-WRAPPER SECTION END-->
 <?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</script>
</body>
</html>
