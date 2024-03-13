<?php

namespace App\Models\Enums;


enum UserRole: string
{
    case ADMIN = 'ADMIN';
    case STUDENT = 'STUDENT';
    case TEACHER = 'TEACHER';
};
