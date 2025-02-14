<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterDistricts extends Model
{
    use HasFactory;
    protected $table = 'master_districts';
    protected $fillable = ['city_id', 'name'];
}
