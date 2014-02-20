<?php

ini_set("memory_limit","32M");
mb_internal_encoding("UTF-8"); 
$con=mysql_connect("localhost", "dipak", "tmp123") or die(mysql_error());
mysql_select_db("ner") or die(mysql_error());
mysql_set_charset('utf8',$con);
include_once 'admin/admin-class.php';
$admin = new itg_admin();
$admin->_authenticate();
$username = $_SESSION['admin_login'];
$info = $db->get_row("SELECT `nicename` FROM `user` WHERE `username` = '" . $db->escape($username) . "'");
$info1 = $db->get_row("SELECT `id` FROM `user` WHERE `username` = '" . $db->escape($username) . "'");
$info2 = $db->get_row("SELECT `status` FROM `user` WHERE `username` = '" . $db->escape($username) . "'");
$user = $info->nicename;
$uid = $info1->id;
$stat = $info2->status;

if ($_FILES["file1"]["error"] > 0 )
  {
 
 if ($_FILES["file1"]["error"] == 4){
	 echo "No files selected!!<BR>";
	 echo "<a href=\"javascript:void(0)\" onclick=\"window.history.back()\">Go Back</a>";
 }
 else if ($_FILES["file1"]["error"] == 4){
	 echo "No Source file selected!!<BR>";
	 echo "<a href=\"javascript:void(0)\" onclick=\"window.history.back()\">Go Back</a>";
 }
 else{
		echo "Error: " . $_FILES["file1"]["error"] . "<br>";
 }
 
  }
else{

    $file1 = $_FILES["file1"]["tmp_name"];
    $handle1 = gzfile($file1);
    if( !@file_exists($file1) ){
        echo "File not found<br/>";
        $s=0;
    }
    $i=0;
    if($handle1){
        $totalLines = count($handle1);
        echo $totalLines;
        foreach($handle1 as $line){
            $query="INSERT INTO `".$username."sentences`(`sentence`) VALUES ('".trim($db->escape($line))."')";
            mysql_query($query) or die(mysql_error());
            $i+=1;
            if($i%50==0){
                session_start();
                $_SESSION['progress']=floatval($i)/$totalLines*100;
                session_write_close();
            }
        }
        $query="UPDATE `user` SET sent_id=1 where username='".$username."' and sent_id=-1";
        mysql_query($query) or die(mysql_error());
        echo "Successfully added ".$i." lines";
        $s=1;
    }else{
        echo "Error processing file <br/>";
        echo "<a href=\"javascript:void(0)\" onclick=\"window.history.back()\">Go Back</a>";

    }
//	$handle2 = fopen($file2,"r");
//	$data1 = fgetcsv($handle1,0,"\t");
//	$data2 = fgetcsv($handle2,0,"\t");
//	$checkt = mysql_query("SELECT count(*) FROM ".$username."target");
//	$checks = mysql_query("SELECT count(*) FROM ".$username."source");
//	$fetchcheckt = mysql_fetch_array($checkt);
//	$fetchchecks = mysql_fetch_array($checks);
//	if($fetchchecks['count(*)']=="" || $fetchchecks['count(*)']==0){
//		$i=1;
//	}
//	else{
//		$i=$fetchchecks['count(*)']+1;
//	}
//	if($fetchcheckt['count(*)']=="" || $fetchcheckt['count(*)']==0){
//		$j=1;
//	}
//	else{
//		$j=$fetchcheckt['count(*)']+1;
//	}
//
//	do {
//        if ($data1[0]) {
//             mysql_query("INSERT INTO corporamt.".$username."source(sid,sentence) VALUES
//                (
//                    ".$i.",
//                    '".addslashes(trim($data1[0]))."'
//                )
//            ") or die(mysql_error());
//            $i++;
//        }
//    } while ($data1 = fgetcsv($handle1,0,"\t"));
//	do {
//        if ($data2[0]) {
//             mysql_query("INSERT INTO corporamt.".$username."target(sid,sentence) VALUES
//                (
//                    ".$j.",
//                    '".addslashes($data2[0])."'
//                )
//            ") or die(mysql_error());
//            $j++;
//        }
//    } while ($data2 = fgetcsv($handle2,0,"\t"));
    //redirect
    //header('Location: upload_form.php?success=1');
  }
?> 
