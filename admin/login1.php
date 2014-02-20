<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Login to Sense Discrimination Tool</title>
    </head>
    <body>
        <form action="login-action.php" method="post">
            <fieldset>
                <legend>Enter Credentials</legend>
                    <p>
                        <label for="username">Username: </label>
                        <input type="text" name="username" id="username" value="" />
                    </p>
                    <p>
                        <label for="password">Password: </label>
                        <input type="password" name="password" id="password" value="" />
                    </p>
                    <p>
                        <label for="remember">
                            <input type="checkbox" name="remember" id="remember" value="1" /> Remember me
                        </label>
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
                <input type="submit" value="Submit" /> <input type="reset" value="Reset" /> <input type="button" name="register" id="register" value="Create Login" onclick="javascript:window.location.href='createlogin.php'"/> 
            </p>
        </form>
    </body>
</html>
