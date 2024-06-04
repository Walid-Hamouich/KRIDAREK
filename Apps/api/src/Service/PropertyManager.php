<?php

namespace App\Service;

use App\Repository\PropertyRepository;

class PropertyManager
{
    public function __construct(
        private PropertyRepository $propertyRepository
    ) {
    }

    public function findByTypeAndAction(string $type, string $action)
    {
        return $this->propertyRepository->findByTypeAndAction($type, $action);
    }
}
