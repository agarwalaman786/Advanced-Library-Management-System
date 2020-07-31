<?php

if(isset($_POST['add'])){
    $title = "'".$_POST['bookname']."'";
    $ISBN= "'".$_POST['isbn']."'";
    $price = "'".$_POST['price']."'";
    $author = "'".$_POST['author']."'";
    $category = "'".$_POST['category']."'";
    $conn = mysqli_connect("localhost","root","","library");
    if($conn){
    $sql = "INSERT INTO tblbooks(BookName, ISBNNumber, BookPrice, author, category) values($title, $ISBN, $price, $author, $category);";
    $result =  mysqli_query($conn,$sql);
    if($result){
       echo "<script>alert('Book Listed successfully');document.location ='manage-books.php';</script>";
    }
    else{
        echo "<script>alert('Book is already in database');document.location ='add-book.php';</script>";
    }
  }
}
?>