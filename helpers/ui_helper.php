<?php
class UI
{
  public static function CreateMenu($url, $name, $chiName = "", $subMenu = [], $icon)
  {
    $name = str_replace("/", "", $name);
    if (in_array(Session::get('positionId'),  Permission::$page[str_replace(' ', '', strtolower($name))])) {
      if (sizeof($subMenu) == 0) {
        echo '<li class="nav-active"><a href="' . Url::getDomain() . $url . '"><i class="fa ' . $icon . '" aria-hidden="true"></i><span>' . $chiName . ' ' . $name . '</span></a></li>';
      } else {
        echo '<li class="nav-parent">';
        echo '<a>';
        echo '<i class="fa ' . $icon . '" aria-hidden="true"></i>';
        echo '<span>' . $chiName . ' ' . $name . '</span>';
        echo '</a>';
        echo '<ul class="nav nav-children">';
        for ($i = 0; $i < sizeof($subMenu); $i++) {
          if (in_array(Session::get('positionId'),  Permission::$page[str_replace(' ', '', strtolower($subMenu[$i][1]))])) {
            echo '<li>';
            echo '<a href="' . Url::getDomain() .  $subMenu[$i][0] . '">';
            echo '<i class="fa ' . $subMenu[$i][4] . '" aria-hidden="true"></i>';
            echo '<span>' . $subMenu[$i][2] . ' ' . $subMenu[$i][1] . '</span>';
            echo '</a>';
            echo '</li>';
          }
        }
        echo '</ul>';
        echo '</li>';
      }
    }
  }

  public static function DisplayAlert($msg)
  {
    if ($msg != "") {
      echo '<div class="alert alert-warning" role="alert" id = "alertDiv">' . $msg . '</div>';
    }
  }

  public static function ConvertToName($name)
  {
    $name = str_replace('/', '_', $name);
    $name = str_replace('(', '', $name);
    $name = str_replace(')', '', $name);
    $name = str_replace(' ', '', $name);
    $name = str_replace('#', '', $name);
    $name = str_replace('*', '', $name);
    $name = str_replace('-', '', $name);
    $name = str_replace('(Vendor)', 'vendor', $name);
    return strtolower($name);
  }

  public static function DisplayName($name, $isIndex = false)
  {
    if ($isIndex) {
      $index = strpos($name, '_');
      return substr($name, 0,  $index);
    }
    return $name;
  }

  public static function CreateElementSet($elements)
  {
    echo '<div class="row form-group">';
    foreach ($elements as $e) {
      UI::CreateElement(
        $e["name"],
        $e["chiName"],
        $e["engName"],
        $e["type"],
        isset($e["options"]) ? $e["options"] : null,
        isset($e["value"]) ? $e["value"] : null,
        isset($e["withoutLabel"]) ? $e["withoutLabel"] : null,
        isset($e["hide"]) ? $e["hide"] : null,
        $e["permission"],
        isset($e["addOn"]) ? $e["addOn"] : null,
        isset($e["isIndex"]) ? $e["isIndex"] : null,
        isset($e["col"]) ? $e["col"] : null,
        false
      );
    }
    echo '</div>';
  }

  public static function CreateElement($name = '', $chiName = '', $engName = '', $type = '', $options = array(), $value = '', $withoutLabel = false, $hide = false, $permission = '', $addOn = '', $isIndex = false, $col = "", $needRow = true)
  {
    switch ($type) {
      case "text":
        self::CreateText($name, $chiName, $engName, $value, $addOn, $permission, $isIndex, $withoutLabel, $col, $needRow);
        break;
      case "dropdown":
        self::CreateDropDown($name, $chiName, $engName, $options, $value, $withoutLabel, $hide, $permission, $addOn, $col, $needRow);
        break;
      case "hidden":
        self::CreateHidden($name, $value);
        break;
      case "file":
        self::CreateFileSelector($name, $chiName, $engName, $permission, $value, $addOn, $col, $needRow);
        break;
      case "imagePdf":
        self::CreatePopup($name, $value, $permission);
        break;
      case "radio":
        self::CreateRadio($name, $chiName, $engName, $options, $value, $permission, $col, $needRow);
        break;
      case "password":
        self::CreatePassword($name, $value);
        break;
      case "date":
        self::CreateDateSelector($name, $chiName, $engName, $value, $permission, $withoutLabel, $col, $needRow);
        break;
      case "checkbox":
        self::CreateCheckbox($name, $chiName, $engName, $options, $value, $permission, $col, $needRow);
        break;
      case "button":
        self::CreateButton($name, $value, $addOn, $chiName . " " .  $engName, $permission);
      case "textEditor":
        self::CreateTextEditor($name, $chiName, $engName, $value, $permission, $withoutLabel, $col, $needRow);
      case "textarea":
        self::CreateTextarea($name, $chiName, $engName, $value, $permission, $withoutLabel, $col, $needRow);
    }
  }

  public static function removeBox($text)
  {
    return str_replace("]", "", str_replace("[", "", $text));
  }

  public static function objArraySearch($array, $key, $value)
  {
    foreach ($array as $arrayInf) {
      if ($arrayInf->{$key} == $value) {
        return $arrayInf;
      }
    }
    return null;
  }

  public static function CreateCheckbox($name = '', $chiName = '', $engName = '', $radioSet = array(), $value = '', $permission = '', $col = '', $needRow = '')
  {
    if ($needRow == true) {
      echo '<div class = "row">';
    }
    echo '<div class="' . $col . '">';
    echo '<div class="form-group">';
    echo '<label class="control-label">' . $chiName . ' ' . $engName . '</label><br/>';
    if ($permission != null && in_array(Session::get("positionId"), Permission::$setting[$permission])) {
      foreach ($radioSet as $option) {
        $checked = '';
        if (is_array($value)) {
          foreach ($value as $v) {
            if ($option->value == $v) {
              $checked = 'checked';
            }
          }
        } else {
          $checked = $option->value == $value ? 'checked' : '';
        }
        echo '<label class="checkbox-inline">';
        echo '<input type="checkbox" id="' . self::removeBox(self::ConvertToName($name)) . '" name="' . self::ConvertToName($name) . '" value = "' . $option->value . '" ' .  $checked . '>';
        echo $option->text;
        echo '</label>';
      }
      echo '<div id = "' . self::removeBox(self::ConvertToName($name)) . 'Error" ></div>';
    } else {
      $option = UI::objArraySearch($radioSet, "value", $value);
      echo ' ' . $option->text;
    }
    echo '</div>';
    echo '</div>';

    if ($needRow == true) {
      echo '</div>';
    }
  }

  public static function CreateButton($name, $value, $addOn = '', $text = "", $permission = '')
  {
    // echo '<div class="form-group row">';
    // echo '<div class="col-md-9 offset-md-3 ">';
    // if (in_array(Session::get("positionId"), Permission::$setting[$permission])) {
    //   echo '<button name = "' . self::ConvertToName($name) . '" id = "' . self::ConvertToName($name) . '" class = "btn btn-' . $addOn . ' btn-block">' . $value . '</button>';
    // }
    // echo '</div>';
    // echo '</div>';

    if ($permission != null && in_array(Session::get("positionId"), Permission::$setting[$permission])) {
      echo '<div class="form-group">';
      echo '<button type="submit" value="' . $value . '" name="' . $name . '" id="' . $name . '" class="btn ' . $addOn . '">' . $text . '</button>';
      echo '</div>';
    }
  }

  public static function CreateDateSelector($name, $chiName, $engName, $value, $permission, $withoutLabel  = false, $col, $needRow)
  {
    if ($needRow == true) {
      echo '<div class = "row">';
    }
    echo '<div class="' . $col . '">';
    echo '<div class="form-group">';
    if ($withoutLabel == false) {
      echo '<label class="control-label">' . $chiName . ' ' . $engName . '</label>';
    }
    if ($permission != null && in_array(Session::get("positionId"), Permission::$setting[$permission])) {
      echo '<div class="input-group">';
      echo '<span class="input-group-addon">';
      echo '<i class="fa fa-calendar"></i>';
      echo '</span>';
      echo '<input type="text" data-plugin-datepicker data-date-format="yyyy-mm-dd" class="form-control" id="' . self::ConvertToName($name) . '" name="' . self::ConvertToName($name) . '" value = "' . $value . '" autocomplete = "off">';
      echo '</div>';
      echo '<div id = "' . self::ConvertToName($name) . 'Error" ></div>';
    } else {
      echo ' ' . $value;
    }
    echo '</div>';
    echo '</div>';

    if ($needRow == true) {
      echo '</div>';
    }
  }


  public static function CreateRadio($name = '', $chiName = '', $engName = '', $radioSet = array(), $value = '', $permission = '', $col = '', $needRow = '')
  {
    if ($needRow == true) {
      echo '<div class = "row">';
    }
    echo '<div class="' . $col . '">';
    echo '<div class="form-group">';
    echo '<label class="control-label">' . $chiName . ' ' . $engName . '</label><br/>';
    if ($permission != null && in_array(Session::get("positionId"), Permission::$setting[$permission])) {
      foreach ($radioSet as $option) {
        $checked = $option->value == $value ? 'checked' : '';
        echo '<label class="checkbox-inline">';
        echo '<input type="radio" id="' . self::ConvertToName($name) . '" name="' . self::ConvertToName($name) . '" value = "' . $option->value . '" ' .  $checked . '>';
        echo $option->text;
        echo '</label>';
      }
      echo '<div id = "' . self::ConvertToName($name) . 'Error" ></div>';
    } else {
      $option = UI::objArraySearch($radioSet, "value", $value);
      echo ' ' . $option->text;
    }
    echo '</div>';
    echo '</div>';

    if ($needRow == true) {
      echo '</div>';
    }
  }

  public static function CreateTextarea($name = '', $chiName, $engName, $value = '', $permission = '',  $withoutLabel = false, $col = "", $needRow = true)
  {
    if ($needRow == true) {
      echo '<div class = "row">';
    }
    echo '<div class="' . $col . '">';
    echo '<div class="form-group">';
    if ($withoutLabel == false) {
      echo '<label class="control-label">' . $chiName . ' ' . $engName . '</label>';
    }
    if ($permission != null && in_array(Session::get("positionId"), Permission::$setting[$permission])) {
      echo '<textarea name="' . self::ConvertToName($name) . '" id="content" rows="15" class="form-control">' . $value . '</textarea>';
      echo '<div id = "' . self::ConvertToName($name) . 'Error" ></div>';
    } else {
      echo ' ' . $value;
    }
    echo '</div>';
    echo '</div>';

    if ($needRow == true) {
      echo '</div>';
    }
  }

  public static function CreateTextEditor($name = '', $chiName, $engName, $value = '', $permission = '',  $withoutLabel = false, $col = "", $needRow = true)
  {
    if ($needRow == true) {
      echo '<div class = "row">';
    }
    echo '<div class="' . $col . '">';
    echo '<div class="form-group">';
    if ($withoutLabel == false) {
      echo '<label class="control-label">' . $chiName . ' ' . $engName . '</label>';
    }
    if ($permission != null && in_array(Session::get("positionId"), Permission::$setting[$permission])) {
      $options = '{"height": 800, "codemirror": { "theme": "ambiance" } }';
      echo "<div id = '" . self::ConvertToName($name) . "' class=\"summernote\" data-plugin-summernote data-plugin-options=\"" . $options . "\">" .  $value . "</div>";
      echo '<div id = "' . self::ConvertToName($name) . 'Error" ></div>';
    } else {
      echo ' ' . $value;
    }
    echo '</div>';
    echo '</div>';

    if ($needRow == true) {
      echo '</div>';
    }
  }

  public static function CreateText($name = '', $chiName, $engName, $value = '', $addOn = "", $permission = '', $isIndex = false, $withoutLabel = false, $col = "", $needRow = true)
  {
    if ($needRow == true) {
      echo '<div class = "row">';
    }
    echo '<div class="' . $col . '">';
    echo '<div class="form-group">';
    if ($withoutLabel == false) {
      echo '<label class="control-label">' . $chiName . ' ' . $engName . '</label>';
    }
    if ($permission != null && in_array(Session::get("positionId"), Permission::$setting[$permission])) {
      if ($addOn == "percentage") {
        echo '<div class="input-group mb-md">';
        echo '<input type="text" class="form-control" type="text" name = "' . self::ConvertToName($name) . '" id = "' . self::ConvertToName($name) . '" onkeypress="return isNumberKey(event)" value = "' . $value . '">';
        echo '<span class="input-group-addon ">%</span>';
        echo '</div>';
      } else {
        $disabled = '';
        if ($permission == "review") {
          $disabled = 'readonly="readonly"';
        }
        echo '<input type="text" name = "' . self::ConvertToName($name) . '" id = "' . self::ConvertToName($name) . '"';
        if ($addOn == "isNumber" || $addOn == "4digits" || $addOn == "5digits") {
          echo 'onkeypress="return isNumberKey(event)"';
        } else if ($addOn != "") {
          echo $addOn;
        }
        if (self::ConvertToName($name) == "remark") {
          echo ' maxlength = "1000"';
        }
        echo '" class="form-control mb-md" placeholder="' . $chiName . ' ' . $engName  . '" aria-label="' . self::DisplayName($name, $isIndex) . '" value = "' . $value . '" ';
        if ($addOn == "4digits") {
          echo ' maxlength="4"';
        } else if ($addOn == "5digits") {
          echo ' maxlength="5"';
        }
        echo $disabled . '>';
      }
      echo '<div id = "' . self::ConvertToName($name) . 'Error" ></div>';
    } else {
      echo ' ' . $value;
    }
    echo '</div>';
    echo '</div>';

    if ($needRow == true) {
      echo '</div>';
    }
  }

  public static function CreateOnlyText($name = '', $value = '', $isNumber = false, $permission = '', $isIndex = false)
  {

    if (in_array(Session::get("positionId"), Permission::$setting[$permission])) {
      echo '<input type="text" name = "' . self::ConvertToName($name) . '" id = "' . self::ConvertToName($name) . '" ';
      if ($isNumber) {
        echo 'onkeypress="return isNumberKey(event)"';
      }
      echo '" class="form-control" value = "' . $value . '" style = "width:100px">';
    } else {
      echo $value;
    }
  }

  public static function CreatePassword($name = '', $value = '', $isNumber = false)
  {
    echo '<div class="form-group row">';
    echo '<label class="col-md-3">' . $name . '</label>';
    echo '<div class="col-md-9">';
    echo '<input type="password" name = "' . self::ConvertToName($name) . '" id = "' . self::ConvertToName($name) . '" ';
    if ($isNumber) {
      echo 'onkeypress="return isNumberKey(event)"';
    }
    echo '" class="form-control" placeholder="' . $name . '" aria-label="' . $name . '" value = "' . $value . '">';
    echo '</div>';
    echo '<div class="col-md-9 offset-md-3" id = "' . self::ConvertToName($name) . 'Error"></div>';
    echo '</div>';
  }

  public static function ReplaceDisplayName($name)
  {
    $name = str_replace("[", "", $name);
    $name = str_replace("]", "", $name);
    return $name;
  }

  public static function CreateDropDown($name = '', $chiName = '', $engName, $options = array(), $value = '', $withoutLabel = false, $hide = false, $permission = '', $addOn = '', $col = 'col-sm-6', $needRow = true)
  {
    if ($needRow == true) {
      echo '<div class = "row">';
    }
    echo '<div class="' . $col . '">';

    echo '<div class="form-group">';
    if ($withoutLabel == false) {
      echo '<label class="control-label">' . $chiName . ' ' . $engName . '</label>';
    }
    $disabled = "disabled";
    if (isset($permission) && in_array(Session::get("positionId"), Permission::$setting[$permission])) {
      $disabled = "";
    }
    if ($permission == "review") {
      $disabled = "disabled";
    }
    echo '<select ' . $disabled . ' class="form-control mb-md" name = "' . self::ConvertToName($name) . '" id = "' . str_replace(']', '', str_replace('[', '', self::ConvertToName($name))) . '"' . $addOn . '>';
    foreach ($options as $option) {
      $selected = $option->value == $value ? 'selected' : '';
      echo '<option value = "' . $option->value . '" ' .  $selected . '>' . $option->text . '</option>';
    }
    echo '</select>';
    echo '<div id = "' . self::ConvertToName($name) . 'Error"></div>';

    echo '</div>';
    echo '</div>';

    if ($needRow == true) {
      echo '</div>';
    }
  }

  public static function CreateHidden($name = '', $value = '')
  {
    echo '<input type = "hidden" name = "' . self::ConvertToName($name) . '" id = "' . self::ConvertToName($name) . '" value = "' . $value . '" />';
  }

  public static function CreateTableHeader($options, $addSearchBox = false, $class = 'searchText')
  {
    foreach ($options as $tableHeader) {
      echo '<th>' . $tableHeader;
      if ($addSearchBox == true) {
        $skipHeader = array(
          'Edit', 'Detail', 'Add Lines', 'Line Items'
        );
        if (!in_array($tableHeader, $skipHeader)) {
          echo '<input type="text" class = "' . $class . '" id = "' .  self::ConvertToName($tableHeader) .  '" placeholder="Search ' . $tableHeader . '" />';
        }
      }
      echo '</th>';
    }
  }

  public static function CreateTableRow($options, $withDelete = false)
  {
    foreach ($options as $tableRow) {
      echo '<tr>';
      if ($withDelete) {
        echo '<form method = "POST" onsubmit = "return YesNoDelete()">';
        self::CreateElement('action', 'hidden', null, 'delete');
        $id = 0;
        foreach ($tableRow as $cell => $value) {
          if ($cell == 'id') {
            $id = $value;
          }
          if ($cell != 'id') {
            self::CreateElement('id', 'hidden', null, $id);
            echo '<td>' . $value .  '</td>';
            echo '<td><button class = "btn btn-danger">Delete</button></td>';
          }
        }
        echo "</form>";
      } else {
        foreach ($tableRow as $cell => $value) {
          echo '<td>' . $value .  '</td>';
        }
      }
      echo '</tr>';
    }
  }

  public static function CreateFileSelector($name, $chiName, $engName, $permission, $value, $addOn, $col, $needRow)
  {
    if ($needRow == true) {
      echo '<div class = "row">';
    }
    echo '<div class="' . $col . '">';
    echo '<div class="form-group">';
    echo '<label class="control-label">' . $chiName . ' ' . $engName . '</label>';
    if ($permission != null && in_array(Session::get("positionId"), Permission::$setting[$permission])) {
      echo '<div class="fileupload fileupload-new" data-provides="fileupload">';
      echo '<div class="input-append">';
      echo '<div class="uneditable-input">';
      echo '<i class="fa fa-file fileupload-exists"></i>';
      echo '<span class="fileupload-preview"></span>';
      echo '</div>';
      echo '<span class="btn btn-default btn-file">';
      echo '<span class="fileupload-exists">Change</span>';
      echo '<span class="fileupload-new">Select file</span>';
      echo '<input type="file" name = "' . self::ConvertToName($name) . ($addOn == 'multiple="multiple"' ? "[]" : "") . '" id = "' . self::ConvertToName($name) . '" ' . $addOn . '>';
      echo '</span>';
      echo '<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>';
      echo '</div>';
      echo '</div>';
      // if ($addOn != '') {
      //   echo '<a class="simple-ajax-modal btn btn-default" href="' . Url::getDomain() . "fileHistory/" . $value . "/?type=" . $addOn . '">紀錄 History</a>';
      // }
      echo '<div id = "' . self::ConvertToName($name) . 'Error" ></div>';
    }
    echo '</div>';
    echo '</div>';

    if ($needRow == true) {
      echo '</div>';
    }
  }


  public static function CreatePopup($value, $type)
  {
    // self::CreatePopupHyperLink($name, $value, $text, $isThumbnail);
    // self::CreatePopupModal($name, $value);
    echo '<a class="simple-ajax-modal btn btn-default" href="' . Url::getDomain() . 'fileHistory/' . $value . '/?type=' . $type . '">紀錄 History</a>';
  }

  public static function CreateConfirmOnPage($path, $action, $text, $formId, $buttonText, $permission, $btnStyle = "", $addOn = "")
  {
    // self::CreatePopupHyperLink($name, $value, $text, $isThumbnail);
    // self::CreatePopupModal($name, $value);
    if ($permission != null && in_array(Session::get("positionId"), Permission::$setting[$permission])) {
      echo '<a class="' . $btnStyle . ' simple-ajax-modal btn btn-default" href="' . Url::getDomain() . $path . "/?action=" . $action . '&text=' . $text . '&formId=' . $formId . '" ' . ($addOn != "" ? $addOn : "") . '>' . $buttonText . '</a>';
    }
  }

  public static function CreateModalBtn($buttonText = "", $onClickFunction = "", $btnStyle = "", $permission)
  {
    if ($permission != null && in_array(Session::get("positionId"), Permission::$setting[$permission])) {
      echo '<button class="' . $btnStyle . '" onclick = "' . $onClickFunction . '" >' . $buttonText . '</button>';
    }
  }

  public static function CreateModal($modalId, $onClickFunction = "")
  {
    echo '<div id="' . $modalId . '" class="modal-block modal-block-primary mfp-hide">';
    echo '<section class="panel">';
    echo '<div class="panel-body text-center">';
    echo '<div class="modal-wrapper">';
    echo '<div class="modal-icon center">';
    echo '<i class="fa fa-question-circle"></i>';
    echo '</div>';
    echo '<div class="modal-text">';
    echo '<h4>確定 ? <br /> Are you confirm?</h4>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '<footer class="panel-footer">';
    echo '<div class="row">';
    echo '<form method="POST">';
    echo '<div class="col-md-12 text-right">';
    echo '<a class="btn btn-primary modal-confirm" onClick = "' . $onClickFunction . '">確定 Confirm</a>';
    echo '<button class="btn btn-default modal-dismiss">取消Cancel</button>';
    echo '</div>';
    echo '</form>';
    echo '</div>';
    echo '</footer>';
    echo '</section>';
    echo '</div>';
  }

  public static function CreatePopupHyperLink($name, $value, $text = '', $isThumbnail = false, $isHtml = false)
  {
    if ($isThumbnail == true) {
      if ($isHtml == true) {
        $html = "";
        $html .=  "<a href = \"#\" data-toggle=\"modal\" data-target=\"#" . $name . "\">";
        $html .= "<img src = \"" . URL::getDomain() . $value . "\" class = \"thumb-lg\" >";
        $html .=  "</a>";
        return $html;
      } else {
        echo '<a href = "#" data-toggle="modal" data-target="#' . $name . '">';
        echo '<img src = "' . URL::getDomain() . $value . '" class = "thumb-lg"/>';
        echo '</a>';
      }
    } else {
      echo '<button type="button" class="btn btn-light margin-5" data-toggle="modal" data-target="#' . $name . '">';
      echo $text;
      echo '</button>';
    }
  }

  public static function CreatePopupModal($name, $value)
  {
    echo '<div class="modal fade" id="' . $name . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
    echo '<div class="modal-dialog" role="document">';
    echo '<div class="modal-content">';
    echo '<div class="modal-header">';
    echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
    echo '<span aria-hidden="true">&times;</span>';
    echo '</button>';
    echo '</div>';
    echo '<div class="modal-body">';
    echo '<img src="' . Url::getDomain() . $value . '" width="100% ">';
    echo '</div>';
    echo '<div class="modal-footer">';
    echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
  }

  public static function DebugArray($array)
  {
    print_r("<pre>" . print_r($array, true) . "</pre>");
  }

  public static function SetMoney($number, $removeDecimal = false)
  {
    if ($removeDecimal) {
      return number_format($number, 0);
    }
    return number_format($number, 2);
  }

  public static function ReturnEmpty($obj, $key)
  {
    $key = strtolower($key);
    if (isset($obj->$key)) {
      return $obj->$key;
    }
    return "";
  }
}
