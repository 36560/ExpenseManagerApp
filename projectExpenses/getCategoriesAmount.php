<?php

    $conn = mysqli_connect("localhost","root","","expensesjs");

    $currentUser = mysqli_real_escape_string($conn, $_POST['currentUser']);    
    $year = mysqli_real_escape_string($conn, $_POST['year']);
    $cat = mysqli_real_escape_string($conn, $_POST['category']); 

    $query = "SELECT * FROM bills WHERE category_name = '$cat' AND id_user='$currentUser' AND date_bill >= '$year-01-01' AND date_bill <= '$year-12-31'";

    $result = mysqli_query($conn, $query);
    $summary = 0;

    if(mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_array($result))
        {
            $amount = $row['amount']; 
            $summary = $summary + $amount;          
        }    
        echo $summary;
    }                        
    else
    {
        echo $summary;                     
    }       

    mysqli_close($conn);  
?>


