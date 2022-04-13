<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "be15_cr12_mount_everest_lucadogaru";
	
	$conn = mysqli_connect($servername, $username, $password, $dbname);

	
	

	
	$dbname = 'be15_cr12_mount_everest_lucadogaru';
	mysqli_select_db ( $conn , $dbname);

	if (!$conn) {
	    die("select db connection failed: " . mysqli_connect_error());
	}

	
	$sql = "CREATE TABLE `location_tab` (
	  `locationLatitude` VARCHAR(50) NOT NULL,
	  `locationLongitude` VARCHAR(50) NOT NULL,
	  `ID` INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY (`ID`))";

	if(mysqli_query($conn, $sql)){
	    echo "Table location created successfully<br>";
	} else {
	    echo "Error creating location table: " . mysqli_error($conn). "<br>";
	}	
			
	mysqli_close($conn);
?>