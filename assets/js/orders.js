var orderFields = [
  { data: "orderId" },
  { data: "createdDate" },
  { data: "updatedDate" },
  { data: "contact" },
  { data: "delivery" },
  { data: "totalAmount" },
  { data: "status" },
  { data: "edit" },
];

$(document).ready(function () {
  load_order_data();
})

function load_order_data() {
  $('#orderList').DataTable({
    'processing': true,
    'serverSide': true,
    'serverMethod': 'POST',
    'order': [],
    'ajax': {
      'url': domain + "api/orders/getOrderList/",
      'type': 'POST',
      // 'data': {
      //   orderFilter: orderFilter
      // }
    },
    'searching': true,
    // "columnDefs": [{
    //   "targets": [2],
    //   "orderable": false
    // }],
    'columns': orderFields
  });
}