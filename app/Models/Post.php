<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'is_published',
        'published_at',
        'category_id',
        'user_id',
        'image',
        'meta_title',
        'meta_description',
    ];

    protected $dates = ['published_at', 'deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
