<?php

session_start();

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../DTO/UserDTO.php';

use App\DTO\UserDTO;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'login') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $rememberMe = isset($_POST['remember_me']);
        if (empty($email) || empty($password)) {
            $_SESSION['error'] = 'Email e senha são obrigatórios.';
            header('Location: ../../public/login.php');
            exit();
        }
        $stmt = $conn->prepare(
            "SELECT id, name, email, password FROM users WHERE email = ?"
        );
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $userRow = $result->fetch_assoc();
            if (password_verify($password, $userRow['password'])) {
                $_SESSION['user_id'] = $userRow['id'];
                $_SESSION['user_name'] = $userRow['name'];
                $_SESSION['user_email'] = $userRow['email'];
                if ($rememberMe) {
                    // Definir cookie para lembrar o usuário por 30 dias
                    setcookie(
                        'remember_user_id',
                        $userRow['id'],
                        time() + (86400 * 30),
                        "/"
                    );
                }

                $_SESSION['success'] = 'Login realizado com sucesso!';
                header('Location: ../../public/dashboard.php');
                // Página após o login
                exit();
            } else {
                $_SESSION['error'] = 'Senha incorreta.';
            }
        } else {
            $_SESSION['error'] = 'Usuário não encontrado.';
        }
        $stmt->close();
        $conn->close();
        header('Location: ../../public/login.php');
        exit();
    } elseif ($_POST['action'] === 'logout') {
        // Limpar sessão
        session_unset();
        session_destroy();
        // Limpar cookie de "lembrar-me"
        setcookie('remember_user_id', '', time() - 3600, "/");
        $_SESSION['success'] = 'Logout realizado com sucesso!';
        header('Location: ../../public/login.php');
        exit();
    }
}
header('Location: ../../public/login.php'); // Redireciona para o login se acesso direto
exit();

?>