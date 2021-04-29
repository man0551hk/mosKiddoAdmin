<section role="main" class="content-body">
  <header class="page-header">
    <h2>Product</h2>

    <div class="right-wrapper pull-right">
      <ol class="breadcrumbs" style="padding-right:15px">
        <li>
          <a href="<?= Url::getDomain() ?>">
            <i class="fa fa-home"></i>
          </a>
        </li>
        <li><span>Product</span></li>
      </ol>
    </div>
  </header>

  <div class="row">
    <a href="<?= Url::getDomain() ?>productEdit/" class="btn btn-primary">Create Product</a>
    <div class="panel-body">
      <table class="table table-bordered table-striped table-condensed mb-none" id="orderList">
        <thead>
          <tr>
            <th>Name</th>
            <th>Category</th>
            <th>Detail</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $productList = $this->productController->GetProductList();
          foreach ($productList as $p) {
          ?>
            <tr>
              <td><?= $p["productName"] ?></td>
              <td><?= $p["categoryName"] ?></td>
              <td><a href="<?= Url::getDomain() ?>productEdit/<?= $p["productId"] ?>/" class="btn btn-primary">Detail</a></td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</section>