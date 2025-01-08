<?php

namespace App\Enums;

enum UserRoleEnum: string
{
    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case DEVELOPER = 'developer';
    case VIEWER = 'viewer';
}
