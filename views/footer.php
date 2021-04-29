</div>

</section>

<!-- Vendor -->
<script src="<?= Url::assetFolderPath() ?>vendor/jquery/jquery.js"></script>
<script src="<?= Url::assetFolderPath() ?>vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
<script src="<?= Url::assetFolderPath() ?>vendor/bootstrap/js/bootstrap.js"></script>
<script src="<?= Url::assetFolderPath() ?>vendor/nanoscroller/nanoscroller.js"></script>
<script src="<?= Url::assetFolderPath() ?>vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?= Url::assetFolderPath() ?>vendor/magnific-popup/magnific-popup.js"></script>
<script src="<?= Url::assetFolderPath() ?>vendor/jquery-placeholder/jquery.placeholder.js"></script>

<!-- Specific Page Vendor -->
<script src="<?= Url::assetFolderPath() ?>vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
<script src="<?= Url::assetFolderPath() ?>vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js"></script>
<script src="<?= Url::assetFolderPath() ?>vendor/jquery-appear/jquery.appear.js"></script>
<script src="<?= Url::assetFolderPath() ?>vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<script src="<?= Url::assetFolderPath() ?>vendor/jquery-easypiechart/jquery.easypiechart.js"></script>
<script src="<?= Url::assetFolderPath() ?>vendor/flot/jquery.flot.js"></script>
<script src="<?= Url::assetFolderPath() ?>vendor/flot-tooltip/jquery.flot.tooltip.js"></script>
<script src="<?= Url::assetFolderPath() ?>vendor/flot/jquery.flot.pie.js"></script>
<script src="<?= Url::assetFolderPath() ?>vendor/flot/jquery.flot.categories.js"></script>
<script src="<?= Url::assetFolderPath() ?>vendor/flot/jquery.flot.resize.js"></script>
<script src="<?= Url::assetFolderPath() ?>vendor/jquery-sparkline/jquery.sparkline.js"></script>
<script src="<?= Url::assetFolderPath() ?>vendor/raphael/raphael.js"></script>
<script src="<?= Url::assetFolderPath() ?>vendor/morris/morris.js"></script>
<script src="<?= Url::assetFolderPath() ?>vendor/gauge/gauge.js"></script>
<script src="<?= Url::assetFolderPath() ?>vendor/snap-svg/snap.svg.js"></script>
<script src="<?= Url::assetFolderPath() ?>vendor/liquid-meter/liquid.meter.js"></script>
<script src="<?= Url::assetFolderPath() ?>vendor/pnotify/pnotify.custom.js"></script>
<script src="<?= Url::assetFolderPath() ?>vendor/select2/select2.js"></script>
<script src="<?= Url::assetFolderPath() ?>vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
<script src="<?= Url::assetFolderPath() ?>vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
<script src="<?= Url::assetFolderPath() ?>vendor/jquery-validation/jquery.validate.js"></script>
<script src="<?= Url::assetFolderPath() ?>vendor/bootstrap-wizard/jquery.bootstrap.wizard.js"></script>
<script src="<?= Url::assetFolderPath() ?>vendor/jquery-autosize/jquery.autosize.js"></script>
<script src="<?= Url::assetFolderPath() ?>vendor/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
<script src="<?= Url::assetFolderPath() ?>vendor/summernote/summernote.js"></script>
<script src="<?= Url::assetFolderPath() ?>vendor/bootstrap-maxlength/bootstrap-maxlength.js"></script>

<script src="<?= Url::assetFolderPath() ?>js/function.js?v=<?= time(); ?>"></script>
<script src="<?= Url::assetFolderPath() ?>javascripts/theme.js"></script>
<script src="<?= Url::assetFolderPath() ?>javascripts/theme.custom.js"></script>
<script src="<?= Url::assetFolderPath() ?>javascripts/theme.init.js"></script>

<?php if ($pageName == "index.php") { ?>

  <script src="<?= Url::assetFolderPath() ?>js/blog.js?v=<?= time(); ?>"></script>
  <script src="<?= Url::assetFolderPath() ?>js/orders.js?v=<?= time(); ?>"></script>
<?php } else if ($pageName == "blog.php") { ?>
  <script src="<?= Url::assetFolderPath() ?>js/blog.js?v=<?= time(); ?>"></script>
<?php } else if ($pageName == "orders.php") { ?>
  <script src="<?= Url::assetFolderPath() ?>js/orders.js?v=<?= time(); ?>"></script>
<?php } ?>

<script>
  SetDomain('<?= Url::getDomain() ?>');
</script>

<?php
if (!empty($_POST)) {
  if (in_array($_POST["action"],  $this->commonController->showsuccessAction)) {
?>
    <script>
      $(function() {
        window.onload = function() {
          var stack_bar_top = {
            "dir1": "down",
            "dir2": "right",
            "push": "top",
            "spacing1": 0,
            "spacing2": 0
          };
          var notice = new PNotify({
            title: 'Saved',
            text: 'Please wait to refresh',
            type: 'success',
            addclass: 'stack-bar-top',
            stack: stack_bar_top,
            width: "100%"
          });
          notice.get().click(function() {
            notice.remove();
          });
        }
      });
    </script>
    <?php if (isset($_POST["refresh"]) && $_POST["refresh"] == "1") {
    ?>
      <script>
        setTimeout(function() {
          window.location.href = '<?= Url::getDomain() . $refreshLink ?>';
        }, 2000);
      </script>
    <?php
    } ?>
<?php
  }
}
?>

</body>

</html>