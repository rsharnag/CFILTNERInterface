<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />

		<meta name="description" content="nlp tool, natural language processing, named entity recognition, deep learning, crf, distributed representation" />

		<meta name="keywords" content="NER, Deep learning, CRF, entity correction" />

		<meta name="author" content="Rahul Sharnagat" />

		<link rel="stylesheet" type="text/css" href="../src/css/style.css" media="screen" />
			
		<link rel="shortcut icon" href="../src/css/favicon.ico" type="image/x-icon" />


		<link rel="stylesheet" href="../src/css/bootstrap.css">	
		
        <title>Login: Copora Management Tool</title>
		
    </head>
    <body>
	    <script src="../src/js/bootstrap.min.js"></script>
		<div id="wrapper" class="container-fluid" style="width:100%">

		<div onclick="location.href='#';" style="cursor:pointer;"><?php include('../includes/header_ner.php'); ?></div>

		<div  class="navbar navbar-inverse" style="width:98%;margin-left:1%;margin-right:1%">
		<ul class="nav navbar-nav" style="float:center">

		<li><a onclick = "window.open('../about.html','About Tool','location=no,scrollbars=yes,height=600,width=600')" href="javascript:void(0)">About Tool</a></li>
		<li><a onclick = "window.open('../help.html','About Tool','location=no,scrollbars=yes,height=600,width=600')" href="javascript:void(0)">Help & FAQ</a></li>		
		
		</ul>

		</div>
		
		<div id="content" style="width:100%;padding-left: 30px; margin-right:10px;">
		

		<!-- end #sidebar -->
        <form action="login-action.php" method="post">
            <fieldset>
                <legend>Enter Credentials</legend>
					<p></p>
                    <p>
                        <div class="form-group" style="width:300px;"><input class="form-control" type="text" name="username" id="username" value="" placeholder="Enter Username" /></div>
                        <div class="form-group" style="width:300px;"><input class="form-control" type="password" name="password" id="password" value="" placeholder="Enter Password" /></div>
                    </p>
                    <p>
                        <label class="checkbox" for="remember">
                            <input type="checkbox" name="remember" id="remember" value="1" /> Remember me
                        </label>
                    </p>
					<p>
						<span id="errormessage"><?php if(isset($_SESSION['invalid'])) echo $_SESSION['invalid']; $_SESSION['invalid']=""; ?></span>
					</p>
		   
                            
                   
            </fieldset>
	    <p> <?php 
			if(isset($_COOKIE['regdmsg'])) {
				echo $_COOKIE['regdmsg'];
				setcookie('regdmsg','',time() - 1*24*60*60);
			}
		
		?>
            <p>
            <p>
                <input class="btn btn-success btn-default" type="submit" value="Submit" /> <input class="btn btn-default" type="reset" value="Reset" /> 
                <p>OR</p>
                <input class="btn btn-primary" type="button" name="register" id="register" value="Create Login" onclick="javascript:window.location.href='createlogin.php'"/> 
            </p>
        </form>
</div> <!-- end #content -->


         <?php include('../includes/footer.php'); ?>


	</body>
    </body>
</html>
