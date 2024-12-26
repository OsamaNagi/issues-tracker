<?php

namespace App\Enums;

enum UserRoleEnum: string
{
    case ADMIN = 'admin';
    case MEMBER = 'user';
    case GUEST = 'guest';
}
