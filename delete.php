<?php
session_start();
if (!isset($_SESSION['authority']) || $_SESSION['authority'] !== '管理者') {
    echo "<p style='color:red;'>権限がないため操作できません。</p>";
    exit;
}
?>

<?php
require_once 'db_connect.php'; // DB接続
$pdo = db_connect();

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "IDが指定されていません。";
    exit;
}

// アカウント情報取得（削除フラグが0のもののみ）
$stmt = $pdo->prepare("SELECT * FROM account WHERE id = ? AND delete_flag = 0");
$stmt->execute([$id]);
$account = $stmt->fetch();

if (!$account) {
    echo "該当アカウントが見つかりません。";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>アカウント削除</title>
    <link rel="stylesheet" href="delete.css">
</head>
<body>
  <header>
    <ul>
      
    
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
    <h1>アカウント削除画面</h1>

<div class="account-info">
  <p><span class="label">名前（姓）</span><span class="value"><?= htmlspecialchars($account['family_name']) ?></span></p>
  <p><span class="label">名前（名）</span><span class="value"><?= htmlspecialchars($account['last_name']) ?></span></p>
  <p><span class="label">カナ（姓）</span><span class="value"><?= htmlspecialchars($account['family_name_kana']) ?></span></p>
  <p><span class="label">カナ（名）</span><span class="value"><?= htmlspecialchars($account['last_name_kana']) ?></span></p>
  <p><span class="label">メールアドレス</span><span class="value"><?= htmlspecialchars($account['mail']) ?></span></p>
  <p><span class="label">パスワード</span><span class="value">●●●●●●●●</span></p>
  <p><span class="label">性別</span><span class="value"><?= $account['gender'] == 0 ? '男' : '女' ?></span></p>
  <p><span class="label">郵便番号</span><span class="value"><?= htmlspecialchars($account['postal_code']) ?></span></p>
  <p><span class="label">住所（都道府県）</span><span class="value"><?= htmlspecialchars($account['prefecture']) ?></span></p>
  <p><span class="label">住所（市区町村）</span><span class="value"><?= htmlspecialchars($account['address_1']) ?></span></p>
  <p><span class="label">住所（番地）</span><span class="value"><?= htmlspecialchars($account['address_2']) ?></span></p>
  <p><span class="label">アカウント権限</span><span class="value"><?= $account['authority'] == 0 ? '一般' : '管理者' ?></span></p>
</div>
    <div class="button-wrapper">
      <form action="delete_confirm.php" method="post">
        <input type="hidden" name="id" value="<?= htmlspecialchars($account['id']) ?>">
        <button type="submit">確認する</button>
      </form>
    </div>
  </main>

  <footer>
    Copyright D.I.Works D.I.blog is the one which provides A to Z about programming
  </footer>
</body>
</html>