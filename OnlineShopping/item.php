<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Item Description</title>
<link rel="stylesheet" href="style.css">
<script>
function validateForm()
{
	var x=document.forms["myForm"]["pin"].value;
	if(x==null||x=="")
	{
		alert("Enter Code");
		return false;
	}
	else
	{
		x=parseInt(x);
		if(100000<=x && x<=999999)
			document.getElementById("msg").innerHTML="*available in your area";
		else
			document.getElementById("msg").innerHTML="*not available in your area or invalid code";
		return false;
	}
}
</script>
</head>

<body id="back">
<?php
if(isset($_SESSION["loggedin"]) && $_SESSION["user"]=='admin') {
	header("location:admin.php");
}
elseif(isset($_SESSION["loggedin"]) && $_SESSION["user"]=='cou') {
	header("location:cou.php");
}
elseif($_SESSION["loggedin"]==1 && (time()-$_SESSION["last"])<=1800)
{
	$_SESSION["last"]=time();
	include 'db.php';
	$user=$_SESSION["user"];
	
	$sql="SELECT id FROM users WHERE uname='$user'";
	$result=$conn->query($sql);
	$row = $result->fetch_assoc();
	$uid=$row["id"];
	$sql = "SELECT uid FROM cart WHERE uid='$uid'";
	$result=$conn->query($sql);
	$rno=$result->num_rows;
	
	$sql="SELECT name FROM users WHERE uname='$user'";
	$result=$conn->query($sql);
	$row = $result->fetch_assoc();
	echo '<div id="head"><table style="width:100%;height:100px;">
  	<tr>
    	<td width="100" style="padding: 0px 0px 0px 0px;margin: 0px 0px 0px 0px;"><img style="margin: 0px 0px 0px 10px;" src="shoping_cart.png" width="100" height="98" alt=""/></td>
    	<td style="margin: 0px 0px 0px 0px;padding: 0px 0px 0px 10px;"><h1 style="margin: 0px 0px 0px 0px;color:#73ED1D ; font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;">Online Shopping Management</h1><br><b>Hello '.$row["name"].'!</b></td>
    	<td style="margin: 0px 0px 0px 0px;padding: 0px 0px 0px 0px;" align="right"><a href="orders.php" class="button">Your Orders</a> &nbsp;&nbsp;&nbsp;<a href="home.php" class="button">Home</a> &nbsp;&nbsp;&nbsp;<a href="logout.php" class="button">Logout</a><br><b><table style="margin: 0px 10px 0px 0px;"><tr><td>CART &gt;&gt;</td><td><a href="cart.php"><img src="shoping_cart.png" width="26" height="26" title="Check your Cart"></a></td><td>['.$rno.']</td></tr></table></b></td>
  	</tr>
	</table></div>
	<center>
	<div id="conmax">
	<center>
	<p style="font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace; font-size: 24px;">&lt;&lt;Item Description&gt;&gt;</p>
	
	<ul id="nav">
		<li><a href="category.php?id=books">Books</a></li>
		<li><a href="category.php?id=electronics">Electronics</a></li>
		<li><a href="category.php?id=fashion">Fashion</a></li>
		<li><a href="category.php?id=jewellery">Jewellery</a></li>
		<li><a href="category.php?id=accessories">Accessories</a></li>
		<li><a href="category.php?id=caraccessories">Car Accessories</a></li>
		<li><a href="category.php?id=homekitchen">Home & Kitchen</a></li>
		<li><a href="category.php?id=stationaries">Stationeries</a></li>
		<li><a href="category.php?id=dvd">DVDs</a></li>
	</ul>
	</center>';
	$pid=$_GET['id'];
	$sql="SELECT pid,pname,pdesc,price,pstock,ptype FROM stock WHERE pid='$pid'";
	$result=$conn->query($sql);
	$row = $result->fetch_assoc();
	
	
	
	
	echo '<table width="611">
	<tr>
<td width="273"><center>';
if($row["ptype"]=='electronics')
echo '<img src="pimages/'.$row["pid"].'.jpg" width="202" height="400"></center></td>';
else
echo '<img src="pimages/'.$row["pid"].'.jpg" width="181" height="205"></center></td>';
	echo '<td width="326"><center><b>'.$row["pname"].'</b><br>Rs.'.$row["price"].'/-<br><a href="addcart.php?id='.$row["pid"].'"><img src="add.png" width="15" height="15">Add to Cart</a></center></td>
	<td width="180"><div align="center" style="border:solid #84C67B 1px;"><b>Check Availability</b><br><form name="myForm" onSubmit="return validateForm()">PIN: <input type="text" name="pin" size="8"><input type="submit" value="Check"></form><div id="msg"></div></div></td>
	</tr></table>';
	
	echo '<p>'.$row["pdesc"].'</p>';
	echo '<p><b>Left in Stock : '.$row["pstock"].'</b></p>';

	echo '</div></center>';
	
	echo '<div id="footer2">
	<table style="padding:3px;font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace">
	<tr>
	<td width="300">
	<inline style="color:#FBCC45">SITE</inline><br>
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
else if($_SESSION["loggedin"]==1 && (time()-$_SESSION["last"])>1800)
{
	header("location:timeout.php");
}
else
{
	header("location:logout.php");
}


?>
</body>
</html>