//this file can be used for adding a new customer to the Bank DB. It can also be used for crediting money to the customer's account. But this way of doing this is not secure.

<html>
<head>
<title>Add Bank Accounts</title>
</head>
<body>
<?php
if (!isset($_POST["btn_add"])) {
		$_POST["bank"]='';
		$_POST["card"]='';
		$_POST["amount"]='';
	}
echo '<center><p><h4>Add Bank Account / Update Account</h4></p>';
include 'db.php';
echo '<form action="'.$_SERVER["PHP_SELF"].'" method="post">
	Bank Name: <input type="text" name="bank" value="'.$_POST["bank"].'"/><br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Card No.: <input type="number" name="card" value="'.$_POST["card"].'"/><br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PIN: <input type="password" name="pin"/><br>
	Add Amount: <input type="number" name="amount" value="'.$_POST["amount"].'"/><br>
	<input type="submit" name="btn_add" value="Add Account"/>
	</form>
	</center>';
	
	if (isset($_POST["btn_add"])) {
		if(strlen($_POST["bank"])>0 && strlen($_POST["card"])>0 && strlen($_POST["pin"])>0 && strlen($_POST["amount"])) {
			$bank=$_POST["bank"];
			$card=$_POST["card"];
			$pin=$_POST["pin"];
			$amt=$_POST["amount"];
			$sql="SELECT cardno FROM bank WHERE cardno='$card'";
			$result=$conn->query($sql);
			if($result->num_rows>0)
			{
				$sql="SELECT pin FROM bank WHERE cardno='$card'";
				$result=$conn->query($sql);
				$row = $result->fetch_assoc();
				if($row["pin"]==$pin) {
					$sql="SELECT amount FROM bank WHERE cardno='$card'";
					$result=$conn->query($sql);
					$row = $result->fetch_assoc();
					$amt = $row["amount"] + $amt;
					$sql="UPDATE bank SET amount='$amt' WHERE cardno='$card'";
					$result=$conn->query($sql);
					echo "<h3><br><center>&lt;&lt;Amount Added to Bank Database&gt;&gt;</center></h3>";
				}
				else {
					echo "<h3><br><center>&lt;&lt;PIN does not match. Please Check Again&gt;&gt;</center></h3>";
				}
			}
			else {
				$sql="INSERT INTO bank(cardno,pin,bankname,amount) VALUES('$card','$pin','$bank','$amt')";
				$result=$conn->query($sql);
				echo "<h3><center>&lt;&lt;Entry Added to Bank Database&gt;&gt;</center></h3>";	
			}
		}
		else {
			echo "<h3><br><center>&lt;&lt;ANY OF THE FIELDS CANNOT BE LEFT BLANK&gt;&gt;</center></h3>";
		}	
	}

?>
</body>
</html>