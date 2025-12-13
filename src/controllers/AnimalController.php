<?php
// controllers/AnimalController.php

require_once __DIR__ . '/../repositories/AnimalRepository.php';
require_once __DIR__ . '/../configs/database.php';

class AnimalController
{
    private AnimalRepository $repo;

    private array $sexosPermitidos  = ['masculino', 'feminino', 'indefinido'];
    private array $idadesPermitidas = ['neonato', 'filhote', 'juvenil', 'adulto', 'idoso'];

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->repo = new AnimalRepository();
    }

    public function listar(): array
    {
        return $this->repo->listarTodos();
    }

    public function buscar(int $id): ?Animal
    {
        return $this->repo->buscarPorId($id);
    }

    public function criar(array $data): array
    {
        $erros = $this->validar($data);
        if (!empty($erros)) {
            return $erros;
        }

        $animal = new Animal(
            null,
            trim($data['especie']),
            trim($data['origem']),
            $data['sexo'],
            $data['idade'],
            $data['obs'] !== '' ? substr($data['obs'], 0, 200) : null
        );

        if (!$this->repo->criar($animal)) {
            $erros[] = 'Erro ao cadastrar animal.';
        } else {
            // pega o ID gerado e registra log
            $conn = Database::getConnection();
            $animalId = $conn->insert_id;
            $this->registrarLog($animalId, 'criar', 'Animal criado.');
        }
        return $erros;
    }

    public function atualizar(int $id, array $data): array
    {
        $erros = $this->validar($data);
        if (!empty($erros)) {
            return $erros;
        }

        $animal = new Animal(
            $id,
            trim($data['especie']),
            trim($data['origem']),
            $data['sexo'],
            $data['idade'],
            $data['obs'] !== '' ? substr($data['obs'], 0, 200) : null
        );

        if (!$this->repo->atualizar($animal)) {
            $erros[] = 'Erro ao atualizar animal.';
        } else {
            $this->registrarLog($id, 'atualizar', 'Animal atualizado.');
        }
        return $erros;
    }

    public function deletar(int $id): void
    {

        // registra log ANTES de excluir
        $this->registrarLog($id, 'deletar', 'Animal deletado.');

        // agora deleta
        $this->repo->deletar($id);
    }

    private function validar(array $data): array
    {
        $erros = [];
        $especie = trim($data['especie'] ?? '');
        $origem  = trim($data['origem'] ?? '');
        $sexo    = $data['sexo']  ?? '';
        $idade   = $data['idade'] ?? '';
        $obs     = $data['obs']   ?? '';

        if ($especie === '') {
            $erros[] = 'Espécie é obrigatória.';
        }
        if ($origem === '') {
            $erros[] = 'Origem é obrigatória.';
        }
        if (!in_array($sexo, $this->sexosPermitidos, true)) {
            $erros[] = 'Sexo inválido.';
        }
        if (!in_array($idade, $this->idadesPermitidas, true)) {
            $erros[] = 'Idade inválida.';
        }
        if (strlen($obs) > 200) {
            $erros[] = 'Observação deve ter no máximo 200 caracteres.';
        }
        return $erros;
    }

    private function registrarLog(int $animalId, string $acao, string $detalhes = ''): void
    {
        if (empty($_SESSION['usuario_id'])) {
            return;
        }

        $conn = Database::getConnection();
        $stmt = $conn->prepare(
            'INSERT INTO animais_logs (animal_id, usuario_id, acao, detalhes) VALUES (?, ?, ?, ?)'
        );

        $usuarioId = (int) $_SESSION['usuario_id'];
        $stmt->bind_param('iiss', $animalId, $usuarioId, $acao, $detalhes);
        $stmt->execute();
        $stmt->close();
    }
}
