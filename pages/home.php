<!DOCTYPE html>
<html>
	<head>
		<title>Trust Factory Certificates</title>
	</head>
	<?php
	session_start();
	if($_SESSION['user']){
	}
	else{
		header("location:index.php");
	}
	$user = $_SESSION['user'];
	?>
	<body>
		<h2>Home Page</h2>
		<p>Hello <?php Print "$user"?>!</p>

		<h3>Create Certificate</h3>
		 <form action="../operations/certificate/create.php" method="POST">
            Certificate Name: <input type="text" name="name"/><br>
            Subject: <input type="text" name="subject"/><br>
            <input type="submit" name="Generate Cert"  />
        </form>

        <h3>Get CSR</h3>
		 <form action="../operations/certificate/getCSR.php" method="POST">
            Certificate Name: <input type="text" name="name"/><br>
            <input type="submit" name="Get CSR"  />
        </form>

        <h3>Merge Signed Request</h3>
		 <form action="../operations/certificate/merge.php" method="POST">
            Certificate Name: <input type="text" name="name"/><br>
            File Name: <input type="text" name="filename"/><br>
            <input type="submit" name="Merge"  />
        </form>

         <h3>Get Cert</h3>
		 <form action="../operations/certificate/getCert.php" method="POST">
            Certificate Name: <input type="text" name="name"/><br>
            <input type="submit" name="Get Cert"  />
        </form>

        <h3>Create Key</h3>
		 <form action="../operations/key/create.php" method="POST">
            Key Name: <input type="text" name="name"/><br>
            Key type: <input type="text" name="keyType"/><br>
            Key Size: <input type="text" name="keySize"/><br>
            <input type="submit" name="Create Key"  />
        </form>

        <h3>Get Key</h3>
		 <form action="../operations/key/get.php" method="POST">
            Key Name: <input type="text" name="name"/><br>
            <input type="submit" name="Get Key"  />
        </form>

         <h3>Sign</h3>
		 <form action="../operations/key/sign.php" method="POST">
            Key name 	: <input type="text" name="name"/><br>
            Signing Algorithm 	: <input type="text" name="algorithm"/><br>
            Hash 	: <input type="text" name="value"/><br>
            <input type="submit" name="Sign"  />
        </form>
		
		
	</body>
	<br><br>
	<a href="logout.php">Click here to Log Out</a><br/><br/>
</html>