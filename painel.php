<head>
    <link rel="stylesheet" href="style.css">
</head>
<?php
session_start();
if (!isset($_SESSION['login'])) {
    die("Acesso negado.");
}

echo "<h2>Bem-vindo, {$_SESSION['login']}</h2>";

if ($_SESSION['tipo'] === 'adm') {
    require 'conexao.php';

    $res = $conn->query("SELECT login, senha_hash FROM usuarios");

    echo "<h3>Contas cadastradas:</h3>";
    echo "<table border='1'><tr><th>Login</th><th>Hash</th></tr>";
    while ($row = $res->fetch_assoc()) {
        echo "<tr>
                <td>{$row['login']}</td>
                <td>{$row['senha_hash']}</td>
              </tr>";
    }
    echo "</table>";

    echo "<br><a href='criar_usuario.php'>Criar novo usuário</a>";
} else {
    echo "Você está logado como usuário comum.";
}
?>
<br><br>
<form action="logout.php" method="post">
    <button type="submit">Sair</button>
</form>