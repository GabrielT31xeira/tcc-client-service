<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

use App\traits\UUID;

class Travel extends Model
{
    use UUID, HasFactory;
    protected $table = 'travel';
    protected $primaryKey = 'id_travel';
    protected $fillable = [
        'user_id',
        'arrival_id',
        'output_id',
        'package_id',
        'sent'
    ];
    protected $hidden = [
        'arrival_id',
        'output_id',
        'package_id',
    ];

    public function arrival(): hasOne
    {
        return $this->hasOne(Arrival::class, 'id_arrival', 'arrival_id');
    }

    public function output(): hasOne
    {
        return $this->hasOne(Output::class, 'id_output', 'output_id');
    }

    public function package(): hasOne
    {
        return $this->hasOne(Package::class, 'id_package', 'package_id');
    }
}
