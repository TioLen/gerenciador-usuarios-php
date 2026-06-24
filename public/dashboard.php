<?php
session_start();
// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    // Tentar logar via cookie se existir
    if (isset($_COOKIE['remember_user_id'])) {
        require_once __DIR__ . '/../../config/database.php';
        $id = (int) $_COOKIE['remember_user_id'];
        $stmt = $conn->prepare("SELECT id, name, email FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $userRow = $result->fetch_assoc();
            $_SESSION['user_id'] = $userRow['id'];
            $_SESSION['user_name'] = $userRow['name'];
            $_SESSION['user_email'] = $userRow['email'];
        }
        $stmt->close();
        $conn->close();
    }
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['error'] =
            'Você precisa estar logado para acessar esta página.';
        header('Location: login.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Bem-vindo, <?php echo
            htmlspecialchars($_SESSION['user_name']); ?>!</h2>
        <p>Este é o seu painel de controle.</p>
        <p>Seu email: <?php echo
            htmlspecialchars($_SESSION['user_email']); ?></p>
        <a href="list.php" class="btn btn-info">Ver Usuários</a>
        <a href="logout.php" class="btn btn-danger">Sair</a>
    </div>
</body>
</html>