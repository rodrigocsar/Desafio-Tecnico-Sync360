<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST");
header("Content-Type: application/json");

// Conexão com o banco
require_once 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
  $sql = "SELECT * FROM usuario WHERE id = 1";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
  } else {
    echo json_encode(["error" => "Usuário não encontrado"]);
  }

} elseif ($method === 'POST') {
  $data = json_decode(file_get_contents("php://input"), true);

  $stmt = $conn->prepare("UPDATE usuario SET nome=?, idade=?, rua=?, bairro=?, estado=?, bio=?, imagem=? WHERE id = 1");
  $stmt->bind_param(
    "sisssss",
    $data['nome'],
    $data['idade'],
    $data['rua'],
    $data['bairro'],
    $data['estado'],
    $data['bio'],
    $data['imagem']
  );

  if ($stmt->execute()) {
    echo json_encode($data);
  } else {
    echo json_encode(["error" => "Erro ao salvar"]);
  }
}
