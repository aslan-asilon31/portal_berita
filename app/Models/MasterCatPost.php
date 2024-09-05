<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterCatPost extends Model
{
    use HasFactory;
    
    protected $table = 'master_category_news'; 

    /**
     * Get the news items for the master category post.
     */
    public function news()
    {
        return $this->hasMany(News::class, 'cat_post_id'); // Foreign key is 'cat_post_id'
    }
}
