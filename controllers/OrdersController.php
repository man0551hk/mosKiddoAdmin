<?php
class OrdersController
{
  private $dbController;
  private $commonController;
  public function __construct($dbController, $commonController)
  {
    $this->dbController = $dbController;
    $this->commonController = $commonController;
  }

  public function GetOrderList()
  {
    $draw = 20;
    if (isset($_POST['draw'])) {
      $draw = $_POST['draw'];
    }
    $row = 0;
    if (isset($_POST["start"])) {
      $row = $_POST['start'];
    }
    $rowperpage = 20; // Rows display per page
    if (isset($_POST["length"])) {
      $rowperpage = $_POST['length'];
    }

    $searchValue = '';
    if (isset($_POST['search'])) {
      $searchValue = $_POST['search']['value']; // Search value
    }

    $conditions = [];
    $condition = "";
    if ($searchValue != "") {
      $conditions = array(
        " name like '%" . $searchValue . "%'",
        " email like '%" . $searchValue . "%'",
        " mobile like '%" . $searchValue . "%'",
        " delivery like '%" . $searchValue . "%'",
        " totalAmount like '%" . $searchValue . "%'",
        " data like '%" . $searchValue . "%'",
      );
      if (sizeof($conditions) > 0) {
        $condition = implode(' or ', $conditions);
      }
    }

    $totalRecordwithFilter = 0;


    $fields = array(
      "orderId",
      "concat(name, '<br/>', email, '<br/>', mobile) as contact",
      "delivery",
      "totalAmount",
      "status",
      "createdDate",
      "updatedDate"
    );

    $orderBy = " createdDate desc";
    if (isset($_POST['order']) && isset($_POST['order'][0])) {
      switch ($_POST['order'][0]['column']) {
        case 0:
          $orderBy = " orderId " .  $_POST['order'][0]['dir'] . " ";
          break;
        case 1:
        default:
          $orderBy = " createdDate " .  $_POST['order'][0]['dir'] . " ";
          break;
        case 2:
          $orderBy = " updatedDate " .  $_POST['order'][0]['dir'] . " ";
          break;
        case 3:
          $orderBy = " contact " .  $_POST['order'][0]['dir'] . " ";
          break;
        case 4:
          $orderBy = " delivery " .  $_POST['order'][0]['dir'] . " ";
          break;
        case 5:
          $orderBy = " totalAmount " .  $_POST['order'][0]['dir'] . " ";
          break;
        case 6:
          $orderBy = " status " .  $_POST['order'][0]['dir'] . " ";
          break;
      }
    }
    $orderBy .= " limit " . $row . "," . $rowperpage;

    $totalRs = $this->dbController->QueryDB("orders", array("count(*) as total"), 'query', $condition, null, null, '', false);
    $totalRecordwithFilter = $this->commonController->ConvertResultToOneRecord($totalRs);

    $result = $this->dbController->QueryDB("orders", $fields, 'query', $condition, null, $orderBy, null, false);
    $datas = [];
    while ($row = mysqli_fetch_array($result)) {

      $datas[] = array(
        "orderId" => sprintf('%08d', $row["orderId"]),
        "createdDate" => $row["createdDate"],
        "updatedDate" => $row["updatedDate"],
        "contact" => $row["contact"],
        "delivery" =>  $row["delivery"],
        "totalAmount" => $row["totalAmount"],
        "status" => $this->ConvertStatus($row["status"]),
        "edit" => "<a href = '" . Url::getDomain() . "orderDetail/" . $row["orderId"] . "/' class = 'btn btn-primary'>Edit</a>",
      );
    }
    $response = array(
      "draw" => intval($draw),
      "iTotalRecords" => $totalRecordwithFilter,
      "iTotalDisplayRecords" => $totalRecordwithFilter,
      "aaData" => $datas,
    );
    echo json_encode($response);
  }

  public function ConvertStatus($status)
  {
    switch ($status) {
      case 0:
        return "Pending";
        break;
      case 1:
        return "Paid, waiting to delivery/pickup";
        break;
      case 2:
        return "Deliverying";
        break;
      case 3:
        return "Completed";
        break;
    }
  }

  public function GetOrderDetail($orderId)
  {
    $fields = array(
      "orderId",
      "name",
      "email",
      "mobile",
      "delivery",
      "totalAmount",
      "data",
      "status",
      "createdDate",
      "updatedDate"
    );
    $rs = $this->dbController->QueryDB("orders", $fields, "query", "orderId = $orderId");
    if ($row = mysqli_fetch_array($rs)) {
      $data = array(
        "orderId" => $row["orderId"],
        "name" => $row["name"],
        "email" => $row["email"],
        "mobile" => $row["mobile"],
        "delivery" => $row["delivery"],
        "totalAmount" => $row["totalAmount"],
        "data" => json_decode($row["data"]),
        "status" => $row["status"],
        "createdDate" => $row["createdDate"],
        "updatedDate" => $row["updatedDate"],
      );
      return $data;
    }
  }

  public function UpdateOrderStatus()
  {
    $orderId = $_POST['orderId'];
    $fields = array(
      "status" => $_POST['status']
    );
    $this->dbController->QueryDB("orders", $fields, "update", "orderId = $orderId");
  }
}
