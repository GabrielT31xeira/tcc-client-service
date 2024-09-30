<?php

namespace App\Models;

use App\traits\UUID;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use UUID;

    protected $table = 'package';

    protected $fillable = [
        'width',
        'height',
        'weight',
        'fragility'
    ];
}
