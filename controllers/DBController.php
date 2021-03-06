<?php
class DBController
{
  private $dbConnection;
  private $link;


  public function __construct($dbConnection, $link)
  {
    $this->dbConnection = $dbConnection;
    $this->link = $link;
  }

  public function DirectQuery($query)
  {
    return $this->dbConnection->DoQuery($this->link, $query);
  }

  public function QueryDB($table, $fields = array(), $type = '', $condition = '', $joinTables = array(), $sorting = '', $groupby = '', $displayQuery = false)
  {
    $table = strtolower($table);

    if (is_array($condition)) {
      $condition = implode(' and ', $condition);
    }

    switch ($type) {
      case "query":
        $query = $this->MakeSelectQuery($table, $fields, $condition, $joinTables, $sorting, $groupby);
        break;
      case "insert":
        $query = $this->MakeInsertQuery($table, $fields);
        break;
      case "delete":
        $query = $this->MakeDeleteQuery($table, $fields);
        break;
      case "update":
        $query = $this->MakeUpdateQuery($table, $fields, $condition);
        break;
    }
    if ($displayQuery == true) {
      echo $query . "<br/>";
    }
    switch ($type) {
      case "query":
        return $this->dbConnection->DoQuery($this->link, $query);
        break;
      case "insert":
        return $this->dbConnection->DoQueryInsertId($this->link, $query);
        break;
      case "delete":
        return $this->dbConnection->DoQuery($this->link, $query);
        break;
      case "update":
        return $this->dbConnection->DoQuery($this->link, $query);
        break;
    }
  }

  public function MakeSelectQuery($table, $fields = array(), $condition = '', $joinTables = array(), $sorting = '', $groupby = '')
  {
    $query  = "select " . implode(", ", $fields) . " from " . $table . ' ';
    if (is_array($joinTables) && sizeof($joinTables) > 0) {
      foreach ($joinTables as $joint) {
        $query .= $joint;
      }
    }
    if ($condition != '') {
      $query .= " where " . $condition;
    }
    if ($groupby != '') {
      $query .= " group by " . $groupby;
    }
    if ($sorting != '') {
      $query .= " order by " . $sorting;
    }
    return $query;
  }

  public function MakeInsertQuery($table, $fields = array())
  {

    foreach ($fields as $key => $value) {
      $fields[$key] = str_replace("'", "''", $value);
    }

    $query = "insert into " . $table . " (";
    $query .= implode(", ", array_keys($fields));
    $query .= ") values ('" .  implode("','", array_values($fields)) . "')";
    return $query;
  }

  public function MakeDeleteQuery($table, $fields = array())
  {
    $query = "delete from " . $table . " where ";
    $condition = array();
    foreach ($fields as $key => $value) {
      array_push($condition, $key . ' = ' . $value);
    }
    $query .= implode(" and ", $condition);
    return $query;
  }

  public function MakeUpdateQuery($table, $fields = array(), $condition = '')
  {
    foreach ($fields as $key => $value) {
      $fields[$key] = str_replace("'", "''", $value);
    }

    $query = "update " . $table . " set ";
    $updateSet = array();
    foreach ($fields as $key => $value) {
      if ($key != 'id') {
        array_push($updateSet, $key . " = '" . $value . "' ");
      }
    }
    $query .= implode(" , ", $updateSet);
    $query .= ' where ' . $condition;

    return $query;
  }

  public function GetIdfromText($text = '', $name = '', $table = '')
  {
    $result = $this->QueryDB($table, array('id'), 'query', $name . ' = \'' . $text . '\'');
    if ($row = mysqli_fetch_array($result)) {
      return $row[0];
    }
  }

  public function GetTextfromId($id = 0, $name = '', $table = '')
  {
    $result =  $this->QueryDB($table, array($name), 'query', 'id = ' . $id);
    if ($row = mysqli_fetch_array($result)) {
      return $row[0];
    }
  }

  public function InsertWhenNotExist($text, $name, $table)
  {
    $id = $this->GetIdfromText($text, $name, $table);
    if ($id == 0) {
      $fields = array($name => $text);
      $id =  $this->QueryDB($table, $fields, 'insert');
    }
    return $id;
  }
}
