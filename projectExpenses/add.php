<?php

    $conn = mysqli_connect("localhost","root","","expensesjs");

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $date_bill = mysqli_real_escape_string($conn, $_POST['dateBill']);
    $currentUserId = mysqli_real_escape_string($conn,$_POST["userId"]);
    $cat = mysqli_real_escape_string($conn, $_POST['category']);     

    $query = "INSERT INTO bills (title,amount,date_bill,category_name,id_user) VALUES ('$title','$amount','$date_bill','$cat','$currentUserId')";
            
    if (mysqli_query($conn, $query)) 
    {
        $last_id = $conn->insert_id;             
        echo $last_id;
    } 
    else 
    {
        echo -1;
    }

    mysqli_close($conn);
?>

