<?php
session_start();
session_destroy();
header('Location: /fin2/html/page-acceuil.html');
exit();
