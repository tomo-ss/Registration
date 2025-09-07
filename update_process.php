<?php
require_once 'db_connect.php';
session_start();

$error_message = '';

// POSTデータの取得
$id                = $_POST['id'] ?? '';
$family_name       = $_POST['family_name'] ?? '';
$last_name         = $_POST['last_name'] ?? '';
$family_name_kana  = $_POST['family_name_kana'] ?? '';
$last_name_kana    = $_POST['last_name_kana'] ?? '';
$mail              = $_POST['mail'] ?? '';
$password          = $_POST['password'] ?? '';
$gender            = $_POST['gender'] ?? '';
$postal_code       = $_POST['postal_code'] ?? '';
$prefecture        = $_POST['prefecture'] ?? '';
$address_1         = $_POST['address_1'] ?? '';
$address_2         = $_POST['address_2'] ?? '';
$authority         = $_POST['authority'] ?? '';

// バリデーション
if (!$id || !$family_name || !$last_name || !$mail || !$password) {
    $error_message = "必須項目が未入力です。";
}

// パスワード暗号化
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

if (!$error_message) {
    try {
        $pdo = db_connect();
        $sql = "UPDATE account SET 
                    family_name = :family_name,
                    last_name = :last_name,
                    family_name_kana = :family_name_kana,
                    last_name_kana = :last_name_kana,
                    mail = :mail,
                    password = :password,
                    gender = :gender,
                    postal_code = :postal_code,
                    prefecture = :prefecture,
                    address_1 = :address_1,
                    address_2 = :address_2,
                    authority = :authority,
                    update_time = NOW()
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':family_name', $family_name);
        $stmt->bindValue(':last_name', $last_name);
        $stmt->bindValue(':family_name_kana', $family_name_kana);
        $stmt->bindValue(':last_name_kana', $last_name_kana);
        $stmt->bindValue(':mail', $mail);
        $stmt->bindValue(':password', $hashed_password);
        $stmt->bindValue(':gender', $gender, PDO::PARAM_INT);
        $stmt->bindValue(':postal_code', $postal_code);
        $stmt->bindValue(':prefecture', $prefecture);
        $stmt->bindValue(':address_1', $address_1);
        $stmt->bindValue(':address_2', $address_2);
        $stmt->bindValue(':authority', $authority, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // 更新成功 → 完了画面へ
        header("Location: update_complete.php");
        exit;
    } catch (PDOException $e) {
        $error_message = "エラーが発生したためアカウント更新できません。";
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>更新エラー</title>
</head>
<body>
  <h1>アカウント更新エラー</h1>
  <?php if ($error_message): ?>
    <p style="color:red"><?= htmlspecialchars($error_message) ?></p>
  <?php endif; ?>
  <form method="POST" action="update.php?id=<?= urlencode($id) ?>">
    <button type="submit">更新画面に戻る</button>
  </form>
</body>
</html>