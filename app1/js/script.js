var errorMessage = {
  emptyField: "Поле не заполнено",
  invalidEmail: "Введен не корректный e-mail"
};

$("#submit").click(function() {
  restore("form div");
  var fieldsValid = checkEmptyFields("input, textarea", ".main form div");
  var emailValid = emailCheck("#email");

  if(fieldsValid  && emailValid) {
    humanTest();
  }
});

$("input, textarea", "form div").focus(function() {
  restore(this.parentElement);
});

$("input[type='reset']").click(function() {
  restore("form div");
});

$("#close-popup").click(function() {
  popupHide(".popup div:not([id='close-popup'])");
});
