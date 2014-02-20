<?php
	include_once '/var/www/smt/admin/admin-class.php';
	$admin = new itg_admin();
	$admin->_authenticate();
	$username = $_SESSION['admin_login'];
	$info = $db->get_row("SELECT `nicename` FROM `user` WHERE `username` = '" . $db->escape($username) . "'");
	$info2 = $db->get_row("SELECT `status` FROM `user` WHERE `username` = '" . $db->escape($username) . "'");
	$user = $info->nicename;
	$stat = $info2->status;
//$datevar = date_create();
//echo date_timestamp_get($date);
echo "<html>";
//echo $username;
//echo $date;
  function downloadsource(){
	$userid=$GLOBALS['username'];
	$datevar = date_create();
	$date=date_timestamp_get($datevar);
	$contentsource=mysql_query("SELECT sentence from sourcecorp INTO OUTFILE '/tmp/".$userid.$date."source.txt'") or die(mysql_error());
	$file1="/tmp/".$userid.$date."source.txt";
	if (file_exists($file1)) {
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($file1));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file1));
		ob_clean();
		flush();
		readfile($file1);
		exit;
	}
}
function downloadtarget(){
	$userid=$GLOBALS['username'];
	$datevar = date_create();
	$date=date_timestamp_get($datevar);
	$contenttarget=mysql_query("SELECT sentence from targetcorp INTO OUTFILE '/tmp/".$userid.$date."target.txt'") or die(mysql_error());
	$file2="/tmp/".$userid.$date."target.txt";
	if (file_exists($file2)) {
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($file2));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file2));
		ob_clean();
		flush();
		readfile($file2);
		exit;
	}
}

  if ($_GET['download']=='s') {
    downloadsource();
  }
  if ($_GET['download']=='t') {
    downloadtarget();
  }
?>
<a href='download2.php?download=s'>Download Source</a><BR>
<a href='download2.php?download=t'>Download Target</a>

</html>

