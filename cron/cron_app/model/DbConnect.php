<?php
class DbConnect {
  protected $pdo;

  function __construct($host, $db, $user, $pass) {
    $dsn = "mysql:host=$host;dbname=$db;";
    $opt = array(
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    );
    $this->pdo = new PDO($dsn, $user, $pass, $opt);
  }

  public function select_query($str) {
    return $this->pdo->query($str)->fetchAll();
  }

  public function insert_values($table, array $fields, array $values) {
    if(count($fields) != count($values)) die("Incorrect query;");
    $str = "INSERT INTO $table (" . implode(', ', $fields) . ") VALUES(" . $this->mask_template($values) . ")";
    $stm = $this->pdo->prepare($str);
    $stm->execute($values);
  }

  protected function mask_template($arr) { // функция создающая маск из знаков вопроса для подстановки в строку запроса
    $str = [];
    for($i = 0; $i < count($arr); $i++) {
      $str[] = "?";
    }
    return implode(', ', $str);
  }

  public function update_query($str) { // метод, который использует для выполнения запроса, не требуещего обработки ответа
    $this->pdo->query($str);
  }
}
 ?>
