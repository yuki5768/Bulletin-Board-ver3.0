<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>新規投稿ページ</title>
<meta charset="utf-8">
</head>
<body>
<h1>新規投稿ページ</h1>
<?php if (isset($_SESSION['id']) && isset($_SESSION['name'])): ?>
<form name="new_post" action="post_check.php" method="POST">
<p>
<h2>タイトル</h2>
<input type="text" name="title">
</p>
<p>
<h2>本文</h2>
<textarea name="body" rows="5" cols="50"></textarea>
</p>
<input type="submit" name="button" value="投稿">
<p><a href="display_post.php">投稿一覧へ</a></p>
</form>
<?php else: ?>
<?php
header('Location: register.php');
exit;
?>
<?php endif; ?>
</body>
</html>
