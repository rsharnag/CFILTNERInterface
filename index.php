<!--USER INFO PHP-->
<?php
error_reporting(E_STRICT);
include_once 'admin/admin-class.php';
$admin = new itg_admin();
$admin->_authenticate();
$username = $_SESSION['admin_login'];
$info = $db->get_row("SELECT `nicename` FROM `user` WHERE `username` = '" . $db->escape($username) . "'");
$info1 = $db->get_row("SELECT `id` FROM `user` WHERE `username` = '" . $db->escape($username) . "'");
$info2 = $db->get_row("SELECT `status` FROM `user` WHERE `username` = '" . $db->escape($username) . "'");
$uid = $info1->id;
$user = $info->nicename;
$stat = $info2->status;
?>
<!--USER INFO PHP END-->

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="nlp tool, natural language processing, named entity recognition, deep learning, crf, distributed representation" />
    <meta name="author" content="Rahul Sharnagat" />
    <link rel="stylesheet" type="text/css" href="src/css/style.css" media="screen" />
    <link rel="stylesheet" href="src/css/bootstrap.css">
    <link rel="stylesheet" href="src/css/jquery.ContextMenu.css"/>
    <link rel="stylesheet" href="src/bootstrap-select/bootstrap-select.css"/>
    <link rel="shortcut icon" href="src/css/favicon.ico" type="image/x-icon" />

    <title>Named Entity Recognition and Correction Tool</title>


    <script type="text/javascript" src="src/js/jquery.js"></script>
    <script type="text/javascript" src="src/js/notify.js.js"></script>
    <script type="text/javascript" src="src/js/notify.min.js"></script>
    <script type="text/javascript" src="src/js/bootstrap.js"></script>

    <script type="text/javascript" src="src/bootstrap-select/bootstrap-select.js"></script>
    <script type="text/javascript" src="src/js/bootbox.js"></script>
    <script type="text/javascript" src="src/js/customJS.js"></script>
    <script type="text/javascript" src="src/js/jquery.ContextMenu.js"></script>
    <script type="text/javascript" src="ui.js"></script>

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-45742992-1', 'iitb.ac.in');
        ga('send', 'pageview');

    </script>

    <ul id="context-menu-1" class="context-menu">
        <li><a onmousedown="GetSelectedText()" onclick="showtransresults()">Search in Dictionary below</a></li>
        <li><a onmousedown="GetWordnetWord()" onclick="shabdkoshSearch()">Search in Shabdkosh</a></li>
        <li><a onmousedown="GetWordnetWord()" onclick="EWordnetSearch()">Search in English Wordnet</a></li>
        <li><a onmousedown="GetWordnetWord()" onclick="GoogleTranslateSearchENHI()">Translate using Google</a></li>
        <li><a onmousedown="GetWordnetWord()" onclick="WikipediaSearch()">Search on Wikipedia</a></li>
        <li><a onmousedown="GetWordnetWord()" onclick="WikitionarySearch()">Search on Wikitionary (dictionary)</a></li>
        <li><a onmousedown="GetWordnetWord()" onclick="GoogleSearch()">Search on Google</a></li>
    </ul>
    <ul id="context-menu-2" class="context-menu">
        <?php
            $availableTags = array();
            $availableTagId = array();
            $query = 'SELECT `level1`, `name`  from tags';
            $res = mysql_query($query) or die(mysql_error());
            $i=0;
            while($row = mysql_fetch_array($res)){

                echo '<li><a onmousedown="setTag(\''.$row['level1'].'\')" >'.$row['name'].'</a></li>';
                $availableTags[$i]=$row['name'];
                $availableTagId[$i]=$row['level1'];
                $i++;
            }
        ?>



        <li><a onmousedown="unSetTag()" onclick="">Clear tag</a> </li>
<!--        <li><a onmousedown="GetSelectedText()" onclick="showtransresults()">Search in Dictionary below</a></li>-->
<!--        <li><a onmousedown="GetWordnetWord()" onclick="shabdkoshSearch()">Search in Shabdkosh</a></li>-->
<!--        <li><a onmousedown="GetWordnetWord()" onclick="HWordnetSearch()">Search in Hindi Wordnet</a></li>-->
<!--        <li><a onmousedown="GetWordnetWord()" onclick="MWordnetSearch()">Search in Marathi Wordnet</a></li>-->
<!--        <li><a onmousedown="GetWordnetWord()" onclick="GoogleTranslateSearchAUTOEN()">Translate using Google</a></li>-->
<!--        <li><a onmousedown="GetWordnetWord()" onclick="GoogleSearch()">Search on Google</a></li>-->
    </ul>

    <!--GOOGLE TRANSLITERATE API SCRIPT-->
<!--    <script type="text/javascript" src="https://www.google.com/jsapi?key=ABQIAAAAcaLlMdnVT3N44H7x504_FRTm3QlNi32Qto_q4ApmWl2h24Y4ZBThIHiDymFNDPXorqAD1uGyzREBow"></script>-->
    <script type="text/javascript">
        // Load the Google Transliterate API
//        google.load("elements", "1", {
//            packages: "transliteration"
//        });

        //		function onLoad() {
        //	  		var options = {
        //			sourceLanguage: 'en', // or google.elements.transliteration.LanguageCode.ENGLISH,
        //          		destinationLanguage: ['hi','mr','kn','ta','te'], // or [google.elements.transliteration.LanguageCode.HINDI],
        //          		shortcutKey: 'ctrl+g',
        //          		transliterationEnabled: true
        //        	};
        //        	// Create an instance on TransliterationControl with the required options.
        //        	var control = new google.elements.transliteration.TransliterationControl(options);
        //
        //	        // Enable transliteration in the textfields with the given ids.
        //    	    var ids = [ "tsentence" ];
        //    	    control.makeTransliteratable(ids);
        //
        //    	    // Show the transliteration control which can be used to toggle between
        //    	    // English and Hindi.
        //    	    control.showControl('translControl');
        //    	  }
        //	      google.setOnLoadCallback(onLoad);
        //
        /////THIS IS THE JQUERY FOR SAVE  & SKIP FUNCTIONS SINCE THE GENERAL FORM.SUBMIT() ONCLICK DOESN'T WORK
        /////AND IF IT DOES, IT DOESN'T LET ONE HREF AFTER ONLCLICK SUBMIT, FALSE RETURN ISSUE IN CHROME(BUG IN CHROME, SEE STACKOVERFLOW)
        /////HENCE TO USE AJAX SUCCESS WAS THE ONLY OPTION LEFT.
        /////ALL THE NAVIGATION (NEXT,PREV) BEING DONE THROUGH JQUERY TO BE FOUND IN CUSTOMJS.JS, THE ONES USING AJAX HAD TO BE KEPT HERE.

        $(document).ready(function(){
            $("#SkipNext").click(function(event) {
                event.preventDefault();
                var tsid = $("#tsid").val();
                var ssid = $("#ssid").val();
                var skip = $("#skip").val();
                var nextval = $("#nextval").val();
                var ssentence = $("#ssentence").val();
                var tsentence = $("#tsentence").val();

                $.ajax({
                    type: "POST",
                    url: "saveIt.php",
                    data: "ssid=" + ssid + "&tsid=" + tsid + "&ssentence=" + ssentence + "&tsentence=" + tsentence + "&skip=" + skip,
                    success: function(){window.location = '?offset=' + nextval;}
                });
            });
        });


        $(document).ready(function(){
            $("#SkipPrev").click(function(event) {
                event.preventDefault();
                var tsid = $("#tsid").val();
                var ssid = $("#ssid").val();
                var skip = $("#skip").val();
                var prevval = $("#prevval").val();
                var ssentence = $("#ssentence").val();
                var tsentence = $("#tsentence").val();

                $.ajax({
                    type: "POST",
                    url: "saveIt.php",
                    data: "ssid=" + ssid + "&tsid=" + tsid + "&ssentence=" + ssentence + "&tsentence=" + tsentence + "&skip=" + skip,
                    success: function(){window.location = '?offset=' + prevval;}
                });
            });
        });

        $(document).ready(function(){
            $("#SavePrev").click(function(event) {
                event.preventDefault();
                var tsid = $("#tsid").val();
                var ssid = $("#ssid").val();
                var prevval = $("#prevval").val();
                var ssentence = $("#ssentence").val();
                var tsentence = $("#tsentence").val();

                $.ajax({
                    type: "POST",
                    url: "saveIt.php",
                    data: "ssid=" + ssid + "&tsid=" + tsid + "&ssentence=" + ssentence + "&tsentence=" + tsentence,
                    success: function(){window.location = '?offset=' + prevval;}
                });
            });
        });

        $(document).ready(function(){
            $("#Next").click(function(event) {
                event.preventDefault();

                var ssid = $("#ssid").val();
                var nextval = $("#nextval").val();
                var ssentence = $("#ssentence").val();
                var tsentence = $("#tsentence").html();

                $.ajax({
                    type: "POST",
                    url: "saveIt.php",
                    data: "sid=" + ssid + "&tsentence=" + tsentence,
                    success: function(res){window.location = '?offset=' + nextval;}
                });
            });
        });
        $(document).ready(function() {
            <?php if($_GET['labelAdded']!=null and $_GET['labelAdded']==1) echo "$.notify(\"Label added\",\"success\");"; ?>
            $('.selectpicker').selectpicker({


            });
        });

    </script>


    <?php
    ini_set("memory_limit","32M");
    mb_internal_encoding("UTF-8");
    function splitIt($s){ 					//FUNCTION TO SPLIT OUR SENTENCES, EVEN COMPLEX SENTENCES WITH BLANKS ETC.
        $arr = array('.',',');
        //$s = str_replace($arr," ",$s);
        $s = preg_replace("/( )+/", " ", $s);
        $s = preg_replace("/^( )+/", "", $s);
        $s = preg_replace("/( )+$/", "", $s);
        $tokens = explode(" ",$s);
        return $tokens;
    }
    function wordCount($string){			//FUNCTION TO COUNT WORDS IN A STRING (FOR TRANSLATION BOX),
        $words = "";						//CAN BE USED TO COUNT WORDS IN A STRING AS WELL. NOT USING THIS AS OF NOW
        $string = eregi_replace(" +", " ", $string);
        $array = explode(" ", $string);
        for($i=0;$i < count($array);$i++){
            if (eregi("[0-9A-Za-zÀ-ÖØ-öø-ÿ]", $array[$i]))
                $words[$i] = $array[$i];
        }
        return count($words);
    }
    ?>

</head>


<body>
<?php include_once('analyticstracking.php');?>
<div id="wrapper" class="container-fluid" style="width:100%">
<!--HEADER ABOVE NAVIGATION-->
<div onclick="javascript:void(0)" style="cursor:pointer;"><?php include('includes/header_ner.php'); ?></div>
<!--NAVIGATION BAR-->
<div  class="navbar navbar-inverse">
    <center>
        <ul class="nav navbar-nav" style="width:100%;">
            <li><a href="./index.php">Tool Home</a></li>
            <?php if($stat==9||$stat==3) echo "<li><a href=\"./admin/admincenter.php\">Administration Center</a></li>"; ?>
            <li class="dropdown">
                <a id="drop4" href="#" class="dropdown-toggle" data-toggle="dropdown">Go To <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a id="gotoSentence" href="javascript:void(0)">Sentence</a></li>
                    <li><a id="gotoWord" href = "javascript:void(0)">Word or phrase</a></li>
                </ul>
            </li>
            <li><a onclick="location.reload()" href="javascript:void(0)">Refresh</a></li>
            <li class="dropdown">
                <a id="drop4" href="#" class="dropdown-toggle" data-toggle="dropdown">Corpus <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a onclick="openwindow('upload_form_ner.php','location=no,scrollbars=yes,height=600,width=900')" href="javascript:void(0)">Upload Corpus</a></li>
                    <li><a onclick="openwindow('download.php','location=no,scrollbars=yes,height=600,width=900')" href="javascript:void(0)">Download Corpus</a></li>
                </ul>
            </li>
            <li><a href="skipped.php">View Skipped</a></li>
            <li><a onclick = "window.open('about.html','About Tool','location=no,scrollbars=yes,height=600,width=600')" href="javascript:void(0)">About Tool</a></li>
            <li><a onclick = "window.open('help.html','About Tool','location=no,scrollbars=yes,height=600,width=800')" href="javascript:void(0)">Help & FAQ</a></li>
            <li><a onclick = "window.open('https://github.com/rsharnag/CFILTNERInterface/issues','Report issue','location=no,scrollbars=yes,height=768,width=1024')" href="javascript:void(0)">Report Bug</a></li>
            <li class="navbar-right" ><a href="./admin/logout.php">Logout</a></li>
        </ul>
    </center>
    <!--p><a href="upload_form.php" rel="facebox">Upload Corpus</a></p-->
</div>
<script>
    function addskip(frm){
        var row = '<input type="hidden" id="skip" name="skip" value="1"/>';
        jQuery('#skipThis').append(row);
    }

</script>
<?php
if($stat!=9){
    $word=$_GET['word'];
    $spec=$_GET['specific'];
    $currid=$_GET['offset'];
    if ($currid==""){
        $currid=1;
    }
    $currid=intval($currid);
    if($currid==0){
        $currid=1;
    }
    if(!isset($word) || strcmp($word,"null")==0){
        $result0 = mysql_query("select count(*) from ".$username."sentences") or die(mysql_error());
        $result1 = mysql_query("select * from ".$username."sentences where sent_id=".$currid) or die(mysql_error());
        $row0 = mysql_fetch_array($result0);
        $row1 = mysql_fetch_array($result1);
        $sentencecount = $row0["count(*)"];
        $sentence = $row1["sentence"];
        $sid = $row1["sent_id"];
        if($currid==$sentencecount){
            $next=1;
        }else{
            $next=$currid+1;
        }
        $prev = $currid-1;
        //Generate target phrase
        $tsent = $row1["mod_sent"];
        if($tsent!=null){
            //Creating tag map

            //Parsing target sentence
            $words = splitIt($tsent);
            $query = 'SELECT  `position`, `level1` as "tag" FROM `'.$username.'nertag` a,`tags` b WHERE a.tag_id=b.tag_id and `sent_id`="'.$currid.'"' ;
            $res = mysql_query($query) or die(mysql_error());
            while($row = mysql_fetch_array($res)){
                $target = $words[$row[0]];
                $target = implode(" ",explode("__",$target));
                $htmltag = '<span title="'.$row[1].'" class="'.$row[1].'">'.$target.'</span>';
                $words[$row[0]]=$htmltag;
            }
            $tsentence = implode(" ",$words);
        }else{
            $tsentence=$sentence;
        }
//        $result0 = mysql_query("select count(*) from ".$username."source") or die(mysql_error());
//        $result1 = mysql_query("select * from ".$username."source where sid=".$currid) or die(mysql_error());
//        $result2 = mysql_query("select * from ".$username."target where sid=".$currid) or die(mysql_error());
//        $row0 = mysql_fetch_array($result0);
//        $row1 = mysql_fetch_array($result1);
//        $row2 = mysql_fetch_array($result2);
//        $sentencecount = $row0["count(*)"];
//        $ssid = $row1["sid"];
//        $tsid = $row2["sid"];
//        $ssentence = $row1["sentence"];
//        $tsentence = $row2["sentence"];
//        if($currid==$sentencecount){
//            $next=1;
//        }else{
//            $next = $currid+1;
//        }
//        $prev = $currid-1;
    } else {
        ///// THE CONTENT BELOW DEPICTS THE PAGE WITH WORD SEARCH RESULTS \\\\\\\
        echo "<div id = \"contentscroll\" style=\"float:left;width:98%; margin-right:1%; margin-left:1%; margin-bottom:30px;\">";
        if($spec==0){
            $results = mysql_query("select * from ".$username."source where sentence LIKE '%".$word."%'") or die(mysql_error());
            $resultt = mysql_query("select * from ".$username."target where sentence LIKE '%".$word."%'") or die(mysql_error());
        }
        else{
            $results = mysql_query("select * from ".$username."source where sentence LIKE '".$word.",%' OR sentence LIKE '%,".$word.",%' OR sentence LIKE '%,".$word."'") or die(mysql_error());
            $resultt = mysql_query("select * from ".$username."target where sentence LIKE '".$word.",%' OR sentence LIKE '%,".$word.",%' OR sentence LIKE '%,".$word."'") or die(mysql_error());
        }
        if(mysql_num_rows($results) || mysql_num_rows($resultt)){
            echo "<div style=\"height:400px;\">";
            echo "<table class=\"tbl\"\>";
            $i=1;
            if(mysql_num_rows($results)){
                echo "<tr><th colspan=\"3\">Source Sentences:</td></tr>";
                echo "<tr><td><span style=\"font-weight:bold;\">S. No.</span></td><td><span style=\"font-weight:bold;\">Sentence ID</span></td><td><span style=\"font-weight:bold;\">Sentence</span></td></tr>";
                while($rows = mysql_fetch_array($results)){
                    echo "<tr><td>".$i++."</td><td><a href='index.php?offset=".$rows['sid']."'>".$rows['sid']."</a></td><td>".$rows['sentence']."</td></tr>";
                }
            }
            echo "</table>";
            echo "<BR>";
            echo "<table class=\"tbl\"\>";
            if(mysql_num_rows($resultt)){
                echo "<tr><th colspan=\"3\">Target Sentences:</td></tr>";
                echo "<tr><td><span style=\"font-weight:bold;\">S. No.</span></td><td><span style=\"font-weight:bold;\">Sentence ID</span></td><td><span style=\"font-weight:bold;\">Sentence</span></td></tr>";
                while($rowt = mysql_fetch_array($resultt)){
                    echo "<tr><td>".$i++."</td><td><a href='index.php?offset=".$rowt['sid']."'>".$rowt['sid']."</a></td><td>".$rowt['sentence']."</td></tr>";
                    //echo "</div>";
                }
            }
            echo "</table>"; echo "</div>";
        }else {
            echo "There are no sentences with the phrase <font size=+1>'<strong>".$word."'</strong></font> in it";
        }
    }
    echo "</div>";
    $ifdataexists = mysql_query("SELECT * from ".$username."sentences");
    if(!isset($word)|| strcmp($word,"null")==0){						// INSIDE THIS IF CONDITION IS THE CONTENT TO BE DISPLAYED NORMALLY FOR VALIDATION
        if(mysql_num_rows($ifdataexists)!=0){
            echo "<div id=\"content\" style=\"width:100%;height:4.0cm;\">
				<div class=\"panel panel-default option-panel\">
					<div class=\"panel-body\">
						<div id=\"translControl\" style=\"float:right;text-align:right\"></div>
						<div id=\"userfield1\" style=\"width:39%;text-align:right;float:right\"></div>
						<div id=\"userfield2\" style=\"width:25%;text-align:center;float:right\">Current Sentence: <span class=\"label label-default\">".$sid."/".$sentencecount."</span></div>
						<div id=\"userfield\" style=\"width:20%;text-align:left;float:left\">Current User: <span class=\"label label-default\">".$user."</span></div>
						<br>
					</div>
					</div>
			
				<div class=\"panel panel-default option-panel\">
					<div class=\"panel-body\">
						<!--<div id=\"userfield1\" style=\"width:5%;text-align:left;float:left\"></div>-->


						<div id=\"userfield1\" style=\"width:30%;text-align:left;float:left\">Language: &nbsp;<select class=\"selectpicker\" value=\"Select Language\">
															  <option value=\"en\">English</option>
															  <option value=\"hi\">Hindi</option>
															  <option value=\"mr\">Marathi</option>
															  </select></div>
					    <div id=\"userfield1\" style=\"width:30%;text-align:right;float:right\">Method: &nbsp;<select class=\"selectpicker\" value=\"Select Method\">
															  <option value=\"CRF\">CRF</option>
															  <option value=\"dp\">Deep Learning</option>
															  </select></div>
						<!-- <div id=\"userfield1\" style=\"width:4%;text-align:right;float:right\"</div> -->

						<br>
					</div>
					</div>
				</div>
				<div id=\"rightPane\"  style=\"width:50%;float:left;margin-bottom:10px;\">
				
					<div id=\"rContent\" style=\"height:25%;margin-bottom:10px;\">";

            echo "<form name='aform' id='aform' method='post' action='' target='_blank'>";
            echo "<div id=\"skipThis\"></div>";
            echo "<input type=\"hidden\" id =\"ssid\" name=\"ssid\" value=".$sid.">";
            echo "<input type=\"hidden\" id =\"nextval\" name=\"nextval\" value=".$next.">";
            echo "<input type=\"hidden\" id =\"prevval\" name=\"prevval\" value=".$prev.">";
            echo "<input type=\"hidden\" id =\"sentencecount\" name=\"sentencecount\" value=".$sentencecount.">";
            echo "<textarea class=\"area form-control\" rows=\"5\" id=\"ssentence\" contenteditable=\"true\" name=\"ssentence\" style=\"width:98%;height:90%;margin-left:1%;margin-right:1%\">".$sentence."</textarea></br>";

            echo "</div>";
            echo "<div id=\"rButtonBar\" style=\"float:left;padding-left:10px;\">";
            echo "<ul class=\"pager\" style=\"margin-bottom:10px;margin-top:0px; padding-top:0px;padding-bottom:10px;\">";

            echo "<li style=\"margin-right:5px;\"><a id=\"Prev\" href=\"javascript:void(0)\" style=\"outline:none\">&larr; Previous</a></li>\n";
            echo "<li style=\"margin-right:5px;\"><a id=\"SavePrev\" href=\"javascript:void(0)\" style=\"outline:none\">&larr; Save & Previous</a></li>\n";
            echo "<li style=\"margin-right:5px;\"><a id=\"first\" href=\"javascript:void(0)\" style=\"outline:none\">&larr;&larr; First Sentence</a></li>\n";
            echo "<li style=\"margin-right:5px;\"><a id=\"SkipPrev\" href=\"javascript:void(0)\" onmousedown='addskip(this.form)' style=\"outline:none\">&larr; Skip & Previous</a></li>\n";
            echo "<li style=\"margin-right:5px;\"><a id=\"Next\" href=\"javascript:void(0)\" style=\"outline:none\">Next &rarr;</a></li>\n";
            echo "<li style=\"...\"><a id=\"TagSent\" href=\"javascript:void(0)\">Tag Sentence</a></li>\n";
            echo "<li style=\"...\"><a id=\"updateSent\" href=\"javascript:void(0)\">Update</a></li>\n";
            echo "</ul>\n";
            echo "</div>\n";
            echo "</div>\n";

            echo "<div id =\"leftPane\" style=\"width:50%;float:right;margin-bottom:10px;\">\n";
            echo "<div id=\"lContent\" style=\"height:25%;\">\n";

            echo "<input type=\"hidden\" id =\"tsid\" name=\"tsid\" value=".$tsid.">\n";
            echo "<div class=\"area form-control\" id=\"tsentence\" contenteditable=\"true\" name=\"tsentence\" style=\"width:98%;height:90%;margin-left:1%;margin-right:1%\">".$tsentence."</div></br>\n";
//							echo "<textarea class=\"area form-control\" rows=\"6\"id=\"tsentence\" contenteditable=\"true\" name=\"tsentence\" style=\"width:98%;height:90%;margin-left:1%;margin-right:1%\">".$tsentence."</textarea></br>";

            //Slow Google Translate line	echo "<a href=\"http://google-translate-api.herokuapp.com/translate?from=en&to=hi&text%5B%5D=".$ssentence."&callback=test\" target=\"_blank\">Translate</a>";
            echo "</div>";
            echo "<div id=\"lButtonBar\" style=\"float:right;padding-right:10px;margin-bottom:10px;\">";
            echo "<ul class=\"pager\" style=\"margin-bottom:10px;margin-top:10px; padding-top:0px;padding-bottom:10px;\">";
            /*
                                            echo "<li style=\"margin-right:5px;\"><a id=\"Prev2\" href=\"javascript:void(0)\" style=\"outline:none\">&larr; Previous</a></li>";
                                            echo "<li style=\"margin-right:5px;\"><a id=\"SkipNext\" href=\"javascript:void(0)\" onmousedown='addskip(this.form)' style=\"outline:none\">Skip & Next &rarr;</a></li>";
                                            echo "<li style=\"margin-right:5px;\"><a id=\"lastSentence\" href=\"javascript:void(0)\" style=\"outline:none\">Last Sentence &rarr;&rarr;</a></li>";
                                            echo "<li style=\"margin-right:5px;\"><a id=\"SaveNext\" href=\"javascript:void(0)\" style=\"outline:none\">Save & Next &rarr;</a></li>";
                                            echo "<li style=\"margin-right:5px;\"><a id=\"Next2\" href=\"javascript:void(0)\" style=\"outline:none\">Next &rarr;</a></li>"; */


            echo "</form>";
        } //CLOSE IF STATEMENT FOR UPLOAD CORPUS
        else{
            echo "<div class=\"alert alert-warning fade in\" style=\"width:100%;padding-bottom:25px;text-align:center\">
									<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">
										<h3>Ok [×]</h3>
									</button>
									<strong>
										<h2>Please upload corpus to start validation.</h2>
									</strong>
								</div>";
            // echo "<h2><div style=\"width:70%;margin-left:auto;margin-right:auto;text-align:center\">Please upload corpus to start validation.</div></h2>";
        }
        $splitssentence=splitIt($ssentence); // CAN BE USED TO SPLIT SENTENCE TO WORD LEVEL
        $splittsentence=splitIt($tsentence); // BOTH FOR SOURCE AND TARGET
        echo "</ul>
				</div>
				
			</div>
		</div>
	
	    <div id=\"translateBox\" style=\"font-weight:bold\"><font size=+1>Tag legend </font> <ul id=\"addLabel\" class=\"pager\" style=\"width:10%;float:right;\" ><li style=\"float:right\" ><a href=\"javascript:void(0)\" style=\"outline:none\">Add new label</a> </li></ul>

		<p></p>
		<div  style=\"float:left;width:80%;\">";

        for($i=0;$i<count($availableTagId);$i++){
            echo "<div class=\"legend-label\"><span class=\"".$availableTagId[$i]." legend-span\">".$availableTags[$i]."</span></div>";
        }
        echo "</div>";
    }


			

    } // CHECK FOR SEARCH RESULTS PAGE OR OFFSET WISE INDEX DISPLAY IF STATEMENT CLOSED.
 // CHECK WHETHER THE USER WAS ADMIN IF STATEMENT CLOSED.
else{
    echo "</div><div id=\"content\" style=\"width:98%;height:25%;margin-left:1%;margin-right:1%;text-align:center\"><h1>Welcome Administrator</h1><br>
				You can see this window since you have logged on as administrator, on the tool home, 
				Kindly assign the roles and review user list in the administration center.<br> 
				Thank you for using Copora Management Tool! :)<br>
				</div>";
    echo "<div><br><br></div>";

}
?>
</form>
</div>
<div id="transresults"></div>
<!--FOOTER-->
<?php include('includes/footer.php'); ?>
<!--CONTENT ENDS-->
</body>
</html>
