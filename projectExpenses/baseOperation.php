<?php  
 class BaseOperation
 {  
      public $conn;  
      private $host = 'localhost';  
      private $username = 'root';  
      private $pass = '';  
      private $db = 'expensesjs';   

      function __construct()  
      {  
        $this->dbConnection();  
      }  

      public function dbConnection()  
      {  
        $this->conn = mysqli_connect($this->host, $this->username, $this->pass, $this->db);  
      }  
      public function executeQuery($query)  
      {  
        return mysqli_query($this->conn, $query);  
      }  

      public function displayCategory($cat)
      { 
        $queryCat = "SELECT * FROM category WHERE name = '$cat'";
        $resultCat = $this->executeQuery($queryCat);  

        if(mysqli_num_rows($resultCat) > 0)
        {
            while($rowCat = mysqli_fetch_array($resultCat))
            {
                $img = '<img src="'.$rowCat['image'].'" class="categoryBill" alt="alternatetext"><br>';
            }
        }
        return $img;
      }
      
      public function getEditCategories()
      {
        $query = "SELECT * FROM category";
        $result = $this->executeQuery($query);  

        if(mysqli_num_rows($result) > 0)
        {
            while($row = mysqli_fetch_array($result))
            {
                echo '<label class="categoryLabel"><input type="radio" name="categoryEdit" id="'.$row["name"].'" value="'.$row["name"].'" required><img src="'.$row["image"].'" class="categoryBill" alt="alternatetext">'.$row['name'].'</label><br>';                               
            }
        }            
      }

      public function readData($query)  
      {  
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

        $result = $this->executeQuery($query);  

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
                $resultCat = $this->executeQuery($queryCat);  

                if(mysqli_num_rows($resultCat) > 0)
                {
                    while($rowCat = mysqli_fetch_array($resultCat))
                    {
                        $img = '<img src="'.$rowCat['image'].'" class="categoryBill" alt="alternatetext"><br>';
                    }
                }

                $tr = '<tr class="row'.$id.' rowCh taskExist onclick="clickedRow('.$id.')">';
                $td = '<td class="text-center" onclick="openEditForm('.$id.","."'".$title."'".","."'".$amount."'".","."'".$date."'".","."'".$cat."'".')">';                                    
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

      }  

      function addData($query)
      {
        $result = $this->executeQuery($query);  
        if($result) 
        {
            $last_id = $this->conn->insert_id;             
            echo $last_id;
        } 
        else 
        {
            echo -1;
        }  
      }
     
      function editData($query)
      {
        $result = $this->executeQuery($query);  
        if($result)
        {
            echo 1;
        } 
        else
        {
            echo -1;
        }
      }

      function deleteData($query)
      {
        $result = $this->executeQuery($query);  
        if ($result) 
        {
            echo 1;
        } 
        else 
        {
            $err = "Unsuccessful delete :C";
            $error = '<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Error! </strong>'.$err.'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';//"Error: " . $query . "" . mysqli_error($conn);
            echo $error;
        }            
      }
 }  
 ?>  