<?php
	include_once '../src/db/Database.php';
	session_start();
	$username = $_POST['username'];
	$password = $_POST['password'];
	$confirm_password = $_POST['confirmPassword'];

	if($password == $confirm_password)
	{

		$database = new Database();
		$db = $database->connect();
		$rand_int = random_int(0,10);
		$unique_id = uniqid(rand(),false);

		$result_usernames = $db->query("SELECT * from users WHERE username='$username'");
		$exists = $result_usernames->rowCount();

		if($exists >= 1)
		{
			while ($row = $result_usernames->fetch(PDO::FETCH_ASSOC)){
				$table_users = $row['username'];
			}

			if($username == $table_users) 
			{
				Print '<script>alert("Username has been taken");</script>';
				Print '<script>window.location.assign("signup.php");</script>';

			}
		}


		else
		{
			$result = $db->query("INSERT INTO users(`id`, `username`, `password`) VALUES ('$unique_id','$username','$password')");
			Print '<script>alert("Successfully registered");</script>';
			Print '<script>window.location.assign("login.php");</script>';				
		}

	}

	else
	{
		Print '<script>alert("Passwords dont match! Try again");</script>';
		Print '<script>window.location.assign("signup.php");</script>';

	}

	// $database = new Database();
	// $db = $database->connect();
	// $db = new PDO('mysql:host=localhost;dbname=first_db', 'root', '');
	// $result = $db->query("SELECT * from users WHERE username='$username'");
	// $exists = $result->rowCount();
	// //echo $exists;
	// $table_users = "";
	// $table_password = "";
	// 
	//
	// if($exists > 0)
	// {
	// 	while ($row = $result->fetch(PDO::FETCH_ASSOC)){
	// 		$table_users = $row['username'];
	// 		$table_password = $row['password'];
	// 	}
	// 	if(($username == $table_users) && ($password == $table_password))
	// 	{
	// 		if ($password = $table_password)
	// 		{
	// 			$_SESSION['user'] = $username;
	// 			header("location: home.php");
	// 		}
	// 	}
	// 	else
	// 	{
	// 		Print '<script>alert("Incorrect Password!");</script>';
	// 		Print '<script>window.location.assign("login.php");</script>';
	// 	}
	// }
	// else
	// {
	// 	Print '<script>alert("Incorrect username!");</script>';
	// 	Print '<script>window.location.assign("login.php");</script>';
	// }
 ?>