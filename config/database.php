<?php
// definindo variáveis de ambiente

define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // Usuário padrão do XAMPP
define('DB_PASS', '');     // Senha padrão do XAMPP (vazia)
define('DB_NAME', 'gerenciador_usuarios');

// cria um novo objeto mysqli usando as var. de ambiente acima
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// se connection deu algum erro
//     matar a conexão e mostrar mensagem de erro
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
// Definir o charset para evitar problemas com acentuação
$conn->set_charset("utf8mb4");

?>