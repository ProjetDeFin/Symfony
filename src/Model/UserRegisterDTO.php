<?php

namespace App\Model;

use App\Enum\UserGenderEnum;
use App\Repository\UserRepository;

class UserRegisterDTO
{
    private UserGenderEnum $gender;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $password;
    private string $role;


    public function __construct(
        array $data,
        UserRepository $userRepository,
    ) {
        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $email = $data['email'];
        $password = $data['password'];
        $confirmPassword = $data['confirmPassword'];
        $gender = UserGenderEnum::fromString($data['gender']);

        if (false === $data['isStudent'] && false === $data['isCompany']) {
            throw new \InvalidArgumentException('You must have a role');
        }

        if (!$firstName || !$lastName || !$email || !$password || !$confirmPassword)
        {
            throw new \InvalidArgumentException('Email and password are required');
        }

        $user = $userRepository->findOneBy(['email' => $email]);
        if (null !== $user) {
            throw new \InvalidArgumentException('User already exists');
        }

        if ($password !== $confirmPassword) {
            throw new \InvalidArgumentException('Passwords do not match');
        }

        if (strlen($password) < 8) {
            throw new \InvalidArgumentException('Password must be at least 8 characters long');
        }

        if (!preg_match('/[A-Z]/', $password)) {
            throw new \InvalidArgumentException('Password must contain at least one uppercase letter');
        }

        if (!preg_match('/[a-z]/', $password)) {
            throw new \InvalidArgumentException('Password must contain at least one lowercase letter');
        }

        if (!preg_match('/[0-9]/', $password)) {
            throw new \InvalidArgumentException('Password must contain at least one number');
        }

        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->gender = $gender;
        $this->role = $data['isStudent'] ? 'ROLE_STUDENT' : 'ROLE_COMPANY_RESPONSIBLE';
    }

    public function getGender(): UserGenderEnum
    {
        return $this->gender;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRole(): string
    {
        return $this->role;
    }
}
