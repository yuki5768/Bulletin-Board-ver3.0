<?php
//keyチェック
if (isset($_GET['key'])) {
	$key = $_GET['key'];
	//DB接続
	try {
		$dbh = new PDO('mysql:host=localhost;dbname=xxxxx;charset=utf8', 'xxxxx', 'xxxxx');
	} catch (PDOExeption $e) {
		echo '接続エラー' . $e->getMessage();
		exit;
	}
	//トークンチェック
	$sql = 'SELECT * FROM pass_reset WHERE reset_token = :token';
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(':token', $key);
	$stmt->execute();
	$result = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>パスワード再設定ページ</title>
<meta charset="utf-8">
</head>
<body>
<?php if (!isset($key)): ?>
<h2>登録済みのメールアドレスを入力してください</h2>
<form name="pass_reset" action="mail_check.php" method="POST">
<label>メールアドレス</label>
<p><input type="text" name="mail"></p>
<input type="submit" name="reset" value="送信">
</form>
<?php else: ?>
<h2>新しいパスワードを入力してください</h2>
<form name="reset_pass" action="pass_reset.php?key=<?php echo $key; ?>" method="POST">
<label>新しいパスワード</label>
<p><input type="password" name="pass"></p>
<input type="submit" value="変更">
</form>
<?php endif; ?>
</body>
</html>
