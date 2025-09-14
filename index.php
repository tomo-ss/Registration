<?php
session_start();

// 未ログインならログイン画面へ
if (!isset($_SESSION['mail'])) {
    header("Location: login.php");
    exit;
}

// ユーザー情報の取得
$name = $_SESSION['name'] ?? 'ゲスト';
$authority = $_SESSION['authority'] ?? 0; 
$authority_label = ($authority == 1) ? '管理者' : '一般'; 
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>D.I.BLOG</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bxslider@4.2.17/dist/jquery.bxslider.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bxslider@4.2.17/dist/jquery.bxslider.min.js"></script>
    <script>
      $(document).ready(function(){
        $(".slide").bxSlider({
            auto:true,
            mode:'horizontal',
            speed:2000
        });
      });
    </script>
</head>
<body>

    <img src="diblog_logo.jpg" alt="D.I.BLOG ロゴ">
    
    <header>
        <ul>
            <li><a href="index.php">トップ</a></li>
            <li>プロフィール</li>
            <li>D.I.Blogについて</li>
            <li>登録フォーム</li>
            <li>問い合わせ</li>
            <?php if ($authority == 1): ?>
                <li><a href="regist.php">アカウント登録</a></li>
                <li><a href="list.php">アカウント一覧</a></li>
            <?php endif; ?>
        </ul>
    </header>

    <main>
        <div class="right">
            <br>
            <h2>人気の記事</h2>
            PHPオススメ本<br>
            PHP MyAdminの使い方<br>
            今人気のエディタのTops<br>
            HTMLの基礎

            <h2>オススメリンク</h2>
            ディーアイワークス株式会社<br>
            XAMPPのダウンロード<br>
            Eclipseのダウンロード<br>
            Braketsのダウンロード<br>

            <h2>カテゴリ</h2>
            HTML<br>
            PHP<br>
            MySQL<br>
            JavaScript<br>
        </div>

        <div class="left">
            <h1>プログラミングに役立つ書籍</h1>
            <p>ようこそ、<?= htmlspecialchars($name) ?> さん（<?= htmlspecialchars($authority_label) ?>）</p>
            <p><?= date('Y年n月j日') ?></p>

            <div class="slide">
                <div><img src="jQuery_image1.jpg" alt=""></div>
                <div><img src="jQuery_image2.jpg" alt=""></div>
                <div><img src="jQuery_image3.jpg" alt=""></div>
                <div><img src="jQuery_image4.jpg" alt=""></div>
                <div><img src="jQuery_image5.jpg" alt=""></div>
            </div>

            <h3>D.I.BlogはD.I.Worksが提供する演習課題です。</h3>
            <p>記事中身</p>

            <div class="box2">
                <div class="box_pic2"><img src="pic1.jpg"><p>ドメイン取得方法</p></div>
                <div class="box_pic2"><img src="pic2.jpg"><p>快適な職場環境</p></div>
                <div class="box_pic2"><img src="pic3.jpg"><p>Linuxの基礎</p></div>
                <div class="box_pic2"><img src="pic4.jpg"><p>マーケティング入門</p></div>
                <div class="box_pic2"><img src="pic5.jpg"><p>アクティブラーニング</p></div>
                <div class="box_pic2"><img src="pic6.jpg"><p>CSSの効率的な勉強方法</p></div>
                <div class="box_pic2"><img src="pic7.jpg"><p>リーダブルコードとは</p></div>
                <div class="box_pic2"><img src="pic8.jpg"><p>HTML5の可能性</p></div>
            </div>
        </div>
    </main>

    <footer>
        Copyright D.I.Works D.I.blog is the one which provides A to Z about programming
    </footer>

</body>
</html>