<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterProvince extends Model
{
    use HasFactory;
    protected $table = 'master_provinces';
    protected $fillable = ['id', 'name'];

}
