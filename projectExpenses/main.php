<?php

    $conn = mysqli_connect("localhost","root","","expensesjs");
    session_start();

    if(!isset($_SESSION["username"]))
    {
        header("location:index.php?action=login");
    }

    $username = $_SESSION["username"];
    $currentUser = $_SESSION["id"];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Expense Manager App</title>       
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script
        src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"
        integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
         <!-- Plots -->
        <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>       
        <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>    
        <link rel="stylesheet" href="style.css">    
</head>
    <script>  
    var color1 = "rgba(5, 48, 165, 0.54)";    
    var color2 = "rgba(5, 48, 165, 0.69)";    
    var color3 = "rgba(8, 165, 5, 0.63)";    
    var color4 = "rgba(8, 165, 5, 0.51)";    
    var color5 = "rgba(8, 165, 5, 0.42)";    
    var color6 = "rgba(236, 200, 23, 0.78)";    
    var color7 = "rgba(236, 200, 23, 0.65)";    
    var color8 = "rgba(236, 200, 23, 0.53)";    
    var color9 = "rgba(232, 90, 31, 0.72)";    
    var color10 = "rgba(232, 90, 31, 0.6)";    
    var color11 = "rgba(232, 90, 31, 0.51)";    
    var color12 = "rgba(5, 48, 165, 0.42)";

    let catChart;
    let monthChart;

    function createChart()  
    {
        var today = new Date();        
        var year = today.getFullYear();
        var yearFilter = $("#yearFilter").val();

        if(yearFilter.length === 4)
            year=yearFilter;

        getDataMonth(year);
        getCategories(year);
    }           
    function drawGraphCategory(categories,amounts,images)
    {
        let myChart = document.getElementById('catChart').getContext('2d');
        const barAvatar = 
        {
            id: 'barAvatar', 
            beforeDraw(chart, args, options)
            {
                const{ctx, chartArea: {top,bottom, left, right, width, height},
                scales: {x,y}} = chart;
                ctx.save();

                for(var i=0 ; i<images.length; i++)
                {
                    const img2 = new Image();
                    img2.src = images[i];
                    ctx.drawImage(img2,x.getPixelForValue(i)-10,y.getPixelForValue(amounts[i])-35,30,30)                    
                }           
            }
        }

        catChart = new Chart(myChart,
        {
            type:'bar',
            data:
            {
                labels: categories,
                datasets: 
                [{
                    label: 'Category',
                    data: amounts,
                    backgroundColor: [color1,color3,color5,color7,color9,color11],
                }]
            },
           options:
           {
                legend: 
                {
                    fontColor: "blue"
                },
            },
            plugins: [barAvatar]
        });
    }
    function sendDataCat(categories,amounts,images) 
    {       
        var i = 0;    
        for(var cat in categories)
        {
            amounts[i] = amounts[categories[cat]];
            i++;
        }     
        
        drawGraphCategory(categories,amounts,images);
    }
    function sendData(months) 
    {            
        drawGraphMonth(months);
    }            
    function drawGraphMonth(months)
    {   
        let myChart = document.getElementById('monthChart').getContext('2d');
        monthChart =  new Chart(myChart,
        {
            type:'bar',
            data:
            {
                labels: ['January','February','March','April','May','June','July','August','September','October','November','December'],
                datasets: 
            [{
                label: 'Months',
                data: months,
                backgroundColor: [color1, color2, color3, color4, color5, color6, color7, color8, color9, color10, color11, color12], 
            }]
          },
          options:
          {
            legend: {
            fontColor: "blue"
            },
          }
      });
    }
    var idBill;
    function clickedRow(id)
    {
        idBill = id;
    }  
    function editTask()
    {
        var title = $('#titleEdit').val();
        var amount = $('#amountEdit').val();
        var date = $('#dateEdit').val();
        var category = $('input[name="categoryEdit"]:checked').val();
        var userId = <?php echo $currentUser ?>;

        if(title && date && category)
        {
            $(".row" + idBill).fadeOut(100);
            $.ajax
            ({
            url: "edit.php",
            type: "POST",
            data: 
            {
                title: title, 
                date: date,
                amount: amount,
                idBill: idBill,
                userId: userId,
                category: category
            },
            cache: false,
            success: function(data) 
            {
                if(data == -1)
                {
                    closeEditForm();
                    var err = "Unsuccessful edit :C"
                    var error = '<div class="alert alert-info alert-dismissible fade show" role="alert"><strong>Error! </strong>'+err+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                    $('.errorInfo').html(error);
                }
                else
                {
                    $(".displayData").fadeOut(200);
                    closeEditForm();    
                    var option = $('#groupOption').val();   
                    readBills(userId,option,'displaydata')
                    catChart.destroy();
                    monthChart.destroy();
                    createChart();
                    $(".displayData").fadeIn(300);          
                }    
            },
            error: function(xhr, status, error) 
            {
                console.error(xhr);
            }  
            });     
            $(".row" + idBill).fadeIn(300);      
        }
        else
        {
            $('#titleBill').attr("placeholder", "Set value");            
        }               
    }
    function deleteTask(id)
    {
        $.ajax
        ({
            url: "delete.php",
            type: "POST",
            data: 
            {
                idBill: id,
            },
            cache: false,
            success: function(data) 
            {               
                if(data == 1)     
                {
                    $(".row" + id).fadeOut('slow');  
                    catChart.destroy();
                    monthChart.destroy();
                    createChart();
                }
                else
                {                  
                    $('.errorInfo').html(data);
                }
            },
            error: function(xhr, status, error) 
            {
                console.error(xhr);              
            }            
        });                        
    }   
    function addBill()
    {
        var title = $('#titleBill').val();
        var dateBill = $('#dateBill').val();
        var amount = $('#amountBill').val();
        var category = $('input[name="categoryBill"]:checked').val();
        var userId = <?php echo $currentUser ?>;        

        if(title && dateBill && category) 
        {
            $.ajax
            ({
            url: "add.php",
            type: "POST",
            data: 
            {
                title: title,
                dateBill: dateBill,
                amount: amount,
                userId: userId,
                category: category
            },
            cache: false,
            success: function(data) 
            {        
                if(data == -1)   
                {
                    var err = "Unsuccessful save :C";
                    var error = '<div class="alert alert-info alert-dismissible fade show" role="alert"><strong>Error! </strong>'+err+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                    $('.errorInfo').html(error);
                }
                else
                {       
                    catChart.destroy();
                    monthChart.destroy();
                    expandAddForm();
                    createChart();
                    $(".displayData").fadeOut(200);
                    var option = $('#groupOption').val();
                    readBills(userId,option,'displaydata');  
                    $(".displayData").fadeIn(300);    
                }         
            },
            error: function(xhr, status, error) 
            {
                console.error(xhr);
            }            
            });  
        }    
        else
        {
            $('#titleBill').attr("placeholder", "Set value");            
        }        
    } 
    function closeEditForm() 
    {        
        $(".fullscreen-container").fadeOut(300);      
        document.getElementById("editForm").style.display = "none";
    }
    function openEditForm(id,titleBill,amountBill,dateBill,cat) 
    {     
        document.getElementById("titleEdit").value = titleBill;
        document.getElementById("amountEdit").value = amountBill;
        document.getElementById("dateEdit").value = dateBill;
        document.getElementById(cat).checked = true;    
        idBill = id;

        $(".fullscreen-container").fadeTo(200, 1);
        document.getElementById("editForm").style.display = "block";        
    }
    function readBills(currentUser, option, divid)
    {
        var ajaxDisplay = document.getElementById(divid);
        var today = new Date();
        var month = today.getMonth() + 1
        var day = today.getDay();
        var year = today.getFullYear();
        var key = $("#searchKey").val();
        var todayDate = today.toISOString().split('T')[0];
                
        $.ajax({
            url: 'read.php',
            type: "POST",
            data:
            {
                currentUser: currentUser,
                todayDate: todayDate,
                option: option,
                searchKey: key
            },
            cache: false,
            success: function(data) 
            {  
                ajaxDisplay.innerHTML = data;                     
            },
            error: function(xhr, status, error) 
            {
            }
        });
    }      
    function expandAddForm()
    {               
        if(document.getElementById("addForm").style.display == 'block')
        {
            document.getElementById("addForm").style.display = "none";     
        }            
        else
        {
            document.getElementById("addForm").style.display = "block";   
            document.getElementById('dateBill').valueAsDate = new Date();
        }            
    }
    function getCategories(year)
    {
        let categories = [];
        let images = [];
        var today = new Date();
       
        $.ajax
        ({
            url: 'getCategories.php',
            type: "POST",
            dataType: 'json',
            cache: false,
            success: function(data) 
            {  
                for(var i=0; i<data[0].length; i++)
                {
                    categories[i] = data[0][i][0];
                    images[i] = data[0][i][1];
                }    
                getDataCategory(categories,year,images);
            },
            error: function(xhr, status, error) 
            {                        
            }
        });      
    }

    function getDataCategory(categories,year,images)
    {                    
        let amounts = [];
        var i = 0;

        for(var cat of categories)
        {(function(cat)
        {            
            $.ajax({
                    url: 'getCategoriesAmount.php',
                    type: "POST",
                    data:
                    {
                        currentUser: <?php echo $currentUser ?>,
                        year: year, 
                        category: cat
                    },
                    cache: false,
                    success: function(data) 
                    {                          
                        amounts[cat] = data;
                       
                        if(i==(categories.length-1))
                            sendDataCat(categories,amounts,images);   
                        i += 1;
                    },
                    error: function(xhr, status, error) 
                    {                        
                    }                   
                });
            })(cat);
        }    
    }    
    function getDataMonth(year)
    {
        let months = [];
        var userId = <?php echo $currentUser ?>;

        for(var month=1; month<=12; month++)
        {(function(month)
        {            
            var d = new Date(year+"-"+month+"-01");        
            var compareDownDate = new Date(d.getTime() - d.getTimezoneOffset() * 60 * 1000).toISOString().split('T')[0];
            var compareUpDate;
   
                if(month==12)
                {
                    var y = parseInt(year)+1;
                    var d = new Date(y+"-01-01");
                    compareUpDate = new Date(d.getTime() - d.getTimezoneOffset() * 60 * 1000).toISOString().split('T')[0];
                }
                else
                {
                    var d = new Date(year+"-"+(month+1)+"-01"); 
                    compareUpDate = new Date(d.getTime() - d.getTimezoneOffset() * 60 * 1000).toISOString().split('T')[0];
                }

            $.ajax({
                    url: 'getAmount.php',
                    type: "POST",
                    data:
                    {
                        comDown: compareDownDate,
                        comUp: compareUpDate,
                        userId: userId
                    },
                    cache: false,
                    success: function(data) 
                    {  
                        if(data>0)  
                            months[month-1] = data;
                        if(month==12)                       
                            sendData(months);
                                                                        
                    },
                    error: function(xhr, status, error) 
                    {                        
                    }
                });
            })(month);      
        }           
    }

    var val1;
    var val2;
    function sortTable(n) 
    {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        var isNumber = false;
        table = document.getElementById("billTable");
        switching = true;
        dir = "asc"; 

        if(n==1)
        {
            document.getElementById("sortAmount").style.color="white";
            document.getElementById("sortDate").style.color="#378dc7";
        }
        if(n==2)
        {
            document.getElementById("sortAmount").style.color="#378dc7";
            document.getElementById("sortDate").style.color="white";
            isNumber = true;
        }

        while (switching)
        {
            switching = false;
            rows = table.rows;

            for (i = 1; i < (rows.length - 1); i++) 
            {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];


                getValues(isNumber,x,y);

                if (dir == "asc") 
                {
                    if (val1>val2)
                    {
                        shouldSwitch= true;
                        break;
                    }
                } 
                else if (dir == "desc") 
                {
                    if (val1<val2) 
                    {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch)
            {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount ++;      
            } 
            else 
            {
                if (switchcount == 0 && dir == "asc") 
                {
                    dir = "desc";
                    switching = true;
                }
            }
        }    
    }
    function getValues(isNumber,x,y)
    {        
        if(isNumber)
        {
            val1 = parseFloat(x.innerHTML);
            val2 = parseFloat(y.innerHTML);
        }
        else
        {
            val1 = x.innerHTML.toLowerCase();
            val2 = y.innerHTML.toLowerCase();
        }
    }
    </script>

<body onload="readBills(<?php echo $currentUser ?>, '0', 'displaydata'); createChart();">

    <?php include('navbar.php'); ?>    
       
    <div style="background: url(https://images.pexels.com/photos/6192754/pexels-photo-6192754.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940)" id="bgImage" class="page-holder bg-cover">


    <div class="errorInfo">
        <?php
            if(isset($_GET["error"]) && isset($_SESSION["error"]))
            {
                $err = $_SESSION["error"];
                echo '<div class="alert alert-info alert-dismissible fade show" role="alert">
                     <strong>Error! </strong>'.$err.'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                     </div>';
            }
        ?>
    </div>

    <div class="container-fluid">
    <div class="row">
        <div class="col">
        </div>
        <div class="col container-all">
        <!-- ADD form -->
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
                            $result = mysqli_query($conn, $query);       
                                    
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
        </div>
        <div class="col">
        </div>
    </div>
    </div>

    <?php include('forms.php'); ?>
        <div class="container-fluid">
        <div class="row">
            <div class="col">
            <form class="d-flex">        
            <div class="input-icons">          
                <i class="far fa-calendar-alt icon"></i>
                <input class="input-field bg-light text-dark searchKey" type="search" name="yearFilter" id="yearFilter" placeholder="Year" aria-label="Search">    
            </div>
            </form>
                <div class="container">
                    <canvas id="monthChart"></canvas>
                </div>
                <div class="container">
                    <canvas id="catChart"></canvas>
                </div>
        </div>
            <div class="col">

            <select class="form-select bg-dark text-light" id="groupOption" aria-label="Default select example"  onchange="readBills(<?php echo $currentUser ?>, this.value, 'displaydata')">
            <option value ="0" selected>All</option>
            <?php 
                $query = "SELECT * FROM category";
                $result = mysqli_query($conn, $query);       
     
                if(mysqli_num_rows($result) > 0)
                {
                    while($row = mysqli_fetch_array($result))
                    {
                        echo '<option value="'.$row["name"].'">'.$row["name"].'</option>';
                    }
                }                         
            ?>         
            </select>
                <div id="displaydata">
                </div>
            </div>
        </div>
        </div>
    </div>   
    </body>

<script>  
    $("#searchKey").on('keyup', function()
    {
        var value = $(this).val().toLowerCase();     
        var option = $('#groupOption').val();      
        readBills(<?php echo $currentUser ?>,option,'displaydata');
    });

    $("#yearFilter").on('keyup', function()
    {
        var value = $(this).val();  
        var today = new Date();      

       if(value.length === 4)    
       {
            catChart.destroy();
            monthChart.destroy();
            createChart();            
       }
       if(value.length === 0)   
       {
            var year = today.getFullYear();
            document.getElementById("yearFilter").value = year;
            catChart.destroy();
            monthChart.destroy();
            createChart();              
       } 
    });
    
</script>


</html>