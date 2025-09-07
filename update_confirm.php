<?php
require_once 'db_connect.php';
session_start();

// POSTデータの取得
$id                = $_POST['id'] ?? '';
$family_name       = $_POST['family_name'] ?? '';
$last_name         = $_POST['last_name'] ?? '';
$family_name_kana  = $_POST['family_name_kana'] ?? '';
$last_name_kana    = $_POST['last_name_kana'] ?? '';
$mail              = $_POST['mail'] ?? '';
$password          = $_POST['password'] ?? '';
$gender_raw        = $_POST['gender'] ?? '';
$postal_code       = $_POST['postal_code'] ?? '';
$prefecture        = $_POST['prefecture'] ?? '';
$address_1         = $_POST['address_1'] ?? '';
$address_2         = $_POST['address_2'] ?? '';
$authority_raw     = $_POST['authority'] ?? '';

// DB登録用に gender / authority を数値化
$gender = ($gender_raw === '男' || $gender_raw === '0') ? 0 : (($gender_raw === '女' || $gender_raw === '1') ? 1 : null);
$authority = ($authority_raw === '一般' || $authority_raw === '0') ? 0 : (($authority_raw === '管理者' || $authority_raw === '1') ? 1 : null);

// 表示用に性別と権限を文字列化（万が一 raw が数値だった場合も補完）
$gender_display = ($gender === 0) ? '男' : (($gender === 1) ? '女' : '');
$authority_display = ($authority === 0) ? '一般' : (($authority === 1) ? '管理者' : '');

// パスワードは伏せて表示
$hidden_password = str_repeat("●", mb_strlen($password));
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>アカウント更新確認</title>
  <link rel="stylesheet" type="text/css" href="update_confirm.css">
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
      <li><a href="list.php">アカウント一覧</a></li>
      <li>その他</li>
    </ul>
  </header>

  <main>
    <h1>アカウント更新内容確認</h1>
    <table>
      <tr><th>名前（姓）</th><td><?= htmlspecialchars($family_name) ?></td></tr>
      <tr><th>名前（名）</th><td><?= htmlspecialchars($last_name) ?></td></tr>
      <tr><th>カナ（姓）</th><td><?= htmlspecialchars($family_name_kana) ?></td></tr>
      <tr><th>カナ（名）</th><td><?= htmlspecialchars($last_name_kana) ?></td></tr>
      <tr><th>メールアドレス</th><td><?= htmlspecialchars($mail) ?></td></tr>
      <tr><th>パスワード</th><td><?= $hidden_password ?></td></tr>
      <tr><th>性別</th><td><?= htmlspecialchars($gender_display) ?></td></tr>
      <tr><th>郵便番号</th><td><?= htmlspecialchars($postal_code) ?></td></tr>
      <tr><th>住所（都道府県）</th><td><?= htmlspecialchars($prefecture) ?></td></tr>
      <tr><th>住所（市区町村）</th><td><?= htmlspecialchars($address_1) ?></td></tr>
      <tr><th>住所（番地）</th><td><?= htmlspecialchars($address_2) ?></td></tr>
      <tr><th>アカウント権限</th><td><?= htmlspecialchars($authority_display) ?></td></tr>
    </table>

    <form method="POST">
      <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
      <input type="hidden" name="family_name" value="<?= htmlspecialchars($family_name) ?>">
      <input type="hidden" name="last_name" value="<?= htmlspecialchars($last_name) ?>">
      <input type="hidden" name="family_name_kana" value="<?= htmlspecialchars($family_name_kana) ?>">
      <input type="hidden" name="last_name_kana" value="<?= htmlspecialchars($last_name_kana) ?>">
      <input type="hidden" name="mail" value="<?= htmlspecialchars($mail) ?>">
      <input type="hidden" name="password" value="<?= htmlspecialchars($password) ?>">
      <input type="hidden" name="gender" value="<?= $gender ?>">
      <input type="hidden" name="postal_code" value="<?= htmlspecialchars($postal_code) ?>">
      <input type="hidden" name="prefecture" value="<?= htmlspecialchars($prefecture) ?>">
      <input type="hidden" name="address_1" value="<?= htmlspecialchars($address_1) ?>">
      <input type="hidden" name="address_2" value="<?= htmlspecialchars($address_2) ?>">
      <input type="hidden" name="authority" value="<?= $authority ?>">

      <button type="submit" formaction="update_process.php">更新する</button>
      <button type="submit" formaction="update.php?id=<?= urlencode($id) ?>">前に戻る</button>
    </form>
  </main>

  <footer>
    Copyright D.I.Works D.I.blog is the one which provides A to Z about programming
  </footer>
</body>
</html>