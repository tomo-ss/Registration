<?php
require_once('db_connect.php');
session_start();

$error_message = '';
$id = $_POST['id'] ?? null;

if (!$id || !is_numeric($id)) {
    $error_message = "IDが不正です。";
} else {
    try {
        $pdo = db_connect();
        $stmt = $pdo->prepare("UPDATE account SET delete_flag = 1 WHERE id = ?");
        $stmt->execute([$id]);

        // 削除成功 → 完了画面へ
        header("Location: delete_complete.php");
        exit;
    } catch (PDOException $e) {
        $error_message = "エラーが発生したためアカウント削除できません。";
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>削除エラー</title>
    <style>
        .error {
            color: red;
            font-weight: bold;
            text-align: center;
            margin-top: 80px;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <?php if ($error_message): ?>
        <div class="error"><?= htmlspecialchars($error_message) ?></div>
    <?php endif; ?>
</body>
</html>