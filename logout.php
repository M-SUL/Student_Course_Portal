<?php
session_start();
session_destroy();
header('Location: /student-portal/index.php');
exit;