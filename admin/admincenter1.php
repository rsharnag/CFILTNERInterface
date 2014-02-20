<?php
include_once 'admin-class.php';
$admin = new itg_admin();
$admin->_authenticate();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ILMT web site</title>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" >

$(document).ready(function(){
  $("button").click(function(){
    txt=$(this).attr('id');
    $.post("update.php",{uname:txt});
    $(this).hide();
    $(this).parent().html("Approved");
	
  });
});



	
</script>
</head>
<body>
<?php

ini_set("memory_limit","32M");
mb_internal_encoding("UTF-8"); 
$con=mysql_connect("localhost", "dipak", "tmp123") or die(mysql_error());
mysql_select_db("cluemarker") or die(mysql_error());

$result = mysql_query("select * from user where status = 0");
echo "<table>";
echo "<tr><th> USERNAME </th><th>EMAIL</th><th>DECISION</th></tr>";
while($row = mysql_fetch_array($result))
{
$flag1=$row['username'];
$flag2=$row['email'];
echo "<tr><td>".$flag1."</td><td>".$flag2."</td><td><input type='button' id=".$flag1." value='APPROVE' ></td></tr>";

}
echo "</table>";
?>
</body>
</html>
