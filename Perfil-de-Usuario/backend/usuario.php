<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST");
header("Content-Type: application/json");

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
    // Pegando os dados do POST
    $nome   = $_POST['nome'] ?? '';
    $idade  = $_POST['idade'] ?? '';
    $rua    = $_POST['rua'] ?? '';
    $bairro = $_POST['bairro'] ?? '';
    $estado = $_POST['estado'] ?? '';
    $bio    = $_POST['bio'] ?? '';

    // Lida com o upload da imagem
    $imagem = '';
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = uniqid() . "_" . basename($_FILES["imagem"]["name"]);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $targetFile)) {
            $imagem = $targetFile;
        } else {
            echo json_encode(["error" => "Erro ao salvar a imagem."]);
            exit;
        }
    }

    // Upsert: insere ou atualiza se já existir
    $stmt = $conn->prepare("
        INSERT INTO usuario (id, nome, idade, rua, bairro, estado, bio, imagem)
        VALUES (1, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            nome = VALUES(nome),
            idade = VALUES(idade),
            rua = VALUES(rua),
            bairro = VALUES(bairro),
            estado = VALUES(estado),
            bio = VALUES(bio),
            imagem = VALUES(imagem)
    ");

    $stmt->bind_param("sisssss", $nome, $idade, $rua, $bairro, $estado, $bio, $imagem);

    if ($stmt->execute()) {
        echo json_encode([
            "id" => 1,
            "nome" => $nome,
            "idade" => $idade,
            "rua" => $rua,
            "bairro" => $bairro,
            "estado" => $estado,
            "bio" => $bio,
            "imagem" => $imagem
        ]);
    } else {
        echo json_encode(["error" => "Erro ao salvar no banco."]);
    }
}
?>
