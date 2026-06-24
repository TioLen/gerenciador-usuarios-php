<!-- UPDATE -->
<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/DTO/UserDTO.php';
use App\DTO\UserDTO;

$userToEdit = null;
if (isset($_GET['id'])) {
    // cria variaveis locais para manipular o 'id' recebido e 
    // no final editar os dados solicitados.
    $id = (int) $_GET['id'];
    $stmt = $conn->prepare("SELECT id, name, email FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->$num_rows === 1) {
        $row = $result->fetch_assoc();
        $userToEdit = new UserDTO($row['id'], $row['name'], $row['email'], '');
    }
    $stmt->close();
}
if (!$userToEdit) {
    header('Location: list.php?error=Usuário não encontrado.');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Editar Usuário</h2>
        <form action="../src/Controller/UserController.php" method="POST">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($userToEdit->getId()); ?>">
            
            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="<?php echo htmlspecialchars($userToEdit->getName()); ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="<?php echo htmlspecialchars($userToEdit->getEmail()); ?>" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">
                    Nova Senha (deixe em branco para não alterar)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>


            <button type="submit" class="btn btn-primary">Atualizar</button>


</body>

</html>