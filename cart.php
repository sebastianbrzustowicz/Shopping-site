<!DOCTYPE html>
<html>

<?php
ob_start();
session_start();
$_SESSION['permission'] = '';

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

<form method="post" style="float:left">
Go to <a href = "welcome.php" tite = "Logout">main page</a>
</form>
<form method="post" style="float:right">
Click here to clean session - <a href = "logout.php" tite = "Logout">Logout</a>
</form><br><br>
    
    <h3>Your cart list:</h3>
    
<?php
    
$sql = "SELECT product1, product2, product3 FROM Shop
WHERE login = '{$_SESSION["name"]}';";
$stmt = sqlsrv_query( $conn, $sql );
$actual_cart = sqlsrv_fetch_array($stmt);
foreach($actual_cart as $r) {}
sqlsrv_free_stmt($stmt);
$sql = "SELECT Name, Cost, Description FROM Products
Where ProductID = 1;";
$stmt = sqlsrv_query( $conn, $sql );
$item1 = sqlsrv_fetch_array($stmt);
foreach($item1 as $r) {}
sqlsrv_free_stmt($stmt);
$sql = "SELECT Name, Cost, Description FROM Products
Where ProductID = 2;";
$stmt = sqlsrv_query( $conn, $sql );
$item2 = sqlsrv_fetch_array($stmt);
foreach($item2 as $r) {}
sqlsrv_free_stmt($stmt);
$sql = "SELECT Name, Cost, Description FROM Products
Where ProductID = 3;";
$stmt = sqlsrv_query( $conn, $sql );
$item3 = sqlsrv_fetch_array($stmt);
foreach($item3 as $r) {}
sqlsrv_free_stmt($stmt);
    

echo "<h3><table border='1' style='background-color:white;'>
<tr>
<th>Product name</th>
<th>Cost</th>
<th>Amount</th>
<th>Sum</th>
</tr>";
  {
  if ($actual_cart[0]!=0){
  echo "<tr>";
  echo "<td>" . $item1[0] . "</td>";
  echo "<td>$" . $item1[1] . "</td>";
  echo "<td>" . $actual_cart[0] . "</td>";
  echo "<td>$" . $item1[1]*$actual_cart[0] . "</td>";
  echo "</tr>";
}
  if ($actual_cart[1]!=0){
  echo "<tr>";
  echo "<td>" . $item2[0] . "</td>";
  echo "<td>$" . $item2[1] . "</td>";
  echo "<td>" . $actual_cart[1] . "</td>";
  echo "<td>$" . $item2[1]*$actual_cart[1] . "</td>";
  echo "</tr>";
}
  if ($actual_cart[2]!=0){
  echo "<tr>";
  echo "<td>" . $item3[0] . "</td>";
  echo "<td>$" . $item3[1] . "</td>";
  echo "<td>" . $actual_cart[2] . "</td>";
  echo "<td>$" . $item3[1]*$actual_cart[2] . "</td>";
  echo "</tr>";
}

  echo "<tr style='background-color:#90ff90;'>";
  echo "<td>" . '' . "</td>";
  echo "<td>" . '' . "</td>";
  echo "<td>" . $actual_cart[0]+$actual_cart[1]+$actual_cart[2] . "</td>";
  echo "<td>$" . $item1[1]*$actual_cart[0]+$item2[1]*$actual_cart[1]+$item3[1]*$actual_cart[2] . "</td>";
  echo "</tr>";
}
echo "</table>";
?>
    

<form method="post">
<input type="submit" VALUE="Clear cart" name="clear_cart">
<input type="submit" VALUE="Order and pay" name="order_and_pay">
</form></h3>

<?php
    
if (isset($_POST['clear_cart'])){
$_SESSION['counter_product1'] = 0;
$_SESSION['counter_product2'] = 0;
$_SESSION['counter_product3'] = 0;
$sql = "UPDATE Shop
SET product1 = 0, product2 = 0, product3 = 0
WHERE login = '{$_SESSION["name"]}';";
$stmt = sqlsrv_query( $conn, $sql );
sqlsrv_free_stmt($stmt);
$_SESSION['empty_cart'] = 1;
header("Refresh:0");
}
    
if ($_SESSION['counter_product1'] == 0&&
$_SESSION['counter_product2'] == 0&&
$_SESSION['counter_product3'] == 0){
echo "<h3>Cart is empty!</h3>";}
    
if (isset($_POST['order_and_pay']) && ($_SESSION['counter_product1'] != 0 ||
$_SESSION['counter_product2'] != 0 ||
$_SESSION['counter_product3'] != 0)){
$ordered_cost = $item1[1]*$actual_cart[0]+$item2[1]*$actual_cart[1]+$item3[1]*$actual_cart[2];
$sql = "UPDATE Shop
SET ordered_cart_cost = '$ordered_cost', order_date = CAST(GETDATE() AS varchar(255)), PR1 = '{$_SESSION['counter_product1']}', PR2 = '{$_SESSION['counter_product2']}', PR3 = '{$_SESSION['counter_product3']}'
WHERE login = '{$_SESSION["name"]}';";
$stmt = sqlsrv_query( $conn, $sql );
sqlsrv_free_stmt($stmt);
echo "<h3>Your Order Was Successful! Thank you for your payment</h3>";
}

?>
    
</body>
</html>