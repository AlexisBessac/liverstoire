<?php

namespace App\Exception;

use Exception;

class PersistenceException extends Exception
{
    public function __construct(string $message, ?\Throwable $previous = null)
    {
        parent::__construct(
            'Une erreur est survenue lors de la sauvegarde des données : ' . $message,
            500,
            $previous
        );
    }
}
