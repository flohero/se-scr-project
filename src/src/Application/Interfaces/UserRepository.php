<?php


namespace Application\Interfaces;


interface UserRepository {
    public function insertUser(string $username, string $password);
}