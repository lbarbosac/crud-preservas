<?php
// repositories/UsuarioRepository.php
require_once __DIR__ . '/../configs/database.php';
require_once __DIR__ . '/../models/Usuario.php';

class UsuarioRepository
{
    private mysqli $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    public function buscarPorEmail(string $email): ?Usuario
    {
        $stmt = $this->conn->prepare('SELECT id, nome, email, senha FROM usuarios WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$result) {
            return null;
        }

        return new Usuario(
            (int) $result['id'],
            $result['nome'],
            $result['email'],
            $result['senha']
        );
    }

    public function criar(Usuario $usuario): bool
    {
        $stmt = $this->conn->prepare('INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)');
        $nome  = $usuario->getNome();
        $email = $usuario->getEmail();
        $senha = $usuario->getSenha();
        $stmt->bind_param('sss', $nome, $email, $senha);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
}
