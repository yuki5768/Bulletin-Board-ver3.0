<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
	header('Location: display_post.php');
}

if (!empty($_POST['mail']) && !empty($_POST['pass'])) {
	try {
		$dbh= new PDO('mysql:host=localhost;dbname=procir_TAKEDA379;charset=utf8', 'TAKEDA379', '4p3kik4ggx');
	} catch (PDOExeption $e) {
		echo '接続エラー' . $e->getMessage();
		exit;
	}
	$mail = $_POST['mail'];
	$pass = $_POST['pass'];
	$sql = 'SELECT * FROM users WHERE mail = :mail AND pass = :pass';
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(':mail', $mail);
	$stmt->bindValue(':pass', $pass);
	$stmt->execute();
	$result = $stmt->fetch();
	if ($result) {
		$_SESSION['id'] = $result['id'];
		$_SESSION['name'] = $result['name'];
		$answer = 'ログインできました！';
	} else {
		$answer = '入力された値が誤っています。';
	}
} else {
	$answer = '入力されていない項目があります。';
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>ログイン結果</title>
<meta charset="utf-8">
</head>
<body>
<?php if (!empty($_POST['mail']) && !empty($_POST['pass'])): ?>
<?php if ($result): ?>
<?php echo $answer; ?>
<?php else: ?>
<?php echo $answer; ?>
<?php endif; ?>
<?php else: ?>
<?php echo $answer; ?>
<?php endif; ?>
<p><a href="display_post.php">投稿一覧ページへ</a></p>
</body>
</html>

