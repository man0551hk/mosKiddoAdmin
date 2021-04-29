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
      new Field("size", true),
      new Field("color", true),
      new Field("price", true),
    ];
  }
}
