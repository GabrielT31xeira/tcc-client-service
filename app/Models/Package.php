<?php

namespace App\Models;

use App\traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use UUID, HasFactory;

    protected $primaryKey = 'id_package';

    protected $table = 'package';
    protected $fillable = [
        'width',
        'metric_width',
        'height',
        'metric_height',
        'weight',
        'metric_weight',
        'fragility',
        'description'
    ];
}
