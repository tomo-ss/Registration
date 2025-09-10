<?php
function db_connect() {
    try {
        return new PDO("mysql:host=localhost;dbname=d.i_blog;charset=utf8", "root", "", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } catch (PDOException $e) {
        throw $e; // 呼び出し元でcatchする
    }
}
?>