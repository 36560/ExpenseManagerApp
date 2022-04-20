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
            data: [
                months[1],  
                months[2],               
                months[3],
                months[4],
                months[5],
                months[6],
                months[7],
                months[8],
                months[9],
                months[10],
                months[11],
                months[12]
            ],
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
                        months[month] = data;

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