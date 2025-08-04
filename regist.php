<?php
// フォームから送信された各項目を受け取り、未定義の場合は空文字にする
$last_name       = $_POST['last_name'] ?? '';
$first_name      = $_POST['first_name'] ?? '';
$last_name_kana  = $_POST['last_name_kana'] ?? '';
$first_name_kana = $_POST['first_name_kana'] ?? '';
$email           = $_POST['email'] ?? '';
$password        = $_POST['password'] ?? '';
$gender          = $_POST['gender'] ?? '';
$postcode        = $_POST['postcode'] ?? '';
$prefecture      = $_POST['prefecture'] ?? '';
$city            = $_POST['city'] ?? '';
$address         = $_POST['address'] ?? '';
$authority       = $_POST['authority'] ?? '';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>アカウント登録画面</title>
  <link rel="stylesheet" type="text/css" href="regist.css">
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
<h1>アカウント登録画面</h1>

 <!-- フォームの送信先とメソッド設定 -->
<form action="regist_confirm.php" method="POST" id="registerForm" class="form-layout">
  <div class="form-group">
    <label for="last_name">名前（姓）</label>
    <input type="text" name="last_name" id="last_name" maxlength="10" required value="<?= htmlspecialchars($last_name) ?>">
  </div>

  <div class="form-group">
    <label for="first_name">名前（名）</label>
    <input type="text" name="first_name" id="first_name" maxlength="10" required value="<?= htmlspecialchars($first_name) ?>">
  </div>

  <div class="form-group">
    <label for="last_name_kana">カナ（姓）</label>
    <input type="text" name="last_name_kana" id="last_name_kana" maxlength="10" required value="<?= htmlspecialchars($last_name_kana) ?>">
  </div>

  <div class="form-group">
    <label for="first_name_kana">カナ（名）</label>
    <input type="text" name="first_name_kana" id="first_name_kana" maxlength="10" required value="<?= htmlspecialchars($first_name_kana) ?>">
  </div>

  <div class="form-group">
    <label for="email">メールアドレス</label>
    <input type="email" name="email" id="email" maxlength="100" required value="<?= htmlspecialchars($email) ?>">
  </div>

  <div class="form-group">
    <label for="password">パスワード</label>
    <input type="password" name="password" id="password" maxlength="10" required value="<?= htmlspecialchars($password) ?>">
  </div>

  <div class="form-group">
    <label>性別</label>
    <label><input type="radio" name="gender" value="男" <?= ($gender === '男') ? 'checked' : '' ?> required> 男</label>
    <label><input type="radio" name="gender" value="女" <?= ($gender === '女') ? 'checked' : '' ?>> 女</label>
  </div>

  <div class="form-group">
    <label for="postcode">郵便番号</label>
    <input type="text" name="postcode" id="postcode" maxlength="7" required value="<?= htmlspecialchars($postcode) ?>">
  </div>

  <div class="form-group">
    <label for="prefecture">住所（都道府県）</label>
    <select name="prefecture" id="prefecture" required>

      <option value="">選択してください</option>
      <?php
      $prefs = ["北海道","青森県","岩手県","宮城県","秋田県","山形県","福島県",
                "茨城県","栃木県","群馬県","埼玉県","千葉県","東京都","神奈川県",
                "新潟県","富山県","石川県","福井県","山梨県","長野県","岐阜県",
                "静岡県","愛知県","三重県","滋賀県","京都府","大阪府","兵庫県",
                "奈良県","和歌山県","鳥取県","島根県","岡山県","広島県","山口県",
                "徳島県","香川県","愛媛県","高知県","福岡県","佐賀県","長崎県",
                "熊本県","大分県","宮崎県","鹿児島県","沖縄県"];
      foreach ($prefs as $p) {
        $selected = ($prefecture === $p) ? 'selected' : '';
        echo "<option value=\"$p\" $selected>$p</option>";
      }
      ?>
    </select>
  </div>

  <div class="form-group">
    <label for="city">住所（市区町村）</label>
    <input type="text" name="city" id="city" maxlength="10" required value="<?= htmlspecialchars($city) ?>">
  </div>

  <div class="form-group">
    <label for="address">住所（番地）</label>
    <input type="text" name="address" id="address" maxlength="100" required value="<?= htmlspecialchars($address) ?>">
  </div>

  <div class="form-group">
    <label for="authority">アカウント権限</label>
    <select name="authority" id="authority">
      <option value="一般" <?= ($authority === '一般') ? 'selected' : '' ?>>一般</option>
      <option value="管理者" <?= ($authority === '管理者') ? 'selected' : '' ?>>管理者</option>
    </select>
  </div>

  <div class="form-group">
    <button type="submit">確認する</button>
  </div>
</form>
</main>

<footer>
  Copyright D.I.Works D.I.blog is the one which provides A to Z about programming
</footer>
</body>
</html>