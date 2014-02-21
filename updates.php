
/**
 * Created by PhpStorm.
 * User: Rahul Sharnagat
 * Date: 21/1/14
 * Time: 4:33 PM
 */
<?php
include_once 'admin/admin-class.php';
$admin = new itg_admin();
$admin->_authenticate();
$username = $_SESSION['admin_login'];
$info = $db->get_row("SELECT `nicename` FROM `user` WHERE `username` = '" . $db->escape($username) . "'");
$info2 = $db->get_row("SELECT `status` FROM `user` WHERE `username` = '" . $db->escape($username) . "'");
$user = $info->nicename;
$stat = $info2->status;

$labelId = $_POST['labelId'];
$labelName = $POST['labelName'];
if($labelId!=null && $labelName!=null){
    if($labelName!=''){
        $query = "INSERT INTO tags(`level1`,`name`) VALUES (".$labelId.",".$labelName.")";
        $res = mysql_query($query) or die("failed");
        echo "Success";
    }
}
?>