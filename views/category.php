<section role="main" class="content-body">
  <header class="page-header">
    <h2>Category</h2>

    <div class="right-wrapper pull-right">
      <ol class="breadcrumbs" style="padding-right:15px">
        <li>
          <a href="<?= Url::getDomain() ?>">
            <i class="fa fa-home"></i>
          </a>
        </li>
        <li><span>Category</span></li>
      </ol>
    </div>
  </header>

  <div class="row">
    <a href="<?= Url::getDomain() ?>categoryEdit/" class="btn btn-primary">Create Category</a>
    <div class="panel-body">
      <table class="table table-bordered table-striped table-condensed mb-none">
        <thead>
          <tr>
            <th>Name</th>
            <th>Detail</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $list = $this->productController->GetCategoryList();
          foreach ($list as $d) {
          ?>
            <tr>
              <td><?= $d["categoryName"] ?></td>
              <td><a href="<?= Url::getDomain() ?>categoryEdit/<?= $d["categoryId"] ?>/" class="btn btn-primary">Detail</a></td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</section>