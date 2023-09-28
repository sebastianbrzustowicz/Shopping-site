<!DOCTYPE html>
<html>
    
<head>
    
<link rel = "stylesheet" href = "style.css">
    
</head> 

<body>

<a href = "login.php" tite = "main page" style="text-decoration:none" ><h1>Herb shop</h1></a>

<?php
error_reporting(E_ERROR | E_PARSE);

$serverName = "DESKTOP-4OJ4H1R\SQLEXPRESS"; //serverName\instanceName

// Since UID and PWD are not specified in the $connectionInfo array,
// The connection will be attempted using Windows Authentication.
$connectionInfo = array( "Database"=>"TSQL");
$conn = sqlsrv_connect( $serverName, $connectionInfo);
?>

<form action="login.php" method="post">
<input type="submit" VALUE="<- Back" name="back">
</form>
    
<div class = "container">
       
   <form class = "form-signin login-form" role = "form" 
      action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
      ?>" method = "post"><p>Create new account:</p>
       <div class = "reg"><input type = "text" class = "form-control" name = "name" placeholder = "Name" required autofocus></div>
         <div class = "reg"><input type="text" name="surname" class = "form-control" placeholder = "Surname" required></div>
         <div class = "reg"><input type="text" name="login" class = "form-control" placeholder = "Login" required></div>
         <div class = "reg"><input type="text" name="mail" class = "form-control" placeholder = "Email" required></div>
         <div class = "reg"><input type="password" name="password" class = "form-control" placeholder = "Password" required></div>
         <div class = "reg"><input type="text" name="address" class = "form-control" placeholder = "Address" required></div>
         <div class = "reg"><input type="text" name="city" class = "form-control" placeholder = "City" required></div>
         <div class = "reg"><p><input type="submit" class = "btn btn-lg btn-primary btn-block" VALUE="Register" name="register" required>Click here to <a href = "login.php" tite = "Login">login.</a></p></div>
         
   </form>
	
    
   
</div>    

<?php
$name=$_POST['name'];
$surname=$_POST['surname'];
$login=$_POST['login'];
$mail=$_POST['mail'];
$password=$_POST['password'];
$address=$_POST['address'];
$city=$_POST['city'];


$sql = "select count(Login)  
from Shop";
$stmt = sqlsrv_query( $conn, $sql );
$new_id = sqlsrv_fetch_array($stmt);
foreach($new_id as $new_id) {}
sqlsrv_free_stmt($stmt);

if($new_id  != 0){
$sql = "SELECT MAX(PersonID)+1
FROM Shop;";
$stmt = sqlsrv_query( $conn, $sql );
$new_id = sqlsrv_fetch_array($stmt);
foreach($new_id as $new_id) {}
sqlsrv_free_stmt($stmt);
}else{$new_id=1;}
//$sql = "select count(IIF(Login = '$login', 1, NULL))
//from Shop";
//$stmt = sqlsrv_query( $conn, $sql );
//$new_login = sqlsrv_fetch_array($stmt);
//foreach($new_login as $new_lg) {}
//sqlsrv_free_stmt($stmt);

    
if(array_key_exists('register', $_POST)) {  
if($new_login[0] < 1){
echo "<p>Registered succesfully! Now log into your account</p>";
$sql = "INSERT INTO Shop (PersonID, Permission, FirstName, LastName, Login, Password, Mail, Address, City, order_date, ordered_cart_cost, product1, product2, product3, PR1, PR2, PR3)
VALUES ($new_id, 'Customer', '$name', '$surname', '$login', '$password', '$mail', '$address', '$city', NULL, 0, 0, 0, 0, 0, 0, 0);";
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}
   
}else {echo "<div><br>Login is in use. Choose another login.</div>";} 
}

?>

    
</body>
</html>