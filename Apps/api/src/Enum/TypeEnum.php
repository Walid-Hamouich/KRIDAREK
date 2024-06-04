<?php

namespace App\Enum;

enum TypeEnum: string
{
    case APARTMENT = 'Appartement';
    case VILLA = 'Villa';
    case GARAGE = 'Garage';
    case STUDIO = 'Studio';
    case FIELD = 'Terrain';
}
