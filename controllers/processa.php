<?php
session_start(); // ESSENCIAL: habilita uso de $_SESSION
require '../config/conexao.php';

$nome  = $_POST['nome']  ?? '';
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';
$acao  = $_POST['acao']  ?? '';

if ($acao === 'cadastrar') {
    if (!$nome || !$email || !$senha) {
        header("Location: ../public/cadastro.php?msg=Preencha todos os campos");
        exit;
    }

    $sql = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
    $sql->bind_param("s", $email);
    $sql->execute();
    $res = $sql->get_result();

    if ($res->num_rows > 0) {
        $origem = basename($_SERVER['HTTP_REFERER']);
        $redirect = $origem === 'criar_usuario.php' ? '../database/criar_usuario.php' : '../public/cadastro.php';
        header("Location: {$redirect}?msg=Esse e-mail já está cadastrado no sistema.");
        exit;
    }

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    $tipo = 'usuario';

    $sql = $conn->prepare("INSERT INTO usuarios (nome, email, senha_hash, tipo) VALUES (?, ?, ?, ?)");
    $sql->bind_param("ssss", $nome, $email, $senha_hash, $tipo);
    $sql->execute();

    $redirect = (basename($_SERVER['HTTP_REFERER']) === 'criar_usuario.php') ? '../database/criar_usuario.php' : '../public/cadastro.php';
    header("Location: {$redirect}?msg=Usuário cadastrado com sucesso!");
    exit;
}

if ($acao === 'login') {
    if (!$email || !$senha) {
        header("Location: ../public/login.php?erro=1");
        exit;
    }

    // Verifica se usuário está bloqueado
    if (isset($_SESSION['bloqueio_login'])) {
        $agora = time();
        if ($agora < $_SESSION['bloqueio_login']) {
            $tempo_restante = $_SESSION['bloqueio_login'] - $agora;
            $minutos = floor($tempo_restante / 60);
            $segundos = $tempo_restante % 60;
            header("Location: ../public/login.php?erro=4&msg=Conta bloqueada. Tente novamente em {$minutos}m {$segundos}s.");
            exit;
        } else {
            // Bloqueio expirado, limpa sessão
            unset($_SESSION['bloqueio_login']);
            unset($_SESSION['tentativas_login']);
        }
    }

    // Busca usuário
    $sql = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
    $sql->bind_param("s", $email);
    $sql->execute();
    $res = $sql->get_result();

    // Se e-mail não existir
    if ($res->num_rows === 0) {
        $_SESSION['tentativas_login'] = ($_SESSION['tentativas_login'] ?? 0) + 1;

        if ($_SESSION['tentativas_login'] >= 3) {
            $_SESSION['bloqueio_login'] = time() + (1 * 60); // 5 minutos de bloqueio
        }

        header("Location: ../public/login.php?erro=1");
        exit;
    }

    $user = $res->fetch_assoc();

    // Se senha incorreta
    if (!password_verify($senha, $user['senha_hash'])) {
        $_SESSION['tentativas_login'] = ($_SESSION['tentativas_login'] ?? 0) + 1;

        if ($_SESSION['tentativas_login'] >= 3) {
            $_SESSION['bloqueio_login'] = time() + (1 * 60); // 5 minutos de bloqueio
        }

        header("Location: ../public/login.php?erro=1");
        exit;
    }

    // Sucesso no login
    unset($_SESSION['tentativas_login']);
    unset($_SESSION['bloqueio_login']);

    session_regenerate_id(true); // Segurança extra: novo ID de sessão
    $_SESSION['login'] = $user['email'];
    $_SESSION['tipo']  = $user['tipo'];

    header("Location: ../public/painel.php");
    exit;
}
