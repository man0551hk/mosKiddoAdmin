<?php
class DbConnection {

  public $link;

  public function __construct() {
    $this->link = $this->Getconnection();
  }

  public function GetConnection() {  
    include 'config/config.php';
    $link = mysqli_connect($hostName, $userName, $password, $dbName);
    mysqli_query($link, "SET NAMES 'utf8'");
    mysqli_query($link, "SET time_zone = '+8:00';");
    mysqli_autocommit($link, FALSE);
    return $link;
  }

  public function DoQuery($link, $query) {
    if (!mysqli_ping($link)) {
      $this->GetConnection();
    }
    
    $result = mysqli_query($link, $query);
    if (mysqli_errno($link)){
      echo mysqli_error($link). "<br/>" . $query;
    } else {
      mysqli_commit($link);
      return $result;
    }
    //mysqli_close($link); 
  }

  public function DoQueryInsertId($link, $query) {
    if (!mysqli_ping($link)) {
      $this->GetConnection();
    }

    mysqli_query($link, $query);
    if (mysqli_errno($link)){
      echo mysqli_error($link). "<br/>" . $query;
    } else {
      $id = mysqli_insert_id($link);
      mysqli_commit($link);
      return $id;
    }
    //mysqli_close($link); 
  }
}

?>
