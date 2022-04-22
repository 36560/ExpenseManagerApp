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
                $object -> getEditCategories();                      
            ?>                           
            <br/>        
                    
            <div class="d-grid gap-2">
            <button type="button"  class="btn btnEdit btn-block text-light" onclick="editBill()">Edit</button>
           
            </div>
            </form>
        </div>
    </div>  
</div>
