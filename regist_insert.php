<?php
try {
  $pdo = new PDO("mysql:host=localhost;dbname=d.i_blog;charset=utf8", "root", "mysql");

  $sql = "INSERT INTO account (
    family_name, last_name, family_name_kana, last_name_kana,
    mail, password, gender, postal_code, prefecture,
    address_1, address_2, authority

  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    $_POST['last_name'],
    $_POST['first_name'],
    $_POST['last_name_kana'],
    $_POST['first_name_kana'],
    $_POST['email'],
    $_POST['password'],
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
  echo "登録失敗: " . $e->getMessage();
}
?>