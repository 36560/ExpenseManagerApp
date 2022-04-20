<?php

    $conn = mysqli_connect("localhost","root","","expensesjs");    
    $currentUser = mysqli_real_escape_string($conn, $_POST['currentUser']);
    $todayDate = mysqli_real_escape_string($conn, $_POST['todayDate']);
    $option = mysqli_real_escape_string($conn, $_POST['option']);
    $key = mysqli_real_escape_string($conn, $_POST["searchKey"]);   

    echo '<div class=" table-wrapper "><table id="billTable" class="table text-dark fw-bold"> 
            <thead>
            <tr class="text-center table-dark">                   
                <th>Title</th>
                <th onclick="sortTable(1)">Date<i class="fa fa-filter" id="sortDate"></i></th>                
                <th onclick="sortTable(2)">Amount<i class="fa fa-filter" id="sortAmount"></i></th>       
                <th>Category</th>                   
                <th></th>
            </tr>  
            </thead>   
        <tbody>';   

    if(isset($_POST["searchKey"]) && !empty($_POST["searchKey"]))
    {                  
        if($option == '0')        
        {
            $query = "SELECT * FROM bills WHERE id_user = '$currentUser' AND title LIKE '%$key%' OR date_bill LIKE '%$key%' OR amount LIKE '%$key%'";     
        }  
        else
        {
            $query = "SELECT * FROM bills WHERE (id_user = '$currentUser' AND category_name = '$option') AND (title LIKE '%$key%' OR date_bill LIKE '%$key%' OR amount LIKE '%$key%')";     
        }       
    }    
    else if($option == '0')        
        $query = "SELECT * FROM bills WHERE id_user = '$currentUser'";                                                                                                     
    else
        $query = "SELECT * FROM bills WHERE id_user = '$currentUser' AND category_name = '$option'";
        
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_array($result))
        {
            $id = $row['id'];
            $title = $row['title'];
            $amount = $row['amount'];
            $cat = $row['category_name'];
            $date = $row['date_bill'];

            $queryCat = "SELECT * FROM category WHERE name = '$cat'";
            $resultCat = mysqli_query($conn, $queryCat);

            if(mysqli_num_rows($resultCat) > 0)
            {
                while($row = mysqli_fetch_array($resultCat))
                {
                    $img = '<img src="'.$row['image'].'" class="categoryBill" alt="alternatetext"><br>';
                }
            }

            $tr = '<tr class="row'.$id.' rowCh taskExist onclick="clickedRow('.$id.')">';
            $td = '<td class="text-center" onclick="openEditForm('.$id.","."'".$title."'".","."'".$amount."'".","."'".$date."'".","."'".$cat."'".')">'; //'.$id.",".                                    
            $endTd = '</td>';                              
            $deleteBtn ='<td><button type="button" onclick="deleteTask('.$id.')" class="btn btn-lg actionBtn"><i class="text-light fas fa-minus-circle"></i></button>'.$endTd;
                                
            echo $tr.$td.$title.'</td>'.$td.$date.'</td>'.$td.$amount.'</td>'.$td.$img.'</td>'.$deleteBtn.'</tr>';                                   
        }    
    }                        
    else
    {
         echo '<tr class="noTask"><th class="display-6 text-center text-dark" colspan="5">No bills<i style="margin: 10px;" class="fas fa-money-check-alt"></i></th></tr> ';                            
    }   
    
    echo '</tbody> </table></div>';

    mysqli_close($conn);  
?>


