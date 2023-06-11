<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;
    
    protected $table    = 'photos';
    protected $fillable = [ 
      'id',
      'user_id',
      'caption',
      'photo',
      'created_at',
      'updated_at'
    ];

    public function photo_tag()
    {
        return $this->hasMany(PhotoTag::class);
    }
    public function like()
    {
        return $this->hasMany(Like::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
