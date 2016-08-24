<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Your Orders</title>
<link rel="stylesheet" href="style.css">
</head>

<body background="back.jpg">
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
	echo '<table width="985" height="151">
  	<tr>
    	<td width="205"><img src="shoping_cart.png" width="142" height="141" alt=""/></td>
    	<td width="507"><h1 style="color:#73ED1D ; font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;">Online Shopping Management</h1></td>
    	<td width="257" align="right" valign="bottom"><b>Hello '.$row["name"].'!</b><br><a href="orders.php" class="button">Your Orders</a> &nbsp;&nbsp;&nbsp;<a href="home.php" class="button">Home</a> &nbsp;&nbsp;&nbsp;<a href="logout.php" class="button">Logout</a><br><table><tr><td>CART &gt;&gt;</td><td><a href="cart.php"><img src="carticon.png" title="Check your Cart"></a></td><td>['.$rno.']</td></tr></table></td>
  	</tr>
	</table>
	<center>
	<hr>
	<p style="font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace; font-size: 24px;">&lt;&lt;Your Orders&gt;&gt;</p>
	
	</center>';
	
	
	
	
	$sql = "SELECT pid,qty FROM orders WHERE uid='$uid' AND (status='C' OR status='H') ORDER BY oid DESC";
	$result=$conn->query($sql);
	if ($result->num_rows > 0) {
		echo '<center><h4><u>Orders Confirmed</u></h4>';
		echo '<table border="1">';
		while($row = $result->fetch_assoc()) {
			echo '<tr>';
			$pid=$row['pid'];
			$sql2="SELECT pname,price,ptype FROM stock WHERE pid='$pid'";
			$result2=$conn->query($sql2);
			$row2 = $result2->fetch_assoc();
			echo '<td width="273"><center><a href="item.php?id='.$pid.'">';
			if($row2["ptype"]=='electronics')
				echo '<img src="pimages/'.$pid.'.jpg" width="100" height="201">';
			else
				echo '<img src="pimages/'.$pid.'.jpg" width="181" height="205">';
			echo '</a></center></td>
<td width="326"><center>'.$row2["pname"].'<br><b>Rs.'.$row2["price"].'/-</b><br>Quantity : '.$row["qty"].'<br></center></td>';
			echo '</tr>';
		}
		echo '</table></center>';
		echo '<hr>';
	}
	else {
		echo "<h3><center>&lt;&lt;NO PENDING ORDERS HERE&gt;&gt;</center></h3>";
		echo '<hr>';
	}
	
	$sql = "SELECT pid,qty FROM orders WHERE uid='$uid' AND status='D' ORDER BY oid DESC";
	$result=$conn->query($sql);
	if ($result->num_rows > 0) {
		echo '<center><h4><u>Orders Already Delivered</u></h4>';
		echo '<table border="1">';
		while($row = $result->fetch_assoc()) {
			echo '<tr>';
			$pid=$row['pid'];
			$sql2="SELECT pname,price,ptype FROM stock WHERE pid='$pid'";
			$result2=$conn->query($sql2);
			$row2 = $result2->fetch_assoc();
			echo '<td width="273"><center><a href="item.php?id='.$pid.'">';
			if($row2["ptype"]=='electronics')
				echo '<img src="pimages/'.$pid.'.jpg" width="100" height="201">';
			else
				echo '<img src="pimages/'.$pid.'.jpg" width="181" height="205">';
			echo '</a></center></td>
<td width="326"><center>'.$row2["pname"].'<br><b>Rs.'.$row2["price"].'/-</b><br>Quantity : '.$row["qty"].'<br></center></td>';
			echo '</tr>';
		}
		echo '</table></center>';
	}
	else {
		echo "<h3><center>&lt;&lt;NOTHING DELIVERED YET&gt;&gt;</center></h3>";
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