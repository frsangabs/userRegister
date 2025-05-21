<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Entrar ou Cadastrar</h2>
<form method="POST" action="processa.php">
    <input type="text" name="login" placeholder="Login" required><br>
    <input type="password" name="senha" placeholder="Senha" required><br>
    <button type="submit" name="acao" value="login">Entrar</button>
    <button type="submit" name="acao" value="cadastrar">Cadastrar</button>
</form>
</body>
</html>