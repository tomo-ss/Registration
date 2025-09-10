<?php
require_once 'db_connect.php';
session_start();

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    echo "IDが不正です。";
    exit;
}

try {
    $pdo = db_connect();
    $stmt = $pdo->prepare("SELECT * FROM account WHERE id = ?");
    $stmt->execute([$id]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$account) {
        echo "対象のアカウントが見つかりません。";
        exit;
    }

    // 「前に戻る」操作でPOSTされた場合はセッションの値を優先
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['back'])) {
        $form_data = $_SESSION['form_data'] ?? $account;
    } else {
        $form_data = $account;
    }

} catch (PDOException $e) {
    echo "DB接続エラー：" . $e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>アカウント更新画面</title>
  <link rel="stylesheet" href="update.css">
  <style>
    .error-message {
      color: red;
      font-size: 12px;
      margin-top: 4px;
      display: block;
    }
  </style>
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
    <h1>アカウント更新フォーム</h1>

    <form action="update_confirm.php" method="POST" id="updateForm">
      <input type="hidden" name="id" value="<?= htmlspecialchars($form_data['id']) ?>">

      <label>名前（姓）：
        <input type="text" name="family_name" maxlength="10" value="<?= htmlspecialchars($form_data['family_name']) ?>">
      </label>

      <label>名前（名）：
        <input type="text" name="last_name" maxlength="10" value="<?= htmlspecialchars($form_data['last_name']) ?>">
      </label>

      <label>カナ（姓）：
        <input type="text" name="family_name_kana" maxlength="10" value="<?= htmlspecialchars($form_data['family_name_kana']) ?>">
      </label>

      <label>カナ（名）：
        <input type="text" name="last_name_kana" maxlength="10" value="<?= htmlspecialchars($form_data['last_name_kana']) ?>">
      </label>

      <label>メールアドレス：
        <input type="text" name="mail" maxlength="100" value="<?= htmlspecialchars($form_data['mail']) ?>">
      </label>

      <label>パスワード：
        <input type="password" name="password" maxlength="10" value="<?= htmlspecialchars($form_data['password']) ?>">
      </label>

      <div class="form-row">
        <label for="gender">性別：</label>
        <div class="gender-group">
          <div class="gender-option">
            <input type="radio" name="gender" value="0" <?= ($form_data['gender'] ?? '') == 0 ? 'checked' : '' ?>><span>男</span>
          </div>
          <div class="gender-option">
            <input type="radio" name="gender" value="1" <?= ($form_data['gender'] ?? '') == 1 ? 'checked' : '' ?>><span>女</span>
          </div>
        </div>
      </div>

      <label>郵便番号：
        <input type="text" name="postal_code" maxlength="7" value="<?= htmlspecialchars($form_data['postal_code']) ?>">
      </label>

      <label>住所（都道府県）：
        <select name="prefecture">
          <option value="">選択してください</option>
          <?php
          $prefs = ['北海道','青森県','岩手県','宮城県','秋田県','山形県','福島県','茨城県','栃木県','群馬県','埼玉県','千葉県','東京都','神奈川県','新潟県','富山県','石川県','福井県','山梨県','長野県','岐阜県','静岡県','愛知県','三重県','滋賀県','京都府','大阪府','兵庫県','奈良県','和歌山県','鳥取県','島根県','岡山県','広島県','山口県','徳島県','香川県','愛媛県','高知県','福岡県','佐賀県','長崎県','熊本県','大分県','宮崎県','鹿児島県','沖縄県'];
          foreach ($prefs as $pref) {
              $selected = ($form_data['prefecture'] === $pref) ? 'selected' : '';
              echo "<option value=\"$pref\" $selected>$pref</option>";
          }
          ?>
        </select>
      </label>

      <label>住所（市区町村）：
        <input type="text" name="address_1" maxlength="10" value="<?= htmlspecialchars($form_data['address_1']) ?>">
      </label>

      <label>住所（番地）：
        <input type="text" name="address_2" maxlength="100" value="<?= htmlspecialchars($form_data['address_2']) ?>">
      </label>

      <label>アカウント権限：
        <select name="authority">
          <option value="一般" <?= $form_data['authority'] == 0 ? 'selected' : '' ?>>一般</option>
          <option value="管理者" <?= $form_data['authority'] == 1 ? 'selected' : '' ?>>管理者</option>
        </select>
      </label>

      <button type="submit">確認する</button>
    </form>
  </main>

  <footer>
    Copyright D.I.Works D.I.blog is the one which provides A to Z about programming
  </footer>
</body>
</html>