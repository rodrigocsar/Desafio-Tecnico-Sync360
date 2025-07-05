<?php
// Lida com o upload da nova imagem
$imagem = $oldImage; // Mantém a imagem antiga por padrão

// --- INÍCIO DO BLOCO DE LIMPEZA ---
$targetDir = "uploads/";
$now = time();
$files = glob($targetDir . "*");
foreach ($files as $file) {
    if (is_file($file)) {
        if ($now - filemtime($file) >= 60 * 60 * 24) {
            unlink($file);
        }
    }
}
// --- FIM DO BLOCO DE LIMPEZA ---

if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Deleta a imagem antiga se existir
    if (!empty($oldImage) && file_exists($oldImage)) {
        unlink($oldImage);
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

?>
