<?php
try {
  // データベースへ接続
  // ホスト: localhost / データベース名: d.i_blog / 文字コード: UTF-8
  // ユーザー名: root / パスワード: mysql
  $pdo = new PDO("mysql:host=localhost;dbname=d.i_blog;charset=utf8", "root", "mysql");


   // パスワードをハッシュ化
  $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  // 登録用SQL文を準備（12項目を登録）
  $sql = "INSERT INTO account (
    family_name, last_name, family_name_kana, last_name_kana,
    mail, password, gender, postal_code, prefecture,
    address_1, address_2, authority

  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// SQL文を事前に準備
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
    $_POST['last_name'],
    $_POST['first_name'],
    $_POST['last_name_kana'],
    $_POST['first_name_kana'],
    $_POST['email'],
    $hashed_password,
    $_POST['gender'],
    $_POST['postcode'],
    $_POST['prefecture'],
    $_POST['city'],
    $_POST['address'],
    $_POST['authority']
  ]);

  // 登録成功 → 完了画面へ
  header("Location: regist_complete.php");
  exit;

} catch (PDOException $e) {
//  エラー発生時 → メッセージ表示
   echo '<p style="color: red;">エラーが発生したためアカウント登録できません。</p>';
}
?>