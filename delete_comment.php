<?php
session_start();
if (!isset($_SESSION['id']) && !isset($_SESSION['name'])) {
	header('Location: display_post.php');
	exit();
}

if (isset($_GET['user_id'])) {
	try {
		$dbh = new PDO('mysql:host=localhost;dbname=procir_TAKEDA379;charset=utf8', 'TAKEDA379', '4p3kik4ggx');
	} catch (PDOExeption $e) {
		echo '接続エラー' . $e->getMessage();
		exit;
	}
	$sql1 = 'SELECT * FROM users WHERE id = :id';
	$stmt1 = $dbh->prepare($sql1);
	$stmt1->bindValue(':id', $_GET['user_id']);
	$stmt1->execute();
	$result = $stmt1->fetch();
	if ($result['id'] == $_SESSION['id']) {
		$sql2 = 'UPDATE users SET quick_comment = :quick_comment WHERE id = :id';
		$stmt2 = $dbh->prepare($sql2);
		$stmt2->bindValue(':quick_comment', NULL);
		$stmt2->bindValue(':id', $_GET['user_id']);
		$stmt2->execute();
		$message = '一言コメントを削除しました。';
	} else {
		header('Location: display_post.php');
		exit();
	}
} else {
	header('Location: display_post.php');
	exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>削除ページ</title>
<meta charset="utf-8">
</head>
<body>
<?php echo $message; ?>
<p><a href="display_post.php">投稿一覧へ</a></p>
</body>
</html>
