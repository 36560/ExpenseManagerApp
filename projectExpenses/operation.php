<?php  
    include ('baseOperation.php');  
    $object = new BaseOperation();  

    //CHART OPERATION:
    if(isset($_POST["chartOperation"]))  
    { 
        if($_POST["chartOperation"] == "getCatJson")  
        {           
            $query = "SELECT * FROM category";
            $result = $object->executeQuery($query);   
        
            if(mysqli_num_rows($result) > 0)
            {
                while($row = mysqli_fetch_array($result))
                {
                    $array[] = array($row["name"],$row["image"]);
                }                
                echo json_encode(array($array)); 
            }    
        }
        
        if($_POST["chartOperation"] == "getSummaryCat")  
        {
            $currentUser = mysqli_real_escape_string($object->conn, $_POST['currentUser']);    
            $year = mysqli_real_escape_string($object->conn, $_POST['year']);
            $cat = mysqli_real_escape_string($object->conn, $_POST['category']); 

            $query = "SELECT * FROM bills WHERE category_name = '$cat' AND id_user='$currentUser' AND date_bill >= '$year-01-01' AND date_bill <= '$year-12-31'";

            $result = $object->executeQuery($query);  
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
        }

        if($_POST["chartOperation"] == "getSummaryMonth")  
        {         
            $comDown = mysqli_real_escape_string($object->conn, $_POST['comDown']);
            $comUp = mysqli_real_escape_string($object->conn, $_POST['comUp']);
            $currentUser = mysqli_real_escape_string($object->conn, $_POST['userId']);
        
            $query = "SELECT * FROM bills WHERE date_bill >= '$comDown' AND date_bill < '$comUp' AND id_user = '$currentUser'";
            $result = $object->executeQuery($query);                
            $summary = 0;
      
            if(mysqli_num_rows($result) > 0)
            {
                while($row = mysqli_fetch_array($result))
                {
                    $amount = $row['amount'];
                    $cat = $row['category_name'];  
        
                    if(!($cat=='Incomes') && !($cat=='Other incomes'))
                    {
                        $summary = $summary + $amount;  
                    }            
                }            
            }  
            echo $summary;
        }
    }

    //CRUD OPERATION:
    if(isset($_POST["operation"]))  
    {          
        if($_POST["operation"] == "read")  
        {    
            $currentUser = mysqli_real_escape_string($object->conn, $_POST['currentUser']);
            $todayDate = mysqli_real_escape_string($object->conn, $_POST['todayDate']);
            $option = mysqli_real_escape_string($object->conn, $_POST['option']);
            $key = mysqli_real_escape_string($object->conn, $_POST["searchKey"]);   

            if(!empty($_POST["searchKey"]))
            {                  
                if($option == '0')       
                    $query = "SELECT * FROM bills WHERE  id_user = '$currentUser' AND (title LIKE '%$key%' OR (date_bill LIKE '%$key%') OR (amount LIKE '%$key%'))";     
                else                  
                    $query = "SELECT * FROM bills WHERE (id_user = '$currentUser' AND category_name = '$option') AND (title LIKE '%$key%' OR (date_bill LIKE '%$key%') OR (amount LIKE '%$key%'))";           
            }    
            else if($option == '0')        
                $query = "SELECT * FROM bills WHERE id_user = '$currentUser'";                                                                                                     
            else
                $query = "SELECT * FROM bills WHERE id_user = '$currentUser' AND category_name = '$option'";

            echo $object->readData($query);  
        } 

        if($_POST["operation"] == "add")  
        {    
            $title = mysqli_real_escape_string($object->conn, $_POST['title']);
            $amount = mysqli_real_escape_string($object->conn, $_POST['amount']);
            $date_bill = mysqli_real_escape_string($object->conn, $_POST['dateBill']);
            $currentUserId = mysqli_real_escape_string($object->conn,$_POST["userId"]);
            $cat = mysqli_real_escape_string($object->conn, $_POST['category']);     

            $query = "INSERT INTO bills (title,amount,date_bill,category_name,id_user) VALUES ('$title','$amount','$date_bill','$cat','$currentUserId')";

            echo $object->addData($query);   
        }

        if($_POST["operation"] == "edit")  
        {    
            $title = mysqli_real_escape_string($object->conn, $_POST['title']);
            $amount = mysqli_real_escape_string($object->conn, $_POST['amount']);
            $date_bill = mysqli_real_escape_string($object->conn, $_POST['date']);
            $currentUserId = mysqli_real_escape_string($object->conn,$_POST["userId"]);
            $cat = mysqli_real_escape_string($object->conn, $_POST['category']);     
            $idBill = mysqli_real_escape_string($object->conn, $_POST['idBill']);     
    
            $query = "UPDATE bills SET title = '$title', amount='$amount', date_bill='$date_bill', category_name='$cat' WHERE id = $idBill";

            echo $object->editData($query);   
        }

        if($_POST["operation"] == "delete")  
        {  
            $idBill = mysqli_real_escape_string($object->conn,$_POST["idBill"]);
            $query = "DELETE FROM bills WHERE id ='$idBill'";

            echo $object->deleteData($query);
        }

    }  
 ?>  