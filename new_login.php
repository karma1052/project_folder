<?php
session_start();
include 'db_config.php'; // データベース接続

// エラーメッセージ初期化
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // 入力チェック
    if (empty($username) || empty($password)) {
        $error = 'ユーザー名とパスワードを入力してください。';
    } else {
        // ユーザー名が既に存在するか確認
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = 'このユーザー名は既に登録されています。別のユーザー名をお試しください。';
        } else {
            // 新しいユーザーを登録
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $password);

            if ($stmt->execute()) {
                $success = '登録に成功しました！ログインページでお試しください。';
            } else {
                $error = '登録中にエラーが発生しました。';
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .message {
            color: green;
            margin-bottom: 10px;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
        label {
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>新規登録</h1>
        <?php if ($success): ?>
            <p class="message"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>
        <?php if ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="username">ユーザー名:</label>
            <input type="text" name="username" id="username" required>
            <label for="password">パスワード:</label>
            <input type="password" name="password" id="password" required>
            <button type="submit">登録</button>
            <a href="index.php">ログイン画面へもどる</a>
        </form>
    </div>
</body>
</html>
