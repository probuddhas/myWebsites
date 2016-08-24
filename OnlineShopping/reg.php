<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Register Yourself</title>
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
	if (!isset($_POST["btn_register"])) {
		$_POST["userid"]='';
		$_POST["dob"]='';
		$_POST["password"]='';
		$_POST["name"]='';
		$_POST["e-mail"]='';
		$_POST["mob"]='';
		$_POST["bank"]='';
		$_POST["cardno"]='';
		$_POST["pin"]='';
		$_POST["addr"]='';
		
	}
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
	
	
	<p style="font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace; font-size: 24px;">&lt;&lt;Register Yourself Here&gt;&gt;</p>
	<form name="myform" action="'.$_SERVER["PHP_SELF"].'" method="post">
	<div style="margin-bottom:100px;">
	<table>
	<tr><td>Username: </td><td><input type="text" name="userid" value="'.$_POST["userid"].'"></td></tr>
	<tr><td>Password: </td><td><input type="password" name="password" value='.$_POST["password"].'></td></tr>
	<tr><td>Name: </td><td><input type="text" name="name" value="'.$_POST["name"].'"></td></tr>
	<tr><td>E-mail Address: </td><td><input type="text" name="e-mail" value="'.$_POST["e-mail"].'"></td></tr>
	<tr><td>Delivery Address: </td><td><textarea rows="2" cols="22" name="addr">'.$_POST["addr"].'</textarea></td></tr>';
	if(isset($_POST["gender"])!=false && $_POST["gender"]=='male') {
		echo '<tr><td>Sex: </td><td><input type="radio" name="gender" value="male" checked>Male&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="gender" value="female">Female</td></tr>';
	}
	elseif(isset($_POST["gender"])!=false && $_POST["gender"]=='female') {
		echo '<tr><td>Sex: </td><td><input type="radio" name="gender" value="male">Male&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="gender" value="female" checked>Female</td></tr>';
	}
	else {
		echo '<tr><td>Sex: </td><td><input type="radio" name="gender" value="male">Male&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="gender" value="female">Female<br></td></tr>';
	}
	echo '<tr><td>Mobile No. </td><td><input type="text" name="mob" value="'.$_POST["mob"].'"></td></tr>
	<tr><td>D.O.B: </td><td><input type="date" name="dob" max="2099-12-31" min="1900-01-01" value='.$_POST["dob"].'></td></tr>
	</table><br>
	Credit Card Details:<br>
	Bank Name: <input type="text" name="bank" value="'.$_POST["bank"].'">
	&nbsp;&nbsp;&nbsp;&nbsp;Card No.: <input type="text" name="cardno" value="'.$_POST["cardno"].'">
	&nbsp;&nbsp;&nbsp;&nbsp;PIN: <input type="password" name="pin" value="'.$_POST["pin"].'"><br><br><br>
	<input type="submit" name="btn_register" value="Register">';
	if (isset($_POST["btn_register"])) {
		if(strlen($_POST["userid"])>0 && strlen($_POST["password"])>0 && strlen($_POST["name"])>0 && strlen($_POST["e-mail"])>0 && strlen($_POST["addr"])>0 && isset($_POST["gender"])!=false && strlen($_POST["dob"])>0 && strlen($_POST["mob"])>0 && strlen($_POST["bank"])>0 && strlen($_POST["cardno"])>0 && strlen($_POST["pin"])>0) {
			include 'db.php';
			$uid=$_POST["userid"];
			$pwd=$_POST["password"];
			$name=$_POST["name"];
			$email=$_POST["e-mail"];
			$addr=$_POST["addr"];
			$sex=$_POST["gender"];
			$dob=$_POST["dob"];
			$mob=$_POST["mob"];
			$bank=$_POST["bank"];
			$card=$_POST["cardno"];
			$pin=$_POST["pin"];
			
			/*if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				echo "<h3><center>&lt;&lt;E-mail ID not valid&gt;&gt;</center></h3>";
				goto lab;
			}
			if((!is_numeric($mob))||(strlen($mob)!=10))
			{
				echo "<h3><center>&lt;&lt;Mobile No. must contain 10 numeric characters&gt;&gt;</center></h3>";
				goto lab;
			}
			if(!is_numeric($card))
			{
				echo "<h3><center>&lt;&lt;Card No. must contain numeric characters&gt;&gt;</center></h3>";
				goto lab;
			}*/
			
			
			$sql = "SELECT uname FROM users WHERE uname='$uid'";
			$result=$conn->query($sql);
			if($result->num_rows>0)
			{
				echo "<h3><center>&lt;&lt;Username is already taken. Please choose a new one&gt;&gt;</center></h3>";
			}
			else
			{
				$sql = "SELECT cardno FROM bank WHERE cardno='$card'";
				$result=$conn->query($sql);
				if($result->num_rows>0)
				{
					echo "<h3><center>&lt;&lt;Card Number exists. Card Numbers are unique&gt;&gt;</center></h3>";
				}
				else
				{
					$sql="INSERT INTO users(uname,pwd,name,email,addr,sex,dob,mob,bankname,cardno,pin) VALUES('$uid','$pwd','$name','$email','$addr','$sex','$dob','$mob','$bank','$card','$pin')";
					$result=$conn->query($sql);
					$sql="INSERT INTO bank(cardno,pin,bankname,amount) VALUES('$card','$pin','$bank',1000000)";
					$result=$conn->query($sql);
					echo '<h3><center>';
					echo '&lt;&lt;DONE&gt;&gt;';
					echo '<br>';
					echo 'Your User id : '.$uid;
					echo '<br>';
					echo '<a href="index.php">Login from HERE</a></center></h3>';
				}
			}
			
		}
		else {
			echo "<h3><center>&lt;&lt;ANY OF THE FIELDS CANNOT BE LEFT BLANK&gt;&gt;</center></h3>";
		}
	}
	//lab: echo '';
	echo '</div>
	</form>
	</center>';
	
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