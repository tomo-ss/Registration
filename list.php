<?php
session_start();
if (!isset($_SESSION['authority']) || $_SESSION['authority'] !== 1) {
    echo "<p style='color:red;'>権限がないため操作できません。</p>";
    exit;
}

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

// 初期化
$accounts = [];
$conditions = ["delete_flag = 0"];
$params = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['family_name'])) {
        $conditions[] = "family_name LIKE ?";
        $params[] = "%" . $_POST['family_name'] . "%";
    }
    if (!empty($_POST['last_name'])) {
        $conditions[] = "last_name LIKE ?";
        $params[] = "%" . $_POST['last_name'] . "%";
    }
    if (!empty($_POST['family_name_kana'])) {
        $conditions[] = "family_name_kana LIKE ?";
        $params[] = "%" . $_POST['family_name_kana'] . "%";
    }
    if (!empty($_POST['last_name_kana'])) {
        $conditions[] = "last_name_kana LIKE ?";
        $params[] = "%" . $_POST['last_name_kana'] . "%";
    }
    if (!empty($_POST['mail'])) {
        $conditions[] = "mail LIKE ?";
        $params[] = "%" . $_POST['mail'] . "%";
    }
    if (isset($_POST['gender']) && $_POST['gender'] !== '') {
        $conditions[] = "gender = ?";
        $params[] = $_POST['gender'];
    }
    if (isset($_POST['authority']) && $_POST['authority'] !== '') {
        $conditions[] = "authority = ?";
        $params[] = $_POST['authority'];
    }

    $sql = "SELECT * FROM account WHERE " . implode(" AND ", $conditions) . " ORDER BY id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// 初期値設定
$gender = $_SERVER['REQUEST_METHOD'] === 'POST' ? ($_POST['gender'] ?? '') : '0';
$authority = $_SERVER['REQUEST_METHOD'] === 'POST' ? ($_POST['authority'] ?? '') : '0';
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
        <li><a href="index.php">トップ</a></li>
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

    <form method="POST" action="list.php" class="search-form">
        <table>
            <tr>
                <th>名前（姓）</th>
                <td><input type="text" name="family_name" value="<?= htmlspecialchars($_POST['family_name'] ?? '') ?>"></td>
                <th>名前（名）</th>
                <td><input type="text" name="last_name" value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>"></td>
            </tr>
            <tr>
                <th>カナ（姓）</th>
                <td><input type="text" name="family_name_kana" value="<?= htmlspecialchars($_POST['family_name_kana'] ?? '') ?>"></td>
                <th>カナ（名）</th>
                <td><input type="text" name="last_name_kana" value="<?= htmlspecialchars($_POST['last_name_kana'] ?? '') ?>"></td>
            </tr>
            <tr>
                <th>メールアドレス</th>
                <td colspan="3"><input type="text" name="mail" value="<?= htmlspecialchars($_POST['mail'] ?? '') ?>"></td>
            </tr>
            <tr>
                <th>性別</th>
                <td class="radio-group">
                    <label><input type="radio" name="gender" value="0" <?= $gender === "0" ? 'checked' : '' ?>>男</label>
                    <label><input type="radio" name="gender" value="1" <?= $gender === "1" ? 'checked' : '' ?>>女</label>
                </td>
                <th>アカウント権限</th>
                <td>
                    <select name="authority">
                        <option value="">選択しない</option>
                        <option value="0" <?= $authority === "0" ? 'selected' : '' ?>>一般</option>
                        <option value="1" <?= $authority === "1" ? 'selected' : '' ?>>管理者</option>
                    </select>
                </td>
            </tr>
        </table>
        <button type="submit">検索</button>
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($accounts)): ?>
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
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <p>該当するアカウントはありません。</p>
    <?php endif; ?>
</main>

<footer>
    Copyright D.I.Works D.I.blog is the one which provides A to Z about programming
</footer>

<!-- ラジオボタン選択解除 -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  let lastClicked = null;
  document.querySelectorAll('input[name="gender"]').forEach(radio => {
    radio.addEventListener('click', function () {
      if (lastClicked === this) {
        this.checked = false;
        lastClicked = null;
      } else {
        lastClicked = this;
      }
    });
  });
});
</script>
</body>
</html>