<?php
/** Include the database file */
include_once 'db.php';
/**
 * The main class of login
 * All the necesary system functions are prefixed with _
 * examples, _login_action - to be used in the login-action.php file
 * _authenticate - to be used in every file where admin restriction is to be inherited etc...
 * 
 */
class itg_admin {

    /**
     * Holds the script directory absolute path
     * @staticvar
     */
    static $abs_path;

    /**
     * Store the sanitized and slash escaped value of post variables
     * @var array
     */
    var $post = array();

    /**
     * Stores the sanitized and decoded value of get variables
     * @var array
     */
    var $get = array();

    /**
     * The constructor function of admin class
     * We do just the session start
     * It is necessary to start the session before actually storing any value
     * to the super global $_SESSION variable
     */
    public function __construct() {
        session_start();

        //store the absolute script directory
        //note that this is not the admin directory
        self::$abs_path = dirname(dirname(__FILE__));

        //initialize the post variable
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->post = $_POST;
            if(get_magic_quotes_gpc ()) {
                //get rid of magic quotes and slashes if present
                array_walk_recursive($this->post, array($this, 'stripslash_gpc'));
            }
        }

        //initialize the get variable
        $this->get = $_GET;
        //decode the url
        array_walk_recursive($this->get, array($this, 'urldecode'));
    }

    /**
     * Sample function to return the nicename of currently logged in admin
     * @global ezSQL_mysql $db
     * @return string The nice name of the user
     */
    public function get_nicename() {
        $username = $_SESSION['admin_login'];
        global $db;
        $info = $db->get_row("SELECT `nicename` FROM `user` WHERE `username` = '" . $db->escape($username) . "'");
        if(is_object($info))
            return $info->nicename;
        else
            return '';
    }

    /**
     * Sample function to return the email of currently logged in admin user
     * @global ezSQL_mysql $db
     * @return string The email of the user
     */
    public function get_email() {
        $username = $_SESSION['admin_login'];
        global $db;
        $info = $db->get_row("SELECT `email` FROM `user` WHERE `username` = '" . $db->escape($username) . "'");
        if(is_object($info))
            return $info->email;
        else
            return '';
    }

    /**
     * Checks whether the user is authenticated
     * to access the admin page or not.
     *
     * Redirects to the login.php page, if not authenticates
     * otherwise continues to the page
     *
     * @access public
     * @return void
     */
     public function _authenticate() {
        //first check whether session is set or not
        if(!isset($_SESSION['admin_login'])) {
            //check the cookie
            if(isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
                //cookie found, is it really someone from the
                if($this->_check_db($_COOKIE['username'], $_COOKIE['password'])) {
                    $_SESSION['admin_login'] = $_COOKIE['username'];
		 	if($_SESSION['admin_login'] == 'admin' ){
					header("location: admincenter.php");
				}                   
				 else {   
					header("location: index.php");
				}
              	      die();
               	 }
             		   else {
            	        header("location: ./admin/login.php");
                	    die();
              	  }
         	   }
          	  else {
                header("location: ./admin/login.php");
                die();
            }
        }
    }


    /**
     * Check for login in the action file
     */
    public function _login_action() {

        //insufficient data provided
        if(!isset($this->post['username']) || $this->post['username'] == '' || !isset($this->post['password']) || $this->post['password'] == '') {
			$_SESSION['invalid']="Insufficient Login Details";
            header ("location: login.php");
        }

        //get the username and password
        $username = $this->post['username'];
        $password = md5(sha1($this->post['password']));

        //check the database for username
        if($this->_check_db($username, $password)) {
            //ready to login
            $_SESSION['admin_login'] = $username;

            //check to see if remember, ie if cookie
            if(isset($this->post['remember'])) {
					//set the cookies for 1 day, ie, 1*24*60*60 secs
					//change it to something like 30*24*60*60 to remember user for 30 days
					setcookie('username', $username, time() + 1*24*60*60);
					setcookie('password', $password, time() + 1*24*60*60);
				} else {
					//destroy any previously set cookie
					setcookie('username', '', time() - 1*24*60*60);
					setcookie('password', '', time() - 1*24*60*60);
				}
            
			if($_SESSION['admin_login']=='admin')
			{
				$_SESSION['is_admin'] = 'Administration Center';
				header("location: admincenter.php");
			}
			else
			{
				$currentoffset = $this->_check_table($username);

			}
     
        }
        else {
			$_SESSION['invalid']="Invalid Username / Password";
            header ("location: ../admin/login.php");
        }
        die();
    }

    private function _check_table($username)
    {

        global $db;
        $tb = "show tables like '" . $username . "sentences'";
        $dbres = mysql_query($tb) or die(mysql_error());
//        $xq = "select sent_id from user where username='".$username."'";
//        $q1 = mysql_query($xq);
//        $arr = mysql_fetch_array($ql);

        if (mysql_num_rows($dbres) == 0) {
            $db->query("CREATE TABLE " . $username . "sentences LIKE sentences");
            $db->query("CREATE TABLE IF NOT EXISTS `" . $username . "nertag`
                        (`sent_id` int(11) NOT NULL DEFAULT '-1' COMMENT 'foreign key',
                         `position` int(11) NOT NULL DEFAULT '-1',
                         `tag_id` int(11) NOT NULL DEFAULT '-1',
                          KEY `sent_id` (`sent_id`),
                          KEY `tag_id` (`tag_id`),
                          FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`)
                          ON DELETE CASCADE ON UPDATE CASCADE,
                          FOREIGN KEY ( `sent_id` ) REFERENCES `".$username."sentences` (`sent_id`)
                          ON DELETE CASCADE ON UPDATE CASCADE
                         )ENGINE=InnoDB DEFAULT CHARSET=latin1;");
            header("location: ../index.php");
        } else {
            $result = mysql_query("Select sent_id from user where username='".$username."'");
//            $result = mysql_query("SELECT sid FROM " . $username . "source WHERE posflag = 0");
            $arraysen = mysql_fetch_array($result);

            header("location: ../index.php?offset=" . $arraysen[0]);

        }

    }
	
    /**
     * Check for login in the action file
     */
    public function _register_action() {

        //insufficient data provided
        if(!isset($this->post['uname']) || $this->post['uname'] == '' || !isset($this->post['pass']) || $this->post['pass'] == '') {
	    setcookie('errmsg','',time() - 1*24*60*60);
	    setcookie('errmsg','<b><font size=+1>Username and Password are mandatory</font></b>',time() + 1*24*60*60);
            header ("location: createlogin.php");
        }
        else if(!isset($this->post['fullname']) || $this->post['fullname'] == '' ){
			setcookie('errmsg','',time() - 1*24*60*60);
			setcookie('errmsg','<b><font size=+1>Please Enter your Full name </font></b>',time() + 1*24*60*60);
            header ("location: createlogin.php");
		}
		else if(!isset($this->post['emailid']) || $this->post['emailid'] == '' ){
			setcookie('errmsg','',time() - 1*24*60*60);
			setcookie('errmsg','<b><font size=+1>Please Enter your Email Address</font></b>',time() + 1*24*60*60);
            header ("location: createlogin.php");
		}
		else{
        //get the username and password
        $username = $this->post['uname'];
        $password = md5(sha1($this->post['pass']));
		$pass1 = $this->post['pass'];
		$email = $this->post['emailid'];
		$nicename = $this->post['fullname'];
        //check the database for username
        if($this->_check_db($username, $password)) {
            //ready to login
            setcookie('errmsg','<b><font size=+1>The user already exists. Kindly use another login</font></b>',time() + 1*24*60*60);
            header("location: createlogin.php");
        }
		else if($this->_check_db_email($email)){
		setcookie('errmsg','<b><font size=+1>A user with email address already exists. Kindly try different address</font></b>',time() + 1*24*60*60);
            	header("location: createlogin.php");	
		}
        else {
	    global $db;
           $db->query("INSERT INTO `user` (`username`, `nicename`, `email`, `password`) VALUES ('". $username . "','". $nicename . "','". $email . "',SHA1('". $pass1 . "'))");
	    
			setcookie('regdmsg','<b><font size=+1>Registration Successful. Kindly Wait for Administrators Approval to Login, contact CFILT SysAd</font></b>',time() + 1*24*60*60);
        
		header ("location: login.php");
        }
	}
        die();
    }

    /**
     * Check the database for login user
     * Get the password for the user
     * compare md5 hash over sha1
     * @param string $username Raw username
     * @param string $password expected to be md5 over sha1
     * @return bool TRUE on success FALSE otherwise
     */
    private function _check_db($username, $password) {
        global $db;
        $user_row = $db->get_row("SELECT * FROM `user` WHERE `status` >= '1' and `username`='" . $db->escape($username) . "'");

        //general return
        if(is_object($user_row) && md5($user_row->password) == $password){
			$_SESSION['invalid']="";
            return true;
		}
        else{
            return false;
		}
	}


     private function _check_db_email($email){
		global $db;
        $user_row = $db->get_row("SELECT * FROM `user` WHERE `status` >= '1' and `email`='" . $db->escape($email) . "'");
		
        //general return
        if(is_object($user_row)){
			$_SESSION['invalid']="";
            return true;
		}
        else{
            return false;
		}
	}

    /**
     * stripslash gpc
     * Strip the slashes from a string added by the magic quote gpc thingy
     * @access protected
     * @param string $value
     */
    private function stripslash_gpc(&$value) {
        $value = stripslashes($value);
    }

    /**
     * htmlspecialcarfy
     * Encodes string's special html characters
     * @access protected
     * @param string $value
     */
    private function htmlspecialcarfy(&$value) {
        $value = htmlspecialchars($value);
    }

    /**
     * URL Decode
     * Decodes a URL Encoded string
     * @access protected
     * @param string $value
     */
    protected function urldecode(&$value) {
        $value = urldecode($value);
    }
}
