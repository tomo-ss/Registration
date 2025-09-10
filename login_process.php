<?php
session_start();
require_once('db_connect.php');
$pdo = db_connect();

// 入力値の取得と初期化
$mail = $_POST['mail'] ?? '';
$password = $_POST['password'] ?? '';

// 入力チェック
if (empty($mail) || empty($password)) {
    $_SESSION['error'] = 'エラーが発生したためログイン情報を取得できません。';
    header('Location: login.php');
    exit;
}

try {
    // アカウント情報の取得（name → family_name + last_name に分割されている場合は要調整）
    $sql = 'SELECT id, family_name, last_name, mail, password, authority FROM account WHERE mail = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$mail]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // パスワード照合（ハッシュ比較）
    if ($user && password_verify($password, $user['password'])) {
        // ログイン成功：セッションに保存
        $_SESSION['id'] = $user['id'];
        $_SESSION['name'] = $user['family_name'] . ' ' . $user['last_name']; // フルネーム表示
        $_SESSION['authority'] = $user['authority'];
        header('Location: index.html');
        exit;
    } else {
        // ログイン失敗（要件により統一メッセージ）
        $_SESSION['error'] = 'エラーが発生したためログイン情報を取得できません。';
        header('Location: login.php');
        exit;
    }

} catch (PDOException $e) {
    // DB接続エラーなど（要件により統一メッセージ）
    $_SESSION['error'] = 'エラーが発生したためログイン情報を取得できません。';
    header('Location: login.php');
    exit;
}