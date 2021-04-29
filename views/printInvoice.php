<?php
$id = isset($_GET["id"]) ? $_GET["id"] : 0;
if ($id == 0) {
  Url::redirect("");
}
$order = $this->ordersController->GetOrderDetail($id);
?>
<html>

<head>
  <title>SHCC eShop- Invoice</title>
  <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="<?= Url::getDomain() ?>assets/vendor/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="<?= Url::getDomain() ?>assets/stylesheets/invoice-print.css" />
</head>

<body>
  <div class="invoice">
    <header class="clearfix">
      <div class="row">
        <div class="col-sm-6 mt-md">
          <img src="<?= Url::getDomain() ?>assets/images/shccLogo.png" />
        </div>
        <div class="col-sm-6 text-right mt-md mb-md">
          <div class="ib">
            <h2 class="h2 mt-none mb-sm text-dark text-bold">INVOICE</h2>
            <h4 class="h4 m-none text-dark text-bold">#<?= sprintf('%08d', $order["orderId"]) ?></h4>
            <br />
          </div>
        </div>
      </div>
    </header>
    <div class="bill-info">
      <div class="row">
        <div class="col-md-6">
          <div class="bill-to">
            <p class="h5 mb-xs text-dark text-semibold">To:</p>
            <address>
              Name: <?= $order["name"] ?>
              <br />
              Delivery: <?= $order["delivery"] ?>
              <br />
              Phone: <?= $order["mobile"] ?>
              <br />
              Email: <?= $order["email"] ?>
            </address>
          </div>
        </div>
        <div class="col-md-6">
          <div class="bill-data text-right">
            <p class="mb-none">
              <span class="text-dark">Invoice Date:</span>
              <span class="value"><?= date('Y-m-d', strtotime($order["createdDate"]))  ?></span>
            </p>
            <!-- <p class="mb-none">
              <span class="text-dark">Due Date:</span>
              <span class="value">06/20/2014</span>
            </p> -->
          </div>
        </div>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table invoice-items">
        <thead>
          <tr class="h4 text-dark">
            <th id="cell-id" class="text-semibold">#</th>
            <th id="cell-item" class="text-semibold">Item</th>
            <th id="cell-desc" class="text-semibold">Description</th>
            <th id="cell-price" class="text-center text-semibold">Price</th>
            <th id="cell-qty" class="text-center text-semibold">Quantity</th>
            <th id="cell-total" class="text-center text-semibold">Total</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $grandTotal = 0;
          foreach ($order["data"] as $d) {
            $grandTotal += $d->sumAmount;
          ?>
            <tr>
              <td><?= sprintf('%04d', $d->productId)  ?></td>
              <td><?= $d->productname ?></td>
              <td>
                <?php
                $description = [];
                if (isset($d->size)) {
                  $description[] = "Size: " . $d->size;
                }
                if (isset($d->color)) {
                  $description[] = "Color: " . $d->color;
                }
                echo implode("<br/>", $description);
                ?>
              </td>
              <td class="text-center">$<?= $d->price ?></td>
              <td class="text-center"><?= $d->qty ?></td>
              <td class="text-center">$<?= $d->sumAmount ?></td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>

    <div class="invoice-summary">
      <div class="row">
        <div class="col-sm-4 col-sm-offset-8">
          <table class="table h5 text-dark">
            <tbody>
              <!-- <tr class="b-top-none">
                <td colspan="2">Subtotal</td>
                <td class="text-left">$73.00</td>
              </tr>
              <tr>
                <td colspan="2">Shipping</td>
                <td class="text-left">$0.00</td>
              </tr> -->
              <tr class="b-top-none">
                <td colspan="2">Grand Total</td>
                <td class="text-left">$<?= $grandTotal ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script>
    window.print();
  </script>
</body>

</html>