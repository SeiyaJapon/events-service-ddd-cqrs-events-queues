<?php

declare (strict_types=1);

namespace App\AuthContext\Application\User\Command\UpdateUserCommand;

use App\AuthContext\Application\Command\CommandInterface;

class UpdateUserCommand implements CommandInterface
{
    private string $id;
    private string $name;
    private string $email;
    private string $password;

    public function __construct(string $id, string $name, string $email, string $password)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}