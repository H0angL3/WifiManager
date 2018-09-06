<?php
/*
*ket noi toi co so du lieu mysql
*/
/**
 *
 */
class Database
{
  private  $_servername = "";
  private  $_username = "";
  private  $_password = "";
  private $_connect = "";
  function __construct($servername, $username, $password) {
    $this->_servername = $servername;
    $this->_username = $username;
    $this->_password = $password;
  }
  //set get
  public function setServerName($servername)
  {
    $this->_servername = $servername;
  }
  public function setUserName($username)
  {
    $this->_username = $username;
  }
  public function setPassword($password)
  {
    $this->_password = $password;
  }

  public function connect(){
    // Create connection
    $this->_connect = new mysqli($this->_servername, $this->_username, $this->_password);
    // Check connection
    if ($this->_connect->connect_error) {
        die("Connection failed: " . $this->_connect->connect_error);
    }
    echo "Connected successfully";
  }
  public function useDatabase($database){
    echo "use " .$database;
    $sql = "use " .$database;
    if ($this->_connect->query($sql) === TRUE) {
    echo "using" . $database;
    } else {
        echo "Error: " . $sql . "<br>" . $this->_connect->error;
    }
  }
  public function insert($table, $column, $value){
    echo "insert into " .$table ."(" .$column .") values (" .$value .")";
    $sql = "insert into " .$table ."(" .$column .") values (" .$value .")";
    if ($this->_connect->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $this->_connect->error;
    }

  }
}

$database = new Database("localhost", "root","");
$connect = $database->connect();
$db = "wifimanagerdb";
$table = "user";
$column = "id, hostname, mac, oui";
$value = "'123', 'abc', 'dec', 'sony'";

echo "<br>";
$database->useDatabase($db);
echo "<br>";
$database->insert($table, $column, $value);
?>
