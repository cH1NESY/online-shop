<?php

namespace Service\Logger;
use Ch1nesy\MyCore\LoggerServiceInterface;
use Model\Log;

class LoggerDbService implements LoggerServiceInterface
{
    public function errors(string $message, array $data = []){
        Log::Createlog($data['message'], $data['file'], $data['line']);
    }

    public function info(string $message, array $data = []){

    }

    public function warnings(string $message, array $data = [] ){

    }
}