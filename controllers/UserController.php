<?php
class UserController
{
  private $dbController;
  private $commonController;
  public function __construct($dbController, $commonController)
  {
    $this->dbController = $dbController;
    $this->commonController = $commonController;
  }

  public function checkLogin()
  {
    $fields = array("name", "id", "password");
    $loginName = $_POST["loginName"];
    $condition = array("loginName = '$loginName'");
    $rs = $this->dbController->QueryDB("user", $fields, "query", $condition, false, false, false, false);
    $isLogin = false;
    if ($row = mysqli_fetch_array($rs)) {
      $password = $row["password"];
      if (Encrypt::decryptIt($password) == $_POST["pwd"] && $_POST["verifyCode"] == Session::get("verifyCode")) {
        $isLogin = true;
        $id = $row["id"];
        $name = $row["name"];
        $user = array(
          "id" => $id,
          "name" => $name,
        );
        Session::set("userCookie", $user);
        Session::set("positionId", 1);
        Session::set("name", $name);
        Url::redirect("");
      }
    }
    if ($isLogin == false) {
      return "Invalid Login";
    }
  }
}
