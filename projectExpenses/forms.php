<div class="fullscreen-container">
    <!-- EDIT form -->
    <div class="text-dark">
        <div class="form-popup" id="editForm">

            <div> 
            <button class="btn btn-lg" id = "x" onclick="closeEditForm()"><i class="	fa fa-mail-reply-all"></i></button>
            <h1 class="text-center">Edit task</h1> 
            </div>
            <form class="add-edit-container" method="POST">
                
            <label>Title</label><br/>
            <input type="text" name="titleEdit" id="titleEdit" class="form-control" required/> 
            <br/>

            <label>Amount</label><br/>
            <input type="text" name="amountEdit" id="amountEdit" class="form-control"/> 
            <br/>

            <label>Date</label><br/>
            <input type="date" name="dateEdit" id="dateEdit" class="form-control" value=""/> 
            <br/>

            <label>Category</label> <br/>
            <?php 

                $query = "SELECT * FROM category";
                $result = mysqli_query($conn, $query);                             
                                    
                if(mysqli_num_rows($result) > 0)
                {
                    while($row = mysqli_fetch_array($result))
                    {    
                        echo '<label class="categoryLabel"><input type="radio" name="categoryEdit" id="'.$row["name"].'" value="'.$row["name"].'" required><img src="'.$row["image"].'" class="categoryBill" alt="alternatetext">'.$row['name'].'</label><br>';                               
                    }
                }                         
                ?>                           
            <br/>        
                    
            <div class="d-grid gap-2">
            <button type="button"  class="btn btnEdit btn-block text-light" onclick="editTask()">Edit</button>
           
            </div>
            </form>
        </div>
    </div>  
</div>
