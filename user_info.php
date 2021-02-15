<?php
session_start();
if (!empty($_GET['user_id'])) {
	try {
		$dbh = new PDO('mysql:host=localhost;dbname=procir_TAKEDA379;charset=utf8', 'TAKEDA379', '4p3kik4ggx');
	} catch (PDOExeption $e) {
		echo '接続エラー' . $e->getMessage();
		exit;
	}
	$user_id = $_GET['user_id'];

	$sql = 'SELECT * FROM users WHERE id = :id';
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(':id', $user_id);
	$stmt->execute();
	$result = $stmt->fetch();
} else {
	header('Location: display_post.php');
	exit();
}
function escape($s) {
	return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>ユーザー情報</title>
<meta charset="utf-8">
</head>
<body>
<h1>ユーザー情報</h1>
<?php if (isset($_SESSION['id'])): ?>
<?php if ($result['id'] == $_SESSION['id']): ?>
<p><a href="user_edit.php?user_id=<?php echo $_SESSION['id']; ?>">ユーザー情報編集</a></p>
<?php endif; ?>
<?php endif; ?>
<?php if ($result): ?>
<table border="1">
<tr>
<th>ユーザー名</th>
<th>ユーザー画像</th>
<th>メールアドレス</th>
<th>一言コメント</th>
</tr>
<tr>
<td><?php echo $result['name']; ?></td>
<?php if (!empty($result['image_name'])): ?>
<td>
<img src="images/<?php echo $result['image_name']; ?>" width="300" height="300">
<?php if (isset($_SESSION['id'])): ?>
<?php if ($result['id'] == $_SESSION['id']): ?>
<p><a href="delete_image.php?user_id=<?php echo $_SESSION['id']; ?>">削除</a></p>
<?php endif; ?>
<?php endif; ?>
</td>
<?php else: ?>
<td><p>未登録</p></td>
<?php endif; ?>
<td><?php echo $result['mail']; ?></td>
<?php if (!empty($result['quick_comment'])): ?>
<td>
<?php echo escape($result['quick_comment']); ?>
<?php if (isset($_SESSION['id'])): ?>
<?php if ($result['id'] == $_SESSION['id']): ?>
<p><a href="delete_comment.php?user_id=<?php echo $_SESSION['id']; ?>">削除</a></p>
<?php endif; ?>
<?php endif; ?>
</td>
<?php else: ?>
<td><p>未登録</p></td>
<?php endif; ?>
<?php endif; ?>
</tr>
</table>
<?php if ($result === false): ?>
<p>user_idが不正な値です</p>
<?php endif; ?>
<p><a href="display_post.php">投稿一覧へ</a></p>
</body>
</html>

