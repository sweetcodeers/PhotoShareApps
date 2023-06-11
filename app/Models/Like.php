<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $table    = 'likes';
    protected $fillable = [ 
      'id',
      'user_id',
      'photo_id',
      'created_at',
      'updated_at'
    ];

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
