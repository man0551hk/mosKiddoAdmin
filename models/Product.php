<?php
class Product
{
  public $fieldList = array();

  public function __construct()
  {
    $this->fieldList = [
      new Field("productName", true),
      new Field("categoryId", true),
      new Field("description", true),
      new Field("totalQuantity", true),
      new Field("maxQtyPerOrder", true),
      new Field("option1", true),
      new Field("option2", true),
      new Field("price", true),
    ];
  }
}
