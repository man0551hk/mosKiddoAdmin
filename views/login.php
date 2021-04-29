<?php
$msg = "";
if (!empty($_POST)) {
  $msg = $this->userController->checkLogin();
}
?>

<!doctype html>
<html class="fixed">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
  <title>Mos Kiddo Admin Portal</title>

  <link rel="stylesheet" href="<?= Url::assetFolderPath() ?>vendor/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="<?= Url::assetFolderPath() ?>vendor/font-awesome/css/font-awesome.css" />
  <link rel="stylesheet" href="<?= Url::assetFolderPath() ?>vendor/magnific-popup/magnific-popup.css" />
  <link rel="stylesheet" href="<?= Url::assetFolderPath() ?>vendor/bootstrap-datepicker/css/datepicker3.css" />
  <link rel="stylesheet" href="<?= Url::assetFolderPath() ?>stylesheets/theme.css" />
  <link rel="stylesheet" href="<?= Url::assetFolderPath() ?>stylesheets/skins/default.css" />
  <link rel="stylesheet" href="<?= Url::assetFolderPath() ?>stylesheets/theme-custom.css">
  <!-- Head Libs -->
  <script src="<?= Url::assetFolderPath() ?>/vendor/modernizr/modernizr.js"></script>

</head>

<body>
  <!-- start: page -->
  <section class="body-sign">
    <div class="center-sign">
      <a href="/" class="logo pull-left">
        Mos Kiddo
      </a>

      <div class="panel panel-sign">
        <div class="panel-title-sign mt-xl text-right">
          <h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i>Sign In</h2>
        </div>
        <div class="panel-body">
          <form method="POST">
            <div class="form-group mb-lg">
              <label>Login Name</label>
              <div class="input-group input-group-icon">
                <input name="loginName" type="text" class="form-control input-lg" autocomplete="off" />
                <span class="input-group-addon">
                  <span class="icon icon-lg">
                    <i class="fa fa-user"></i>
                  </span>
                </span>
              </div>
            </div>

            <div class="form-group mb-lg">
              <div class="clearfix">
                <label class="pull-left">Password</label>
              </div>
              <div class="input-group input-group-icon">
                <input name="pwd" type="password" class="form-control input-lg" autocomplete="off" />
                <span class="input-group-addon">
                  <span class="icon icon-lg">
                    <i class="fa fa-lock"></i>
                  </span>
                </span>
              </div>
            </div>

            <div class="form-group mb-lg">
              <div class="clearfix">
                <label class="pull-left">Verify Code</label>
              </div>
              <div class="input-group input-group-icon">
                <input name="verifyCode" type="text" class="form-control input-lg" autocomplete="off" />
                <span class="input-group-addon">
                  <span class="icon icon-lg">
                    <i class="fa fa-lock"></i>
                  </span>
                </span>
              </div>
            </div>

            <div class="form-group mb-lg">
              <div class="input-group input-group-icon">
                <img src="<?= Url::getDomain() ?>verifyCode.php" />
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <font style="color:red"><?= $msg ?></font>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4 text-right">

                <button type="submit" class="btn btn-primary hidden-xs">Sign In</button>
                <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Sign In</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <!-- end: page -->

  <!-- Vendor -->
  <script src="<?= Url::assetFolderPath() ?>vendor/jquery/jquery.js"></script>
  <script src="<?= Url::assetFolderPath() ?>vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
  <script src="<?= Url::assetFolderPath() ?>vendor/bootstrap/js/bootstrap.js"></script>
  <script src="<?= Url::assetFolderPath() ?>vendor/nanoscroller/nanoscroller.js"></script>
  <script src="<?= Url::assetFolderPath() ?>vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
  <script src="<?= Url::assetFolderPath() ?>vendor/magnific-popup/magnific-popup.js"></script>
  <script src="<?= Url::assetFolderPath() ?>vendor/jquery-placeholder/jquery.placeholder.js"></script>

  <!-- Theme Base, Components and Settings -->
  <script src="<?= Url::assetFolderPath() ?>javascripts/theme.js"></script>

  <!-- Theme Custom -->
  <script src="<?= Url::assetFolderPath() ?>javascripts/theme.custom.js"></script>

  <!-- Theme Initialization Files -->
  <script src="<?= Url::assetFolderPath() ?>javascripts/theme.init.js"></script>
</body>

</html>