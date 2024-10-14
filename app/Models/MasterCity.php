<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterCity extends Model
{
    use HasFactory;
    protected $table = 'master_cities';
    protected $fillable = ['id', 'name', 'province_id'];
}
