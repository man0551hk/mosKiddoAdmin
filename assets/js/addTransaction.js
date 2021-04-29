function checkAddTransactionForm() {
  var err = 0;
  err += GenericCheckInput("transactionDate", "text", "請輸入日期 Please input date");
  err += GenericCheckInput("remark", "text", "請輸入交易 Please input transaction");
  
  if ($("#debitamountusd").val() == "" && $("#creditamountusd").val() == "" ) {
    $("#errorMsg").html("請輸入借方(USD)/貸方(USD) Please input either debit(USD) or credit(USD)");
    $("#errorMsg").css("display", "");
    err += 1;
  }
  if ($("#debitamountusd").val() != "") {
    err += GenericCheckInput("debitAmountUSD", "decmial", "請輸入請輸入借方(USD) Please input debit(USD) ");
  }

  if ($("#creditamountusd").val() != "") {
    err += GenericCheckInput("creditAmountUSD", "decmial", "請輸入請輸入貸方(USD) Please input credit(USD) ");
  }
  
  if (err != 0) {
    return false;
  } 
  return true;
}