<?php

// CSRF対策
// Token発行してSessionに格納
// フォームからもTokenを発行、送信
// Check

// namespace MyApp;

// class Todo {
  // private $_db;  //下記で必要 何もない変数を作った

  // public function __construct() {  //最初に行われるのはこれという意味 construct
    // $this->_createToken();

    try {
      $pdo = new PDO(DSN, DB_USERNAME, DB_PASSWORD);       //namespace内にいる為
      $pdo->setAttribute(PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
      $stmt = $pdo->query("select * from todos order by id desc");
      $todos = $stmt->fetchAll(PDO::FETCH_OBJ);

    } catch (PDOException $e) {
      echo $e->getMessage();
      exit;
    }

  //  function _createToken() {
  //   if (!isset($_SESSION['token'])) {
  //     $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
  //   }
  // }


//   public function post() {     // validateToken()
//     $this->_validateToken();
//
    if (!isset($_POST['mode'])) {     //jsから"mode"渡してる
      throw new \Exception('mode not set!');
    }

    switch ($_POST['mode']) {
      case 'update':
        return $this->_update();
      case 'create':
        return $this->_create();
      case 'delete':
        return $this->_delete();
    }

  // }
//
//   public function _validateToken() {
//     if (
//       !isset($_SESSION['token']) ||
//       !isset($_POST['token']) ||
//       $_SESSION['token'] !== $_POST['token']
//     ) {
//       throw new \Exception('invalid token!');
//     }
//   }
//
  public function _update() {
    if (!isset($_POST['id'])) {
      throw new \Exception('[update] id not set!');
    }

    $this->_db->beginTransaction();

    $sql = sprintf("update todos set state = (state + 1) %% 2 where id = %d", $_POST['id']);  //ここの動きが適用されていると思われるが不明
    $stmt = $this->_db->prepare($sql);
    $stmt->execute(); //クエリの実行

    $sql = sprintf("select state from todos where id = %d", $_POST['id']);
    $stmt = $this->_db->query($sql);
    $state = $stmt->fetchColumn();

    $this->_db->commit();

    return [
      'state' => $state
    ];
  }
//
//   public function _create() {
//     if (!isset($_POST['title']) || $_POST['title'] === '') {
//       throw new \Exception('[create] title not set!');
//     }
//
//     $sql = "insert into todos (title) values (:title)";
//     $stmt = $this->_db->prepare($sql);
//     $stmt->execute([':title' => $_POST['title']]);
//
//     return [
//       'id' => $this->_db->lastInsertId()
//     ];
//   }
//
    function _delete() {
    if (!isset($_POST['id'])) {
      throw new \Exception('[delete] id not set!');
    }

    $sql = sprintf("delete from todos where id = %d", $_POST['id']);
    $stmt = $this->_db->prepare($sql);
    $stmt->execute();

    return [];
//   }
// }
