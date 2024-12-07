<?php
session_start();
include 'db_config.php'; // データベース接続

// ログインチェック
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'user') {
    header('Location: index.php');
    exit;
}

// 新着情報を取得
$sql = "SELECT title, content, created_at FROM news ORDER BY created_at DESC";
$result = $conn->query($sql);

// エラーハンドリング
if (!$result) {
    die("新着情報の取得中にエラーが発生しました: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新着情報一覧</title>
</head>
<body>
    <div class="news-container">
        <h1>新着情報</h1>
        <a href="user_dashboard.php">ユーザ画面に戻る</a>
        <div>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="news-item">
                        <p class="news-title"><?php echo htmlspecialchars($row['title']); ?></p>
                        <p class="news-date">投稿日: <?php echo htmlspecialchars($row['created_at']); ?></p>
                        <p class="news-content"><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>新着情報はありません。</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>