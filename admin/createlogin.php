<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />

		<meta name="description" content="Sense Discrimination Tool designed for CFILT Lab @ IITB" />

		<meta name="keywords" content="sense,sense discrimination,discrimination,sense,disambiguation" />

		<meta name="author" content="Diptesh Kanojia" />

		<link rel="stylesheet" type="text/css" href="../src/css/style.css" media="screen" />
		
		<link rel="stylesheet" href="../src/css/bootstrap.min.css">	
		
		<script src="../src/js/bootstrap.min.js"></script>

        <title>Registeration: Clue Marker Tool</title>
		
    </head>
    <body>
        <?php include_once("../analyticstracking.php"); ?>
		<script src="../src/js/bootstrap.min.js"></script>
		<div id="wrapper" class="container-fluid" style="width:100%">

		<div onclick="location.href='http://www.cfilt.iitb.ac.in/~diptesh/index.php';" style="cursor:pointer;"><?php include('../includes/header.php'); ?></div>

		<div  class="navbar navbar-inverse" style="width:98%;margin-left:1%;margin-right:1%">
		<ul class="nav navbar-nav" style="float:center">

		<li><a onclick = "window.open('../about.html','About Tool','location=no,scrollbars=yes,height=600,width=600')" href="#">About Tool</a></li>
		<li><a onclick = "window.open('../help.html','About Tool','location=no,scrollbars=yes,height=600,width=600')" href="#">Help & FAQ</a></li>		
		
		</ul>

		</div>
		
		<div id="content" style="width:100%;padding-left: 30px; margin-right:10px;">
		
		<div style="float:right;border-left:1px dotted; padding-left:20px; padding-right:50px;">
				<h3>Important Links</h3>
				<li style="list-style: none;"><a href="http://www.cfilt.iitb.ac.in/">CFILT Home</a></li>
				<li style="list-style: none;"><a href="http://www.cfilt.iitb.ac.in/wordnet/webhwn/wn.php">Hindi WordNet</a></li>
				<!--li><a href="#">Links</a></li-->
		</div>
		<!-- end #sidebar -->
		
        <form action="register-action.php" method="post">
            <fieldset>
                <legend>Enter Credentials</legend>
                <p> Your account will be verified, and then approved by the CFILT Systems Administrator, Kindly contact CFILT Lab to get approval and start using the tool.</p>                            
		   <p> Email ID should be correct, otherwise the Administrator will not be able to verify your identity, resulting in the disapproval of your account.</p>                            
                    <p>
                        <div class="form-group" style="width:300px;">
                        <input class="form-control" type="text" name="fullname" id="fullname" value="" placeholder="Enter Full Name Here" />            
                        <input class="form-control" type="text" name="uname" id="uname" value="" placeholder="Enter Desired Username Here" />
                        <input class="form-control" type="password" name="pass" id="pass" value="" placeholder="Enter Desired Password Here" />
                        <input class="form-control" type="text" name="emailid" id="emailid" value="" placeholder="Enter Email ID" />
                        </div>
                    </p>
		   
                   
            </fieldset>
	    <p> <?php 
			if(isset($_COOKIE['errmsg'])) {
				echo $_COOKIE['errmsg'];
				setcookie('errmsg','',time() - 1*24*60*60);
			}
		
		?>
            <p>
                <input class="btn btn-default" type="submit" value="Register" onclick="javascript:window.location.href='register-action.php'"/> <input class="btn btn-default" type="reset" value="Reset" /> <input class="btn btn-info btn-default" type="button" value="Back to Login Screen" onclick="javascript:window.location.href='login.php'"/> 
            </p>
        </form>
</div> <!-- end #content -->

		
		<div id="footer">
			<center><p><a href="http://www.cfilt.iitb.ac.in/"><b>C</b>enter <b>F</b>or <b>I</b>ndian <b>L</b>anguages <b>T</b>echnology</a>,<br>CSE Department, IIT Bombay<br /><br />
	Created by: Diptesh Kanojia & Raj Dabre<br />
	Under the guidance of <a href="http://www.cse.iitb.ac.in/~pb/">Dr. Pushpak Bhattacharyya</a><br /><br /></center>
</div> <!-- end #footer -->

		</div> <!-- End #wrapper -->


    </body>
</html>
