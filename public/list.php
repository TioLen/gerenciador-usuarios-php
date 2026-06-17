<!-- READ -->
<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../DTO/UserDTO.php';

use App\DTO\UserDTO;

$users = [];
$result = $conn->query("SELECT id, name, email, created_at FROM users");

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = new UserDTO(
            $row['id'],
            $row['name'],
            $row['email'],
            '',
            $row['created_at']
        );
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Lista de Usuários</h2>
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success" role="alert">
                <?php echo htmlspecialchars($_GET['success']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>
        <a href="create.php" class="btn btn-primary mb-3">
            Cadastrar Novo Usuário
        </a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Criado Em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="5">Nenhum usuário cadastrado.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user->getId()); ?></td>
                            <td><?php echo htmlspecialchars($user->getName()); ?></td>
                            <td><?php echo htmlspecialchars($user->getEmail()); ?></td>
                            <td><?php echo htmlspecialchars($user->getCreatedAt()); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $user->getId(); ?>" class="btn btn-sm btn-warning">Editar</a>
                                <a href="delete.php?id=<?php echo $user->getId(); ?>" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Tem certeza que deseja excluir este usuário?');">
                                    Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>