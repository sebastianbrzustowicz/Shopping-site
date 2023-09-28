<!DOCTYPE html>
<html>

<?php
ob_start();
session_start();

error_reporting(E_ERROR | E_PARSE);

if(!isset($_SESSION['counter_product1'])) {
    $_SESSION['counter_product1'] = 0;
}

if(isset($_POST['add_product1'])) {
    ++$_SESSION['counter_product1'];
}    

if(isset($_POST['reset_product1'])) {
    $_SESSION['counter_product1'] = 0;
}
if(!isset($_SESSION['counter_product2'])) {
    $_SESSION['counter_product2'] = 0;
}

if(isset($_POST['add_product2'])) {
    ++$_SESSION['counter_product2'];
}    

if(isset($_POST['reset_product2'])) {
    $_SESSION['counter_product2'] = 0;
}
if(!isset($_SESSION['counter_product3'])) {
    $_SESSION['counter_product3'] = 0;
}

if(isset($_POST['add_product3'])) {
    ++$_SESSION['counter_product3'];
}    

if(isset($_POST['reset_product3'])) {
    $_SESSION['counter_product3'] = 0;
}

$serverName = "DESKTOP-4OJ4H1R\SQLEXPRESS"; //serverName\instanceName

// Since UID and PWD are not specified in the $connectionInfo array,
// The connection will be attempted using Windows Authentication.
$connectionInfo = array( "Database"=>"Shop_data");
$conn = sqlsrv_connect( $serverName, $connectionInfo);
?>
    
<head>
    
<style> 
body {
  //background-image: url("herbs.jpg"); no-repeat center center fixed; 
  background-color: darkseagreen;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}

input[type=button], input[type=submit], input[type=reset] {
  background-color: #04AA6D;
  //border: none;
  color: white;
  padding: 10px 16px;
  text-decoration: none;
  margin: 10px 8px;
  cursor: pointer;
}

div {text-align: center;}
.form-signin {
   max-width: 330px;
   padding: 15px;
   margin: 0 auto;
}
divl {text-align: left;}
.form-signin {
   max-width: 330px;
   padding: 15px;
   margin: 200px;
}


.form-signin .form-signin-heading,
.form-signin .checkbox {
   margin-bottom: 10px;
}

.form-signin .checkbox {
   font-weight: normal;
}

.form-signin .form-control {
   position: relative;
   height: auto;
   -webkit-box-sizing: border-box;
   -moz-box-sizing: border-box;
   box-sizing: border-box;
   padding: 10px;
   font-size: 16px;
}

.form-signin .form-control:focus {
   z-index: 2;
}

.form-signin input[type="email"] {
   margin: 10px 10px 10px 10px;

}

.form-signin input[type="password"] {
   margin: 10px 10px 10px 10px;

}
h1 {text-align: center;background: rgba(76, 175, 80, 0.9);color: black;}
h3 {text-align: center;}
h4 {text-align: left;}
p {text-align: center;}
c {background: rgba(76, 175, 80, 0.4);font-size: 20px;}
div {text-align: center;}
    
.column {
  float: left;
  width: 24%;
  margin: 40px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
</style>
    
</head> 

    
<body>

<?php
global $countedProducts;
$sql = "SELECT COUNT(*)
FROM Products;";
$stmt = sqlsrv_query( $conn, $sql );
$countedProducts = sqlsrv_fetch_array($stmt);
foreach($countedProducts as $ctd) {}
sqlsrv_free_stmt( $stmt);
?>
    
<a href = "login.php" tite = "main page" style="text-decoration:none" ><h1>Herb shop</h1></a>
    
<form method="post" style="float:left">
    <a href = "cart.php" tite = "cart"><img src="shopping_cart.png" alt="shopping_cart" style="width:4%"></a>
Go to your <a href = "cart.php" tite = "cart">shopping cart</a>
</form>

<form method="post" style="float:right">
Click here to clean session - <a href = "logout.php" tite = "Logout">Logout</a>
</form><br>
<?php
$_SESSION['items'] = $_SESSION['counter_product1']+$_SESSION['counter_product2']+$_SESSION['counter_product3'];
echo "<h4>Available different items - ",$countedProducts[0],"<br>Selected items - ",$_SESSION['items'],"</h4>";
?><br>

<?php

$sql = "SELECT Name, Cost, Description FROM Products
Where ProductID = 1;";
$stmt = sqlsrv_query( $conn, $sql );
$item1 = sqlsrv_fetch_array($stmt);
foreach($item1 as $r) {}
sqlsrv_free_stmt( $stmt);
$sql = "SELECT Name, Cost, Description FROM Products
Where ProductID = 2;";
$stmt = sqlsrv_query( $conn, $sql );
$item2 = sqlsrv_fetch_array($stmt);
foreach($item2 as $r) {}
sqlsrv_free_stmt( $stmt);
$sql = "SELECT Name, Cost, Description FROM Products
Where ProductID = 3;";
$stmt = sqlsrv_query( $conn, $sql );
$item3 = sqlsrv_fetch_array($stmt);
foreach($item3 as $r) {}
sqlsrv_free_stmt( $stmt);
?>

<div class="row">
  <div class="column" >
    <img src="product1.jpg" alt="Oregano" style="width:100%;border: 3px solid; " >
    <h2><?php echo $item1[0]; ?></h2>
  <h3 class="price">$<?php echo $item1[1]; ?></h3>
  <h3><?php echo $item1[2]; ?></h3>
  <form method="POST">
    <input type="hidden" name="counter_product1" value="<?php echo $_SESSION['counter_product1']; ?>" />
    <input type="submit" name="add_product1" value="Add" />
    <input type="submit" name="reset_product1" value="Reset" />
      <h1><?php echo "In cart: ",$_SESSION['counter_product1']; ?></h1>
  </form>
  </div>
  <div class="column">
    <img src="product2.jpg" alt="Rosemary" style="width:100%;border: 3px solid;">
    <h2><?php echo $item2[0]; ?></h2>
  <h3 class="price">$<?php echo $item2[1]; ?></h3>
  <h3><?php echo $item2[2]; ?></h3>
  <form method="POST">
    <input type="hidden" name="counter_product2" value="<?php echo $_SESSION['counter_product2']; ?>" />
    <input type="submit" name="add_product2" value="Add" />
    <input type="submit" name="reset_product2" value="Reset" />
      <h1><?php echo "In cart: ",$_SESSION['counter_product2']; ?></h1>
  </form>
  </div>
  <div3 class="column">
    <img src="product3.jpg" alt="Mint" style="width:100%;border: 3px solid;">
    <h2><?php echo $item3[0]; ?></h2>
  <h3 class="price">$<?php echo $item3[1]; ?></h3>
  <h3><?php echo $item3[2]; ?></h3>
  <form method="POST">
    <input type="hidden" name="counter_product3" value="<?php echo $_SESSION['counter_product3']; ?>" />
    <input type="submit" name="add_product3" value="Add" />
    <input type="submit" name="reset_product3" value="Reset" />
      <h1><?php echo "In cart: ",$_SESSION['counter_product3']; ?></h1>
  </form>
  </div>
</div>
    

    
<?php
$sql = "UPDATE Shop
SET product1 = '{$_SESSION['counter_product1']}', product2 = '{$_SESSION['counter_product2']}', product3 = '{$_SESSION['counter_product3']}'
WHERE login = '{$_SESSION["name"]}';";
$stmt = sqlsrv_query( $conn, $sql );
$update_cart = sqlsrv_fetch_array($stmt);
foreach($update_cart as $r) {}
sqlsrv_free_stmt($stmt);


?>
    

    
</body>
</html>