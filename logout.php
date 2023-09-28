<?php
   session_start();
   unset($_SESSION["username"]);
   unset($_SESSION["password"]);
   unset($_SESSION["counter_product1"]);
   unset($_SESSION["counter_product2"]);
   unset($_SESSION["counter_product3"]);

   echo 'You have cleaned session';
   header('Refresh: 2; URL = login.php');
?>