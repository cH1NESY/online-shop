<?php

namespace Service;

class LogerService
{
    public function errors(array $errors)
    {

        $errorFile = "./../Storage/Log/error.txt";
        foreach ($errors as $error) {
            file_put_contents($errorFile, $error, FILE_APPEND);
        }
    }
}