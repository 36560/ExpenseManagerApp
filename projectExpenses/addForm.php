<div class="text-dark">
    <div class="form-popup" id="addForm">
        <form class="add-edit-container" method="POST">
                            
            <h1 class="text-center">Add bill</h1>

            <label>Title</label><br/>
            <input type="text" id="titleBill" name="titleBill" class="form-control" required/> 
            <br/>

            <label>Date</label><br/>
            <input type="date" id="dateBill" name="dateBill" class="form-control" value="" required/> 
            <br/>

            <label>Amount</label> <br/>
            <input type="text" id="amountBill" name="amountBill" class="form-control"/>
            <br/>

            <label>Category</label> <br/>
                <?php 
                    $query = "SELECT * FROM category";
                    $result = $object->executeQuery($query);

                    if(mysqli_num_rows($result) > 0)
                    {
                        while($row = mysqli_fetch_array($result))
                        {
                            echo '<label class="categoryLabel"><input type="radio" name="categoryBill" id="categoryBill" value="'.$row["name"].'" checked><img src="'.$row["image"].'" class="categoryBill" alt="alternatetext">'.$row['name'].'</label></br>';                                        
                        }
                    }                         
                ?>                           
            <br/>                                    
            <div class="d-grid gap-2">
            <button type="button" class="btn text-light btn-block btnAdd" onclick="addBill()" id="add">Add</button>                               
            </div>
        </form>
    </div>
</div>   