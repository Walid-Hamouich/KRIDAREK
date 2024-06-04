<?php

namespace App\Enum;

enum StatusEnum: string
{
    case PROCESSING = 'En cours de traitement';
    case   PUBLISHED = 'Publier';
    case   NONPUBLISHED = 'Non Publier';
    case   DELETED = 'Supprimer';
}
