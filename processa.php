<?php
require 'conexao.php';

$login = $_POST['login'];
$senha = $_POST['senha'];
$acao = $_POST['acao'];

if (!$login || !$senha) {
    die("Usuário ou senha inválidos");
}

if ($acao === 'cadastrar') {
    $sql = $conn->prepare("SELECT * FROM usuarios WHERE login = ?");
    $sql->bind_param("s", $login);
    $sql->execute();
    $res = $sql->get_result();

    if ($res->num_rows > 0) {
        die("Usuário indisponível");
    }

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    $sql = $conn->prepare("INSERT INTO usuarios (login, senha_original, senha_hash) VALUES (?, ?, ?)");
    $sql->bind_param("sss", $login, $senha, $senha_hash);
    $sql->execute();

    echo "Usuário cadastrado com sucesso!";
    exit;
}

if ($acao === 'login') {
    $sql = $conn->prepare("SELECT * FROM usuarios WHERE login = ?");
    $sql->bind_param("s", $login);
    $sql->execute();
    $res = $sql->get_result();

    if ($res->num_rows === 0) {
        die("Usuário ou senha inválidos");
    }

    $user = $res->fetch_assoc();

    if (!password_verify($senha, $user['senha_hash'])) {
        die("Usuário ou senha inválidos");
    }

    session_start();
    $_SESSION['login'] = $user['login'];
    $_SESSION['tipo'] = $user['tipo'];

    header("Location: painel.php");
    exit;
}
?>