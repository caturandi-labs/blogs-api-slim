<?php

//kelas koneksi database
class Connect{
	
	private $dbHost = "localhost";
	private $dbUser = "root";
	private $dbPass = "";
	private $dbName = "slimblog";

	public function connect()
	{
		$dsn= "mysql:host=localhost;dbname=slimblog";
		$dbConnection = new PDO($dsn,$this->dbUser,$this->dbPass);
		$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
		return $dbConnection;
	}

}
