<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Welcome to Online Shopping</title>
<link rel="stylesheet" href="style.css">
</head>
<body background="back.jpg">
<?php
$ses_flag=0;
if(isset($_SESSION["loggedin"]) && $_SESSION["user"]=='admin') {
	$ses_flag=1;
	header("location:admin.php");
}
elseif(isset($_SESSION["loggedin"]) && $_SESSION["user"]=='cou') {
	$ses_flag=1;
	header("location:cou.php");
}
elseif(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"]==0) {
	include 'db.php';
	echo '<div id="head"><table style="width:100%;height:100px;">
  	<tr>
    	<td width="100" style="padding: 0px 0px 0px 0px;margin: 0px 0px 0px 0px;"><img style="margin: 0px 0px 0px 10px;" src="shoping_cart.png" width="100" height="98" alt=""/></td>
    	<td style="margin: 0px 0px 0px 0px;padding: 0px 0px 0px 10px;"><h1 style="margin: 0px 0px 0px 0px;color:#73ED1D ; font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;">Online Shopping Management</h1></td>
  	</tr>
	</table></div>
	<center>
	<div style="padding-top:100px;">
	<ul id="nav">
		<li><a href="index.php">Home</a></li>
		<li><a href="reg.php">Register</a></li>
		<li><a href="admin_login.php">Admin Login</a></li>
		<li><a href="cou_login.php">Courier Login</a></li>
	</ul>
	</div>
	
	<p style="font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace; font-size: 24px;">&lt;&lt;Welcome To The Online Shopping Page&gt;&gt;</p>
	<p><a style="font-size: x-large; color: #180FE8; font-family: Impact, Haettenschweiler, Franklin Gothic Bold, Arial Black, sans-serif;" href="reg.php">If Unregistered, REGISTER HERE for shopping</a>
	</p>
	<p style="font-size: 18px">OR</p>
	<p style="font-size: large; color: #E85C1D; font-weight: bold; font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;">Login From Here</p>
	<form action="'.$_SERVER["PHP_SELF"].'" method="post">
	Username: <input type="text" name="username"/><br>
	&nbsp;Password: <input type="password" name="pwd"/><br>
	<input type="submit" name="btn_login" value="Login"/>
	</form>
	<br>
	<!-- <b>FOR GUEST LOGIN :- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b><i>Username : </i><u>guest</u> <i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Password : </i><u>guest123</u> -->
	</center>';
	if (isset($_POST["btn_login"])) {
		$uname=$_POST["username"];
		$pass=$_POST["pwd"];
		$sql = "SELECT uname, pwd FROM users WHERE uname='$uname' AND pwd='$pass'";
		$result=$conn->query($sql);
		if($result->num_rows<1)
		{
			echo "<h3><center>&lt;&lt;INVALID REQUEST. AUTHENTICATION FAILED&gt;&gt;</center></h3>";
		}
		else
		{
			$ses_flag=1;
			$_SESSION["user"]=$uname;
			$_SESSION["loggedin"]=1;
			$_SESSION["last"]=time();
			header("location:home.php");
		}
	}
	echo '<div id="footer"> <center><table><tr>
	<td style="border-right: 3px solid red;padding-right:6px">You are Visitor<br><!-- hitwebcounter Code START -->
<a href="http://www.hitwebcounter.com" target="_blank">
<img src="http://hitwebcounter.com/counter/counter.php?page=6316917&style=0038&nbdigits=7&type=page&initCount=0" title="" Alt=""   border="0" >
</a>                                        <br/>
                                        <!-- hitwebcounter.com --><a href="http://www.hitwebcounter.com" title="Live Stats For Website" 
                                        target="_blank" style="font-family: Geneva, Arial, Helvetica, sans-serif; 
                                        font-size: 10px; color: #908C86; text-decoration: underline ;"><em>Live Stats For Website                                        </em>
                                        </a>   
                            </td>
<td style="padding-left:6px">
<a href="http://www.000webhost.com/" target="_blank"><img src="http://www.000webhost.com/images/120x60_powered.gif" alt="Web Hosting" width="120" height="60" border="0" /></a>
</td>
</tr></table></center>
</div>';

	echo '<div id="footer2">
	<table style="padding:3px;font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace">
	<tr>
	<td width="300">
	<inline style="color:#FBCC45">SITE [login only]</inline><br>
	<table style="font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace">
	<tr><td width="60"><b><a href="home.php">HOME</a></b></td><td width="80"><b><a href="orders.php">ORDERS</a></b></td><td width="80"><b><a href="cart.php">CART</a></b></td></tr>
	</table>
	</td>
	<td width="300">
	<inline style="color:#FBCC45">CONNECT</inline><br>
	<table style="font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;">
	<tr><td width="100"><b><a href="contact.html">CONTACT</a></b></td><td width="100"><b><a href="contact.html">FEEDBACK</a></b></td></tr>
	</table>
	</td>
	<td width="250">
	<inline style="color:#FBCC45">SOCIAL</inline><br>
	<table>
	<tr><td width="40"><a href="http://www.facebook.com/probs.yo" target="_blank"><img src="fb_footer.png" title="Facebook"></a></td><td width="40"><a href="https://www.google.com/+probuddhasingha" target="_blank"><img src="gp_footer.png" title="Google+"></a></td><td width="40"><a href="https://www.twitter.com/faultofearth" target="_blank"><img src="tw_footer.png" title="Twitter"></a></td></tr>
	</table>
	</td>
	<td align="right">
	Thanks for Dropping By....
	</td>
	</tr>
	</table>
	</div>';
}
else
{
	$ses_flag=1;
	header("location:home.php");
}
if($ses_flag==0)
{
	session_unset();
	session_destroy();
}
?>

</body>
</html>