<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PackageUser extends Model
{
    protected $table = 'package_user';

    protected $fillable = [
        'user_id',
        'package_id'
    ];

}
