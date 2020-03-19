<?php

// session_start();

require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/function.php');
require_once(__DIR__ . '/Todo.php');



// get todos
// $todoApp = new \MyApp\Todo();
// $todos = $todoApp->getAll();
// var_dump($todos);
// exit;

// if (isset($_POST['title'])) {
// $title = $_POST['title'];
// $todoApp->_create();
// }

// $todos = $todoApp->getAll();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>My Todos</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div id="container">
    <h1>Todos</h1>
    <form action="todo.php" id="new_todo_form" method="post">
      <input type="text" id="new_todo" placeholder="What needs to be done?" >
      <!-- <input type="text" name="title" value="" placeholder="What needs to be done?"> -->
      <input type="submit">
    <ul id="todos">
    <?php foreach ($todos as $todo) : ?>
      <li id="todo_<?= h($todo->id); ?>" data-id="<?= h($todo->id); ?>">
        <input type="checkbox" class="update_todo" <?php if ($todo->state === '1') { echo 'checked'; } ?>>
        <span class="todo_title <?php if ($todo->state === '1') { echo 'done'; } ?>"><?= h($todo->title); ?></span>
        <div class="delete_todo">x</div>
      </li>
    <?php endforeach; ?>

      <li id="todo_template" data-id="">      <!--????-->
        <input type="checkbox" class="update_todo">
        <span class="todo_title"></span>
        <div class="delete_todo">x</div>
      </li>
    </ul>
  </form>

  </div>
  <!-- <input type="hidden" id="token" value="<?= h($_SESSION['token']); ?>"> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="todo.js"></script>
</body>
</html>
