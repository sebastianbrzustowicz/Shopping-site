<!DOCTYPE html>
<html>

<?php
ob_start();
session_start();
$_SESSION['permission'] = '';
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

<form action="sign_up.php" method="post" style="float:left">
<input type="submit" VALUE="Sign up" name="sign_up">
</form>

<form method="POST" action="login_owner.php" style="float:right">
    <input type="submit" VALUE="Log in as owner"/>
  </form><br><br><br><br>
<form method="post" style="float:right">
Click here to clean session - <a href = "logout.php" tite = "Logout">Logout</a>
</form>

<div class = "container" >

   <form class = "form-signin login-form" role = "form" 
      action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
      ?>" method = "post" >
       <p>Login as customer:</p>
      <input type = "text" class = "form-control" 
         name = "name" placeholder = "Name" 
         required autofocus></br>
      <input type = "password" class = "form-control"
         name = "password" placeholder = "Password" required>
      <p><input type="submit" class = "btn btn-lg btn-primary btn-block" VALUE="Enter" name="login">
    <input type="checkbox" checked="checked" name="remember"> Remember me</p>
   </form>
</div>

<?php
$msg = '';


if (isset($_POST['login']) && !empty($_POST['name']) 
   && !empty($_POST['password'])) {

$sql = "SELECT Password, Permission FROM Shop
Where Login = '{$_POST["name"]}';";
$stmt = sqlsrv_query( $conn, $sql );
while( $sqlpassword = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC) ) {
if (md5($_POST['password']) == md5($sqlpassword[0]) && $sqlpassword[1] == 'Customer') {
   $_SESSION['name'] = $_POST['name'];
   $_SESSION['valid'] = true;
   $_SESSION['timeout'] = time();
   $_SESSION['permission'] = 'customer';
   
   $msg = '<p>You have entered valid username and password<br>Go to <a href = "welcome.php" tite = "Shop">shop.</a></p>';
   
}else {
   $msg = '<p>Wrong username or password</p>';
}
} 
if ($msg == '' && !empty($_POST['name']) && !empty($_POST['password'])){$msg = '<p>Wrong username or password</p>';};
sqlsrv_free_stmt( $stmt);

}
echo $msg;



    
    
?>
    

    
</body>
</html>