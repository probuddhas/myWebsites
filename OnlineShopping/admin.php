<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Admin Page</title>
<link rel="stylesheet" href="style.css">
</head>

<body background="back.jpg">
<?php

if(isset($_SESSION["loggedin"]) && ($_SESSION["user"]!='admin' && $_SESSION["user"]!='cou')) {
	header("location:home.php");
}
elseif(isset($_SESSION["loggedin"]) && $_SESSION["user"]=='cou') {
	header("location:cou.php");
}
elseif($_SESSION["loggedin"]==1 && (time()-$_SESSION["last"])<=1800)
{
	$_SESSION["last"]=time();
	if (!isset($_POST["btn_submit1"])) {
		$_POST["pname"]='';
		$_POST["pdesc"]='';
		$_POST["price"]='';
		$_POST["pstock"]='';
	}
	echo '<table width="985" height="151">
  	<tr>
    	<td width="205"><img src="shoping_cart.png" width="142" height="141" alt=""/></td>
    	<td width="507"><h1 style="color:#73ED1D ; font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;">Online Shopping Management</h1></td>
    	<td width="257" align="right" valign="bottom"><b>Administrator Page</b><br><a href="admin.php" class="button">Home</a> &nbsp;&nbsp;&nbsp;<a href="logout.php" class="button">Logout</a></td>
  	</tr>
	</table><hr>
	
	<center>
	<table border="1">
	<tr>
	<td width="600"><center><h3>Add New Items:</h3></center>
	<form action="'.$_SERVER["PHP_SELF"].'" method="post" enctype="multipart/form-data">
	&nbsp;Product Name: <input type="text" name="pname" value="'.$_POST["pname"].'"/><br>
	&nbsp;Product Description: (use HTML formatting)<br><textarea name="pdesc" rows="5" cols="70">'.$_POST["pdesc"].'</textarea><br>
	&nbsp;Product Price: <input type="number" name="price" value="'.$_POST["price"].'"/><br>
	&nbsp;Product Type: <input type="radio" name="ptype" value="books">Books&nbsp;
	<input type="radio" name="ptype" value="electronics">Electronics&nbsp;
	<input type="radio" name="ptype" value="fashion">Fashion&nbsp;
	<input type="radio" name="ptype" value="jewellery">Jewellery&nbsp;
	<input type="radio" name="ptype" value="accessories">Accessories<br>	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="ptype" value="caraccessories">Car Accessories&nbsp;
	<input type="radio" name="ptype" value="homekitchen">Home & Kitchen&nbsp;
	<input type="radio" name="ptype" value="stationaries">Stationaries&nbsp;
	<input type="radio" name="ptype" value="dvd">DVDs<br>
	&nbsp;Product Image: <input type="file" name="image" size="20" /><br>
	&nbsp;No. of Product Items in Stock: <input type="number" name="pstock" value="'.$_POST["pstock"].'"/><br><br>
	<center><input type="submit" name="btn_submit1" value="Submit"/></center>
	</form></td>

	<td width="599" valign="top"><center><h3>Add Stocks for an Item:</h3></center>
	<form action="'.$_SERVER["PHP_SELF"].'" method="post">
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Unique Product ID: <input type="number" name="pid"/><br>
	&nbsp;No. of Units to Add to Stock: <input type="number" name="no"/><br><br>
	<center><input type="submit" name="btn_submit2" value="Submit"/></center>
	</form></td></tr>
	</table></center>';
	
	if (isset($_POST["btn_submit1"])) {
		if(strlen($_POST["pname"])>0 && strlen($_POST["pdesc"])>0 && strlen($_POST["price"])>0 && isset($_POST["ptype"])!=false && $_FILES['image']['size']>0 && strlen($_POST["pstock"])>0) {
			if($_FILES['image']['type']=='image/jpeg' OR $_FILES['image']['type']=='image/gif' OR $_FILES['image']['type']=='image/png' OR $_FILES['image']['type']=='image/tiff') {
				include 'db.php';
				$pname=$_POST["pname"];
				$pdesc=$_POST["pdesc"];
				$price=$_POST["price"];
				$ptype=$_POST["ptype"];
				$pstock=$_POST["pstock"];
			
				$sql="SELECT pid FROM stock";
				$result=$conn->query($sql);
				$iname=($result->num_rows)+1;
				$iname="pimages/".$iname.".jpg";
				$tmpName=$_FILES['image']['tmp_name'];
				move_uploaded_file($tmpName,$iname);
						
				$sql="INSERT INTO stock (pname,pdesc,price,ptype,pstock) VALUES ('$pname','$pdesc','$price','$ptype','$pstock')";
				$result=$conn->query($sql);
				echo "<h3><br><center>&lt;&lt;DATABASE UPDATED&gt;&gt;<br>&lt;&lt;CLICK ON HOME TO INSERT ANOTHER ITEM&gt;&gt;</center></h3>";
			}
			else {
				echo "<h3><br><center>&lt;&lt;Only JPG, GIF, PNG or TIF Files are allowed&gt;&gt;</center></h3>";	
			}
		}
		else {
			echo "<h3><br><center>&lt;&lt;ANY OF THE FIELDS CANNOT BE LEFT BLANK&gt;&gt;<br>&lt;&lt;CLICK ON HOME TO INSERT ANOTHER ITEM&gt;&gt;</center></h3>";
		}
	}
	
	
	if (isset($_POST["btn_submit2"])) {
		if(strlen($_POST["pid"])>0 && strlen($_POST["no"])>0) {
			include 'db.php';
			$pid=$_POST["pid"];
			$no=$_POST["no"];
			$sql = "SELECT pid FROM stock WHERE pid='$pid'";
			$result=$conn->query($sql);
			if($result->num_rows<1)
			{
				echo "<h3><center>&lt;&lt;Entered Product ID does not exist. Please try again&gt;&gt;</center></h3>";
			}
			else
			{
				$sql="SELECT pstock FROM stock WHERE pid='$pid'";
				$result=$conn->query($sql);
				$row = $result->fetch_assoc();
				$add=$row["pstock"]+$no;
				
				$sql="SELECT qty,oid FROM orders WHERE pid='$pid' AND status='H'";
				$result=$conn->query($sql);
				while($row = $result->fetch_assoc()) {
					$oid=$row["oid"];
					$qty=$row["qty"];
					if(($add - $qty)>=0) {
						$add = $add - $qty;
						
						$sql2="UPDATE orders SET status='C' WHERE oid='$oid'";
						$result2=$conn->query($sql2);
					}
					if($add==0)
					{
						break;
					}
				}
				echo "<h3><br><center>&lt;&lt;orders TABLE UPDATED&gt;&gt;</center></h3>";
				$sql="UPDATE stock SET pstock='$add' WHERE pid='$pid'";
				$result=$conn->query($sql);
				echo "<h3><br><center>&lt;&lt;stock TABLE UPDATED&gt;&gt;</center></h3>";
			}
		}
		else {
			echo "<h3><br><center>&lt;&lt;ANY OF THE FIELDS CANNOT BE LEFT BLANK&gt;&gt;</center></h3>";
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