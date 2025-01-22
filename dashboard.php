<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
    <title>管理画面</title>
</head>
<body>
    <div class="container">
    <h1>管理画面</h1>
    <a href="manage_news.php" class="button">新着情報の管理</a>
    <a href="manage_contacts.php" class="button">お問い合わせ内容の管理</a>
    <a href="employee_management.php" class="button">ユーザー情報</a>
    <a href="logout.php" class="button logout">ログアウト</a>
    </div>
</body>
</html>

