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

<form action="login.php" method="post" style="float:left">
<input type="submit" VALUE="<- Back" name="login" >
</form>
<form method="post" style="float:right">
Click here to clean session - <a href = "logout.php" tite = "Logout">Logout</a>
</form>
    
<div class = "container">
      
   <form class = "form-signin login-form" role = "form" id="login123"
      action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
      ?>" method = "post"><p>Login as owner:</p> 
      <input type = "text" class = "form-control" 
         name = "name" placeholder = "Name" 
         required autofocus></br>
      <input type = "password" class = "form-control"
         name = "password" placeholder = "Password" required><br>
      <p><input type="submit" class = "btn btn-lg btn-primary btn-block" VALUE="Enter" name="login">
    <input type="checkbox" checked="checked" name="remember"> Remember me</p>
   </form>
	
    
   
</div>

<?php
error_reporting(E_ERROR | E_PARSE);
$msg = '';


if (isset($_POST['login']) && !empty($_POST['name']) 
   && !empty($_POST['password'])) {
	
$sql = "USE TSQL; GO";
$stmt = sqlsrv_query( $conn, $sql );
$sql = "SELECT Password, Permission FROM Shop
Where Login = '{$_POST["name"]}';";
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {die( print_r( sqlsrv_errors(), true) );}
    
while( $sqlpassword = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC) ) {
if (md5($_POST['password']) == md5($sqlpassword[0]) && $sqlpassword[1] == 'Admin') {
   $_SESSION['name'] = $_POST['name'];
   $_SESSION['valid'] = true;
   $_SESSION['timeout'] = time();
   $_SESSION['permission'] = 'admin';
   
   $msg = '<p>You have entered valid username and password<br>Go to <a href = "admin_control_panel.php" tite = "control_panel">control panel</a></p>';
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