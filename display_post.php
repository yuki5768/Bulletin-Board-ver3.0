<?php
session_start();
try {
	$dbh = new PDO('mysql:host=localhost;dbname=procir_TAKEDA379;charset=utf8', 'TAKEDA379', '4p3kik4ggx');
} catch (PDOExeption $e) {
	echo '接続エラー' . $e->getMessage();
	exit;
}
$sql = 'SELECT * FROM users INNER JOIN posts ON posts.user_id = users.id WHERE deleted_flag = 0 ORDER BY post_date';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();
function escape($s) {
	return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>投稿一覧</title>
<meta charset="utf-8">
</head>
<body>
<p><a href="new_post.php">新規投稿</a></p>
<?php if (isset($_SESSION['name']) && isset($_SESSION['id'])): ?>
<p><a href="logout.php">ログアウト</a></p>
<?php else: ?>
<p><a href="login.php">ログイン</a></p>
<p><a href="register.php">新規ユーザー登録へ</a></p>
<?php endif; ?>
<table border="1">
<tr>
<th>投稿ID</th>
<th>投稿者名</th>
<th>タイトル</th>
<th>本文</th>
<th>投稿日時</th>
</tr>
<?php foreach ($result as $post): ?>
<?php if (isset($_SESSION['id']) && isset($_SESSION['name'])): ?>
<tr>
<td><?php echo escape($post['id']); ?></td>
<td>
<a href="user_info.php?user_id=<?php echo $post['user_id']; ?>"><?php echo escape($post['name']); ?></a>
</td>
<?php if ($post['user_id'] == $_SESSION['id']): ?>
<td>
<?php echo escape ($post['title']); ?>
 <a href="edit.php?post_id=<?php echo $post['id']; ?>">編集</a>
 <a href="delete.php?post_id=<?php echo $post['id']; ?>">削除</a>
</td>
<?php else: ?>
<td><?php echo escape($post['title']); ?></td>
<?php endif; ?>
<td><?php echo escape($post['body']); ?></td>
	<td><?php echo date('Y年n月j日G:i', strtotime(escape($post['post_date']))); ?></td>
</tr>
<?php else: ?>
<tr>
<td><?php echo escape($post['id']); ?></td>
<td>
<a href="user_info.php?user_id=<?php echo $post['user_id']; ?>"><?php echo escape($post['name']); ?></a>
</td>
<td><?php echo escape($post['title']); ?></td>
<td><?php echo escape($post['body']); ?></td>
<td><?php echo date('Y年n月j日G:i', strtotime(escape($post['post_date']))); ?></td>
</tr>
<?php endif; ?>
<?php endforeach; ?>
</table>
</body>
</html>
