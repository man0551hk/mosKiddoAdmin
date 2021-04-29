<?php

$modelFiles = scandir(Url::modelsFolderPath());
if (is_array($modelFiles)) {
  foreach ($modelFiles as $modelFile) {
    if (strpos($modelFile, ".php") > -1) {
      include_once(Url::modelsFolderPath() . $modelFile);
    }
  }
}

$controllers = scandir(Url::controllersFolderPath());
if (is_array($controllers)) {
  foreach ($controllers as $controller) {
    if (strpos($controller, ".php") > -1 && $controller != 'PageController.php') {
      include_once(Url::controllersFolderPath() . $controller);
    }
  }
}

class PageController
{
  public $link;
  public $dbConnection;
  public $dbController;
  public $commonController;
  public $userController;
  public $productController;
  public $albumController;
  public $blogController;
  public $ordersController;

  public function __construct()
  {
    $this->dbConnection = new DbConnection();
    $this->link = $this->dbConnection->GetConnection();
    $this->dbController = new DBController($this->dbConnection, $this->link);
    $this->commonController = new CommonController($this->dbController);
    $this->userController = new UserController($this->dbController, $this->commonController);
    $this->productController = new ProductController($this->dbController, $this->commonController);
     $this->ordersController = new OrdersController($this->dbController, $this->commonController);
  }

  public function show($pageName)
  {
    if ($pageName == "logout.php") {
      Session::set("userCookie", null);
      Url::redirect();
    }

    if (strpos($pageName, "Api") >  -1) {
      include Url::getPath("api") . $pageName;
    } else {

      if ($pageName != "logout.php" && $pageName != "login.php") {
        if (Session::get("userCookie") == "") {
          Url::redirect("login/");
        }
      }

      if ($pageName == "login.php" || $pageName == "statementPdf.php" || $pageName == "printInvoice.php") {
        include Url::getPath("views") . $pageName;
      } else {
        include Url::getPath("views") . 'header.php';
        include Url::getPath("views") . 'menu.php';
        if (file_exists(Url::getPath("views")  .  $pageName)) {
          include Url::getPath("views")  . $pageName;
        }
        include Url::getPath("views") . 'footer.php';
      }
    }
  }
}
