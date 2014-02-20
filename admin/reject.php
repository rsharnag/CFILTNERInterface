<?php


mb_internal_encoding("UTF-8"); 
$con=mysql_connect("localhost", "dipak", "tmp123") or die(mysql_error());
mysql_select_db("corporamt") or die(mysql_error());

$result = mysql_query("DELETE FROM user WHERE username = '".$_POST['uname']."'");
if($result)
    echo 'true';

else
 	echo 'flase';
mysql_close($con);

?>