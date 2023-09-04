<?php

function validated($review)
{
  $errors = [];

  //書籍名が正しく入力されているかチェック
  if(!strlen($review['title'])) {
    $errors['title'] = '書籍名を入力してください。';
  } elseif(strlen($review['title']) > 255) {
    $errors['title'] = '書籍名は255文字以内で入力してください。';
  }

  //著者名が正しく入力されているかチェック
  if(!strlen($review['author'])) {
    $errors['author'] = '著者名を入力してください。';
  } elseif(strlen($review['author']) > 100) {
    $errors['author'] = '書籍名は255文字以内で入力してください。';
  }

  //読書状況が正しく入力されているかチェック
  if(!in_array($review['reading'],['未読','読んでる','読了',],true)) {
    $errors['reading'] = '読書状況は「未読」「読んでる」「読了」の中から1つ入力してください。';
  }

  //評価が1以上5以下で正しく入力されているかのチェック
  if($review['evaluation'] < 1 || $review['evaluation'] > 5) {
    $errors['evaluation'] = '評価は1から5の整数を入力してください。';
  }

  //感想が正しく入力されているかチェック
  if (!strlen($review['thoughts'])) {
    $errors['thoughts'] = '感想を入力してください。';
  } elseif (strlen($review['thoughts']) > 1000) {
    $errors['thoughts'] = '感想は1000文字以内で入力してください。';
  }

  return $errors;

}

function createReview($link){
  $review= [];

  echo '読書ログを登録してください' . PHP_EOL;
  echo '書籍名:';
  $review['title'] = trim(fgets(STDIN));

  echo '著者名:';
  $review['author'] = trim(fgets(STDIN));

  echo '読書状況（未読, 読んでる,読了）:';
  $review['reading'] = trim(fgets(STDIN));

  echo '評価（5点満点の整数）:';
  $review['evaluation'] = (int) trim(fgets(STDIN));

  echo '感想:';
  $review['thoughts'] = trim(fgets(STDIN));

  $validated = validated($review);
  if (count($validated) > 0) {
    foreach($validated as $error) {
      echo $error . PHP_EOL;
    }
    return;
  }


  $sql = <<<EOT
INSERT INTO reviews(
  title,
  author,
  reading,
  evaluation,
  thoughts
) VALUES (
  "{$review['title']}",
  "{$review['author']}",
  "{$review['reading']}",
  "{$review['evaluation']}",
  "{$review['thoughts']}"
)
EOT;

  $result = mysqli_query($link,$sql);
  if ($result) {
    echo '登録を完了しました。' . PHP_EOL;
  } else {
    echo 'Error:登録に失敗しました。' . PHP_EOL;
    echo 'Debugging Error:' . mysqli_error($link) . PHP_EOL . PHP_EOL;
  }
}

function showingReview($link){
  echo '登録されている読書ログを表示します' . PHP_EOL;
  $sql = 'SELECT id, title,author,reading,evaluation,thoughts,created_at FROM reviews';
  $results = mysqli_query($link, $sql);
  while ($review = mysqli_fetch_assoc($results)) {
    echo '書籍名:' . $review['title'] . PHP_EOL;
    echo '著者名:' . $review['author'] . PHP_EOL;
    echo '読書状況(未読, 読んでる,読了):' . $review['reading'] . PHP_EOL;
    echo '評価(5点満点の整数):' . $review['evaluation'] . PHP_EOL;
    echo '感想:' . $review['thoughts'] . PHP_EOL;
    echo  "-------------" . PHP_EOL;
  }
  mysqli_free_result($results);
}

function dbConnect()
{
  $link = mysqli_connect('db', 'book_log', 'pass', 'book_log');
  if (!$link) {
    echo 'Error:データベースに接続できません' . PHP_EOL;
    echo 'Debugging error:' . mysqli_connect_error() . PHP_EOL;
  exit;
  }
  // echo 'データベースに接続しました' . PHP_EOL;
  return $link;
}

// $reviews = [];
$link = dbConnect();

while(true) {
  echo '1.読書ログを登録' . PHP_EOL;
  echo '2.読書ログを表示' . PHP_EOL;
  echo '9.アプリケーションを終了' . PHP_EOL;
  echo '番号を選択してください(1,2,9) :' . PHP_EOL;
  $num = trim(fgets(STDIN));

  if($num === '1') {
    createReview($link);
  } elseif($num === '2') {
    showingReview($link);
  }elseif($num === '9') {
    mysqli_close($link);
    break;
  }
}
