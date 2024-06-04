<?php

namespace App\Enum;

enum RoleEnum: string
{
    case MEMBER = 'ROLE_MEMBER';
    case ADMIN = 'ROLE_ADMIN';
    case SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
}
