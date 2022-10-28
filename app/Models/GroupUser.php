<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    use HasFactory;

    const GROUP_ROLE_OWNER = 'Owner';
    const GROUP_ROLE_ADMIN = 'Admin';
}
