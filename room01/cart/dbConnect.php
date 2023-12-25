<?php

// $db = mysql_connect('localhost', 'root', 'root', 'sousaku') or die(mysql_connect_error());
// mysql_set_charset($db, 'utf8');

/**
  * 
  */
class connect
{
  // 定数の宣言
  const DB_NAME = 'sousaku';
  const HOST = 'localhost';
  const UTF = 'utf8';
  const USER = 'root';
  const PASS = 'root';

  private $dbh;

  // データベースに接続
  function __construct()
  {
    $dsn = 'mysql:host='.self::HOST.';dbname='.self::DB_NAME.';charset='.self::UTF;
    try{
      $this->dbh = new PDO($dsn, self::USER, self::PASS);
    } catch(Exception $e){
      exit($e->getMessage());
    }

    $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
  }

  public function select($sql){
    $stmt = $this->dbh->query($sql);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $items;
  }

  public function plural($sql, $item){
    $stmt = $this->dbh->prepare($sql);
    $stmt->execute(array(":id"=>$item));
    return $stmt;
  }
}

?>