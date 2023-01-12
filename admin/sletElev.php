<?php
//<!-- Updatet 17-02-2020. Til at slette bruger. -->
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['someAction']))
{
	func();
}
function func()
{

require_once('../core/init.php');

	$username = Config::get('database/username');
	$password = Config::get('database/password');
	$dsn = Config::get('database/dsn');

	try {
		$conn = new PDO($dsn, $username, $password);
		
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$sql = "DELETE FROM tjekind_brugere WHERE userID='" . $_GET["userID"] . "'";
		
		$conn->exec($sql);
		echo "Record deleted successfully";
		}
	catch(PDOException $e)
	{
		echo $sql . "<br>" . $e->getMessage();
	}

	$conn = null;

	header("Location: dashboard.php"); 
  	exit; 

}
func();
?>
