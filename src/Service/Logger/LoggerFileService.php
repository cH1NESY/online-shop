<?php

namespace Service\Logger;

class LoggerFileService
{
    public function errors(string $message, array $data = [])
    {

        $errorFile = "./../Storage/Log/error.txt";

        date_default_timezone_get('UTC + 8');
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