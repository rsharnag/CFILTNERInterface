<?php
include_once 'admin-class.php';
$admin = new itg_admin();
$admin->_authenticate();
$username = $_SESSION['admin_login'];
$info = $db->get_row("SELECT `nicename` FROM `user` WHERE `username` = '" . $db->escape($username) . "'");
$info2 = $db->get_row("SELECT `status` FROM `user` WHERE `username` = '" . $db->escape($username) . "'");
$user = $info->nicename;
$stat = $info2->status;
if($stat>2){
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="description" content="Corpora Management Tool designed for CFILT Lab @ IITB" />

<meta name="keywords" content="corpora, corpora management, corpora mangement tool, tool to manage corpora, parallel corpora translation tool, corpora translation" />

<meta name="author" content="Diptesh Kanojia" />

<link rel="stylesheet" type="text/css" href="../src/css/style.css" media="screen" />

<link rel="shortcut icon" href="../src/css/favicon.ico" type="image/x-icon" />


<link rel="stylesheet" href="../src/css/bootstrap.css">	

<title>Administration Center</title>

<script type="text/javascript" src="../src/js/jquery.js"></script>
<!--script type="text/javascript" src="../src/js/customJS.js"></script-->
<script type="text/javascript" >


$(document).ready(function(){
  $(".aprove-button").click(function(){
    txt=$('.aprove-button').attr('id');
	var elem = $('.aprove-button');
    $.ajax({
		type:"POST",
		url : "approve.php",
		data :{uname:txt},
		success : function(data){
			elem.hide();
			elem.parent().html("Approved");
			setTimeout(function(){window.location.reload();},700);
		}
	});
    
  });
});


$(document).ready(function(){
  $(".sup-button").click(function(){
    txt=$(this).attr('id');
	var elem = $(this);
    $.ajax({
		type:"POST",
		url : "super.php",
		data :{uname:txt},
		success : function(data){
			elem.hide();
			elem.parent().html("Super User Now");
			setTimeout(function(){window.location.reload();},700);
		}
	});
    
  });
});



$(document).ready(function(){
  $(".reject-button").click(function(){
    txt=$(this).attr('id');
	var elem = $(this);
    $.ajax({
		type:"POST",
		url : "reject.php",
		data :{uname:txt},
		success : function(data){
			elem.hide();
			elem.parent().html("Rejected");
			setTimeout(function(){window.location.reload();},700);
		}
	});
    
  });
});

$(document).ready(function(){
  $(".ban-button").click(function(){
    txt=$(this).attr('id');
	var elem = $(this);
    $.ajax({
		type:"POST",
		url : "ban.php",
		data :{uname:txt},
		success : function(data){
			elem.hide();
			elem.parent().html("Banned");
			setTimeout(function(){window.location.reload();},700);
		}
	});
    
  });
});

$(document).ready(function(){
  $(".dem-button").click(function(){
    txt=$(this).attr('id');
	var elem = $(this);
    $.ajax({
		type:"POST",
		url : "demote.php",
		data :{uname:txt},
		success : function(data){
			elem.hide();
			elem.parent().html("Demoted");
			setTimeout(function(){window.location.reload();},700);
		}
	});
    
  });
});


$(document).ready(function(){
  $(".delete-button").click(function(){
    txt=$(this).attr('id');
	var elem = $(this);
    $.ajax({
		type:"POST",
		url : "reject.php",
		data :{uname:txt},
		success : function(data){
			elem.hide();
			elem.parent().html("Removed");
			setTimeout(function(){window.location.reload();},700);
		}
	});
    
  });
});


	
</script>
<style>
table
{
	margin-top:2px;
}
td
{
	padding: 5px 5px 5px 5px;
	text-align:center;
	border:1px solid black;
}
th
{
	border:2px solid black;
	text-align:center;
	background-color:grey;
	padding: 5px 5px 5px 5px;
}
</style>
</head>
<body>
<script src="bootstrap.min.js"></script>

<div id="wrapper" class="container-fluid" style="width:100%">

	<div onclick="location.href='http://www.cfilt.iitb.ac.in/~diptesh/index.php';" style="cursor:pointer;"><?php include('../includes/header.php'); ?></div>
		<div  class="navbar navbar-inverse" style="width:98%;margin-left:1%;margin-right:1%">
			<ul class="nav navbar-nav" style="float:center">		
				<li><a href = "../index.php">Tool Home</a></li>
				<li><a onclick="location.reload()" href="#">Refresh</a></li>
				<li><a onclick = "window.open('../about.html','About Tool','location=no,scrollbars=yes,height=600,width=600')" href="#">About Tool</a></li>
				<li><a onclick = "window.open('../help.html','About Tool','location=no,scrollbars=yes,height=600,width=600')" href="#">Help & FAQ</a></li>
				<li><a href = "../admin/logout.php">Logout</a></li>
			</ul>
		
		</div>
<div id="content" style="margin-left:3%;margin-right:5%;width:90%;">
<ul class="pager" style="margin-bottom:10px;margin-top:10px; padding-top:0px;padding-bottom:0px;height:50px;">
	<li><a href = "../index.php" >Click here to Go to Tool Home</a></li>
</ul>
<?php

ini_set("memory_limit","32M");
mb_internal_encoding("UTF-8"); 

$result = mysql_query("select * from user where status = 0");
$alluser = mysql_query("select * from user where status = 1");
$superuser = mysql_query("select * from user where status = 3");



echo "<table>";

//Pending Decisions Table


if(mysql_num_rows($result)) // if there are any pending user ids, or banned ones.
{
	echo "<tr><div align=\"left\"><h3 style=\"margin-top:2px; padding: 1px 1px 1px 1px\">Pending Decisions: </h3></div></tr>";
	echo "<tr><th><b>User Name</b></th><th><b>Full Name</b></th><th><b>Email ID</b></th><th><b>Action</b></th></tr>";
}

while($row = mysql_fetch_array($result))
{
$flag1=$row['username'];
$flag2=$row['nicename'];
$flag3=$row['email'];
echo "<tr><td>".$flag1."</td><td>".$flag2."</td><td>".$flag3."</td>";
echo "<td><input type='button' class='aprove-button btn btn-success' id=".$flag1." value=' Approve '>&nbsp&nbsp&nbsp&nbsp<input type='button' class='reject-button btn btn-danger' id=".$flag1." value=' Reject '></td></tr>";
}


echo "<tr></tr></table>";
echo "<table>";

//Super User Table

if(mysql_num_rows($superuser))
{
	echo "<tr><div align=\"left\"><h3>Super Users: </h3></div></tr>";
	echo "<tr><th><b>User Name</b></th><th><b>Full Name</b></th><th><b>Email ID</b></th>";if($stat==9) echo "<th><b>Action</b></th></tr>";
}
echo "<tr></tr>";
while($row3 = mysql_fetch_array($superuser))
{
$fl1=$row3['username'];
$fl2=$row3['nicename'];
$fl3=$row3['email'];

echo "<tr><td>".$fl1."</td><td>".$fl2."</td><td>".$fl3."</td>";

if($stat==9)
{

echo "<td><input type='button' class='ban-button btn btn-warning' id=".$fl1." value=' Ban User '>&nbsp&nbsp&nbsp&nbsp<input type='button' class='delete-button btn btn-danger' id=".$fl1." value=' Remove User '>&nbsp&nbsp&nbsp&nbsp<input type='button' class='dem-button btn btn-default' id=".$fl1." value=' Demote to Normal User'></td></tr>";

}

}

echo "<tr></tr></table>";
echo "<table>";
//Registered users table

if(mysql_num_rows($alluser))
{
	echo "<tr><div align=\"left\"><h3>Registered Users: </h3></div></th></tr>";
	echo "<tr><th><b>User Name</b></th><th><b>Full Name</b></th><th><b>Email ID</b></th><th><b>Action</b></th></tr>";
}
echo "<tr></tr>";
while($row2 = mysql_fetch_array($alluser))
{
$fla1=$row2['username'];
$fla2=$row2['nicename'];
$fla3=$row2['email'];
echo "<tr><td>".$fla1."</td><td>".$fla2."</td><td>".$fla3."</td><td><input type='button' class='ban-button btn btn-warning' id=".$fla1." value=' Ban User '>&nbsp&nbsp&nbsp&nbsp";

if($stat==9)
{
echo "<input type='button' class='delete-button btn btn-danger' id=".$fla1." value=' Delete User '>&nbsp&nbsp&nbsp&nbsp<input type='button' class='sup-button btn btn-info' id=".$fla1." value=' Super User '></td></tr>";
}

}

echo "</table>";
?>
<ul class="pager" style="margin-bottom:10px;margin-top:10px; padding-top:0px;padding-bottom:0px;height:50px;">
	<li><a href = "../index.php" >Click here to Go to Tool Home</a></li>
</ul>


		
		</div> 
			<?php include('../includes/footer.php'); ?>
			<!-- end #footer -->

		</div> <!-- End #wrapper -->

</body>
</html>
<?php
} else {
	header('location: ../index.php');
}
?>
