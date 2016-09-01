<?php
function getLessTime($minutes) { // возвращает дату на 10 минут меньше текущей
  return date("Y-m-d H:i:s", mktime(date("H"), date("i") - $minutes));
}
 ?>
