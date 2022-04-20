# ExpenseManagerApp


## This web app is dedicated to managing your expenses/bills/incomes.

### Used languages and tools:
 - HTML
 - PHP
 - CSS
 - JavaScript
 - JQuery
 - AJAX
 - Bootstrap v5
 - Plotly

### Funcionality:
 - login and register screens
 - basic CRUD operations: create, read, update, delete
 - drawing a graph with summary amount of bills in each month and selected year (only expenses)
 - drawing a chart with summary amount of bills in each category and selected year
 - displaying data with selected category
 - search by date, name or value (without page refreshing)
 
### Structure of base
Elementary version of database contains table with bills, users and categories. 
User password is encrypted by default algorithm (bcrypt) in PHP 5.5.0.

## Database example view
![elementarBase](https://user-images.githubusercontent.com/67658221/164230883-cb928596-04fe-4b94-a80c-e30e4b5817ef.png)

### Application - screens 

#### - Main screen of app - scrolling table with bills and charts (by deafult graph includes bills from current year)

![read](https://user-images.githubusercontent.com/67658221/164232039-edb1e8c1-c364-4745-9155-7bc4e5547b99.png)

#### - Display chart in another year (by typing year in input field)

![yearChart](https://user-images.githubusercontent.com/67658221/164232583-b4c38093-9a9b-4108-9159-11a4b4ef4be6.png)

#### - Add new bill (expand form by click in nabar icon)
![add](https://user-images.githubusercontent.com/67658221/164230616-8e5c1105-87f3-4f07-b72d-7dd52ec45c90.png)

#### - Edit bill (by click on table row)
![edit](https://user-images.githubusercontent.com/67658221/164231079-3a940543-1d9f-4a8e-b913-28d7a189b685.png)

#### - Searcher (by typing search key in input field)
![search](https://user-images.githubusercontent.com/67658221/164231190-f91fe55c-4cf7-4024-ba59-901cac5d36c4.png)

#### - Grouping of bills (by select option in dropdown list)
![select](https://user-images.githubusercontent.com/67658221/164232844-68f209b8-5144-4da7-ae03-964d3362b9f9.png)

#### - Sort (by click on filter icon in table head)
![sort](https://user-images.githubusercontent.com/67658221/164233041-eb834bdf-04cb-44c3-bceb-eb1e96576e0d.png)


