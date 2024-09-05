<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'image',
        'category',
        'link_sm',
        'desc',
        'desc1',
        'desc2',
        'email',
        'phone',
        'address',
    ];

    
    protected $table = 'sys_settings';
    protected $primaryKey  = 'id';

}
