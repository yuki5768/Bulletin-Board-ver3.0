<?php
session_start();
if (!isset($_SESSION['id']) && !isset($_SESSION['name'])) {
	header('Location: display_post.php');
}
if (!empty($_POST['title']) && !empty($_POST['body'])) {
	try {
		$dbh = new PDO('mysql:host=localhost;dbname=procir_TAKEDA379;charset=utf8', 'TAKEDA379', '4p3kik4ggx');
	} catch (PDOExeption $e) {
		echo '接続エラー' . $e->getMessage();
		exit;
	}
	$sql = 'INSERT INTO posts(user_id, post_date, title, body, deleted_flag) VALUES(:user_id, now(), :title, :body, 0)';
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(':user_id', $_SESSION['id']);
	$stmt->bindValue(':title', $_POST['title']);
	$stmt->bindValue(':body', $_POST['body']);
	$stmt->execute();
	header ('Location: display_post.php');
} else {
	$answer = '入力されていない項目があります。';
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>投稿確認</title>
<meta charset="utf-8">
</head>
<body>
<?php echo $answer; ?>
</body>
</html>
