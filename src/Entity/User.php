<?php

namespace ScrollLock\Entity;

class User
{
    private ?int $id = null;

    private string $email;

    private string $password;

    private string $fullName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = password_hash($password, PASSWORD_ARGON2I);

        return $this;
    }

    public function setEncryptedPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = htmlspecialchars($fullName);

        return $this;
    }

    public function toJson(): string
    {
        return json_encode([
            'id' => (string) $this->id,
            'email' => $this->email,
            'fullName' => $this->fullName,
        ]);
    }
}
