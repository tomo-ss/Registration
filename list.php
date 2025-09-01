<?php
// DB接続情報
$dsn = 'mysql:host=localhost;dbname=d.i_blog;charset=utf8';
$user = 'root';
$password = '';

// DB接続
try {
    $pdo = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'DB接続エラー: ' . $e->getMessage();
    exit;
}

// アカウント一覧取得（ID降順）
$sql = "SELECT * FROM account WHERE delete_flag = 0 ORDER BY id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>アカウント一覧</title>
    <link rel="stylesheet" href="list.css">

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
    <h1>アカウント一覧</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>名前（姓）</th>
            <th>名前（名）</th>
            <th>カナ（姓）</th>
            <th>カナ（名）</th>
            <th>メールアドレス</th>
            <th>性別</th>
            <th>アカウント権限</th>
            <th>削除フラグ</th>
            <th>登録日時</th>
            <th>更新日時</th>
            <th>操作</th>
        </tr>
        <?php foreach ($accounts as $account): ?>
<tr>
    <td><?= htmlspecialchars($account['id']) ?></td>
    <td><?= htmlspecialchars($account['family_name']) ?></td>
    <td><?= htmlspecialchars($account['last_name']) ?></td>
    <td><?= htmlspecialchars($account['family_name_kana']) ?></td>
    <td><?= htmlspecialchars($account['last_name_kana']) ?></td>
    <td><?= htmlspecialchars($account['mail']) ?></td>
    <td><?= $account['gender'] == 0 ? '男' : '女' ?></td>
    <td><?= $account['authority'] == 0 ? '一般' : '管理者' ?></td>
    <td><?= $account['delete_flag'] == 0 ? '有効' : '無効' ?></td>
    <td><?= date('Y-m-d', strtotime($account['registered_time'])) ?></td>
    <td><?= date('Y-m-d', strtotime($account['update_time'])) ?></td>
    <td>
        <form action="update.php" method="get" style="display:inline;">
            <input type="hidden" name="id" value="<?= $account['id'] ?>">
            <button type="submit">更新</button>
        </form>
        <form action="delete.php" method="get" style="display:inline;">
            <input type="hidden" name="id" value="<?= $account['id'] ?>">
            <button type="submit">削除</button>
        </form>
    </td>
</tr>
        <?php endforeach; ?>
    </table>
        </main>

    <footer>
      Copyright D.I.Works D.I.blog is the one which provides A to Z about programming
    </footer>
</body>
</html>