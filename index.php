<?php
session_start();
include 'db_config.php'; // データベース接続

// 既にログインしている場合、役割に応じてダッシュボードにリダイレクト
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: dashboard.php');
    } elseif ($_SESSION['role'] === 'user') {
        header('Location: user_dashboard.php');
    }
    exit;
}

// エラーメッセージ初期化
$error = '';

// フォームが送信された場合の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // データベースからユーザーを検索
    $stmt = $conn->prepare("SELECT username, password, role FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // ユーザー情報を取得
        $user = $result->fetch_assoc();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // ロールに応じてダッシュボードへリダイレクト
        if ($user['role'] === 'admin') {
            header('Location: dashboard.php');
        } elseif ($user['role'] === 'user') {
            header('Location: user_dashboard.php');
        }
        exit;
    } else {
        $error = 'ユーザ名またはパスワードが間違っています。';
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>ログイン</title>
</head>
<body>
    <div class="main">
        <h1>ログイン</h1>
        <?php if ($error): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="text">
            <label for="username">ユーザ名:</label>
            <input type="text" name="username" id="username" required>
            </div>
            <br>
            <div class="text">
            <label for="password">パスワード:</label>
            <input type="password" name="password" id="password" required>
            </div>
            <br>
            <button type="submit">ログイン</button>
            <a href="new_login.php" class="button">新規登録</a>
        </form>
    </div>
</body>
</html>