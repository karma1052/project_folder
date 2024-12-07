<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit();
}
require 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_news'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $stmt = $conn->prepare("INSERT INTO news (title, content) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $content);
        $stmt->execute();
    } elseif (isset($_POST['delete_news'])) {
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM news WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">    
    <link rel="stylesheet" href="styles.css">
    <title>新着情報管理</title>
</head>
<body>
    <div class="admin-news">
    <h2>新着情報管理</h2>
    <form method="post">
        <label>タイトル:</label><input type="text" name="title" required><br>
        <label>内容:</label><textarea name="content" required></textarea><br>
        <button type="submit" name="add_news">追加</button>
    </form>
    <h3>新着情報</h3>
    <?php
    $result = $conn->query("SELECT * FROM news");
    while ($row = $result->fetch_assoc()) {
        echo "<p>{$row['title']} <form style='display:inline;' method='post'><input type='hidden' name='id' value='{$row['id']}'><button type='submit' name='delete_news'>削除</button></form></p>";
    }
    ?>
    <a href="dashboard.php">管理画面に戻る</a>
    </div>
</body>
</html>