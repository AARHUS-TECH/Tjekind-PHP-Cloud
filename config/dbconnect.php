<?php

class DB_CONNECT {
 
    // Constructor
    function __construct() {
        // Trying to connect to the database
        $this->connect();
    }
 
    // Destructor
    function __destruct() {
        // Closing the connection to database
        $this->close();
    }
 
   // Function to connect to the database
    function connect() {

        //importing dbconfig.php file which contains database credentials 
        $filepath = realpath (dirname(__FILE__));
        require_once($filepath."/dbconfig.php");
        
		// Connecting to mysql (phpmyadmin) database
        $con = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE) or die( mysqli_error() );
 
        // Selecing database
        //$db = mysqli_select_db($con, DB_DATABASE) or die( mysql_error() );
 
		// Check connection
		if ($con->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} else {
			echo "Connected successfully";
		}

        
		// returing connection cursor
        return $con;
    }
 
	// Function to close the database
    function close() {
        // Closing data base connection
        mysqli_close();
    }
 
}
 
?>