<?php
session_start();
require_once '../auth/check_auth.php';



requireLogin();




header('Location: /Click-Journey-adem/html/payment.php');
exit();
