<?php
session_start();
session_destroy();
header("Location: http://localhost:8080/" . "onlycode/site/index.php");
exit;
