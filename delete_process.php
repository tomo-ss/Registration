<?php
require_once('db_connect.php');
session_start();

// 削除対象のIDを取得
$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    // IDが不正 → エラー画面へ
    header('Location: error.php');
    exit;
}

try {
    $dbh = db_connect();
    $sql = 'DELETE FROM users WHERE id = :id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // 削除成功 → 完了画面へ
    header('Location: delete_complete.php');
    exit;
} catch (PDOException $e) {
    // 削除失敗 → エラー画面へ
    header('Location: error.php');
    exit;
}