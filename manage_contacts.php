<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit();
}
require 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete_contact'])) {
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM contact WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>お問い合わせ管理</title>
</head>
<body>
    <h2>お問い合わせ管理</h2>
    <?php
    $result = $conn->query("SELECT * FROM contact");
    while ($row = $result->fetch_assoc()) {
        echo "<p>名前: {$row['name']} | メール: {$row['email']} | 内容: {$row['message']}
        <form style='display:inline;' method='post'><input type='hidden' name='id' value='{$row['id']}'><button type='submit' name='delete_contact'>削除</button></form></p>";
    }
    ?>
    <a href="dashboard.php">管理画面に戻る</a>
</body>
</html>