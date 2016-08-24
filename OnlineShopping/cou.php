<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Courier Page</title>
<link rel="stylesheet" href="style.css">
</head>

<body background="back.jpg">
<?php
if(isset($_SESSION["loggedin"]) && ($_SESSION["user"]!='admin' && $_SESSION["user"]!='cou')) {
	header("location:home.php");
}
elseif(isset($_SESSION["loggedin"]) && $_SESSION["user"]=='admin') {
	header("location:admin.php");
}
elseif($_SESSION["loggedin"]==1 && (time()-$_SESSION["last"])<=1800)
{
	$_SESSION["last"]=time();
	include 'db.php';
	echo '<table width="985" height="151">
  	<tr>
    	<td width="205"><img src="shoping_cart.png" width="142" height="141" alt=""/></td>
    	<td width="507"><h1 style="color:#73ED1D ; font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;">Online Shopping Management</h1></td>
    	<td width="257" align="right" valign="bottom"><b>Hello Courier Agent!</b><br><a href="cou.php" class="button">Home</a> &nbsp;&nbsp;&nbsp;<a href="logout.php" class="button">Logout</a></td>
  	</tr>
	</table>
	<center>
	<hr>
	<p style="font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace; font-size: 24px;">&lt;&lt;Check Orders To Be Delivered&gt;&gt;</p>
	<hr>
	</center>';
	echo '<center>';
	$sql="SELECT oid,uid,pid,qty FROM orders WHERE status='C'";
	$result=$conn->query($sql);
	echo '<table border="1"<tr><th>Order ID</th><th>User ID</th><th>Product ID</th><th>Quantity</th></tr>';
	while($row = $result->fetch_assoc()) {
		echo '<tr><td>'.$row["oid"].'</td><td>'.$row["uid"].'</td><td>'.$row["pid"].'</td><td>'.$row["qty"].'</td></tr>';
	}
	echo '</table>';
	echo '<hr>';
	
	echo '<h3>Mark An Order ID as Delivered :</h3>
	<form action="'.$_SERVER["PHP_SELF"].'" method="post">
	Unique Order ID: <input type="number" name="oid"/><br>
	<input type="submit" name="btn_submit" value="Mark as Delivered"/>
	</form>';
	
	echo '</center>';
	
	
	if (isset($_POST["btn_submit"])) {
		if(strlen($_POST["oid"])>0) {
			$oid=$_POST["oid"];
			$sql="SELECT oid FROM orders WHERE status='C' AND oid='$oid'";
			$result=$conn->query($sql);
			if($result->num_rows<1) {
				echo "<h3><br><center>&lt;&lt;Order already marked as Delivered OR Order ID Doesn't Exist&gt;&gt;</center></h3>";
			}
			else {
				$sql="UPDATE orders SET status='D' WHERE oid='$oid'";
				$result=$conn->query($sql);
				header("location:cou.php");
			}
		}
		else {
			echo "<h3><br><center>&lt;&lt;FIELD CANNOT BE LEFT BLANK&gt;&gt;</center></h3>";
		}
		
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