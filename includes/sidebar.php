<?php
session_start();
$username = $_SESSION['admin_login'];
$info = $db->get_row("SELECT `nicename` FROM `user` WHERE `username` = '" . $db->escape($username) . "'");
$info2 = $db->get_row("SELECT `status` FROM `user` WHERE `username` = '" . $db->escape($username) . "'");
$user = $info->nicename;
$stat = $info2->status;
//echo $stat;
?>

<div id="sidebar">

<br>
<h3 style="margin-bottom: 2px;">Logged in as: </h3><br>
<?php 

echo "<h4 style=\"margin-top: 1px;\">".$user."</h4>"; 

?>
<h3>Important Links</h3>
	<?php if($stat>2) echo "<li><a href=\"./admin/admincenter.php\">Administration Center</a></li>"; ?>
	<li><a href="http://www.cfilt.iitb.ac.in/">CFILT Home</a></li>
	<li><a href="http://www.cfilt.iitb.ac.in/wordnet/webhwn/wn.php">Hindi WordNet</a></li>
	<li><a href="http://www.cfilt.iitb.ac.in/Resources.html">Resources</a></li>
<h3>Navigate to:</h3>
	<li><a onclick="goTo()" href="#">Synset ID</a></li>
	<li><a onclick="goToword()" href="#">Synset Word</a></li>

	<!--li><a href="#">Links</a></li-->
</div> <!-- end #sidebar -->
