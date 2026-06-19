<?php

require_once __DIR__ . '/../../config/database.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()){
        header('Location: list.php?sucess=Usuário excluído');
    }else{
        header('Location: list.php?error=Erro ao excluir usuário.' . $stmt->error);
    }

    $stmt->close();
    $conn->close();
    exit();
}

header('Location: list.php?error=ID de usuário não fornecido.');
exit();
?>