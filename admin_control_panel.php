<!DOCTYPE html>
<html>

<?php
ob_start();
session_start();
$_SESSION['items'] = 0;
error_reporting(E_ERROR | E_PARSE);

$serverName = "DESKTOP-4OJ4H1R\SQLEXPRESS"; //serverName\instanceName

// Since UID and PWD are not specified in the $connectionInfo array,
// The connection will be attempted using Windows Authentication.
$connectionInfo = array( "Database"=>"TSQL");
$conn = sqlsrv_connect( $serverName, $connectionInfo);
?>
    
<head>
    
<link rel = "stylesheet" href = "style.css">
    
</head> 

<body>

<a href = "login.php" tite = "main page" style="text-decoration:none" ><h1>Herb shop</h1></a>

<form method="post" style="float:right">
Click here to clean session - <a href = "logout.php" tite = "Logout">Logout</a>
</form><br><br>
Admin options enabled<br>
<form method="POST" style="float:left">Sort:
    <input type="submit" VALUE="ID ASC" name="sort_asc"/>
</form> 
<form method="POST" style="float:left">
    <input type="submit" VALUE="ID DESC" name="sort_desc"/>
</form> 
<form method="POST" style="float:left">
    <input type="submit" VALUE="Date ASC" name="date_asc"/>
</form> 
<form method="POST" style="float:left">
    <input type="submit" VALUE="Date DESC" name="date_desc"/>
</form> 
<form method="POST" style="float:left">
    <input type="submit" VALUE="Orders" name="actual_orders"/>
</form> 
<form method="POST" style="float:right">Search:
    <input type="text" VALUE="" name="searched_word"/>
    <input type="submit" VALUE="Login" name="search_login"/>
    <input type="submit" VALUE="Name" name="search_name"/>
    <input type="submit" VALUE="Surname" name="search_surname"/>
</form> <br><br><br><br>
<form method="POST" style="float:left">User Login:
    <input type="text" VALUE="" name="user_dlt_clr"/>
    <input type="submit" VALUE="Delete acc" name="delete_acc"/>
    <input type="submit" VALUE="Clear order" name="clr_order"/>
</form><br><br><br>
    
<?php

//if ($_SESSION['permission'] == 'admin'){
    

echo "<h3><table border='1' style='background-color:white;'>
<tr>
<th>UserID</th>
<th>Permission</th>
<th>Name</th>
<th>Surname</th>
<th>Login</th>
<th>Password</th>
<th>Mail</th>
<th>Address</th>
<th>City</th>
<th>Order date</th>
<th>Order cost [$]</th>
<th>PR1 cart</th>
<th>PR2 cart</th>
<th>PR3 cart</th>
<th>PR1</th>
<th>PR2</th>
<th>PR3</th>
</tr>";

$sql = "SELECT * FROM Shop";
if(isset($_POST['sort_asc'])){
$sql = "SELECT * FROM Shop ORDER BY PersonID ASC;";}
if(isset($_POST['sort_desc'])){
$sql = "SELECT * FROM Shop ORDER BY PersonID DESC;";}
if(isset($_POST['date_asc'])){
$sql = "SELECT * FROM Shop WHERE order_date IS NOT NULL ORDER BY order_date ASC;";}
if(isset($_POST['date_desc'])){
$sql = "SELECT * FROM Shop WHERE order_date IS NOT NULL ORDER BY order_date DESC;";}
if(isset($_POST['actual_orders'])){
$sql = "SELECT * FROM Shop WHERE ordered_cart_cost != 0;";}
if(isset($_POST['search_login'])){
$sql = "SELECT * FROM Shop WHERE Login = '{$_POST['searched_word']}';";}
if(isset($_POST['search_name'])){
$sql = "SELECT * FROM Shop WHERE FirstName = '{$_POST['searched_word']}';";}
if(isset($_POST['search_surname'])){
$sql = "SELECT * FROM Shop WHERE LastName = '{$_POST['searched_word']}';";}
if(isset($_POST['delete_acc'])){
$sql = "DELETE FROM Shop WHERE Login = '{$_POST['user_dlt_clr']}';";}
if(isset($_POST['clr_order'])){
$sql = "UPDATE Shop
SET order_date = NULL, ordered_cart_cost = NULL, product1 = 0,product2 = 0 ,product3 = 0,PR1 = 0,PR2 = 0 ,PR3 = 0 WHERE Login = '{$_POST['user_dlt_clr']}';";}

$stmt = sqlsrv_query($conn, $sql);
while($users = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_NUMERIC)){
echo "<tr>";
echo "<td>" . $users[0] . "</td>";
echo "<td>" . $users[1] . "</td>";
echo "<td>" . $users[2] . "</td>";
echo "<td>" . $users[3] . "</td>";
echo "<td>" . $users[4] . "</td>";
echo "<td>" . $users[5] . "</td>";
echo "<td>" . $users[6] . "</td>";
echo "<td>" . $users[7] . "</td>";
echo "<td>" . $users[8] . "</td>";
echo "<td>" . $users[9] . "</td>";
echo "<td>" . $users[10] . "</td>";
echo "<td>" . $users[11] . "</td>";
echo "<td>" . $users[12] . "</td>";
echo "<td>" . $users[13] . "</td>";
echo "<td>" . $users[14] . "</td>"; $userssum1 = $userssum1 + $users[13];
echo "<td>" . $users[15] . "</td>"; $userssum2 = $userssum2 + $users[14];
echo "<td>" . $users[16] . "</td>"; $userssum3 = $userssum3 + $users[15];
echo "</tr>";
}  

echo "</table></h3>";
sqlsrv_free_stmt( $stmt);   
?>

<?php

$sql = "SELECT SUM(ordered_cart_cost)
FROM Shop
WHERE MONTH(order_date) = 1;";
$stmt = sqlsrv_query($conn, $sql);
while(sqlsrv_fetch($stmt) === true) {$order_cost_month_1 = sqlsrv_get_field($stmt, 0);}
sqlsrv_free_stmt($stmt); 
$sql = "SELECT SUM(ordered_cart_cost)
FROM Shop
WHERE MONTH(order_date) = 2;";
$stmt = sqlsrv_query($conn, $sql);
while(sqlsrv_fetch($stmt) === true) {$order_cost_month_2 = sqlsrv_get_field($stmt, 0);}
sqlsrv_free_stmt($stmt); 
$sql = "SELECT SUM(ordered_cart_cost)
FROM Shop
WHERE MONTH(order_date) = 3;";
$stmt = sqlsrv_query($conn, $sql);
while(sqlsrv_fetch($stmt) === true) {$order_cost_month_3 = sqlsrv_get_field($stmt, 0);}
sqlsrv_free_stmt($stmt); 
$sql = "SELECT SUM(ordered_cart_cost)
FROM Shop
WHERE MONTH(order_date) = 4;";
$stmt = sqlsrv_query($conn, $sql);
while(sqlsrv_fetch($stmt) === true) {$order_cost_month_4 = sqlsrv_get_field($stmt, 0);}
sqlsrv_free_stmt($stmt); 
$sql = "SELECT SUM(ordered_cart_cost)
FROM Shop
WHERE MONTH(order_date) = 5;";
$stmt = sqlsrv_query($conn, $sql);
while(sqlsrv_fetch($stmt) === true) {$order_cost_month_5 = sqlsrv_get_field($stmt, 0);}
sqlsrv_free_stmt($stmt); 
$sql = "SELECT SUM(ordered_cart_cost)
FROM Shop
WHERE MONTH(order_date) = 6;";
$stmt = sqlsrv_query($conn, $sql);
while(sqlsrv_fetch($stmt) === true) {$order_cost_month_6 = sqlsrv_get_field($stmt, 0);}
sqlsrv_free_stmt($stmt); 
$sql = "SELECT SUM(ordered_cart_cost)
FROM Shop
WHERE MONTH(order_date) = 7;";
$stmt = sqlsrv_query($conn, $sql);
while(sqlsrv_fetch($stmt) === true) {$order_cost_month_7 = sqlsrv_get_field($stmt, 0);}
sqlsrv_free_stmt($stmt); 
$sql = "SELECT SUM(ordered_cart_cost)
FROM Shop
WHERE MONTH(order_date) = 8;";
$stmt = sqlsrv_query($conn, $sql);
while(sqlsrv_fetch($stmt) === true) {$order_cost_month_8 = sqlsrv_get_field($stmt, 0);}
sqlsrv_free_stmt($stmt); 
$sql = "SELECT SUM(ordered_cart_cost)
FROM Shop
WHERE MONTH(order_date) = 9;";
$stmt = sqlsrv_query($conn, $sql);
while(sqlsrv_fetch($stmt) === true) {$order_cost_month_9 = sqlsrv_get_field($stmt, 0);}
sqlsrv_free_stmt($stmt); 
$sql = "SELECT SUM(ordered_cart_cost)
FROM Shop
WHERE MONTH(order_date) = 10;";
$stmt = sqlsrv_query($conn, $sql);
while(sqlsrv_fetch($stmt) === true) {$order_cost_month_10 = sqlsrv_get_field($stmt, 0);}
sqlsrv_free_stmt($stmt); 
$sql = "SELECT SUM(ordered_cart_cost)
FROM Shop
WHERE MONTH(order_date) = 11;";
$stmt = sqlsrv_query($conn, $sql);
while(sqlsrv_fetch($stmt) === true) {$order_cost_month_11 = sqlsrv_get_field($stmt, 0);}
sqlsrv_free_stmt($stmt); 
$sql = "SELECT SUM(ordered_cart_cost)
FROM Shop
WHERE MONTH(order_date) = 12;";
$stmt = sqlsrv_query($conn, $sql);
while(sqlsrv_fetch($stmt) === true) {$order_cost_month_12 = sqlsrv_get_field($stmt, 0);}
sqlsrv_free_stmt($stmt); 
    
//$dataPoints = array(
//	array("label"=> "Product 1", "y"=> $userssum1),
//	array("label"=> "Product 2", "y"=> $userssum2),
//	array("label"=> "Product 3", "y"=> $userssum3)
//);
$dataPoints = array(
	array("label"=> "January", "y"=> $order_cost_month_1),
    array("label"=> "February", "y"=> $order_cost_month_2),
	array("label"=> "March", "y"=> $order_cost_month_3),
	array("label"=> "April", "y"=> $order_cost_month_4),
	array("label"=> "May", "y"=> $order_cost_month_5),
	array("label"=> "June", "y"=> $order_cost_month_6),
	array("label"=> "July", "y"=> $order_cost_month_7),
	array("label"=> "August", "y"=> $order_cost_month_8),
	array("label"=> "September", "y"=> $order_cost_month_9),
	array("label"=> "October", "y"=> $order_cost_month_10),
	array("label"=> "November", "y"=> $order_cost_month_11),
	array("label"=> "December", "y"=> $order_cost_month_12)
);
    
?>
    
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2",
	title: {
		text: "Products ordered"
	},
	axisY: {
		prefix: "$",
		scaleBreaks: {
			autoCalculate: true
		}
	},
	data: [{
		type: "column",
		yValueFormatString: "$#######.00",
		indexLabel: "{y}",
		indexLabelPlacement: "inside",
		indexLabelFontColor: "white",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
<div id="chartContainer" style="height: 370px; width: 50%; margin: 0 auto"></div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

<?php
  
$sql = "SELECT TOP 1 ordered_cart_cost
FROM Shop
ORDER BY ordered_cart_cost DESC;";
$stmt = sqlsrv_query($conn, $sql);
while($biggest_order = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_NUMERIC)){echo "<h3>Biggest order cost: ",$biggest_order[0];}
sqlsrv_free_stmt($stmt); 
$sql = "SELECT SUM(PR1)
FROM Shop;";
$stmt = sqlsrv_query($conn, $sql);
while($biggest_p1_order = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_NUMERIC)){echo "<br>Total product1 orders: ",$biggest_p1_order[0];}
sqlsrv_free_stmt($stmt); 
$sql = "SELECT SUM(PR2)
FROM Shop;";
$stmt = sqlsrv_query($conn, $sql);
while($biggest_p2_order = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_NUMERIC)){echo "<br>Total product2 orders: ",$biggest_p2_order[0];}
sqlsrv_free_stmt($stmt); 
$sql = "SELECT SUM(PR3)
FROM Shop;";
$stmt = sqlsrv_query($conn, $sql);
while($biggest_p3_order = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_NUMERIC)){echo "<br>Total product3 orders: ",$biggest_p3_order[0];}
sqlsrv_free_stmt($stmt); 
$sql = "SELECT ordered_cart_cost
FROM Shop
ORDER BY ordered_cart_cost DESC;";
$stmt = sqlsrv_query($conn, $sql);
$total_order_cost = 0;
while($total_order_cost_fetch = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_NUMERIC)){$total_order_cost=$total_order_cost+$total_order_cost_fetch[0];}
echo "<br>Total order cost: ",$total_order_cost,"</h3>";
sqlsrv_free_stmt($stmt); 
    

    
?>

    
</body>
</html>