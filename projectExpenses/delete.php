<?php

    $conn = mysqli_connect("localhost","root","","expensesjs");
    $idBill = mysqli_real_escape_string($conn,$_POST["idBill"]);
    $query = "DELETE FROM bills WHERE id ='$idBill'";
 
    if (mysqli_query($conn, $query)) 
    {
        echo 1;
    } 
    else 
    {
        $err = "Unsuccessful delete :C";
        $error = '<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Error! </strong>'.$err.'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';//"Error: " . $query . "" . mysqli_error($conn);
        echo $error;
    }
        
    mysqli_close($conn);
?>


