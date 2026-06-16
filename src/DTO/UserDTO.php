<?php

namespace App\DTO;

class UserDTO
{
    public ?int $id;
    public string $name;
    public string $email;
    public string $password;
    public ?string $createdAt;

    // é chamado quando novo usuário é criado
    // funcoes "mágicas" ---> __
    public function __construct(?int $id, string $name, string $email,
    string $password, ?string $createdAt = null)
    {
        // '$this->id' se refere à variável '$id' criada globalmente
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = $createdAt;
    }

    // Métodos para obter os dados (getters)
    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getEmail(): string { return $this->email; }
    public function getPassword(): string { return $this->password; }
    public function getCreatedAt(): ?string { return $this->createdAt; }

    // Opcional: Método para converter o DTO em array (útil para JSON)
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password, // Em um cenário real, a senha nunca seria
                                           // retornada assim
            'created_at' => $this->createdAt
        ];
    }
}