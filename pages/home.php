<!DOCTYPE html>
<html>
    <?php
    session_start();
    if($_SESSION['user']){
    }
    else{
        header("location:index.php");
    }
    $user = $_SESSION['user'];
    ?>

	<head>
		<title>Trust Factory Certificates</title>
	</head>

	<body>
		<h2>Home Page</h2>
		<p>Hello <?php Print "$user"?>!</p>

		<h3>Certificate Operations</h3>
        <h4>Create Certificate</h4>
		 <form action="../operations/certificate/create.php" method="POST">
            Certificate Name: <input type="text" name="name"/><br>
            Subject: <input type="text" name="subject"/><br>
            <input type="submit" name="Generate Cert"  />
        </form>

        <h4>Get Certificate Signing Request (CSR)</h4>
		 <form action="../operations/certificate/getCSR.php" method="POST">
            Certificate Name: <input type="text" name="name"/><br>
            <input type="submit" name="Get CSR"  /><br><br>
            <a href="../operations/certificate/listCSRs.php">List All CSRs</a><br/>           
        </form>

        <h4>Merge Signed Request</h4>
		 <form action="../operations/certificate/merge.php" method="POST">
            Certificate Name: <input type="text" name="name"/><br>
            File Name: <input type="text" name="filename"/><br>
            <input type="submit" name="Merge"  />
        </form>

         <h4>Get Certificate</h4>
		 <form action="../operations/certificate/getCert.php" method="POST">
            Certificate Name: <input type="text" name="name"/><br>
            <input type="submit" name="Get Cert"  /><br> <br>
            <a href="../operations/certificate/listCerts.php">List All Certificates</a><br/>
        </form>        

        <h3>Key Operations</h3>
        <h4>Create Key</h4>
		 <form action="../operations/key/create.php" method="POST">
            Key Name: <input type="text" name="name"/><br>
            Key type: <input type="text" name="keyType"/><br>
            Key Size: <input type="text" name="keySize"/><br>
            <input type="submit" name="Create Key"  />
        </form>

        <h4>Get Key</h4>
		 <form action="../operations/key/get.php" method="POST">
            Key Name: <input type="text" name="name"/><br>
            <input type="submit" name="Get Key"  /><br><br>
            <a href="../operations/key/listKeys.php">List All Keys</a><br/>
        </form>

         <h4>Sign</h4>
		 <form action="../operations/key/sign.php" method="POST">
            Key name 	: <input type="text" name="name"/><br>
            Signing Algorithm 	: <input type="text" name="algorithm"/><br>
            Hash 	: <input type="text" name="value"/><br>
            <input type="submit" name="Sign"  />
        </form>

         <h4>Verify</h4>
         <form action="../operations/key/verify.php" method="POST">
            Key name    : <input type="text" name="name"/><br>
            Signing Algorithm   : <input type="text" name="algorithm"/><br>
            Hash    : <input type="text" name="value"/><br>
            Signature Value     : <input type="text" name="signature"><br>
            <input type="submit" name="Sign"  />
        </form>
		
		
	</body>
	<br><br>
	<a href="logout.php">Click here to Log Out</a><br/><br/>
</html>
