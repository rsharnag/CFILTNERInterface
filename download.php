<link rel="stylesheet" href="src/css/bootstrap.css">	
    <link rel="stylesheet" href="src/css/jquery.ContextMenu.css"/>

	<title>Corpora Management Tool</title>
	
	<link rel="shortcut icon" href="src/css/favicon.ico" type="image/x-icon" />
	<script type="text/javascript" src="src/js/jquery.js"></script>
	<script type="text/javascript" src="src/js/bootbox.js"></script>
	<script type="text/javascript" src="src/js/bootstrap.js"></script>
	<script type="text/javascript" src="src/js/customJS.js"></script>
<?php
	include_once 'admin/admin-class.php';
	$admin = new itg_admin();
	$admin->_authenticate();
	$username = $_SESSION['admin_login'];
	$info = $db->get_row("SELECT `nicename` FROM `user` WHERE `username` = '" . $db->escape($username) . "'");
	$info2 = $db->get_row("SELECT `status` FROM `user` WHERE `username` = '" . $db->escape($username) . "'");
	$user = $info->nicename;
	$stat = $info2->status;

function downloadsource(){  // FUNCTION TO DOWNLOAD SOURCE FILE
		$userid=$GLOBALS['username'];
		$contentsource=mysql_query("SELECT sentence from ".$userid."source") or die(mysql_error());
		$contentsize=mysql_query("SELECT count(sentence) from ".$userid."source") or die(mysql_error());
		$sizevar=mysql_fetch_array($contentsize);
		$size=$sizevar["count(sentence)"];
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.$userid.'source.txt');
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		while($source=mysql_fetch_array($contentsource)){
			echo $source['sentence']."\n";
		}
		exit;
}

function downloadtarget(){ // FUNCTION TO DOWNLOAD TARGET FILE
		$userid=$GLOBALS['username'];
		$contenttarget=mysql_query("SELECT sentence from ".$userid."target") or die(mysql_error());
		$contentsize=mysql_query("SELECT count(sentence) from ".$userid."target") or die(mysql_error());
		$sizevar=mysql_fetch_array($contentsize);
		$size=$sizevar["count(sentence)"];
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.$userid.'target.txt');
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		while($target=mysql_fetch_array($contenttarget)){
			echo $target['sentence']."\n";
		}
		exit;
}
function truncateData(){ // FUNCTION TO TRUNCATE DATA
		$userid=$GLOBALS['username'];
        mysql_query("SET FOREIGN_KEY_CHECKS=0;");
		$truncateSource = mysql_query("TRUNCATE TABLE ".$userid."nertag") or die(mysql_error());
		$truncateTarget = mysql_query("TRUNCATE TABLE ".$userid."sentences") or die(mysql_error());
    mysql_query("SET FOREIGN_KEY_CHECKS=1;");
}
  if ($_GET['download']=='s') {
    downloadsource();
  }
  if ($_GET['download']=='t') {
    downloadtarget();
  }
  if ($_GET['truncate']=='y') {
    truncateData();
  }
?>
<script type="text/javascript">

function getConfirmation(){
   var retVal = bootbox.confirm("Do you really want to Truncate all the data ? (Please make sure you have downloaded the work done, verify the files)", function(retVal){
   if( retVal == true ){
	   window.location.href = 'download.php?truncate=y';
	  return true;
   }else{
	  
   }
});
}
    window.onunload = refreshParent;
function refreshParent() {
    window.opener.location.reload();
}
function close(){
	window.close();
}
</script>
<html>
<input class="btn btn-lg btn-success" type="button" value="Download Source" onclick="javascript:window.location.href='download.php?download=s'"/>
<!--a href='download.php?download=s'>Download Source</a><BR-->
<input class="btn btn-lg btn-success pull-right" type="button" value="Download Target" onclick="javascript:window.location.href='download.php?download=t'"/>
<!--a href='download.php?download=t'>Download Target</a><BR--><BR><BR>

<div class="alert alert-warning fade in pull-left" style="width:100%;padding-bottom:25px;text-align:center">
	<strong>
		<h3>Warning!! Click the button below to empty your uploaded work, Click this only when you are done validating all the sentences, and have successfully downloaded you data</h3>
	</strong>
	<button class="close" aria-hidden="true" data-dismiss="alert" type="button">
		Ok, Sure. [×]
	</button>
</div>
<h3></h3>
<input type=" button" class="btn btn-lg btn-danger"value="Truncate Data" onclick="getConfirmation();" />

</html>

