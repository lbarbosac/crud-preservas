<?php
// models/Animal.php
class Animal
{
    private ?int $id;
    private string $especie;
    private string $origem;
    private string $sexo;
    private string $idade;
    private ?string $obs;

    public function __construct(
        ?int $id = null,
        string $especie = '',
        string $origem = '',
        string $sexo = 'indefinido',
        string $idade = 'filhote',
        ?string $obs = null
    ) {
        $this->id      = $id;
        $this->especie = $especie;
        $this->origem  = $origem;
        $this->sexo    = $sexo;
        $this->idade   = $idade;
        $this->obs     = $obs;
    }

    public function getId(): ?int { return $this->id; }
    public function getEspecie(): string { return $this->especie; }
    public function getOrigem(): string { return $this->origem; }
    public function getSexo(): string { return $this->sexo; }
    public function getIdade(): string { return $this->idade; }
    public function getObs(): ?string { return $this->obs; }

    public function setId(?int $id): void { $this->id = $id; }
    public function setEspecie(string $especie): void { $this->especie = $especie; }
    public function setOrigem(string $origem): void { $this->origem = $origem; }
    public function setSexo(string $sexo): void { $this->sexo = $sexo; }
    public function setIdade(string $idade): void { $this->idade = $idade; }
    public function setObs(?string $obs): void { $this->obs = $obs; }
}
