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
		
		
	</body>
	<br><br>
	<a href="logout.php">Click here to Log Out</a><br/><br/>
</html>
