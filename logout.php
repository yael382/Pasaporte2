<?php
include_once __DIR__ . "/init.php";

startAPI("login");

Usuario::logout();
header("Location: index.php");
exit();
