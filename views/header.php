<!doctype html>
<html class="fixed">

<head>
  <meta charset="UTF-8">
  <title>SHCC Admin Portal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

  <link rel="stylesheet" href="<?= Url::assetFolderPath() ?>vendor/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="<?= Url::assetFolderPath() ?>vendor/font-awesome/css/font-awesome.css" />
  <link rel="stylesheet" href="<?= Url::assetFolderPath() ?>vendor/magnific-popup/magnific-popup.css" />
  <link rel="stylesheet" href="<?= Url::assetFolderPath() ?>vendor/bootstrap-datepicker/css/datepicker3.css" />

  <link rel="stylesheet" href="<?= Url::assetFolderPath() ?>vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
  <link rel="stylesheet" href="<?= Url::assetFolderPath() ?>vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
  <link rel="stylesheet" href="<?= Url::assetFolderPath() ?>vendor/morris/morris.css" />
  <link rel="stylesheet" href="<?= Url::assetFolderPath() ?>vendor/pnotify/pnotify.custom.css" />
  <link rel="stylesheet" href="<?= Url::assetFolderPath() ?>vendor/bootstrap-fileupload/bootstrap-fileupload.min.css" />
  <link rel="stylesheet" href="<?= Url::assetFolderPath() ?>vendor/select2/select2.css" />
  <link rel="stylesheet" href="<?= Url::assetFolderPath() ?>vendor/jquery-datatables-bs3/assets/css/datatables.css" />
  <link rel="stylesheet" href="<?= Url::assetFolderPath() ?>vendor/summernote/summernote.css" />
  <link rel="stylesheet" href="<?= Url::assetFolderPath() ?>vendor/summernote/summernote-bs4.css" />

  <link rel="stylesheet" href="<?= Url::cssFolderPath() ?>theme.css" />
  <link rel="stylesheet" href="<?= Url::cssFolderPath() ?>skins/default.css" />
  <link rel="stylesheet" href="<?= Url::cssFolderPath() ?>theme-custom.css">

  <script src="<?= Url::assetFolderPath() ?>vendor/modernizr/modernizr.js"></script>
  <style>
    .disabled-link {
      cursor: default;
      pointer-events: none;
      text-decoration: none;
    }

    .tmHighlight {
      border-color: #006699 !important;
    }

    .datepicker {
      z-index: 10002 !important;
    }
  </style>
</head>

<body>
  <section class="body">
    <header class="header">
      <div class="logo-container">
        <a href="#" class="logo">
          <img src="<?= Url::getDomain() ?>assets/images/shccLogo.png" height="40px" />
        </a>
        <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
          <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
        </div>
      </div>

      <div class="header-right">
        <span class="separator"></span>
        <div id="userbox" class="userbox">
          <a href="#" data-toggle="dropdown">
            <figure class="profile-picture">
              <img src="<?= Url::getDomain() ?>profilePic/1.png" class="img-circle" data-lock-picture="<?= Url::getDomain() ?>profilePic/1.png" />
            </figure>
            <div class="profile-info" data-lock-name="<?= Session::get("name") ?>">
              <span class="name"><?= Session::get("name") ?></span>
            </div>
            <i class="fa custom-caret"></i>
          </a>

          <div class="dropdown-menu">
            <ul class="list-unstyled">
              <li class="divider"></li>
              <li>
                <a role="menuitem" tabindex="-1" href="<?= Url::getDomain() ?>logout/"><i class="fa fa-power-off"></i> Logout</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </header>

    <div class="inner-wrapper">