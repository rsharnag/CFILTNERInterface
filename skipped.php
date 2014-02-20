<!--USER INFO PHP-->
<?php
	include_once 'admin/admin-class.php';
	$admin = new itg_admin();
	$admin->_authenticate();
	$username = $_SESSION['admin_login'];
	$info = $db->get_row("SELECT `nicename` FROM `user` WHERE `username` = '" . $db->escape($username) . "'");
	$info2 = $db->get_row("SELECT `status` FROM `user` WHERE `username` = '" . $db->escape($username) . "'");
	$user = $info->nicename;
	$stat = $info2->status;
?>
<!--USER INFO PHP END-->

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="nlp tool, natural language processing, corpora management tool, corpus, corpora, management, tool, parallel corpora, smt, machine translation" />
	<meta name="author" content="Diptesh Kanojia" />
	<link rel="stylesheet" type="text/css" href="src/css/style.css" media="screen" />	
	<link rel="stylesheet" href="src/css/bootstrap.css">	
    <link rel="stylesheet" href="src/css/jquery.ContextMenu.css"/>
	<link rel="shortcut icon" href="src/css/favicon.ico" type="image/x-icon" />
	
	<title>Corpora Management Tool</title>
	
	<script type="text/javascript" src="src/js/jquery.js"></script>
	<script type="text/javascript" src="src/js/bootbox.js"></script>
	<script type="text/javascript" src="src/js/bootstrap.js"></script>
	<script type="text/javascript" src="src/js/customJS.js"></script>
	<script type="text/javascript" src="src/js/jquery.ContextMenu.js"></script>
	

	
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
         <li><a onmousedown="GetSelectedText()" onclick="showtransresults()">Search in Dictionary below</a></li>
         <li><a onmousedown="GetWordnetWord()" onclick="shabdkoshSearch()">Search in Shabdkosh</a></li>
         <li><a onmousedown="GetWordnetWord()" onclick="HWordnetSearch()">Search in Hindi Wordnet</a></li>
         <li><a onmousedown="GetWordnetWord()" onclick="MWordnetSearch()">Search in Marathi Wordnet</a></li>
         <li><a onmousedown="GetWordnetWord()" onclick="GoogleTranslateSearchAUTOEN()">Translate using Google</a></li>
         <li><a onmousedown="GetWordnetWord()" onclick="GoogleSearch()">Search on Google</a></li>
	  </ul>
	
	<!--GOOGLE TRANSLITERATE API SCRIPT-->
	<script type="text/javascript" src="https://www.google.com/jsapi?key=ABQIAAAAcaLlMdnVT3N44H7x504_FRTm3QlNi32Qto_q4ApmWl2h24Y4ZBThIHiDymFNDPXorqAD1uGyzREBow"></script>
	<script type="text/javascript">
		// Load the Google Transliterate API
		google.load("elements", "1", {
            packages: "transliteration"
        });

		function onLoad() {
	  		var options = {
			sourceLanguage: 'en', // or google.elements.transliteration.LanguageCode.ENGLISH,
          		destinationLanguage: ['hi','mr','kn','ta','te'], // or [google.elements.transliteration.LanguageCode.HINDI],
          		shortcutKey: 'ctrl+g',
          		transliterationEnabled: true
        	};
        	// Create an instance on TransliterationControl with the required options.
        	var control = new google.elements.transliteration.TransliterationControl(options);

	        // Enable transliteration in the textfields with the given ids.
    	    var ids = [ "tsentence" ];
    	    control.makeTransliteratable(ids);

    	    // Show the transliteration control which can be used to toggle between
    	    // English and Hindi.
    	    control.showControl('translControl');
    	  }
	      google.setOnLoadCallback(onLoad);
	      
	      
	      /////THIS IS THE JQUERY FOR SAVE  & SKIP FUNCTIONS SINCE THE GENERAL FORM.SUBMIT() ONCLICK DOESN'T WORK 
	      /////AND IF IT DOES, IT DOESN'T LET ONE HREF AFTER ONLCLICK SUBMIT, FALSE RETURN ISSUE IN CHROME(BUG IN CHROME, SEE STACKOVERFLOW)
	      /////HENCE TO USE AJAX SUCCESS WAS THE ONLY OPTION LEFT.
	      
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
			$("#SaveNext").click(function(event) {
				event.preventDefault();
				var tsid = $("#tsid").val();
				var ssid = $("#ssid").val();
				var nextval = $("#nextval").val();
				var ssentence = $("#ssentence").val();
				var tsentence = $("#tsentence").val();				

				$.ajax({
					type: "POST",
					url: "saveIt.php",
					data: "ssid=" + ssid + "&tsid=" + tsid + "&ssentence=" + ssentence + "&tsentence=" + tsentence,
					success: function(){window.location = '?offset=' + nextval;}
				});
			});
		});
    </script>

	
<?php
	//require('db/db.php');
	ini_set("memory_limit","32M");
	mb_internal_encoding("UTF-8"); 
	/*$con=mysql_connect("localhost", "dipak", "tmp123") or die(mysql_error()); // ALL BEING DONE IN ADMINCLASS.PHP
	mysql_select_db("corporamt") or die(mysql_error());
	*/ 
?>
<?php
	function splitIt($s){ 					//FUNCTION TO SPLIT OUR SENTENCES, EVEN COMPLEX SENTENCES WITH BLANKS ETC.
		$arr = array('.',',');
		$s = str_replace($arr," ",$s);
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
<div id="overlay_form" style="display:none">
	<h2> Enter phrase or word:</h2>
	<input type="text" id="searchf" name="username" class="query"/><br /><br />
    <button class="searchforterm">Submit</button>
	<button class="delete" >Cancel</button>
	
</div>

<div id="wrapper" class="container-fluid" style="width:100%">
		<!--HEADER ABOVE NAVIGATION-->			
		<div onclick="location.href='#';" style="cursor:pointer;"><?php include('includes/header.php'); ?></div>
		<!--NAVIGATION BAR-->
		<div  class="navbar navbar-inverse">
			<center>
				<ul class="nav navbar-nav" style="width:100%;">
				<li><a href="./index.php">Tool Home</a></li>
				<?php if($stat==9||$stat==3) echo "<li><a href=\"./admin/admincenter.php\">Administration Center</a></li>"; ?>
				<li><a onclick="location.reload()" href="#">Refresh</a></li>
				<li><a href="index.php">View All Sentences</a></li>				
				<li><a onclick = "window.open('about.html','About Tool','location=no,scrollbars=yes,height=600,width=600')" href="javascript:void(0)">About Tool</a></li>
				<li><a onclick = "window.open('help.html','About Tool','location=no,scrollbars=yes,height=600,width=600')" href="javascript:void(0)">Help & FAQ</a></li>
				<li class="navbar-right"><a href="./admin/logout.php">Logout</a></li>
				</ul>
			</center>			
		</div>
		
		
		<?php
		if($stat!=9){
						$word=$_GET['word'];
						$spec=$_GET['specific'];

					if(!isset($word) || strcmp($word,"null")==0){
						
						$result0 = mysql_query("select count(*) from ".$username."source where posflag=2") or die(mysql_error());
						$result1 = mysql_query("select * from ".$username."source where posflag=2") or die(mysql_error());
						$result2 = mysql_query("select * from ".$username."target where posflag=2") or die(mysql_error());
						$row0 = mysql_fetch_array($result0);
						$sentencecount = $row0["count(*)"]-1;
						//var_dump($sentencecount);
						while($row1=mysql_fetch_assoc($result1)){
							$ssids[] = $row1["sid"];
							$ssentence[] = $row1["sentence"];
						}
						//var_dump($tsids);
						while($row2=mysql_fetch_assoc($result2)){
							$tsids[] = $row2["sid"];
							$tsentence[] = $row2["sentence"];
						}
						//var_dump($tsids);
						$currid=$_GET['offset'];
						if ($currid==""){
							$currid=0;
						}
						$currid=intval($currid);
						if($currid==-1){
							$currid=$sentencecount;
						}
						if($currid>=$sentencecount){
								$next=0;
						}else{
							$next = $currid+1;
						}
						$prev = $currid-1;
						if($ssids[$currid]==""){
							$currid=$currid-1;
						}
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
											//echo "</div>";
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
			$ifdataexists = mysql_query("SELECT * from ".$username."source where posflag=2");
			if(!isset($word)|| strcmp($word,"null")==0){						// INSIDE THIS IF CONDITION IS THE CONTENT TO BE DISPLAYED NORMALLY FOR VALIDATION
				if(mysql_num_rows($ifdataexists)!=0){
			echo "<div id=\"content\" style=\"width:98%;height:10%;margin-left:1%;margin-right:1%\">
					<div class=\"panel panel-default\">
						<div class=\"panel-body\">
							<div id=\"translControl\" style=\"float:right;text-align:right\"></div>
							<div id=\"userfield1\" style=\"width:39%;text-align:right;float:right\">Choose Transliteration Language: &nbsp;</div>
							<div id=\"userfield2\" style=\"width:25%;text-align:right;float:right\">Current Sentence: <span class=\"label label-default\">".$ssids[$currid]."</span></div>
							<div id=\"userfield\" style=\"width:20%;text-align:left;float:left\">Current User: <span class=\"label label-default\">".$user."</span></div>
							<br>
						</div>
					</div>
				</div>
				</div>
				
				
				
				<!--div id=\"skippedmsg\" style=\"width:100%;text-align:center\" ><h3>You are currently working with skipped sentences</h3></div-->
				<div class=\"alert alert-warning fade in\" style=\"width:100%;margin-top:100px;\">
					<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">
						I know! [×]
					</button>
					<strong>
						Remember, You are woking with skipped sentences.
					</strong>
				</div>
				<div id=\"rightPane\"  style=\"width:50%;float:left;margin-bottom:10px;\">
				
					<div id=\"rContent\" style=\"height:25%;margin-bottom:10px;\">";
				 
						echo "<form name='aform' method='post' action='saveIt.php' target='_blank'>";
						echo "<div id=\"skipThis\"></div>";
						echo "<input type=\"hidden\" id =\"ssid\" name=\"ssid\" value=".$ssids[$currid].">";
						echo "<input type=\"hidden\" id =\"nextval\" name=\"nextval\" value=".$currid.">";
						echo "<input type=\"hidden\" id =\"skipnextval\" name=\"skipnextval\" value=".$next.">";						
						echo "<input type=\"hidden\" id =\"prevval\" name=\"prevval\" value=".$prev.">";					
						echo "<input type=\"hidden\" id =\"sentencecount\" name=\"sentencecount\" value=".$sentencecount.">";						
						echo "<textarea class=\"area form-control\" rows=\"5\" id=\"ssentence\" class=\"area\" contenteditable=\"true\" name=\"ssentence\" style=\"width:98%;height:90%;margin-left:1%;margin-right:1%\">".$ssentence[$currid]."</textarea></br>";
						
				echo "</div>";
				echo "<div id=\"rButtonBar\" style=\"float:left;padding-left:10px;\">";
				echo "<ul class=\"pager\" style=\"margin-bottom:10px;margin-top:0px; padding-top:0px;padding-bottom:10px;\">"; 
					
							echo "<li style=\"margin-right:5px;\"><a id=\"skippedPrev\" href=\"javascript:void(0)\">&larr; Previous</a></li>";
							echo "<li style=\"margin-right:5px;\"><a id=\"SavePrev\" href=\"javascript:void(0)\" >&larr; Save & Previous</a></li>";
							echo "<li style=\"margin-right:5px;\"><a id=\"skippedFirst\" href=\"javascript:void(0)\">&larr;&larr; First Sentence</a></li>";
							echo "<li style=\"margin-right:5px;\"><a id=\"skippedNext\" href=\"javascript:void(0)\">Next &rarr;</a></li>"; 
						
				echo "</ul>";
				echo "</div>";
			echo "</div>";
			
			echo "<div id =\"leftPane\" style=\"width:50%;float:right;margin-bottom:10px;\">";
				echo "<div id=\"lContent\" style=\"height:25%;\">";

							echo "<input type=\"hidden\" id =\"tsid\" name=\"tsid\" value=".$tsids[$currid].">";
							echo "<textarea class=\"area form-control\" rows=\"5\" id=\"tsentence\" class=\"area\" contenteditable=\"true\" name=\"tsentence\" style=\"width:98%;height:90%;margin-left:1%;margin-right:1%\">".$tsentence[$currid]."</textarea></br>";
						
				echo "</div>";
				echo "<div id=\"lButtonBar\" style=\"float:right;padding-right:10px;margin-bottom:10px;\">";
					echo "<ul class=\"pager\" style=\"margin-bottom:10px;margin-top:10px; padding-top:0px;padding-bottom:10px;\">";

								echo "<li style=\"margin-right:5px;\"><a id=\"skippedPrev2\" href=\"javascript:void(0)\">&larr; Previous</a></li>";
								echo "<li style=\"margin-right:5px;\"><a id=\"lastSentence\" href=\"javascript:void(0)\">Last Sentence &rarr;&rarr;</a></li>";
								echo "<li style=\"margin-right:5px;\"><a id=\"SaveNext\" href=\"javascript:void(0)\">Save & Next &rarr;</a></li>"; 
								echo "<li style=\"margin-right:5px;\"><a id=\"skippedNext2\" href=\"javascript:void(0)\">Next &rarr;</a></li>"; 
							
						echo "</form>";
					} //CLOSE IF STATEMENT FOR UPLOAD CORPUS
					else{
						 echo "<div class=\"alert alert-warning fade in\" style=\"width:100%;padding-bottom:25px;text-align:center\">
									<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">
										<h3>Ok [×]</h3>
									</button>
									<strong>
										<h2>No skipped sentences,<BR> Please click \"View All Sentences\" above.</h2>
									</strong>
								</div>";
					}
					$splitssentence=splitIt($ssentence); // CAN BE USED TO SPLIT SENTENCE TO WORD LEVEL
					$splittsentence=splitIt($tsentence); // BOTH FOR SOURCE AND TARGET
					echo "</ul>
				</div>
				
			</div>
		</div>
		<div id=\"translateBox\" style=\"font-weight:bold\"><font size=+1>Dictionary Suggestions </font><font size=-1>(courtsey of <a href=\"http://www.cfilt.iitb.ac.in/~hdict/webinterface_user/\" target=\"_blank\">English-Hindi Dictionary</a>)<br></font>
		<p></p>
		<form name=\"form1\" id=\"form1\" onsubmit=\"showtransresults(); return false\">
			<div style=\"float:right\">
				<ul class=\"pager\" style=\"margin-bottom:10px;margin-top:10px; padding-top:0px;padding-bottom:10px;\">
					<li id=\"hideshow\" style=\"margin-right:5px;\"><a style=\"outline:none\" href=\"javascript:void(0)\">Hide / Show Results</a></li>
				</ul>
			</div>
			<div class=\"formgroup\" style=\"width:350px;float:left;\">
				<input style=\"size:50px;\" class=\"form-control searchquery\" type=\"Text\" id=\"transWord\" name=\"transWord\" placeholder=\"Enter Hindi or English Word\">
			</div>
			<button class=\"btn btn-default\" type=\"button\" name=\"submit\" id=\"submit\" onclick=\"showtransresults()\">Search</button>
			
			";
		} // CHECK FOR SEARCH RESULTS PAGE OR OFFSET WISE INDEX DISPLAY IF STATEMENT CLOSED.
	} // CHECK WHETHER THE USER WAS ADMIN IF STATEMENT CLOSED.
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
	<div id="transresults" ></div>
	<!--FOOTER-->		
		<?php include('includes/footer.php'); ?>
	<!--CONTENT ENDS-->
</body>
</html>
