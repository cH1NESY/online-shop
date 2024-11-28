<?php

namespace Service\Logger;

use Ch1nesy\MyCore\LoggerServiceInterface;

class LoggerFileService implements LoggerServiceInterface
{
    public function errors(string $message, array $data = [])
    {

        $errorFile = "./../Storage/Log/error.txt";

        $date = date('Y-m-d H:i:s');
        foreach ($data as $error) {
            file_put_contents($errorFile, $error, FILE_APPEND);
        }
        file_put_contents($errorFile, $date, FILE_APPEND);
    }

    public function info(string $message, array $data = [])
    {
        $errorFile = "./../Storage/Log/info.txt";

    }


    public function warnings(string $message, array $data = [])
    {
        $errorFile = "./../Storage/Log/warnings.txt";

    }
}