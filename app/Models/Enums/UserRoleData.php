<?php

namespace App\Models\Enums;

interface UserRoleData
{

    const USER = 'user';
    const MODERATOR = 'moderator';
    const ADMIN = 'admin';
    const ROLES = [self::USER, self::MODERATOR, self::ADMIN];

}