<?php
session_start();
if (isset($_SESSION['login'])) {
    header("Location: painel.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/style.css">
    <title>Cadastro</title>
</head>
<body class="bg-dark d-flex justify-content-center align-items-center min-vh-100">
    <div class="content card shadow p-4">
        <h2 class="text-center mb-4">Cadastrar nova conta</h2>
        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-info text-center">
                <?= htmlspecialchars($_GET['msg']) ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="../controllers/processa.php">
            <input type="hidden" name="acao" value="cadastrar">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome do usuário:</label>
                <input type="text" name="nome" class="form-control" id="nome" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-mail:</label>
                <input type="email" name="email" class="form-control" id="email" required>
            </div>
            <div class="mb-5">
                <label for="senha" class="form-label">Senha:</label>
                <input type="password" name="senha" class="form-control" id="senha" required>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Cadastrar</button>
                <a href="login.php" class="btn btn-secondary">Já tenho uma conta</a>
            </div>
        </form>
    </div>
</body>
</html>
