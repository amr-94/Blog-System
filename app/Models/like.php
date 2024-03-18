<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class like extends Model
{
    use HasFactory;
    protected $fillable=[
        'like','dislike','user_id','comment_id', 'post_id'
    ];
    // protected $casts = [
    //     //هنا بقدر اغير صيفة اى حقل من الحقول
    //     'like' => 'int'
    // ];
    /**
     * Get the user that owns the like
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    /**
     * Get all of the comments for the like
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->belongsTo(Comment::class, 'comment_id', 'id');
    }

    /**
     * Get the user that owns the like
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(post::class, 'post_id', 'id');
    }
}
