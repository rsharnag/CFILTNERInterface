<?php
error_reporting(E_STRICT);
include_once 'admin/admin-class.php';
$admin = new itg_admin();
$admin->_authenticate();
$username = $_SESSION['admin_login'];
$info = $db->get_row("SELECT `nicename` FROM `user` WHERE `username` = '" . $db->escape($username) . "'");
$info2 = $db->get_row("SELECT `status` FROM `user` WHERE `username` = '" . $db->escape($username) . "'");
$user = $info->nicename;
$stat = $info2->status;
?>
<?php
function replace_match($matches){
    $t = preg_replace('|\s|','__',$matches[2]);
    return " ".$t.'$$'.$matches[1]." ";
}
function splitIt($s){ 					//FUNCTION TO SPLIT OUR SENTENCES, EVEN COMPLEX SENTENCES WITH BLANKS ETC.
    $arr = array('.',',');
    //$s = str_replace($arr," ",$s);
    $s = preg_replace("/( )+/", " ", $s);
    $s = preg_replace("/^( )+/", "", $s);
    $s = preg_replace("/( )+$/", "", $s);
    $tokens = explode(" ",$s);
    return $tokens;
}
function parse_sent($sent){
    $res_word = array();
    $res_tag = array();
    $pattern = '|<span.*?title="(.*?)".*?>(.*?)</span>|';
    $parsed_sent = preg_replace_callback($pattern,"replace_match", $sent);
    $words = splitIt($parsed_sent) ;

    for($i=0;$i<count($words);$i++){
        $l = explode("$$",$words[$i]);
        if (count($l)==2){
            array_push($res_word,$l[0]);
            array_push($res_tag,$l[1]);

        }else{
            array_push($res_word,$words[$i]);
            array_push($res_tag,"O");
        }
    }
    return array($res_word,$res_tag);

}
ini_set("memory_limit","32M");
mb_internal_encoding("UTF-8");
$con=mysql_connect("localhost", "dipak", "tmp123") or die(mysql_error());
mysql_select_db("ner") or die(mysql_error());
$ssid = $_POST['sid'];

$ssid= $_POST['sid'];
$tsentence= $_POST['tsentence'];

$skip = $_POST['skip'];
if($tsentence!=null and $tsentence!=''){
    list($tsent,$tag_list) = parse_sent($tsentence);
    //Update new sentence
    $nsent = mysql_real_escape_string(implode(" ",$tsent));
    $query = "UPDATE `".$username."sentences` SET `mod_sent`='".$nsent."' WHERE `sent_id`='".$ssid."'";
    $res1 = mysql_query($query) or die(mysql_error());

    $query="DELETE FROM `".$username."nertag` WHERE sent_id=".$ssid;

    mysql_query($query);
//    print_r($tag_list);
    for($i=0;$i<count($tag_list);$i++){
        if($tag_list[$i]!="O")
        {
           $query = "INSERT INTO `".$username."nertag`(`sent_id`, `position`, `tag_id`) SELECT ".$ssid.",".$i.", tag_id FROM tags where level1='".$tag_list[$i]."'";
           mysql_query($query) or die(mysql_error());
        }

    }

}
//$ssentence = mysql_real_escape_string($ssentence);
//$tsentence = mysql_real_escape_string($tsentence);
//
//
//$checkt = mysql_query("SELECT sentence FROM ".$username."target WHERE sid=".$id);
//$checks = mysql_query("SELECT sentence FROM ".$username."source WHERE sid=".$id);
//$fetchcheckt = mysql_fetch_array($checkt);
//$fetchchecks = mysql_fetch_array($checks);
//if($skip==1){
//	if($fetchchecks['sentence']!=""){
//		$res1 = mysql_query("UPDATE ".$username."source SET sentence='".$ssentence."',posflag=2 WHERE sid=".$id) or die(mysql_error());
//	}
//	else{
//		$res2 = mysql_query("INSERT INTO ".$username."source VALUES(".$id.",'".$ssentence."',2)") or die(mysql_error());
//	}
//	if($fetchcheckt['sentence']!=""){
//		$res3 = mysql_query("UPDATE ".$username."target SET sentence='".$tsentence."',posflag=2 WHERE sid=".$id) or die(mysql_error());
//	}
//	else{
//		$res4 = mysql_query("INSERT INTO ".$username."target VALUES(".$id.",'".$tsentence."',2)") or die(mysql_error());
//	}
//}
//else{
//	if($fetchchecks['sentence']!=""){
//		$res1 = mysql_query("UPDATE ".$username."source SET sentence='".$ssentence."',posflag=1 WHERE sid=".$id) or die(mysql_error());
//	}
//	else{
//		$res2 = mysql_query("INSERT INTO ".$username."source VALUES(".$id.",'".$ssentence."',1)") or die(mysql_error());
//	}
//	if($fetchcheckt['sentence']!=""){
//		$res3 = mysql_query("UPDATE ".$username."target SET sentence='".$tsentence."',posflag=1 WHERE sid=".$id) or die(mysql_error());
//	}
//	else{
//		$res4 = mysql_query("INSERT INTO ".$username."target VALUES(".$id.",'".$tsentence."',1)") or die(mysql_error());
//	}
//	$checkexists = mysql_query("SELECT * FROM validated WHERE sid=".$id) or die(mysql_error());
//	if(!mysql_num_rows($checkexists)){
//		mysql_query("INSERT INTO validated VALUES (".$id.",'".$username."')") or die(mysql_error());
//	}
//	else{
//		mysql_query("UPDATE validated SET validated_uid='".$username."' WHERE sid=".$id) or die(mysql_error());
//	}
//}
//echo $value;
mysql_close($con);
?>

