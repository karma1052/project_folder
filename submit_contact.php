<?php
// データベース接続情報
$servername = "localhost";
$username = "username"; // データベースのユーザー名
$password = "password"; // データベースのパスワード
$dbname = "test";       // データベース名

// フォームからの入力を取得
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$message = trim($_POST['message']);

// 空入力チェック
if (empty($name) || empty($email) || empty($message)) {
    echo "全ての項目を入力してください。";
    exit();
}

// データベースに接続
$conn = new mysqli($servername, $username, $password, $dbname);

// 接続確認
if ($conn->connect_error) {
    die("データベース接続に失敗しました: " . $conn->connect_error);
}

// SQL文を準備
$stmt = $conn->prepare("INSERT INTO contact (name, email, message) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $message);

// データを挿入
if ($stmt->execute()) {
    echo "お問い合わせ内容が送信されました。";
} else {
    echo "エラーが発生しました: " . $stmt->error;
}

// 接続を閉じる
$stmt->close();
$conn->close();
?>