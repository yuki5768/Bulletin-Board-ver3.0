<?php
session_start();
if (!isset($_SESSION['id']) && !isset($_SESSION['name'])) {
	header('Location: display_post.php');
}
if (isset($_GET['post_id'])) {
	$post_id = $_GET['post_id'];
	try {
		$dbh = new PDO('mysql:host=localhost;dbname=procir_TAKEDA379;charset=utf8', 'TAKEDA379', '4p3kik4ggx');
	} catch (PDOExeption $e) {
		echo '接続エラー' . $e->getMessage();
		exit;
	}
	$sql = 'SELECT * FROM posts WHERE id = :id';
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(':id', $post_id);
	$stmt->execute();
	$result = $stmt->fetch();
} else {
	header('Location: display_post.php');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>編集ページ</title>
<meta charset="utf-8">
</head>
<body>
<?php if (isset($result)): ?>
<?php if ($result['user_id'] == $_SESSION['id']): ?>
<form method="POST" action="edit_check.php?post_id=<?php echo $post_id; ?>">
<p>
<h2>タイトル</h2>
<input type="text" name="title" value="<?php echo $result['title']; ?>">
</p>
<p>
<h2>本文</h2>
<textarea name="body" rows="5" cols="50"><?php echo $result['body']; ?></textarea>
</p>
<p><input type="submit" name="更新"></p>
</form>
<?php else: ?>
<?php header('Location: display_post.php'); ?>
<?php endif; ?>
<?php endif; ?>
</body>
</html>
