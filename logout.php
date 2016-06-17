<?php
 include 'includes/header.html';
 session_destroy();
header ("Location: index.php");
exit();
include 'includes/footer.html';