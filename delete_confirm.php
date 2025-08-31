<?php
require_once 'db_connect.php'; // DB接続

$id = $_POST['id'] ?? null;
$error_message = '';

if (!$id) {
    echo "IDが指定されていません。";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        try {
            $pdo = dbConnect();
            $stmt = $pdo->prepare("UPDATE account SET delete_flag = 1 WHERE id = ?");
            $stmt->execute([$id]);

            header("Location: delete_complete.php");
            exit;
        } catch (PDOException $e) {
            $error_message = "エラーが発生したためアカウント削除できません。";
        }
    } elseif (isset($_POST['back'])) {
        header("Location: delete.php?id=" . urlencode($id));
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>アカウント削除確認</title>
    <link rel="stylesheet" href="delete_confirm.css">
    <style>
        .center { text-align: center; margin-top: 60px; }
        .error { color: red; margin-top: 20px; }
        button { padding: 10px 20px; margin: 10px; }
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
    <div class="center">
        <h2>本当に削除してよろしいですか？</h2>

        <?php if ($error_message): ?>
            <p class="error"><?= htmlspecialchars($error_message) ?></p>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
            <button type="submit" name="delete">削除する</button>
            <button type="submit" name="back">前に戻る</button>
        </form>
    </div>
        </main>
  <footer>
    Copyright D.I.Works D.I.blog is the one which provides A to Z about programming
  </footer>
</body>
</html>