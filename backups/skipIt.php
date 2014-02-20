<?php
include_once './admin/admin-class.php';
$admin = new itg_admin();
$admin->_authenticate();
$username = $_SESSION['admin_login'];
$info = $db->get_row("SELECT `nicename` FROM `user` WHERE `username` = '" . $db->escape($username) . "'");
$info2 = $db->get_row("SELECT `status` FROM `user` WHERE `username` = '" . $db->escape($username) . "'");
$user = $info->nicename;
$stat = $info2->status;
?>
<?php
ini_set("memory_limit","32M");
mb_internal_encoding("UTF-8"); 
$con=mysql_connect("localhost", "dipak", "tmp123") or die(mysql_error());
mysql_select_db("corporamt") or die(mysql_error());
$ssid = $_POST['ssid'];
$tsid = $_POST['tsid'];
$ssentence= $_POST['ssentence'];
$tsentence= $_POST['tsentence'];
//print $sid."</br>";
//$ssentence=substr($ssentence,0,-1);
//$tsentence=substr($tsentence,0,-1);
$ssentence = mysql_real_escape_string($ssentence);
$tsentence = mysql_real_escape_string($tsentence);
//print $ssentence."</br>";
//print $tsentence."</br>";
/*echo intval($sid);
$id=intval($sid);
if($id==0){
$id=1;
}*/
if($ssid==null){
	$id=$tsid;
}
else{
	$id=$ssid;
}
session_start();
$checkt = mysql_query("SELECT sentence FROM ".$username."target WHERE sid=".$id);
$checks = mysql_query("SELECT sentence FROM ".$username."source WHERE sid=".$id);
$fetchcheckt = mysql_fetch_array($checkt);
$fetchchecks = mysql_fetch_array($checks);
if($fetchchecks['sentence']!=""){
	$res1 = mysql_query("UPDATE ".$username."source SET sentence='".$ssentence."',posflag=2 WHERE sid=".$id) or die(mysql_error());
}
else{
	$res2 = mysql_query("INSERT INTO ".$username."source VALUES(".$id.",'".$ssentence."',2)") or die(mysql_error());
}
if($fetchcheckt['sentence']!=""){
	$res3 = mysql_query("UPDATE ".$username."target SET sentence='".$tsentence."',posflag=2 WHERE sid=".$id) or die(mysql_error());
}
else{
	$res4 = mysql_query("INSERT INTO ".$username."target VALUES(".$id.",'".$tsentence."',2)") or die(mysql_error());
}
$checkexists = mysql_query("SELECT * FROM validated WHERE sid=".$id) or die(mysql_error());
if(!mysql_num_rows($checkexists)){
	mysql_query("INSERT INTO validated VALUES (".$id.",'".$username."')") or die(mysql_error());
}
else{
	mysql_query("UPDATE validated SET validated_uid='".$username."' WHERE sid=".$id) or die(mysql_error());
}
//$_SESSION['res1'] = $res1;
mysql_close($con);
?>

<script type='text/javascript'>
window.close();
</script>
