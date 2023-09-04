<?php

require_once __DIR__ . '/lib/mysqli.php';

function createCompany($link, $company)
{
  $sql = <<<EOT
INSERT INTO companies(
    name,
    establishment_date,
    founder
)VALUES (
  "{$company['name']}",
  "{$company['establishment_date']}",
  "{$company['founder']}"
)
EOT;
  $result = mysqli_query($link, $sql);
  if (!$result) {
    error_log('Error: fail to create company');
    error_log('Debugging Error: ' . mysqli_error($link));
  }
}

function validate($company)
{
  $errors = [];

  // 会社名
  if (!strlen($company['name'])) {
    $errors['name'] = '会社名を入力してください。';
  } elseif (strlen($company['name']) > 255) {
    $errors['name'] = '会社名は255文字以内で入力してください。';
  }
  return $errors;
}

// HTTPメソッドがPOSTだったら
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // POSTされた会社情報を変数に格納する
  $company = [
    'name' => $_POST['name'],
    'establishment_date' => $_POST['establishment_date'],
    'founder' => $_POST['founder']
  ];

  // バリデーションする
  $errors = validate($company);
  // バリデーションエラーがなければ
  if (!count($errors)) {
    // データベースに接続する
    $link = dbConnect();

    // データベースにデータを登録する
    createCompany($link, $company);

    // データベースとの接続を切断する
    mysqli_close($link);

    header("Location: index.php");
  }


  // もしエラーがあれば下記のHTMLが表示される
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>会社情報の登録</title>
</head>

<body>
  <h1>会社情報の登録</h1>
  <form action="create.php" method="POST">
    <?php if (count($errors)) : ?>
      <ul>
        <?php foreach ($errors as $error) : ?>
          <li><?php echo $error; ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <div>
      <label for="name">会社名</label>
      <input type="text" id="name" name="name">
    </div>
    <div>
      <label for="establishment_date">設立日</label>
      <input type="date" id="establishment_date" name="establishment_date">
    </div>
    <div>
      <label for="founder">代表者</label>
      <input type="text" id="founder" name="founder">
    </div>
    <button type="submit">登録する</button>
  </form>
</body>

</html>



