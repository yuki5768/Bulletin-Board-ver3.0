<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
	header('Location: display_post.php');
	exit();
}

if (!empty($_POST['name']) && !empty($_POST['mail']) && !empty($_POST['pass'])) {
	if (preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $_POST['mail'])) {
		if (preg_match('/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,100}+\z/', $_POST['pass'])) {
			try {
				$dbh = new PDO('mysql:host=localhost;dbname=procir_TAKEDA379;charset=utf8', 'TAKEDA379', '4p3kik4ggx');
			} catch (PDOExeption $e) {
				echo '接続エラー' . $e->getMessage();
				exit;
			}
			$sql1 = 'SELECT * FROM users WHERE mail = :mail';
			$stmt1 = $dbh->prepare($sql1);
			$stmt1->bindParam(':mail', $_POST['mail'], PDO::PARAM_STR);
			$stmt1->execute();
			$result = $stmt1->fetch();
			if ($result) {
				$answer = '同じメールアドレスは登録できません。';
			} else {
				$sql2 = 'INSERT INTO users(name, mail, pass) VALUES (:name, :mail, :pass)';
				$stmt2 = $dbh->prepare($sql2);
				$stmt2->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
				$stmt2->bindParam(':mail', $_POST['mail'], PDO::PARAM_STR);
				$stmt2->bindParam(':pass', $_POST['pass'], PDO::PARAM_STR);
				$stmt2->execute();
				$answer = '登録が完了しました。';
			}
		} else {
			$answer = 'パスワードは半角英小文字大文字数字をそれぞれ1種類以上含む8文字以上100文字以下のものにしてください';
		}
	} else {
		$answer = 'メールアドレスの形式が正しくありません。';
	}
} else {
	$answer = '入力されていない項目があります。';
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>登録結果</title>
<meta charset="utf-8">
</head>
<body>
<?php if (!empty($_POST['name']) && !empty($_POST['mail']) && !empty($_POST['pass'])): ?>
<?php if (preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $_POST['mail'])): ?>
<?php if (preg_match('/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,100}+\z/', $_POST['pass'])): ?>
<?php if ($result): ?>
<?php echo $answer; ?>
<p><a href="register.php">戻る</a></p>
<?php else: ?>
<?php echo $answer; ?>
<p><a href="login.php">ログインページへ</a></p>
<?php endif; ?>
<?php else: ?>
<?php echo $answer; ?>
<p><a href="register.php">戻る</a></p>
<?php endif; ?>
<?php else: ?>
<?php echo $answer; ?>
<p><a href="register.php">戻る</a></p>
<?php endif; ?>
<?php else: ?>
<?php echo $answer; ?>
<p><a href="register.php">戻る</a></p>
<?php endif; ?>
</body>
</html>
