<!DOCTYPE html>
<html>
    <?php
    include_once '../src/db/Database.php';
    session_start();
    if($_SESSION['user']){
    }
    else{
        header("location:index.php");
    }
    $user = $_SESSION['user'];
    $user_id = $_SESSION['user_id'];

    $database = new Database();
    $db = $database->connect();
  

    $result = $db->query("SELECT id from vaults WHERE provider ='Azure'");
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $_SESSION['vault_id'] = $row['id'];
    ?>

	<head>
		<title>Trust Factory Certificates</title>
	</head>

	<body>
		<h2>Home Page</h2>
		<p>Hello <?php Print "$user" ?>!</p>

		<h3>Certificate Operations</h3>
        <h4>Create Certificate</h4>
		 <form action="../operations/certificate/create.php" method="POST">
            Certificate Name: <input type="text" name="name" required="required"/> <br>
            Email: <input type="text" name="email" required="required"/><br>
            <br>
            Common Name: <input type="text" name="common_name"/><br >
            Organization: <input type="text" name="organization"/><br>
            Organization Unit: <input type="text" name="organization_unit"/><br>
            Country: <input type="text" name="country"/><br>
            State: <input type="text" name="state"/><br>
            <br>
            Key type: <input type="text" name="keyType"/><br>
            Key Size: <input type="text" name="keySize"/><br>
            <input type="submit" name="Generate Cert"  />
        </form>

        <h4>Get Certificate Signing Request (CSR)</h4>
		 <form action="../operations/certificate/getCSR.php" method="POST">
            Certificate Name: <input type="text" name="name" required="required" /><br>
            <input type="submit" name="Get CSR"  /><br><br>
            <a href="../operations/certificate/listCSRs.php">List All CSRs</a><br/>           
        </form>

        <h4>Merge Signed Request</h4>
		 <form action="../operations/certificate/merge.php" method="POST">
            Certificate Name: <input type="text" name="name" required="required" /><br>
            File Name: <input type="text" name="filename" required="required" /><br>
            <input type="submit" name="Merge"  />
        </form>

         <h4>Get Certificate</h4>
		 <form action="../operations/certificate/getCert.php" method="POST">
            Certificate Name: <input type="text" name="name" required="required" /><br>
            <input type="submit" name="Get Cert"  /><br> <br>
            <a href="../operations/certificate/listCerts.php">List All Certificates</a><br/>
        </form>        

        <h3>Key Operations</h3>
        <h4>Create Key</h4>
		 <form action="../operations/key/create.php" method="POST">
            Key Name: <input type="text" name="name" required="required" /><br>
            Key type: <input type="text" name="keyType" required="required" /><br>
            Key Size: <input type="text" name="keySize" required="required" /><br>
            <input type="submit" name="Create Key"  />
        </form>

        <h4>Get Key</h4>
		 <form action="../operations/key/get.php" method="POST">
            Key Name: <input type="text" name="name" required="required" /><br>
            <input type="submit" name="Get Key"  /><br><br>
            <a href="../operations/key/listKeys.php">List All Keys</a><br/>
        </form>
            
        </form>

         <h4>Sign</h4>
		 <form action="../operations/key/sign.php" method="POST">
            Key name 	: <input type="text" name="name" required="required" /><br>
            Signing Algorithm 	: <input type="text" name="algorithm" required="required" /><br>
            Hash 	: <input type="text" name="value" required="required" /><br>
            <input type="submit" name="Sign"  />
        </form>

         <h4>Verify</h4>
         <form action="../operations/key/verify.php" method="POST">
            Key name    : <input type="text" name="name" required="required" /><br>
            Signing Algorithm   : <input type="text" name="algorithm" required="required" /><br>
            Hash    : <input type="text" name="value" required="required" /><br>
            Signature Value     : <input type="text" name="signature" required="required"><br>
            <input type="submit" name="Sign"  />
        </form>
		
		
	</body>
	<br><br>
	<a href="logout.php">Click here to Log Out</a><br/><br/>
</html>
