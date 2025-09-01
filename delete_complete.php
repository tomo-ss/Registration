<?php
// セッション開始
session_start();

// 削除処理が完了したことを確認
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>削除完了</title>
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
  <div class="container">
    <h1>削除が完了しました </h1>
    <p>対象のデータは正常に削除されました。</p>
    <a href="index.html" class="btn">一覧に戻る</a>
  </div>
</main>
    <footer>
    Copyright D.I.Works D.I.blog is the one which provides A to Z about programming
  </footer>
</body>
</html>
