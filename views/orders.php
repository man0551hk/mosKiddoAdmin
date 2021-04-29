<section role="main" class="content-body">
  <header class="page-header">
    <h2>Orders</h2>

    <div class="right-wrapper pull-right">
      <ol class="breadcrumbs" style="padding-right:15px">
        <li>
          <a href="<?= Url::getDomain() ?>">
            <i class="fa fa-home"></i>
          </a>
        </li>
        <li><span>Orders</span></li>
      </ol>
    </div>
  </header>

  <div class="row">
    <div class="panel-body">
      <table class="table table-bordered table-striped table-condensed mb-none" id="orderList">
        <thead>
          <tr>
            <th>Order Id</th>
            <th>Created Date</th>
            <th>Updated Date</th>
            <th>Contact</th>
            <th>Delivery</th>
            <th>Total Amount</th>
            <th>Status</th>
            <th>Edit</th>
          </tr>
        </thead>
        </tbody>
      </table>
    </div>
  </div>
</section>

<?php

// $data = [
//   array("productId" => 1, "productname" => "test 1", "qty" => 1, "price" => 100, "sumAmount" => 100, "size" => "XL", "color" => "Black"),
//   array("productId" => 1, "productname" => "test 2", "qty" => 2, "price" => 100, "sumAmount" => 200, "size" => "L", "color" => "White"),
// ];

// echo json_encode($data);
?>