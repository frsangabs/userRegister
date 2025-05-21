<?php
session_start();
if ($_SESSION['tipo'] !== 'adm') {
    die("Acesso negado.");
}
?>

<h2>Criar novo usuário</h2>
<form method="POST" action="processa.php">
    <input type="text" name="login" placeholder="Login" required><br>
    <input type="password" name="senha" placeholder="Senha" required><br>
    <input type="hidden" name="acao" value="cadastrar">
    <button type="submit">Criar</button>
</form>