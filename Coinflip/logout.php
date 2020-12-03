<?php

setcookie("hash", "", time() - 3600, '/');
header('Location: index.php');
exit();

?>
