<?php
session_start();
// Encerra a sessão
session_destroy();

// Redireciona
header("Location: 15d_login.php");
exit();

?>