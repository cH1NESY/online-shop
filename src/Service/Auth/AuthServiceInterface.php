<?php

namespace Service\Auth;

use Model\User;

interface AuthServiceInterface
{
    public function __construct();

    public function check():bool;


    public function getCurrentUser();

    private function sessionStart();

    public function login(string $login, string $password): bool;


}