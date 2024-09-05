<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    
    protected $table = 'news';
    protected $primaryKey  = 'id';

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    protected $fillable = [
        'id',
        'type_news_id',
        'cat_post_id',
        'name',
        'status',
        'file',
        'category',
        'page',
        'video',
        'desc2',
        'start_date',
        'end_date',
        'image',
    ];

    public function masterCatPost()
    {
        return $this->belongsTo(MasterCatPost::class, 'cat_post_id');
    }

    public function masterTypePost()
    {
        return $this->belongsTo(MasterTypePost::class, 'type_news_id');
    }
}
