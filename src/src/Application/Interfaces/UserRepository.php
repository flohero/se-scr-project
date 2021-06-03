<?php


namespace Application\Interfaces;


use Application\Entities\User;

interface UserRepository {
    public function insertUser(string $username, string $password): int;

    public function findUserByUsername(string $username): ?User;

    public function findUserByUsernameAndPassword(string $username, string $password): ?User;

    public function findUserById(int $id): ?User;
}