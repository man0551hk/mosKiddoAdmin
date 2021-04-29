<?php
$refreshLink = "categoryEdit/";
$categoryId = isset($_GET["id"]) ? $_GET["id"] : 0;
if (!empty($_POST)) {
  if (isset($_POST["action"]) && $_POST["action"] == "saveCategory") {
    $categoryId = $this->productController->SaveCategory();
    $refreshLink .=  $categoryId . "/";
  }
} else if ($categoryId > 0) {
  $refreshLink .=  $categoryId . "/";
}
$categoryName = $this->productController->GetCategory($categoryId);
?>
<section role="main" class="content-body">
  <header class="page-header">
    <h2>Create/Edit Category</h2>

    <div class="right-wrapper pull-right">
      <ol class="breadcrumbs" style="padding-right:15px">
        <li>
          <a href="<?= Url::getDomain() ?>">
            <i class="fa fa-home"></i>
          </a>
        </li>
        <li><span>Create/Edit Category</span></li>
      </ol>
    </div>
  </header>

  <div class="row">
    <div class="panel-body">
      <form method="POST" onsubmit="return checkCategory()">
        <?php
        if ($categoryId != 0) {
          UI::CreateHidden("categoryId", $categoryId);
        }
        UI::CreateHidden("refresh", 1);
        UI::CreateElement("categoryName", "", "Category Name", "text", null, $categoryName, false, false, "top", "", false, "col-md-12", true);
        UI::CreateButton("action", "saveCategory", "btn btn-primary", "Save Category", "top");
        ?>
      </form>
    </div>
  </div>
</section>