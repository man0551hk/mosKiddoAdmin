<?php
class ProductController
{
  private $dbController;
  private $commonController;
  public function __construct($dbController, $commonController)
  {
    $this->dbController = $dbController;
    $this->commonController = $commonController;
  }

  public function SaveCategory()
  {
    $categoryId = isset($_POST[strtolower("categoryId")]) ? $_POST[strtolower("categoryId")] : 0;
    $categoryName = $_POST[strtolower("categoryName")];
    $fields = array(
      "categoryName" => $categoryName
    );
    if ($categoryId == 0) {
      $categoryId = $this->dbController->QueryDB("category", $fields, "insert");
    } else {
      $this->dbController->QueryDB("category", $fields, "update", "categoryId = $categoryId");
    }
    return $categoryId;
  }

  public function GetCategory($categoryId)
  {
    $fields = array("categoryName");
    $rs = $this->dbController->QueryDB("category", $fields, "query", "categoryId = $categoryId");
    return $this->commonController->ConvertResultToOneRecord($rs);
  }

  public function GetCategoryList()
  {
    $fields = array("categoryId", "categoryName");
    $rs = $this->dbController->QueryDB("category", $fields, "query");
    $data = [];
    while ($row = mysqli_fetch_array($rs)) {
      $data[] = array(
        "categoryId" => $row["categoryId"],
        "categoryName" => $row["categoryName"]
      );
    }
    return $data;
  }


  public function convertProductData($isNewInsert = false)
  {
    $product = $this->commonController->ValidateFields(new Product());
    if (isset($product["data"])) {
      $saveableObj = $this->commonController->ConvertToSaveableObject($product["data"]);
      if ($isNewInsert === true) {
        $saveableObj["createDate"] = date('Y-m-d');
      } else {
        $saveableObj["updateDate"] = date('Y-m-d');
      }
      $product["data"] = $this->commonController->omit($saveableObj);
    }
    return $product;
  }

  public function SaveProduct()
  {
    $productId = isset($_POST[strtolower("productId")]) ? $_POST[strtolower("productId")] : 0;

    $product = $this->convertProductData();

    if (!empty($product["error"])) {
      return array("error" => $product["error"]);
    } else {
      $product["data"]["description"] = $this->commonController->ReplaceEmpty($product["data"]["description"]);
      if (isset($_FILES["images"]) && $_FILES["images"]["error"][0] == 0) {

        $product["data"]["imageList"] = $this->commonController->SaveFile($_FILES["images"], 0, "imagesGallery/productImages");
      }
      $product["data"]["option1"] = explode(",",  $product["data"]["option1"]);
      $product["data"]["option2"] = explode(",",  $product["data"]["option2"]);

      if ($productId == 0) {
        $product["data"]["createDate"] = date("Y-m-d");
        $fields = array(
          "data" => json_encode($product["data"], JSON_UNESCAPED_UNICODE),
          "categoryId" =>  $product["data"]["categoryid"]
        );
        $productId = $this->dbController->QueryDB("product", $fields, "insert");
      } else {
        $fields = array("data");
        $condition = "productId = $productId";
        $rs = $this->dbController->QueryDB("product", $fields, "query", $condition);
        $data = [];
        if ($row = mysqli_fetch_array($rs)) {
          $data = json_decode($row["data"]);
        }
        $imageList = isset($data->imageList) ? $data->imageList : null;
        foreach ($product["data"] as $key => $value) {
          $data->$key = $value;
        }
        if (!isset($product["data"]["imageList"])) {
          $product["data"]["imageList"] = $imageList;
        }
        $product["data"]["updateDate"] = date("Y-m-d");
        $fields = array(
          "data" => json_encode($product["data"], JSON_UNESCAPED_UNICODE),
          "categoryId" =>  $product["data"]["categoryid"]
        );
        $this->dbController->QueryDB("product", $fields, "update",  $condition, "", "", "", true);
      }
      return array("id" => $productId);
    }
  }

  public function GetProduct($productId)
  {
    $fields = array("data");
    $rs = $this->dbController->QueryDB("product", $fields, "query", "productId = $productId");
    $rs = $this->commonController->ConvertResultToOneRecord($rs);
    $data = json_decode($rs);
    if (isset($data->description)) {
      $breaks = array("<br />", "<br>", "<br/>");
      $data->description = str_ireplace($breaks, "\r\n", $data->description);
    }
    if (isset($data->option1)) {
      $data->option1 = implode(",", $data->option1);
    }
    if (isset($data->option2)) {
      $data->option2 = implode(",",   $data->option2);
    }
    return $data;
  }

  public function GetProductList()
  {
    $fields = array(
      "p.productId",
      "p.data",
      "c.categoryName"
    );
    $joint = array(
      " inner join category c on c.categoryId = p.categoryId"
    );
    $rs = $this->dbController->QueryDB("product p", $fields, "query", null, $joint);
    $data = [];
    while ($row = mysqli_fetch_array($rs)) {
      $product = json_decode($row["data"]);
      $data[] = array(
        "productId" => $row["productId"],
        "productName" => $product->productname,
        "categoryName" => $row["categoryName"]
      );
    }
    return $data;
  }
}
