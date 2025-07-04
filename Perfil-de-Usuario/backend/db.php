<?php
$host = 'localhost';
$db = 'desafio_sync360';
$user = 'root';
$pass = 'cesar44'; // coloque a senha que criou

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die("Conexão falhou: " . $conn->connect_error);
}
?>
