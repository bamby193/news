<?php
 
class DB_Connect {
    // constructor
    function __construct() 
    {
         
    }
 
    // destructor
    function __destruct() 
    {
        // $this->close();
    }
 
    // Connecting to database
    public function connect() 
    {
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "news";

        $con = new PDO('mysql:host='.$servername.';dbname='.$dbname.';charset=utf8;useUnicode=true', $username, $password);
        $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
        // return database handler
        return $con;
    }
 
    // Closing database connection
    public function close() 
    {
        // mysql_close();
    }
}
?>