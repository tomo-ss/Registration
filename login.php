<?php
session_start();
$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ログイン</title>
  <link rel="stylesheet" href="login.css">
</head>
<body>
  <header>
    <ul>
      <li><a href="index.php">トップ</a></li>
      <li>プロフィール</li>
      <li>D.I.Blogについて</li>
      <li>登録フォーム</li>
      <li>問い合わせ</li>
      <li>その他</li>
    </ul>
  </header>

  <main>
    <h1>ログイン画面</h1>

    <?php if ($error): ?>
      <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="login_process.php">
      <label for="mail">メールアドレス：</label><br>
      <input type="text" name="mail" id="mail" maxlength="100"><br><br>

      <label for="password">パスワード：</label><br>
      <input type="password" name="password" id="password" maxlength="10"><br><br>

      <button type="submit">ログイン</button>
    </form>
  </main>

    <footer>
      Copyright D.I.Works D.I.blog is the one which provides A to Z about programming
    </footer>

</body>
</html>