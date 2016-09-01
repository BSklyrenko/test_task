<?php
class Curl {

  private $url;
  private $ch;

  function __construct($url) {
    $this->url = $url;
  }

  private function setCurlOpt($data){
    $this->ch = curl_init( $this->url );
    curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);   // возвращает веб-страницу
    curl_setopt($this->ch, CURLOPT_HEADER, 0);           // не возвращает заголовки
    curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1);   // переходит по редиректам
    curl_setopt($this->ch, CURLOPT_ENCODING, "");        // обрабатывает все кодировки
    curl_setopt($this->ch, CURLOPT_POST, true);
    curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 120); // таймаут соединения
    curl_setopt($this->ch, CURLOPT_TIMEOUT, 120);        // таймаут ответа
    curl_setopt($this->ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);
  }

  public function getPageContent($data) {
    $this->setCurlOpt($data);

    $content = curl_exec($this->ch);
    curl_close($this->ch);
    return $content;
  }

  public function getErrorStatus($data) {
    $this->setCurlOpt($data);

    $err     = curl_errno( $this->ch );
    $errmsg  = curl_error( $this->ch );
    return [$err, $errmsg];
  }

  public function getFullInfo($data) {
    $this->setCurlOpt($data);

    $content = curl_exec( $this->ch );
    $err     = curl_errno( $this->ch );
    $errmsg  = curl_error( $this->ch );
    $header  = curl_getinfo( $this->ch );
    curl_close( $this->ch );

    $header['errno']   = $err;
    $header['errmsg']  = $errmsg;
    $header['content'] = $content;
    return $header;
  }
}
 ?>
