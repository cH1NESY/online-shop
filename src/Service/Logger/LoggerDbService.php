<?php

namespace Service\Logger;
use Model\Logger;
class LoggerDbService implements LoggerServiceInterface
{
    public function errors(string $message, array $data = []){
        Logger::Createlog($data['message'], $data['file'], $data['line']);
    }

    public function info(string $message, array $data = []){

    }

    public function warnings(string $message, array $data = [] ){

    }
}