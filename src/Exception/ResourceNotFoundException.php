<?php

namespace App\Exception;

use Exception;

class ResourceNotFoundException extends Exception
{
    public function __construct(string $resourceType, int $id)
    {
        parent::__construct(
            sprintf('La ressource %s avec l\'ID %d n\'existe pas.', $resourceType, $id),
            404
        );
    }
}
