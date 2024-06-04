<?php

namespace App\Controller;

use App\Entity\Property;
use App\Service\PropertyManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyPostController extends AbstractController
{
    public function __construct(private PropertyManager $propertyManager)
    {
    }

    public function __invoke(Property $property)
    {
        $result = $this->propertyManager->findByTypeAndAction($property->getType(), $property->getAction());
        if ($result == null) {
            return $property;
        }
        return $this->json($result);
    }
}
