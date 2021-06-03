<?php

namespace Application\Services;

class AuthenticationService {

    const SESSION_USER_ID = "userId";

    public function __construct(private \Application\Interfaces\Session $session) {
    }

    public function login(int $userId) {
        $this->session->put(self::SESSION_USER_ID, $userId);
    }

    public function logout(): void {
        $this->session->delete(self::SESSION_USER_ID);
    }

    public function userId(): ?int {
        return $this->session->get(self::SESSION_USER_ID);
    }
}