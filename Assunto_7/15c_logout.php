<?php
session_start();
// Encerra a sessão
session_destroy();

// Redireciona
header("Location: 15a_sistema.php");
exit();

?>