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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../public/style.css">
    <title>Faça login</title>
</head>
<body class="bg-dark d-flex justify-content-center align-items-center min-vh-100">
    <div class="content card shadow p-4">
        <h2 class="text-center mb-4">Login</h2>
        <?php
        if (isset($_GET['erro'])) {
            if ($_GET['erro'] == 1) {
                echo '<div class="alert alert-danger">E-mail ou senha incorretos.</div>';
            } elseif ($_GET['erro'] == 4 && isset($_GET['msg'])) {
                echo '<div class="alert alert-warning">' . htmlspecialchars($_GET['msg']) . '</div>';
            }
        }
        ?>
        <form method="POST" action="../controllers/processa.php">
            <input type="hidden" name="acao" value="login">
            <div class="mb-3">
                <label for="email" class="form-label">E-mail:</label>
                <input type="text" name="email" class="form-control" id="email" required>
            </div>
            <div class="mb-5">
                <label for="senha" class="form-label">Senha:</label>
                <div class="input-group">
                    <input type="password" name="senha" class="form-control" id="senha" required>
                    <button type="button" class="btn btn-secondary" onclick="toggleSenha()"><i class="password-icon fa-solid fa-eye"></i></button>
                </div>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Entrar</button>
                <a href="cadastro.php" class="btn btn-secondary">Cadastrar nova conta</a>
            </div>
        </form>
    </div>
    
    <script>
        function toggleSenha() {
            const senhaInput = document.querySelector('#senha');
            const eyeIcon = document.querySelector('.password-icon');
            if (senhaInput.type === 'password') {
                senhaInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                senhaInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
