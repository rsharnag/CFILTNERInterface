<!DOCTYPE html>
<html>
<head>
    <title>Test Page</title>
    <script src="ui.js" lang="text/javascript"></script>
</head>
<body>
This is <span style="background-color:black;color:white">the</span> text.
<div style="background-color:green;width:30px;height:30px;margin:30px" onmouseover="alert(getSelectedHTMLText())"></div>
</body>
</html>
<?php
include_once 'admin/admin-class.php';
$admin = new itg_admin();
$admin->_authenticate();
$username = $_SESSION['admin_login'];
$info = $db->get_row("SELECT `nicename` FROM `user` WHERE `username` = '" . $db->escape($username) . "'");
$info2 = $db->get_row("SELECT `status` FROM `user` WHERE `username` = '" . $db->escape($username) . "'");
$user = $info->nicename;
$stat = $info2->status;
    $pattern = '|<span.*?title="(.*?)".*?>(.*?)</span>|';
    $text = 'Through the <span title="person" class="person">presence</span> of such industries, a <span title="location" class="location">wider range</span> of food products could be sold and distributed to the distant locations';
    function replace_match($matches){
        $t = preg_replace('|\s|','__',$matches[0]);
        return $t.'$$'.$matches[1];
    }
    $username = "rdsharnagat";
    $currid=10;
    echo preg_replace_callback($pattern,"replace_match",$text);
    $result1 = mysql_query("select * from ".$username."sentences where sent_id=".$currid) or die(mysql_error());

    $row1 = mysql_fetch_array($result1);

    print_r($row1["mod_sent"]!=null);
?>