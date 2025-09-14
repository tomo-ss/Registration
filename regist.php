<?php
session_start();
if (!isset($_SESSION['authority']) || $_SESSION['authority'] !== '管理者') {
    echo "<p style='color:red;'>権限がないため操作できません。</p>";
    exit;
}
?>

<?php
$last_name       = $_POST['last_name'] ?? '';
$first_name      = $_POST['first_name'] ?? '';
$last_name_kana  = $_POST['last_name_kana'] ?? '';
$first_name_kana = $_POST['first_name_kana'] ?? '';
$email           = $_POST['email'] ?? '';
$password        = $_POST['password'] ?? '';
$gender          = $_POST['gender'] ?? '';
$postcode        = $_POST['postcode'] ?? '';
$prefecture      = $_POST['prefecture'] ?? '';
$city            = $_POST['city'] ?? '';
$address         = $_POST['address'] ?? '';
$authority       = $_POST['authority'] ?? '';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>アカウント登録画面</title>
  <link rel="stylesheet" type="text/css" href="regist.css">
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
<h1>アカウント登録画面</h1>

<form action="regist_confirm.php" method="POST" id="registerForm" class="form-layout">
  <?php
    function inputGroup($label, $name, $type, $max, $value) {
      echo "<div class='form-group'>
              <label for='{$name}'>{$label}</label>
              <div class='input-wrap'>
                <input type='{$type}' name='{$name}' id='{$name}' maxlength='{$max}' value='" . htmlspecialchars($value) . "'>
              </div>
            </div>";
    }

    inputGroup('名前（姓）', 'last_name', 'text', 10, $last_name);
    inputGroup('名前（名）', 'first_name', 'text', 10, $first_name);
    inputGroup('カナ（姓）', 'last_name_kana', 'text', 10, $last_name_kana);
    inputGroup('カナ（名）', 'first_name_kana', 'text', 10, $first_name_kana);
    inputGroup('メールアドレス', 'email', 'text', 100, $email);
    inputGroup('パスワード', 'password', 'password', 10, $password);
  ?>

  <div class="form-group">
    <label>性別</label>
    <label><input type="radio" name="gender" value="男" <?= ($gender === '男') ? 'checked' : '' ?>> 男</label>
    <label><input type="radio" name="gender" value="女" <?= ($gender === '女') ? 'checked' : '' ?>> 女</label>
  </div>

  <?php
    inputGroup('郵便番号', 'postcode', 'text', 7, $postcode);
  ?>

  <div class="form-group">
    <label for="prefecture">住所（都道府県）</label>
    <div class="input-wrap">
      <select name="prefecture" id="prefecture">
        <option value="">選択してください</option>
        <?php
        $prefs = ["北海道","青森県","岩手県","宮城県","秋田県","山形県","福島県",
                  "茨城県","栃木県","群馬県","埼玉県","千葉県","東京都","神奈川県",
                  "新潟県","富山県","石川県","福井県","山梨県","長野県","岐阜県",
                  "静岡県","愛知県","三重県","滋賀県","京都府","大阪府","兵庫県",
                  "奈良県","和歌山県","鳥取県","島根県","岡山県","広島県","山口県",
                  "徳島県","香川県","愛媛県","高知県","福岡県","佐賀県","長崎県",
                  "熊本県","大分県","宮崎県","鹿児島県","沖縄県"];
        foreach ($prefs as $p) {
          $selected = ($prefecture === $p) ? 'selected' : '';
          echo "<option value=\"$p\" $selected>$p</option>";
        }
        ?>
      </select>
    </div>
  </div>

  <?php
    inputGroup('住所（市区町村）', 'city', 'text', 10, $city);
    inputGroup('住所（番地）', 'address', 'text', 100, $address);
  ?>

  <div class="form-group">
    <label for="authority">アカウント権限</label>
    <div class="input-wrap">
      <select name="authority" id="authority">
        <option value="一般" <?= ($authority === '一般') ? 'selected' : '' ?>>一般</option>
        <option value="管理者" <?= ($authority === '管理者') ? 'selected' : '' ?>>管理者</option>
      </select>
    </div>
  </div>

  <div class="form-group">
    <button type="submit">確認する</button>
  </div>
</form>

</main>
<footer>
  Copyright D.I.Works D.I.blog is the one which provides A to Z about programming
</footer>

<script>
document.getElementById('registerForm').addEventListener('submit', function(e) {
  const form = e.target;
  let hasError = false;

  form.querySelectorAll('.error-message').forEach(span => span.remove());

  const showError = (element, message) => {
    const span = document.createElement('span');
    span.className = 'error-message';
    span.textContent = message;
    const wrap = element.closest('.input-wrap');
    const group = element.closest('.form-group');
    if (wrap) {
      wrap.appendChild(span);
    } else if (group) {
      group.appendChild(span);
    }
  };

  const checkRequired = (id, label) => {
    const input = document.getElementById(id);
    if (!input || input.value.trim() === '') {
      showError(input, `${label}が未入力です。`);
      hasError = true;
    }
  };

  const checkSelect = (id, label) => {
    const select = document.getElementById(id);
    if (!select || select.value === '') {
      showError(select, `${label}が未選択です。`);
      hasError = true;
    }
  };

  const checkRadio = (name, label) => {
    const radios = document.getElementsByName(name);
    const checked = [...radios].some(r => r.checked);
    if (!checked) {
      showError(radios[0], `${label}が未選択です。`);
      hasError = true;
    }
  };

  const checkPattern = (id, label, regex, errorMessage) => {
    const input = document.getElementById(id);
    if (input && !regex.test(input.value.trim())) {
      showError(input, `${label}は${errorMessage}`);
      hasError = true;
    }
  };

  // バリデーション実行
  checkRequired('last_name', '名前（姓）');
  checkPattern('last_name', '名前（姓）', /^[\u3040-\u309F\u4E00-\u9FFF]+$/, 'ひらがなまたは漢字で入力してください。');

  checkRequired('first_name', '名前（名）');
  checkPattern('first_name', '名前（名）', /^[\u3040-\u309F\u4E00-\u9FFF]+$/, 'ひらがなまたは漢字で入力してください。');

  checkRequired('last_name_kana', 'カナ（姓）');
  checkPattern('last_name_kana', 'カナ（姓）', /^[\u30A0-\u30FF]+$/, 'カタカナで入力してください。');

  checkRequired('first_name_kana', 'カナ（名）');
  checkPattern('first_name_kana', 'カナ（名）', /^[\u30A0-\u30FF]+$/, 'カタカナで入力してください。');

  checkRequired('email', 'メールアドレス');
  checkPattern('email', 'メールアドレス', /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/, '正しいメールアドレス形式で入力してください。');

  checkRequired('password', 'パスワード');
  checkPattern('password', 'パスワード', /^[a-zA-Z0-9]+$/, '半角英数字のみで入力してください。');

  checkRadio('gender', '性別');

  checkRequired('postcode', '郵便番号');
  checkPattern('postcode', '郵便番号', /^[0-9]{7}$/, '半角数字7桁で入力してください。');

  checkSelect('prefecture', '都道府県');

  checkRequired('city', '市区町村');
  checkPattern('city', '市区町村', /^[\u3040-\u30FF\u4E00-\u9FFF0-9\s\-]+$/, 'ひらがな、カタカナ、漢字、数字、スペース、ハイフンのみ入力可能です。');

  checkRequired('address', '住所（番地）');
  checkPattern('address', '住所（番地）', /^[\u3040-\u30FF\u4E00-\u9FFF0-9\s\-]+$/, 'ひらがな、カタカナ、漢字、数字、スペース、ハイフンのみ入力可能です。');

  if (hasError) {
    e.preventDefault();
  }
});

</script>
</body>
</html>