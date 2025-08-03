<?php
$last_name        = $_POST['last_name'];
$first_name       = $_POST['first_name'];
$last_name_kana   = $_POST['last_name_kana'];
$first_name_kana  = $_POST['first_name_kana'];
$email            = $_POST['email'];
$password         = $_POST['password'];
$gender           = $_POST['gender'];
$postcode         = $_POST['postcode'];
$prefecture       = $_POST['prefecture'];
$city             = $_POST['city'];
$address          = $_POST['address'];
$authority        = $_POST['authority'];

$hidden_password = str_repeat("●", strlen($password));
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>アカウント確認画面</title>
  <link rel="stylesheet" type="text/css" href="confirm.css">
</head>

<body>
  <header>
    <ul>
      <li><a href="index.html">トップ</a></li>
      <li>プロフィール</li>
      <li>D.I.Blogについて</li>
      <li>登録フォーム</li>
      <li>問い合わせ</li>
      <li><a href="regist.php">アカウント登録</a></li>
      <li>その他</li>
    </ul>
  </header>

  <main>
    <h1>アカウント登録内容確認</h1>
    <table>
      <tr><th>名前（姓）</th><td><?= htmlspecialchars($last_name) ?></td></tr>
      <tr><th>名前（名）</th><td><?= htmlspecialchars($first_name) ?></td></tr>
      <tr><th>カナ（姓）</th><td><?= htmlspecialchars($last_name_kana) ?></td></tr>
      <tr><th>カナ（名）</th><td><?= htmlspecialchars($first_name_kana) ?></td></tr>
      <tr><th>メールアドレス</th><td><?= htmlspecialchars($email) ?></td></tr>
      <tr><th>パスワード</th><td><?= $hidden_password ?></td></tr>
      <tr><th>性別</th><td><?= htmlspecialchars($gender) ?></td></tr>
      <tr><th>郵便番号</th><td><?= htmlspecialchars($postcode) ?></td></tr>
      <tr><th>住所（都道府県）</th><td><?= htmlspecialchars($prefecture) ?></td></tr>
      <tr><th>住所（市区町村）</th><td><?= htmlspecialchars($city) ?></td></tr>
      <tr><th>住所（番地）</th><td><?= htmlspecialchars($address) ?></td></tr>
      <tr><th>アカウント権限</th><td><?= htmlspecialchars($authority) ?></td></tr>
    </table>

  
    <form method="POST">
      <input type="hidden" name="last_name" value="<?= htmlspecialchars($last_name) ?>">
      <input type="hidden" name="first_name" value="<?= htmlspecialchars($first_name) ?>">
      <input type="hidden" name="last_name_kana" value="<?= htmlspecialchars($last_name_kana) ?>">
      <input type="hidden" name="first_name_kana" value="<?= htmlspecialchars($first_name_kana) ?>">
      <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
      <input type="hidden" name="password" value="<?= htmlspecialchars($password) ?>">
      <input type="hidden" name="gender" value="<?= htmlspecialchars($gender) ?>">
      <input type="hidden" name="postcode" value="<?= htmlspecialchars($postcode) ?>">
      <input type="hidden" name="prefecture" value="<?= htmlspecialchars($prefecture) ?>">
      <input type="hidden" name="city" value="<?= htmlspecialchars($city) ?>">
      <input type="hidden" name="address" value="<?= htmlspecialchars($address) ?>">
      <input type="hidden" name="authority" value="<?= htmlspecialchars($authority) ?>">

      
      <div class="button-wrapper">
        <button type="submit" formaction="regist_insert.php">登録する</button>
        <button type="submit" formaction="regist.php">前に戻る</button>
      </div>
    </form>
  </main>

  <footer>
    Copyright D.I.Works D.I.blog is the one which provides A to Z about programming
  </footer>
</body>
</html>