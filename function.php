<?php

function userRating($userId, $bookId, $conn)
{
    $average = 0;
    $avgQuery = "SELECT rate FROM rating WHERE StudentID = '" . $userId . "' and ISBN = '" . $bookId . "'";
    $total_row = 0;
    
    if ($result = mysqli_query($conn, $avgQuery)) {
        // Return the number of rows in result set
        $total_row = mysqli_num_rows($result);
    } // endIf
    
    if ($total_row > 0) {
        foreach ($result as $row) {
            $average = round($row["rate"]);
        } // endForeach
    } // endIf
    return $average;
}
 // endFunction
function totalRating($bookId, $conn)
{
    $totalVotesQuery = "SELECT * FROM rating WHERE ISBN = '" . $bookId . "'";
    
    if ($result = mysqli_query($conn, $totalVotesQuery)) {
        // Return the number of rows in result set
        $rowCount = mysqli_num_rows($result);
        // Free result set
        mysqli_free_result($result);
    } // endIf
    
    return $rowCount;
}//endFunction
