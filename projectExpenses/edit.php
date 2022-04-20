<?php
    $conn = mysqli_connect("localhost","root","","expensesjs");

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $idBill = mysqli_real_escape_string($conn, $_POST['idBill']);     
    $currentUserId = mysqli_real_escape_string($conn,$_POST["userId"]);
    $cat = mysqli_real_escape_string($conn,$_POST["category"]);

    $query = "UPDATE bills SET title = '$title', amount='$amount', date_bill='$date', category_name='$cat' WHERE id = $idBill";

    if (mysqli_query($conn, $query))
    {
        echo 1;
    } 
    else
    {
        echo -1;
    }
    
    mysqli_close($conn);       
?>



