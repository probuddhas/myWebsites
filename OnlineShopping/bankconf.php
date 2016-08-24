<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Payment Confirmation</title>
<link rel="stylesheet" href="style.css">
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
	if(isset($_SESSION["total"])) {
		$_SESSION["last"]=time();
		include 'db.php';
		$user=$_SESSION["user"];
	
		$sql="SELECT id FROM users WHERE uname='$user'";
		$result=$conn->query($sql);
		$row = $result->fetch_assoc();
		$uid=$row["id"];
	
	
		$sql="SELECT name FROM users WHERE uname='$user'";
		$result=$conn->query($sql);
		$row = $result->fetch_assoc();
		
		echo '<div id="head"><table style="width:100%;height:100px;">
  	<tr>
    	<td width="100" style="padding: 0px 0px 0px 0px;margin: 0px 0px 0px 0px;"><img style="margin: 0px 0px 0px 10px;" src="shoping_cart.png" width="100" height="98" alt=""/></td>
    	<td style="margin: 0px 0px 0px 0px;padding: 0px 0px 0px 10px;"><h1 style="margin: 0px 0px 0px 0px;color:#73ED1D ; font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;">Online Shopping Management</h1><br><b>Hello '.$row["name"].'!</b></td>
    	<td style="margin: 0px 0px 0px 0px;padding: 0px 0px 0px 0px;" align="right"><a href="orders.php" class="button">Your Orders</a> &nbsp;&nbsp;&nbsp;<a href="home.php" class="button">Home</a> &nbsp;&nbsp;&nbsp;<a href="logout.php" class="button">Logout</a></td>
  	</tr>
	</table></div>
	<center>
	<div id="conmax">
	<center>
	<p style="font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace; font-size: 24px;">&lt;&lt;Your Payment Confirmation&gt;&gt;</p>
	
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
	
	$sql="SELECT cardno,pin FROM users WHERE uname='$user'";
	$result=$conn->query($sql);
	$row = $result->fetch_assoc();
	$cardno=$row["cardno"];
	$pin=$row["pin"];
	
	$sql="SELECT cardno FROM bank WHERE cardno='$cardno' AND pin='$pin'";
	$result=$conn->query($sql);
	if($result->num_rows>0)
	{
	
	$sql="SELECT amount FROM bank WHERE cardno='$cardno'";
	$result=$conn->query($sql);
	$row = $result->fetch_assoc();
	
	if($row["amount"]>=$_SESSION["total"]) {
		$sql1="SELECT uid,pid,qty FROM cart WHERE uid='$uid'";
		$result1=$conn->query($sql1);
		while($row1 = $result1->fetch_assoc()) {
			$id=$row1["uid"];
			$pid=$row1["pid"];
			$qty=$row1["qty"];
			$sql2="SELECT pstock FROM stock WHERE pid='$pid'";
			$result2=$conn->query($sql2);
			$row2 = $result2->fetch_assoc();
			if($qty<=$row2["pstock"])
			{
				$sts='C';
				$sto = $row2["pstock"] - $qty;
				$sql6="UPDATE stock SET pstock='$sto' WHERE pid='$pid'";
				$result6=$conn->query($sql6);
			}
			else {
				$sts='H';
				$flag=1;
			}
			$sql3="INSERT INTO orders(uid,pid,qty,status) VALUES('$id','$pid','$qty','$sts')";
			$result3=$conn->query($sql3);
			
		}
		$diff = $row["amount"] - $_SESSION["total"];
		$sql4="UPDATE bank SET amount='$diff' WHERE cardno='$cardno'";
		$result4=$conn->query($sql4);
		
		$sql5="DELETE FROM cart WHERE uid='$uid'";
		$result5=$conn->query($sql5);
		
		if(isset($flag))
		{
			echo '<h3><br><center>&lt;&lt;Your Order has been Placed. The Amount has been deducted from your bank account. Our Courier Partner has been notified. Some items might take longer to be delivered as they are out of stock now. <a href="home.php">Go To Home</a>&gt;&gt;</center></h3>';
		}
		else {
		echo '<h3><br><center>&lt;&lt;Your Order has been Placed. The Amount has been deducted from your bank account. Our Courier Partner has been notified. <a href="home.php">Go To Home</a>&gt;&gt;</center></h3>';
		}
		
	}
	else {
		echo '<h3><br><center>&lt;&lt;Not Enough Balance in Your Bank Account. <a href="home.php">Go To Home</a>&gt;&gt;</center></h3>';
	}
	
	
	}
	else {
		echo '<h3><br><center>&lt;&lt;Card No. & PIN Not Valid <a href="pay.php">Try Again</a>&gt;&gt;</center></h3>';
	}
	
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
	else {
		header("location:cart.php");
	}
	
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