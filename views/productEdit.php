<?php
$productId = isset($_GET["id"]) ? $_GET["id"] : 0;
if (!empty($_POST)) {
  if (isset($_POST["action"]) && $_POST["action"] == "saveProduct") {
    $returnMsg = $this->productController->SaveProduct();
    if (isset($returnMsg["id"])) {
      // Url::redirect("productEdit/" . $returnMsg["id"] . "/");
    }
  }
}
$product = $this->productController->GetProduct($productId);
?>
<section role="main" class="content-body">
  <header class="page-header">
    <h2>Create/Edit Product</h2>

    <div class="right-wrapper pull-right">
      <ol class="breadcrumbs" style="padding-right:15px">
        <li>
          <a href="<?= Url::getDomain() ?>">
            <i class="fa fa-home"></i>
          </a>
        </li>
        <li><span>Create/Edit Product</span></li>
      </ol>
    </div>
  </header>

  <div class="row">
    <div class="panel-body">
      <form method="POST" onsubmit="return checkProduct(<?= $productId == 0 ? 1 : 0 ?>)" enctype="multipart/form-data">
        <?php
        if ($productId != 0) {
          UI::CreateHidden("productId", $productId);
        }
        UI::CreateElement("productName", "", "Product Name", "text", null, UI::ReturnEmpty($product, "productName"), false, false, "top", "", false, "col-md-12", true);
        $fields = array("categoryId", "categoryName");
        $rs = $this->dbController->QueryDB("category", $fields, "query");
        $categoryOptions = $this->commonController->ConvertResultToOption($rs);
        UI::CreateElement("categoryId", "", "Category", "dropdown",  $categoryOptions, UI::ReturnEmpty($product, "categoryId"), false, false, "top", "", false, "col-md-12", true);
        UI::CreateElement("description", "", "Description", "textarea", null, UI::ReturnEmpty($product, "description"), false, false, "top", "", false, "col-md-12", true);
        UI::CreateElement("totalQuantity", "", "Total Quantity", "text", null, UI::ReturnEmpty($product, "totalQuantity"), false, false, "top", "isNumber", false, "col-md-12", true);
        UI::CreateElement("maxQtyPerOrder", "", "Max Quantity Per Order", "text", null, UI::ReturnEmpty($product, "maxQtyPerOrder"), false, false, "top", "isNumber", false, "col-md-12", true);
        UI::CreateElement("option1", "", "Option set 1 (use comma , to separate options)", "text", null, UI::ReturnEmpty($product, "option1"), false, false, "top", "", false, "col-md-12", true);
        UI::CreateElement("option2", "", "Option set 2 (use comma , to separate options)", "text", null, UI::ReturnEmpty($product, "option2"), false, false, "top", "", false, "col-md-12", true);
        UI::CreateElement("price", "", "Price", "text", null, UI::ReturnEmpty($product, "price"), false, false, "top", "isNumber", false, "col-md-12", true);

        if (isset($product->imageList)) {
        ?>
          <section class="panel panel-info">
            <div class="panel-body panel-info">
              <div class="row">
                <?php
                foreach ($product->imageList as $image) {
                ?>
                  <div class="col-md-1">
                    <img src="<?= Url::getImageDomain() . "productImages/" .  $image ?>" height="100" /><br />
                    <!-- <a href="#" class="btn btn-sm btn-danger">Delete</a> -->
                  </div>
                <?php
                }
                ?>
              </div>
            </div>
          </section>
        <?php
        }
        UI::CreateElement("images", "", "Images (support multi photos)", "file", null, "", false, false, "top", 'multiple="multiple"', false, "col-md-12", true);
        UI::CreateButton("action", "saveProduct", "btn btn-block btn-primary", "Save Product", "top");
        if ($productId != 0) {
          UI::CreateButton("action", "deleteProduct", "btn btn-block btn-danger", "Archive Product", "top");
        }
        if (isset($returnMsg["error"])) {
          // echo '<div class="alert alert-danger">' . implode(",", $returnMsg["error"]) . '</div>';
        }
        ?>
      </form>
    </div>
  </div>
</section>