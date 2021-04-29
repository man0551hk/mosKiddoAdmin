<?php
$orderId = isset($_GET["id"]) ? $_GET["id"] : 0;
if ($orderId == 0) {
  Url::redirect("");
}
if (isset($_POST)) {
  if (isset($_POST["action"]) && $_POST["action"] == "updateOrderStatus") {
    $this->ordersController->UpdateOrderStatus();
  }
}
$order = $this->ordersController->GetOrderDetail($orderId);
?>
<section role="main" class="content-body">
  <header class="page-header">
    <h2>Order Detail</h2>

    <div class="right-wrapper pull-right">
      <ol class="breadcrumbs" style="padding-right:15px">
        <li>
          <a href="<?= Url::getDomain() ?>">
            <i class="fa fa-home"></i>
          </a>
        </li>
        <li><span>Order Detail</span></li>
      </ol>
    </div>
  </header>

  <div class="row">
    <div class="panel-body">
      <h4>Status: <?= $this->ordersController->ConvertStatus($order["status"]) ?></h4>
      <?php if ($order["status"] < 3) { ?>
        <a href="#updateOrderStatusModal" class="modal-basic btn btn-success">Update Status</a>
      <?php }  ?>

    </div>
  </div>

  <div class="row">
    <div class="panel-body">
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
                  <!-- <tr class="h4"> -->
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

      <div class="text-right mr-lg">
        <a href="<?= Url::getDomain() ?>printInvoice/<?= $order["orderId"] ?>/" target="_blank" class="btn btn-primary ml-sm"><i class="fa fa-print"></i> Print</a>
      </div>
    </div>
  </div>
</section>

<div id="updateOrderStatusModal" class="modal-block modal-header-color modal-block-success mfp-hide">
  <section class="panel">
    <header class="panel-heading">
      <h2 class="panel-title">Update Order Status</h2>
    </header>
    <div class="panel-body">
      <div class="modal-wrapper">
        <div class="modal-icon">
          <i class="fa fa-question-circle"></i>
        </div>
        <div class="modal-text">
          <h4>Update Order Status</h4>
          <p>Comfirm change status to <b><?= $this->ordersController->ConvertStatus($order["status"] + 1) ?></b></p>
        </div>
      </div>
    </div>
    <footer class="panel-footer">
      <div class="row">
        <div class="col-md-12 text-right">
          <form method="POST">
            <input type="hidden" name="orderId" id="orderId" value="<?= $orderId ?>">
            <input type="hidden" name="status" id="status" value="<?= $order["status"] + 1 ?>">
            <div class="col-md-12 text-right">
              <button type="submit" id="action" name="action" value="updateOrderStatus" class="btn btn-primary modal-confirm">Confirm</button>
              <button class="btn btn-default modal-dismiss">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </footer>
  </section>
</div>