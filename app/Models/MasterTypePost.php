<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterTypePost extends Model
{
    use HasFactory;
    
    protected $table = 'master_status_post'; 

    /**
     * Get the news items for the master category post.
     */
    public function news()
    {
        return $this->hasMany(News::class, 'type_news_id'); // Foreign key is 'cat_post_id'
    }
}
