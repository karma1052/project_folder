<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'user') {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー画面</title>
    <link rel="stylesheet" href="styles.css"> <!-- CSSを適用 -->
</head>
<body>
    <div class="container">
        <h1>ユーザー画面</h1>
        <div class="user-view">
            <a href="user_manage_news.php" class="button">新着情報</a>
            <a href="contact_form.php" class="button">お問い合わせ</a>
            <a href="logout.php" class="button logout">ログアウト</a>
        </div>
    </div>
</body>
</html>
