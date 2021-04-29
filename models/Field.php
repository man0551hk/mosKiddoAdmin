<?php
class Field
{
  public $fieldName = "";
  public $requried = false;
  public $isSaveField = true;
  public $value = null;

  public function __construct(
    $fieldName = "",
    $requried = false,
    $isSaveField = true,
    $value = null
  ) {
    $this->fieldName = strtolower($fieldName);
    $this->requried = $requried;
    $this->isSaveField = $isSaveField;
    $this->value = $value;
  }
}
