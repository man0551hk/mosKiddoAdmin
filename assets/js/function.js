var domain = "";
var positionId = 0;
String.prototype.trim = function () {
  return this.replace(/^\s+|\s+$/g, "");
}

function SetDomain(comeDomain) {
  domain = comeDomain;
}

function SetPositionId(comePositionId) {
  positionId = comePositionId;
}

function YesNo() {
  if (confirm("Confirm to save?")) {
    return true;
  } else {
    return false;
  }
}

function YesNoDelete() {
  if (confirm("Confirm to save?")) {
    return true;
  } else {
    return false;
  }
}

function AlertSuccess() {
  alert("Data saved successful");
}

function validateEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}

function passwordChanged() {
  var strength = document.getElementById('errorPassword');
  var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
  var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
  var enoughRegex = new RegExp("(?=.{6,}).*", "g");
  var pwd = document.getElementById("password");
  if (pwd.value.length == 0) {
    strength.innerHTML = "<font style = 'color:red;'>密碼最少8個字母及數字 Password at least 8 characters and digits</font>";
  } else if (false == enoughRegex.test(pwd.value)) {
    strength.innerHTML = "<font style = 'color:red;'>請輸入更多字母或數字 Please input more characters or digits</font>";
  } else if (strongRegex.test(pwd.value)) {
    strength.innerHTML = '<span style="color:green">Strong!</span>';
  } else if (mediumRegex.test(pwd.value)) {
    strength.innerHTML = '<span style="color:orange">Medium!</span>';
  } else {
    strength.innerHTML = '<span style="color:red">Weak!</span>';
  }
}

function isNumberKey(evt) {
  var key = window.event ? event.keyCode : event.which;
  if (event.keyCode === 8 || event.keyCode === 46) {
    return true;
  } else if (key < 48 || key > 57) {
    return false;
  } else {
    return true;
  }
}

function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function IsDecmial(input) {
  //var RE = new RegExp("/^{0,1}\d*\.{0,1}\d+$/");
  return input.match(/^(\d+\.?\d*|\.\d+)$/);
  //return (RE.test(input));
}

function GetRadioValue(id, radioListCount) {
  var value = '';
  for (var i = 0; i < radioListCount; i++) {
    console.log(document.getElementById(id + i));
    if (document.getElementById(id + i) != null) {
      if (document.getElementById(id + i).checked) {
        value = document.getElementById(id + i).value;
        break;
      }
    }
  }
  return value;
}

function checkUserForm() {
  var err = 0;
  try {
    err += GenericCheckInput("name", "text", "Please input name");
    err += GenericCheckInput("login", "email", "Please input valid login");
    err += GenericCheckInput("password", "text", "Please input password");
    err += GenericCheckInput("confirmpassword", "text", "Please input password");
    err += GenericCheckInput("department", "select", "Please select department");
    if (document.getElementById("confirmpassword").value != document.getElementById("password").value) {
      err += 1;
      document.getElementById("confirmpasswordError").innerHTML = "<font class = \"error\">Password doesn't match</font>";
    }
  } catch (err) {
    console.log(err);
  }
  if (err == 0) {
    return true;
  }
  return false;
}

function GenericCheckInput(id, type, msg, radioListCount) {
  id = id.toLowerCase();
  if (document.getElementById(id) == null) {
    console.log(id)
  }

  var err = 0;

  if (type == "file") {
    if (document.getElementById(id).files.length == 0) {
      err = 1;
    }
  } else if (type == "text") {
    if (document.getElementById(id).value.trim() == "") {
      err = 1;
    }
  } else if (type == "integer") {
    if (document.getElementById(id).value.trim() == "") {
      err = 1;
    } else if (!isNumber(document.getElementById(id).value)) {
      err = 1;
    }
  } else if (type == "decimal") {
    if (document.getElementById(id).value.trim() == "") {
      err = 1;
    } else if (!isNumber(document.getElementById(id).value) && !IsDecmial(document.getElementById(id).value)) {
      err = 1;
    }
  } else if (type == "select") {
    var selectDropDown = document.getElementById(id);
    if (selectDropDown.options[selectDropDown.selectedIndex].value == 0 || selectDropDown.options[selectDropDown.selectedIndex].value == "") {
      err = 1;
    }
  } else if (type == "checkboxList") {
    var checkboxList = document.getElementsByName(id);
    var checkboxListValue = 0;
    for (var i = 0, length = checkboxList.length; i < length; i++) {
      if (checkboxList[i].checked) {
        checkboxListValue = checkboxList[i].value;
        break;
      }
    }
    if (checkboxListValue == 0) {
      err = 1;
    }
  } else if (type == "email") {
    if (document.getElementById(id).value == "") {
      err = 1;
    } else if (!validateEmail(document.getElementById(id).value)) {
      err = 1;
    }
  } else if (type == "phone") {
    if (document.getElementById(id).value == "") {
      err = 1;
    } else if (document.getElementById(id).value.length < 8) {
      err = 1;
    }
  } else if (type == "radio") {
    var value = '';
    for (var i = 0; i < radioListCount; i++) {
      if (document.getElementById(id + i).checked) {
        value = document.getElementById(id + i).value;
        break;
      }
    }
    if (value == '') {
      err = 1;
    }
  }

  if (err == 0) {
    SetInnerHtml(id + 'Error', '');
    return 0;
  } else {
    document.getElementById(id).focus();
    SetInnerHtml(id + 'Error', '<div class="alert alert-danger">' + msg + '</div>');
    return 1;
  }
}

function SetInnerHtml(id, msg) {
  try {
    document.getElementById(id).innerHTML = msg;
  } catch (err) {
    console.log(id);
  }
}

function compare(type, id) {
  if (document.getElementById("left_" + type + id).value != document.getElementById("right_" + type + id).value) {

    var td = document.getElementById(type + id).getElementsByTagName("td");
    for (i = 0; i < td.length; i++) {
      td[i].style.borderColor = "red";
      td[i].style.borderWidth = "1px";
      td[i].style.borderStyle = "solid";
    }
  } else {
    var row = document.getElementById(type + id);
    row.parentNode.removeChild(row);
  }
}

function GetMessage(userId) {
  var html = "";
  $.ajax({
    type: "POST",
    url: domain + "api/getMessage/" + userId + "/",
    dataType: "json",
    success: function (response) {
      document.getElementById("msgCount").innerHTML = response.length;
      for (var i = 0; i < response.length; i++) {
        html += "<li><div><em class=\"fa fa-user\"></em>" + response[i].message + "</li><li class=\"divider\"></li>";
      }
      document.getElementById("msgContent").innerHTML = html;
    },
    error: function (jqXHR, exception) { }
  });
}

function getDropDownValue(id) {
  var selectDropDown = document.getElementById(id);
  return selectDropDown.options[selectDropDown.selectedIndex].value;
}

function changeFileHistorySource(type, path, id) {
  $("#embedPdf").css("display", "none");
  $("#embedImg").css("display", "none");

  $(".tmHighlight").removeClass("tmHighlight");

  if (type == "pdf") {
    $("#embedPdf").css("display", "");
    $("#embedPdf").attr("src", path);
  } else {
    $("#embedImg").css("display", "");
    $("#embedImg").attr("src", path);
  }

  $("#tm" + id).addClass("tmHighlight");
  $("html, body").animate({ scrollTop: 0 }, "fast");
}


function checkChangeStatus() {
  var err = 0;
  err += GenericCheckInput("status", "select", "請選擇狀態 Please select status");
  if ($("#startDate") != null) {
    err += GenericCheckInput("startDate", "text", "請輸入開始日期 Please input start date");
  }

  if (err == 0) {
    return true;
  }
  return false;
}

(function ($) {

  if ($(".simple-ajax-modal") != null) {
    'use strict';
    $(document).on('click', '.modal-dismiss', function (e) {
      e.preventDefault();
      $.magnificPopup.close();
    });

    $('.simple-ajax-modal').magnificPopup({
      type: 'ajax',
      alignTop: true,
      modal: true,
      showCloseBtn: true,
    });
  }
  if ($(".modal-basic") != null) {
    $('.modal-basic').magnificPopup({
      type: 'inline',
      preloader: false,
      modal: true
    });
  }

}).apply(this, [jQuery]);



function setApproveId(id) {
  $("<input>")
    .attr({
      type: "hidden",
      id: "approveId",
      name: "approveId",
      value: id,
    })
    .appendTo($("#approveForm"));
}

function checkCategory() {
  var err = 0;
  err += GenericCheckInput("categoryName", "text", "Please enter category name");
  if (err == 0) {
    return true;
  }
  return false;
}

function checkProduct(isInsert) {
  var err = 0;
  try {

    err += GenericCheckInput("productName", "text", "Please enter product name");
    err += GenericCheckInput("categoryId", "select", "Please select category");
    err += GenericCheckInput("totalQuantity", "integer", "Please enter total quantity");
    err += GenericCheckInput("maxQtyPerOrder", "text", "Please enter max quantity per order");
    err += GenericCheckInput("price", "integer", "Please enter price");
    if (isInsert == 1) {
      err += GenericCheckInput("images", "file", "Please select at least 1 photo");
    }
  } catch (err) {
    console.log(err);
    err = 1;
  }

  if (err == 0) {
    return true;
  }
  return false;
}

function setCaption(galleryId, caption) {
  $("#galleryId").attr("value", galleryId);
  $("#caption").attr("value", caption);
}

function setDeleteGallery(galleryId) {
  $("#deleteGalleryId").attr("value", galleryId);
}