<?php
$servername = "localhost";  // サーバーホスト名（通常は "localhost"）
$username = "root";         // MySQLユーザー名（デフォルトは "root"）
$password = "";             // MySQLパスワード（デフォルトは空）
$dbname = "test";           // データベース名

// データベース接続
$conn = new mysqli($servername, $username, $password, $dbname);

// 接続エラーチェック
if ($conn->connect_error) {
    die("データベース接続に失敗しました: " . $conn->connect_error);
}

?>