<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
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
	$pid=$_GET['id'];
	$sql = "SELECT qty FROM cart WHERE uid='$uid' AND pid='$pid'";
	$result=$conn->query($sql);
	$row = $result->fetch_assoc();
	$qty=$row["qty"];
	if($qty==1)
	{
		$sql="DELETE FROM cart WHERE uid='$uid' AND pid='$pid'";
		$result=$conn->query($sql);
		header("location:cart.php");
	}
	else
	{
		$qty = $qty - 1;
		$sql="UPDATE cart SET qty='$qty' WHERE uid='$uid' AND pid='$pid'";
		$result=$conn->query($sql);
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