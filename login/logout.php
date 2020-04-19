<?php
setcookie('id', '', time() - 3600 * 24 * 24 * 60, "/");
setcookie('hash', '', time() - 3600 * 24 * 24 * 60, "/");
header("Location: login.php");