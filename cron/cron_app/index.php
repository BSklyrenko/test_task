<?php
require_once("views/emailTemplates.php");
require_once("model/DbConnect.php");
require_once("model/model.php");
date_default_timezone_set("Europe/Moscow");

$pdo = new DbConnect("localhost", "task", "root", "root"); // создаем объект дескриптора бд

$exeptionDomains = ['mail.ru', 'rambler.ru', 'yandex.ru']; // список доменов, к которым надо применять первый шаблон

$clients = $pdo->select_query("SELECT * FROM task_table WHERE date_created <= '" . getLessTime(10) . "' AND sent=0");

foreach($clients as $key => $value) { // обходим все поля, соответсвующие требованиям
  $id = $value['id'];
  $name = $value['name'];
  $message = $value['message'];
  $email = $value['email'];
  $domain = explode('@', $email)[1];

  $template = in_array($domain, $exeptionDomains) ? 'template1' : 'template2';
  $subject = $emailTemplates[$template]['subject'];
  $body = $emailTemplates[$template]['body'];

  $body = preg_replace('/#fio/', $name, $body);
  $body = preg_replace('/#domain/', $domain, $body);
  $body = preg_replace('/#msg/', $message, $body);

  try {
    mail($email, $subject, $body);
  } catch(Exception $e) {
    die("Failed to sent e-mail message");
  }

  $pdo->update_query("UPDATE task_table SET sent='1' WHERE id='" . $id . "'");
}
 ?>
