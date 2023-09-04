<?php
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>読書ログ登録</title>
</head>

<body>
  <h1>読書ログ</h1>
  <form action="" method="post">
    <div>
      <label for="title">書籍名</label>
      <input type="text" id="title" name="title">
    </div>
    <div>
      <label for="author">著者名</label>
      <input type="text" id="author" name="author">
    </div>
    <div>
      <!-- radioボタンを使用する -->
      <label>読書状況</label>
      <div>
        <div>
          <input type="radio" id="reading1" name="reading" value="未読">
          <label for="reading1">未読</label>
        </div>
        <div>
          <input type="radio" id="reading2" name="reading" value="読んでる">
          <label for="reading2">読んでる</label>
        </div>
        <div>
          <input class="form-chek-input" type="radio" id="reading3" name="reading" value="読了">
          <label for="reading3">読了</label>
        </div>
      </div>
    </div>
    <div>
      <!-- 数字のみ使用できるinputタグを使用する -->
      <label for="evaluation">評価(５点満点の整数)</label>
      <input type="number" max="5" min="1" id="evaluation" name="evaluation">
    </div>
    <div>
      <!-- input type="text"は1行しか入らないので、複数行入るようにする -->
      <label for="thoughts">感想</label>
      <textarea type="text" id="thoughts" name="thoughts" rows="10"></textarea>
    </div>
    <button type="submit">登録する</button>
  </form>
</body>

</html>
