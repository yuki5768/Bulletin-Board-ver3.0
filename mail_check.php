<?php
if (!empty($_POST['mail'])) {
	try {
		$dbh = new PDO('mysql:host=localhost;dbname=procir_TAKEDA379;charset=utf8', 'TAKEDA379', '4p3kik4ggx');
	} catch (PDOExeption $e) {
		echo '接続エラー' . $e->getMessage();
		exit;
	}
	$sql1 = 'SELECT * FROM users WHERE mail = :mail';
	$stmt1 = $dbh->prepare($sql1);
	$stmt1->bindValue(':mail', $_POST['mail']);
	$stmt1->execute();
	$result = $stmt1->fetch();
	if (!empty($result) && $result['mail'] == $_POST['mail']) {
		$token = rand(0, 100) . uniqid();
		$url = $_SERVER['HTTP_REFERER'] . "?key=" . $token;
		mb_language("Japanese");
		mb_internal_encoding("UTF-8");
		$to = $_POST['mail'];
		$subject = 'パスワード再設定フォーム';
		$message = 'パスワードを再設定するには、以下のアドレスを開いてください。/このURLの有効期限は30分間です。/';
		$message .= $url . "\n\n";
		$headers = 'From: yuuki9978@outlook.jp' . "\r\n";
		mb_send_mail($to, $subject, $message, $headers, '-f' . 'yuuki9978@outlook.jp');
		$sql2 = 'INSERT INTO pass_reset(user_id, reset_date, reset_token) VALUES (:user_id, now(), :reset_token)';
		$stmt2 = $dbh->prepare($sql2);
		$stmt2->bindValue(':user_id', $result['id']);
		$stmt2->bindValue(':reset_token', $token);
		$stmt2->execute();
	}
} else {
	header('Location: display_post.php');
	exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>確認メール送信</title>
<meta charset="utf-8">
</head>
<body>
<?php echo '再発行用URLを送信しました。'; ?>
<p><a href="display_post.php">投稿一覧へ</a></p>
</body>
</html>
