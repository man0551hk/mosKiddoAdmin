var blogFields = [
  { data: "createdDate" },
  { data: "name" },
  { data: "message" },
  { data: "status" },
  { data: "edit" },
];

$(document).ready(function () {
  load_blog_data();
})

function load_blog_data() {
  $('#blogList').DataTable({
    'processing': true,
    'serverSide': true,
    'serverMethod': 'POST',
    'order': [],
    'ajax': {
      'url': domain + "api/blog/getBlogList/",
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
    'columns': blogFields
  });
}

function OpenModal(id, status, msg) {
  $("#blogId").attr("value", id);
  $("#status").attr("value", status);
  $("#title").html(msg);
  $.magnificPopup.open({
    items: {
      src: '#updateBlog',
    },
    type: 'inline'
  });
}