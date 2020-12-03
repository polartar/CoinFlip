<?php

$message = 'Successfully logged in';
setcookie('hash', $_GET['id'], time() + 3600 * 24 * 7, '/');
header('Location: index.php?message='.$message);

?>
