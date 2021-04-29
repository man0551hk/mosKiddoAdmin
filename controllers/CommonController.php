<?php
class CommonController
{
  private $dbController;
  public $pageName;
  public function __construct($dbController)
  {
    $this->dbController = $dbController;
  }

  public $showsuccessAction = array(
    "saveCategory",
    "addAlbum",
    "uploadPhotos",
    "editCaption",
    "deleteGalleryId",
    "updateBlog",
    "updateOrderStatus"
  );

  public function ConvertResultToOption($result)
  {
    $data = array();
    $emptyOption = new Option('Select', 0);
    array_push($data, $emptyOption);
    while ($row = mysqli_fetch_array($result)) {
      $i = 1;
      $text = "";
      while ($i < 10) {
        if (isset($row[$i])) {
          $text .= " " . $row[$i];
          $i++;
        } else {
          break;
        }
      }
      if ($text != "") {
        $option = new Option($text, $row[0]);
      }
      array_push($data, $option);
    }
    return $data;
  }

  public function ConvertResultToOneRecord($result)
  {
    if ($row = mysqli_fetch_array($result)) {
      return $row[0];
    }
  }

  public function ConvertResultToOneRow($result)
  {
    return mysqli_fetch_array($result);
  }

  public function ReturnJson($data)
  {
    $json = json_encode($data, JSON_UNESCAPED_UNICODE);
    if ($json === false) {
      $json = json_encode(array("jsonError", json_last_error_msg()));
      if ($json === false) {
        $json = '{"jsonError": "unknown"}';
      }
      http_response_code(500);
    }
    echo $json;
  }

  public function SaveImage($image, $id, $folder)
  {
    $target_dir = Url::getPath($folder);
    if (!file_exists($target_dir)) {
      mkdir($target_dir, 0777, true);
    }
    $imageFileType = strtolower(pathinfo(basename($image["name"]), PATHINFO_EXTENSION));
    $fileName = $id . '_' . Cookie::RandomValue() . '.' .  $imageFileType;
    $target_file = $target_dir . $fileName;
    $uploadOk = 1;

    $check = getimagesize($image["tmp_name"]);
    if ($check !== false) {
      $uploadOk = 1;
    } else {
      $uploadOk = 0;
    }

    if (file_exists($target_file)) {
      $uploadOk = 0;
    }
    // Check file size
    if ($image["size"] > 5242800) {
      $uploadOk = 0;
    }
    // Allow certain file formats
    $imageFileType = strtolower($imageFileType);
    if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif"  || $imageFileType == "pdf") {
      $uploadOk = 1;
    }
    if ($uploadOk == 0) {
      return false;
    } else {
      $fn = $image["tmp_name"];
      $size = getimagesize($fn);
      $ratio = $size[0] / $size[1]; // width/height
      if ($ratio > 1) {
        $width = 800;
        $height = 800 / $ratio;
      } else {
        $width = 800 * $ratio;
        $height = 800;
      }
      $src = imagecreatefromstring(file_get_contents($fn));
      $dst = imagecreatetruecolor($width, $height);
      imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
      imagedestroy($src);
      imagepng($dst, $folder . '/' . $fileName); // adjust format as needed
      imagedestroy($dst);
      return $folder . '/' . $fileName;
    }
  }

  public function SendMessage($content, $toAll = false, $toUserId = 0)
  {
    $now = new datetime('now');
    $current = $now->format('Y-m-d H:i:s');
    if ($toAll == true) {
      $condition = " userId != " . Session::get("userId");
      $allUserRs = $this->dbController->QueryDB("user", array('userId'), "query", $condition, null, '', '');
      while ($row = mysqli_fetch_array($allUserRs)) {
        $fields = array(
          "fromUserId" => Session::get("userId"),
          "toUserId" => $row["userId"],
          "content" => $content,
          "status" => 0,
          "sentDate" => $current
        );
        $this->dbController->QueryDB("message", $fields, "insert", null, null, null, null, false);
      }
    } else {
      $fields = array(
        "fromUserId" => Session::get("userId"),
        "toUserId" => $toUserId,
        "content" => $content,
        "status" => 0,
        "sentDate" => $current
      );
      $this->dbController->QueryDB("message", $fields, "insert");
    }
  }

  public function remove_element(&$array, $value)
  {
    if (($key = array_search($value, $array)) !== false) {
      unset($array[$key]);
    }
  }

  public function ShowActiveClass($currentPage)
  {
    if ($this->pageName == $currentPage) {
      echo 'active';
    }
  }

  public function omit($array)
  {
    foreach ($array as $key => $value) {
      if (is_null($value) || $value == '' || (is_array($value) && sizeof($value) == 0) || empty($value))
        unset($array[$key]);
    }
    return $array;
  }

  public function ReplaceEmpty($text)
  {
    $value = str_replace(array("\r", "\n", "\r\n", "\n\r"), '<br/>', $text);
    $value = str_replace('<br/><br/><br/>', '<br/>', $value);
    $value = str_replace('<br/><br/>', '<br/>', $value);
    return $value;
  }

  public function ValidateFields($object)
  {
    $error = [];
    foreach ($object->fieldList as &$field) {
      if (isset($_POST[$field->fieldName])) {
        $field->value = $_POST[$field->fieldName];
      } else if ($field->requried === true && !isset($_POST[$field->fieldName])) {
        $error[] = $field->fieldName . " is required";
      }
    }

    if (!empty($error)) {
      return array(
        "data" => null,
        "error" => $error
      );
    }
    return array(
      "data" => $object,
    );
  }

  public function ConvertToSaveableObject($object)
  {
    $saveableObj = [];
    foreach ($object->fieldList as &$field) {
      if ($field->isSaveField == true) {
        $saveableObj[$field->fieldName] = $field->value;
      }
    }
    return $saveableObj;
  }

  public function GetValueByList($list, $byKey, $byValue, $getKey)
  {
    $found_key = array_search($byValue, array_column($list, $byKey));
    if (!isset($found_key)) {
      return null;
    }
    return $list[$found_key]->$getKey;
  }

  public function SaveFile($file, $id, $folder)
  {
    $target_dir = Url::getPath($folder);
    if (!file_exists($target_dir)) {
      mkdir($target_dir, 0777, true);
    }
    $total_count = count($file['name']);
    $fileList = [];
    for ($i = 0; $i < $total_count; $i++) {
      $imageFileType = strtolower(pathinfo(basename($file["name"][$i]), PATHINFO_EXTENSION));
      $fileName = $id . '_' . Cookie::RandomValue() . '.' .  $imageFileType;

      $target_file = $target_dir . $fileName;
      $uploadOk = 1;

      if (file_exists($target_file)) {
        $uploadOk = 0;
      }

      if ($file["size"][$i] > 20482800) {
        $uploadOk = 0;
      }
      if ($uploadOk == 1) {
        move_uploaded_file($file["tmp_name"][$i], $target_file);
        $fileList[] = $fileName;
      }
    }
    return $fileList;
  }
}
