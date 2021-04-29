<section role="main" class="content-body">
  <header class="page-header">
    <h2>Dashboard</h2>

    <div class="right-wrapper pull-right">
      <ol class="breadcrumbs" style="padding-right:15px">
        <li>
          <a href="<?= Url::getDomain() ?>">
            <i class="fa fa-home"></i>
          </a>
        </li>
        <li><span>Dashboard</span></li>
      </ol>
    </div>
  </header>

  <div class="row">
    <div class="panel-heading">
      <h4>New Blogs</h4>
    </div>
    <div class="panel-body">
      <table class="table table-bordered table-striped table-condensed mb-none" id="blogList">
        <thead>
          <tr>
            <th>Created Date</th>
            <th>Name</th>
            <th>Message</th>
            <th>Status</th>
            <th>Edit</th>
          </tr>
        </thead>
        </tbody>
      </table>
    </div>
  </div>

  <div class="row">
    <div class="panel-heading">
      <h4>New Orders</h4>
    </div>
    <div class="panel-body">
      <table class="table table-bordered table-striped table-condensed mb-none" id="orderList">
        <thead>
          <tr>
            <th>Order Id</th>
            <th>Created Date</th>
            <th>Updated Date</th>
            <th>Contact</th>
            <th>Delivery</th>
            <th>Total Amount</th>
            <th>Status</th>
            <th>Edit</th>
          </tr>
        </thead>
        </tbody>
      </table>
    </div>
  </div>
</section>