<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../DTO/UserDTO.php';
use App\DTO\UserDTO;

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) &&
    $_POST['action'] === 'create'
){
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    // Validação básica
    if (empty($name) || empty($email) || empty($password)) {
        header(
            'Location: ../../public/create.php?error=Campos obrigatórios não preenchidos'
        );
        exit();
    }
    // Hash da senha (essencial para segurança)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $userDTO = new UserDTO(null, $name, $email, $hashedPassword);

    // stmt ---> statement --> declaração, instrução, comando
    $stmt = $conn->prepare(
        "INSERT INTO users (name, email, password) VALUES (?, ?, ?)"
    );
    $stmt->bind_param(
        "sss",
        $userDTO->name,
        $userDTO->email,
        $userDTO->password
    );
    if ($stmt->execute()) {
        header('Location: ../../public/list.php?success=Usuário cadastrado
com sucesso!');
    } else {
        header(
            'Location: ../../public/create.php?error=Erro ao cadastrar usuário: ' . $stmt->error
        );
    }
    $stmt->close();
    $conn->close();
    exit();
}