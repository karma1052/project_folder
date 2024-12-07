<?php
// データベース接続ファイルをインクルード
include 'db_config.php';

// メッセージ初期化
$error = '';
$success = '';

// フォームが送信された場合の処理
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // フォームから送信されたデータを取得
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    // 入力チェック
    if (empty($name) || empty($email) || empty($message)) {
        $error = 'すべての項目を入力してください。';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = '有効なメールアドレスを入力してください。';
    } else {
        // データベースにデータを挿入
        $stmt = $conn->prepare("INSERT INTO contact (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $name, $email, $message);

        if ($stmt->execute()) {
            $success = 'お問い合わせ内容を送信しました。';
            // フォームの入力内容をリセット
            $name = '';
            $email = '';
            $message = '';
        } else {
            $error = '送信中にエラーが発生しました。もう一度お試しください。';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせフォーム</title>
    <style>
        form {
            max-width: 500px;
            margin: auto;
        }
        label {
            font-weight: bold;
        }
        input, textarea, button {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
        }
        button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">お問い合わせ</h1>

    <div style="max-width: 600px; margin: auto;">
        <!-- エラーメッセージ -->
        <?php if ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <!-- 成功メッセージ -->
        <?php if ($success): ?>
            <p class="success"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>

        <!-- フォーム -->
        <form method="POST" action="">
            <label for="name">名前：</label>
            <input type="text" name="name" id="name" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" required>

            <label for="email">メールアドレス：</label>
            <input type="email" name="email" id="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>

            <label for="message">お問い合わせ内容：</label>
            <textarea name="message" id="message" rows="5" required><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>

            <button type="submit">送信</button>
            <a href="user_dashboard.php">ユーザ画面に戻る</a>
        </form>
    </div>
</body>
</html>