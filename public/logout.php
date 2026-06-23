<?php
// Este arquivo apenas redireciona para o controlador de autenticação
// para processar o logout
// Poderia ser um botão em qualquer página que envie um POST para
// AuthController.php com action=logout
?>
<!DOCTYPE html>
<html lang="pt-br">
</html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Saindo...</h2>
        <form id="logoutForm" action="../src/Auth/AuthController.php" method="POST">
            <input type="hidden" name="action" value="logout">
        </form>
        <script>
            document.getElementById('logoutForm').submit();
        </script>
    </div>
</body>

</html>