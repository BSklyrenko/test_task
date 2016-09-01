// функция создает сообщение об ошибке для поля формы
function createErrorMsg(str) {
  var $errBlock = $("<span class='err-msg'>" + str + "</span>");
  return $errBlock;
}

// функция проверяет заполнение формы
function checkEmptyFields(selector, context) {
  context = context || null;
  var isValid = true;

  $(selector, context).each(function() {
    if($(this).val() === "") {
      restore(this.parentElement);

      $(this.parentElement).append(createErrorMsg(errorMessage.emptyField));
      $(this).addClass("wrong-field");

      isValid = false;
    }
  });
  return isValid;
}

// функция проверяет валидность e-mail адреса
function emailCheck(selector, context) {
  context = context || null;
  var isValid = true;
  var pattern = /^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$/i;
  var $emailField = $(selector, context);

  if($emailField.val() !== "")  {
    if($emailField.val().search(pattern) !== 0) {
      restore(".err-msg", $emailField.parents("div").first());

      $emailField.parents("div").first().append(createErrorMsg(errorMessage.invalidEmail));
      $emailField.addClass("wrong-field");

      isValid = false;
    }
  }
  return isValid;
}

// функция восстанавливает стандартный вид форм
function restore(selector) {
  $(".err-msg", selector).remove();
  $("input, textarea", selector).removeClass("wrong-field");
}

// функция открывает всплавающее окно
function popupOpen(selector) {
  $(".popup").show();
  $(selector).slideDown(400);
}

// функция закрывает всплавающее окно
function popupHide(selector) {
  $(".popup").hide();
  $(selector).slideUp(400);
}

// функция активирует всплыающее окно с сообщение на некоторое время
function popupMsg(msg) {
  $(".popup .msg").empty();
  $(".popup .msg").html(msg);
  popupOpen(".msg");
}

// функция вызывает создает капчи, в случае успеха, осуществляет ajax запрос
function humanTest() {
  var testResult = makeCaptcha();
  $("input[type='button']", ".captcha").click(testResult);
  popupOpen(".captcha");
}

// функция создает капчу
function makeCaptcha() {
  var num1 = Math.ceil(Math.random() * 20);
  var num2 = Math.ceil(Math.random() * 20);
  var answer = num1 + num2;
  var taskString = "Докажите что вы не робот: " + num1 + " + " + num2;
  $("label", ".captcha").html(taskString);

  return function() {
    if($(this).prev().val() == answer) {
      popupHide(".captcha");
      makeRequest();
    } else {
      popupHide(".captcha");
      popupMsg("Неверно");
    }
  };
}

// функция осуществляет упаковку данных и ajax запрос
// с последующей обработкой ответа
function makeRequest() {
  var pack = {
    name: $("#name").val(),
    message: $("#message").val(),
    email: $("#email").val()
  };

  $.post("buffer.php", $.param({request: JSON.stringify(pack)}), function(response){
    popupMsg(response, 3000);
  });
}
