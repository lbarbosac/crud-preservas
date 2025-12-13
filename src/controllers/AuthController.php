<?php
// controllers/AuthController.php

require_once __DIR__ . '/../repositories/UsuarioRepository.php';

class AuthController
{
    private UsuarioRepository $repo;

    public function __construct()
    {
        $this->repo = new UsuarioRepository();
    }

    public function registrar(array $data): array
    {
        $erros = [];

        $nome  = trim($data['nome']  ?? '');
        $email = trim($data['email'] ?? '');
        $senha = $data['senha']      ?? '';
        $conf  = $data['senha_confirmacao'] ?? '';

        if ($nome === '') {
            $erros[] = 'Nome é obrigatório.';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erros[] = 'Email inválido.';
        }
        if (strlen($senha) < 6) {
            $erros[] = 'Senha deve ter pelo menos 6 caracteres.';
        }
        if ($senha !== $conf) {
            $erros[] = 'Senha e confirmação não conferem.';
        }

        if ($this->repo->buscarPorEmail($email)) {
            $erros[] = 'Já existe um usuário com esse email.';
        }

        if (!empty($erros)) {
            return $erros;
        }

        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $usuario = new Usuario(null, $nome, $email, $hash);

        if (!$this->repo->criar($usuario)) {
            $erros[] = 'Erro ao cadastrar usuário.';
            return $erros;
        }

        $_SESSION['usuario_id']   = $usuario->getId();
        $_SESSION['usuario_nome'] = $usuario->getNome();
        $_SESSION['usuario_email']= $usuario->getEmail();

        return $erros;
    }

    public function login(array $data): array
    {
        $erros = [];
        $email = trim($data['email'] ?? '');
        $senha = $data['senha'] ?? '';

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $senha === '') {
            $erros[] = 'Credenciais inválidas.';
            return $erros;
        }

        $usuario = $this->repo->buscarPorEmail($email);
        if (!$usuario || !password_verify($senha, $usuario->getSenha())) {
            $erros[] = 'Email ou senha incorretos.';
            return $erros;
        }

        $_SESSION['usuario_id']   = $usuario->getId();
        $_SESSION['usuario_nome'] = $usuario->getNome();
        $_SESSION['usuario_email']= $usuario->getEmail();

        return $erros;
    }

    public function logout(): void
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: index.php');
        exit;
    }
}
