<?php

    $conn = mysqli_connect("localhost","root","","expensesjs");

    $comDown = mysqli_real_escape_string($conn, $_POST['comDown']);
    $comUp = mysqli_real_escape_string($conn, $_POST['comUp']);
    $currentUser = mysqli_real_escape_string($conn, $_POST['userId']);

    $query = "SELECT * FROM bills WHERE date_bill >= '$comDown' AND date_bill < '$comUp' AND id_user = '$currentUser'";

    $result = mysqli_query($conn, $query);
   
    $summary = 0;

    if(mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_array($result))
        {
            $id = $row['id'];
            $title = $row['title'];
            $amount = $row['amount'];
            $date = $row['date_bill'];  
            $cat = $row['category_name'];  

            if(!($cat=='Incomes') && !($cat=='Other incomes'))
            {
                $summary = $summary + $amount;  
            }            
        }            
    }  
    echo $summary;
                     
    mysqli_close($conn);  
?>


