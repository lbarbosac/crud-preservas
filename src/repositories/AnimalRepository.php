<?php
// repositories/AnimalRepository.php
require_once __DIR__ . '/../configs/database.php';
require_once __DIR__ . '/../models/Animal.php';

class AnimalRepository
{
    private mysqli $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    public function listarTodos(): array
    {
        $animais = [];
        $sql = 'SELECT id, especie, origem, sexo, idade, obs, created_at FROM animais ORDER BY created_at DESC';
        $result = $this->conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            $animais[] = new Animal(
                (int) $row['id'],
                $row['especie'],
                $row['origem'],
                $row['sexo'],
                $row['idade'],
                $row['obs'] ?? null
            );
        }
        return $animais;
    }

    public function buscarPorId(int $id): ?Animal
    {
        $stmt = $this->conn->prepare('SELECT id, especie, origem, sexo, idade, obs FROM animais WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$row) {
            return null;
        }

        return new Animal(
            (int) $row['id'],
            $row['especie'],
            $row['origem'],
            $row['sexo'],
            $row['idade'],
            $row['obs'] ?? null
        );
    }

    public function criar(Animal $animal): bool
    {
        $stmt = $this->conn->prepare(
            'INSERT INTO animais (especie, origem, sexo, idade, obs) VALUES (?, ?, ?, ?, ?)'
        );
        $especie = $animal->getEspecie();
        $origem  = $animal->getOrigem();
        $sexo    = $animal->getSexo();
        $idade   = $animal->getIdade();
        $obs     = $animal->getObs();
        $stmt->bind_param('sssss', $especie, $origem, $sexo, $idade, $obs);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function atualizar(Animal $animal): bool
    {
        $stmt = $this->conn->prepare(
            'UPDATE animais SET especie = ?, origem = ?, sexo = ?, idade = ?, obs = ? WHERE id = ?'
        );
        $especie = $animal->getEspecie();
        $origem  = $animal->getOrigem();
        $sexo    = $animal->getSexo();
        $idade   = $animal->getIdade();
        $obs     = $animal->getObs();
        $id      = $animal->getId();
        $stmt->bind_param('sssssi', $especie, $origem, $sexo, $idade, $obs, $id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function deletar(int $id): bool
    {
        $stmt = $this->conn->prepare('DELETE FROM animais WHERE id = ?');
        $stmt->bind_param('i', $id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
}
