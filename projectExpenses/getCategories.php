 <?php 
    $conn = mysqli_connect("localhost","root","","expensesjs");
    $query = "SELECT * FROM category";
    $result = mysqli_query($conn, $query);   
    $json = '{}';

    if(mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_array($result))
        {
            $array[] = array($row["name"],$row["image"]);
        }
        
        echo json_encode(array($array)); 
    }                         
?>          